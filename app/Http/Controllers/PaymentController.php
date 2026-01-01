<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\PaymentGateway;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    /**
     * Muestra la pantalla de selección de pago
     */
    public function show(Request $request, $id)
    {
        $invoice = Invoice::with('client', 'items')->findOrFail($id);

        if ($invoice->status === 'paid') {
            return redirect()->route('invoices.show', $id)->with('success', 'Esta factura ya está pagada.');
        }

        // Obtener pasarelas activas
        $gateways = PaymentGateway::where('is_active', 1)->get();

        return view('client.checkout.payment', compact('invoice', 'gateways'));
    }

    /**
     * Procesa el pago según la pasarela elegida
     */
    public function process(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);
        $slug = $request->input('gateway');

        $gateway = PaymentGateway::where('slug', $slug)->where('is_active', 1)->firstOrFail();

        if ($slug === 'paypal') {
            return $this->processPayPal($invoice, $gateway);
        }

        if ($slug === 'payu') {
            return $this->processPayU($invoice, $gateway);
        }

        return back()->with('error', 'Pasarela no válida.');
    }

    // =========================================================================
    // LÓGICA PAYPAL (API REST v2)
    // =========================================================================
    private function processPayPal($invoice, $gateway)
    {
        $config = $gateway->config;
        $clientId = $config['client_id'];
        $secret = $config['client_secret'];
        
        // URL Base (Sandbox o Live)
        $baseUrl = $gateway->test_mode 
            ? 'https://api-m.sandbox.paypal.com' 
            : 'https://api-m.paypal.com';

        try {
            // 1. Obtener Token de Acceso (OAuth 2.0)
            $responseToken = Http::withBasicAuth($clientId, $secret)
                ->asForm()
                ->post("$baseUrl/v1/oauth2/token", [
                    'grant_type' => 'client_credentials'
                ]);

            if ($responseToken->failed()) {
                throw new \Exception("Error autenticando con PayPal: " . $responseToken->body());
            }

            $accessToken = $responseToken->json()['access_token'];

            // 2. Crear la Orden de Pago
            $responseOrder = Http::withToken($accessToken)
                ->post("$baseUrl/v2/checkout/orders", [
                    'intent' => 'CAPTURE',
                    'purchase_units' => [[
                        'reference_id' => $invoice->id,
                        'amount' => [
                            'currency_code' => 'USD', // PayPal suele requerir USD o EUR. Si usas COP, PayPal hará la conversión.
                            'value' => number_format($invoice->total, 2, '.', '')
                        ],
                        'description' => "Pago Factura #{$invoice->id} - Linea365"
                    ]],
                    'application_context' => [
                        'brand_name' => 'Linea365 Hosting',
                        'return_url' => route('payment.callback', ['gateway' => 'paypal', 'invoice_id' => $invoice->id]),
                        'cancel_url' => route('payment.show', $invoice->id),
                    ]
                ]);

            if ($responseOrder->failed()) {
                throw new \Exception("Error creando orden PayPal: " . $responseOrder->body());
            }

            // 3. Obtener el enlace de aprobación y redirigir
            $links = $responseOrder->json()['links'];
            foreach ($links as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect($link['href']); // Redirigimos al usuario a PayPal.com
                }
            }

            return back()->with('error', 'No se pudo iniciar el pago con PayPal.');

        } catch (\Exception $e) {
            Log::error('PayPal Error: ' . $e->getMessage());
            return back()->with('error', 'Error de conexión con PayPal. Intenta más tarde.');
        }
    }

    // =========================================================================
    // LÓGICA PAYU LATAM
    // =========================================================================
    private function processPayU($invoice, $gateway)
    {
        $config = $gateway->config;
        $url = $gateway->test_mode 
            ? 'https://sandbox.checkout.payulatam.com/ppp-web-gateway-payu/' 
            : 'https://checkout.payulatam.com/ppp-web-gateway-payu/';

        $referenceCode = 'INV-' . $invoice->id . '-' . time();
        $amount = number_format($invoice->total, 2, '.', '');
        $currency = 'COP'; // PayU sí soporta COP nativo

        // Firma MD5
        $signature = md5("{$config['api_key']}~{$config['merchant_id']}~$referenceCode~$amount~$currency");

        $data = [
            'url' => $url,
            'merchantId' => $config['merchant_id'],
            'accountId' => $config['account_id'],
            'description' => "Pago Factura #{$invoice->id}",
            'referenceCode' => $referenceCode,
            'amount' => $amount,
            'tax' => '0', 'taxReturnBase' => '0',
            'currency' => $currency,
            'signature' => $signature,
            'test' => $gateway->test_mode ? '1' : '0',
            'buyerEmail' => $invoice->client->email,
            'responseUrl' => route('payment.callback', ['gateway' => 'payu']),
            'confirmationUrl' => route('payment.webhook', ['gateway' => 'payu']),
        ];

        return view('client.checkout.redirect_payu', compact('data'));
    }

    // =========================================================================
    // CALLBACK (Retorno del Usuario)
    // =========================================================================
    public function callback(Request $request, $gateway)
    {
        // 1. RESPUESTA PAYPAL (GET)
        if ($gateway === 'paypal') {
            $token = $request->token; // ID de la orden en PayPal
            $invoiceId = $request->invoice_id;

            if (!$token) return redirect()->route('dashboard')->with('error', 'Pago cancelado.');

            // Capturar el pago (Confirmar que tenemos el dinero)
            if ($this->capturePayPalOrder($token)) {
                $this->markInvoiceAsPaid($invoiceId, 'PayPal', $token);
                return redirect()->route('invoices.show', $invoiceId)->with('success', '¡Pago con PayPal exitoso! Tu servicio se está activando.');
            } else {
                return redirect()->route('invoices.show', $invoiceId)->with('error', 'El pago no fue aprobado por PayPal.');
            }
        }

        // 2. RESPUESTA PAYU (GET)
        if ($gateway === 'payu') {
            // PayU solo avisa el estado real por Webhook, aquí solo redirigimos
            $state = $request->input('transactionState');
            if ($state == 4) {
                return redirect()->route('dashboard')->with('success', 'Transacción aprobada por PayU.');
            }
            return redirect()->route('dashboard')->with('info', 'Pago en proceso o pendiente.');
        }

        return redirect()->route('dashboard');
    }

    // =========================================================================
    // WEBHOOK (Aviso Silencioso)
    // =========================================================================
    public function webhook(Request $request, $gateway)
    {
        Log::info("Webhook $gateway", $request->all());

        if ($gateway === 'payu') {
            // Estado 4 = Aprobada
            if ($request->input('state_pol') == 4) {
                // Extraer el ID de factura de la referencia (Ej: INV-15-173829)
                $refParts = explode('-', $request->input('reference_sale'));
                $invoiceId = $refParts[1] ?? null;

                if ($invoiceId) {
                    $this->markInvoiceAsPaid($invoiceId, 'PayU', $request->input('reference_pol'));
                }
            }
        }

        return response('OK', 200);
    }

    // --- FUNCIONES AUXILIARES ---

    private function capturePayPalOrder($orderId)
    {
        // Obtener credenciales de nuevo
        $gateway = PaymentGateway::where('slug', 'paypal')->first();
        $config = $gateway->config;
        $baseUrl = $gateway->test_mode ? 'https://api-m.sandbox.paypal.com' : 'https://api-m.paypal.com';

        // Token
        $responseToken = Http::withBasicAuth($config['client_id'], $config['client_secret'])
            ->asForm()->post("$baseUrl/v1/oauth2/token", ['grant_type' => 'client_credentials']);
        
        $accessToken = $responseToken->json()['access_token'];

        // Capturar
        $response = Http::withToken($accessToken)
            ->post("$baseUrl/v2/checkout/orders/$orderId/capture", [
                'headers' => ['Content-Type' => 'application/json']
            ]);

        return $response->successful() && $response->json()['status'] === 'COMPLETED';
    }

    private function markInvoiceAsPaid($invoiceId, $method, $transactionId)
    {
        $invoice = Invoice::find($invoiceId);
        if ($invoice && $invoice->status !== 'paid') {
            $invoice->update([
                'status' => 'paid',
                'amount_paid' => $invoice->total,
                // Podrías guardar el transaction_id en notas o un campo extra
            ]);
            
            // AQUÍ IRÍA LA LÓGICA DE ACTIVACIÓN AUTOMÁTICA DEL SERVICIO (cPanel/WHM)
            // $this->activateService($invoice);
        }
    }
}