<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth; // Faltaba importar Auth
use Illuminate\Support\Str;
use Carbon\Carbon;

// Modelos
use App\Models\Product;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Service;
use App\Models\Client;

class OrderController extends Controller
{
    /**
     * TIENDA: Muestra productos filtrados
     */
    public function index(Request $request)
    {
        $type = $request->input('type', 'hosting');

        $categoryTitle = match($type) {
            'hosting'         => 'Planes de Hosting',
            'hosting_windows' => 'Hosting Windows',
            'vps'             => 'Servidores VPS',
            'dedicated'       => 'Servidores Dedicados',
            'domain'          => 'Registro de Dominios',
            default           => 'Servicios ' . ucfirst($type)
        };

        $products = Product::where('type', $type)
            ->where('is_active', 1)
            ->orderBy('price_monthly', 'asc')
            ->get();

        $groupedProducts = $products->groupBy(function ($item) {
            return $item->group_name ?: $item->name;
        });

        return view('store.index', compact('groupedProducts', 'categoryTitle', 'type'));
    }

    /**
     * CONFIGURACIÓN
     */
    public function configure($id)
    {
        $product = Product::findOrFail($id);
        $allowedCycles = explode(',', $product->billing_cycles);
        return view('frontend.configure', compact('product', 'allowedCycles'));
    }

    /**
     * AJAX: Verificar dominio
     */
    public function checkDomain(Request $request)
    {
        $domain = $request->input('domain');
        if (!$domain || !str_contains($domain, '.')) {
            return response()->json(['status' => 'error', 'message' => 'Ingresa un dominio válido.']);
        }

        try {
            // Buscamos si existe un producto tipo 'domain' para sacar el precio base
            $domainProduct = Product::where('type', 'domain')->where('is_active', 1)->first();
            
            // Precio por defecto si no hay producto configurado
            $price = $domainProduct ? (float)$domainProduct->price_yearly : 15.00;

            // Lógica simulada de disponibilidad (Para producción usar API real)
            $isAvailable = true; 
            
            if ($isAvailable) {
                return response()->json([
                    'status' => 'available', 
                    'domain' => $domain, 
                    'price' => $price, 
                    'message' => '¡Disponible!'
                ]);
            }
            return response()->json(['status' => 'taken', 'domain' => $domain, 'message' => 'No disponible']);
        } catch (\Exception $e) {
            Log::error("Domain Check Error: " . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Error de conexión.']);
        }
    }

    /**
     * CARRITO: Agregar ítem
     */
    public function addToCart(Request $request)
    {
        $cart = Session::get('cart', []);

        // Procesar Hosting
        if ($request->has('product_id')) {
            $product = Product::findOrFail($request->input('product_id'));
            $cycle = $request->input('billing_cycle', 'monthly');
            
            $price = ($cycle === 'yearly') ? $product->price_yearly : $product->price_monthly;
            // Fallback si el precio es 0 o nulo
            if ($price <= 0) $price = $product->price_monthly;

            $cart['hosting'] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => (float)$price,
                'billing_cycle' => $cycle,
                'period_name' => ($cycle === 'yearly') ? 'Anual' : 'Mensual',
                'has_free_domain' => $product->config['free_domain'] ?? false
            ];
        }

        // Procesar Dominio
        if ($request->has('domain_option') && $request->input('domain_option') === 'register') {
            $cart['domain'] = [
                'name' => $request->input('domain_name'),
                'price' => (float)$request->input('domain_price'),
                'price_original' => (float)$request->input('domain_price'),
                'period' => 1,
                'is_free' => false
            ];
        }

        $cart = $this->applyDiscounts($cart);
        Session::put('cart', $cart);
        
        return redirect()->route('cart.checkout');
    }

    /**
     * CARRITO: Eliminar ítem
     */
    public function removeItem($type)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$type])) {
            unset($cart[$type]);
            $cart = $this->applyDiscounts($cart);
            Session::put('cart', $cart);
        }
        return redirect()->route('cart.checkout');
    }

    /**
     * VISTA: Checkout
     */
    public function checkout()
    {
        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('store.index')->with('info', 'Tu carrito está vacío.');
        }
        
        $total = 0;
        if (isset($cart['hosting'])) $total += $cart['hosting']['price'];
        if (isset($cart['domain'])) $total += $cart['domain']['price'];
        
        return view('frontend.checkout', compact('cart', 'total'));
    }

    /**
     * ACCIÓN FINAL: Crear Pedido y Factura
     */
    public function placeOrder(Request $request)
    {
        $cart = Session::get('cart', []);
        if (empty($cart)) return redirect()->route('store.index');

        if (!auth()->check()) {
            Session::put('url.intended', route('cart.checkout'));
            return redirect()->route('login')->with('info', 'Debes iniciar sesión para completar la compra.');
        }

        $user = auth()->user();
        
        // Calcular total final
        $total = 0;
        if (isset($cart['hosting'])) $total += $cart['hosting']['price'];
        if (isset($cart['domain'])) $total += $cart['domain']['price'];

        // Buscar el perfil de Cliente
        $client = Client::where('user_id', $user->id)->first();
        
        // Si no existe perfil de cliente, lo creamos al vuelo para no perder la venta
        if (!$client) {
            $client = Client::create([
                'user_id' => $user->id,
                'uuid' => Str::uuid(),
                'first_name' => $user->name,
                'last_name' => '', 
                'email' => $user->email,
                'currency' => 'USD',
                'language' => 'es',
                'is_active' => 1
            ]);
        }

        try {
            DB::beginTransaction();

            // 1. Crear Factura (Con número temporal)
            $invoice = Invoice::create([
                'client_id' => $client->id,
                'number'    => 'TEMP-' . uniqid(),
                'status'    => 'unpaid',
                'total'     => $total,
                'subtotal'  => $total,
                'tax_total' => 0, 
                'due_date'  => Carbon::now(), // Vence hoy
                'issue_date'=> Carbon::now(),
                'currency'  => 'USD'
            ]);

            // 2. Actualizar Número de Factura (INV-000X)
            $invoiceNumber = 'INV-' . str_pad($invoice->id, 5, '0', STR_PAD_LEFT);
            $invoice->update(['number' => $invoiceNumber]);

            // 3. Procesar Hosting
            if (isset($cart['hosting'])) {
                $hosting = $cart['hosting'];

                // A. Item Factura
                InvoiceItem::create([
                    'invoice_id'  => $invoice->id,
                    'description' => "Hosting: {$hosting['name']} ({$hosting['period_name']})",
                    'unit_price'  => $hosting['price'],
                    'total'       => $hosting['price'],
                    'quantity'    => 1
                ]);

                // B. Crear Servicio
                // CORRECCIÓN SQL: Guardamos precio y ciclo en JSON porque la tabla no tiene esas columnas
                $nextDue = ($hosting['billing_cycle'] === 'yearly') ? Carbon::now()->addYear() : Carbon::now()->addMonth();
                
                $configData = [
                    'price' => $hosting['price'],
                    'billing_cycle' => $hosting['billing_cycle']
                ];

                Service::create([
                    'client_id'      => $client->id,
                    'product_id'     => $hosting['id'],
                    'domain'         => $cart['domain']['name'] ?? 'dominio-pendiente.com',
                    'status'         => 'pending',
                    'next_due_date'  => $nextDue,
                    // 'server_id'   => null (por defecto)
                    'config'         => json_encode($configData) // <--- Aquí guardamos los datos extra
                ]);
            }

            // 4. Procesar Dominio
            if (isset($cart['domain'])) {
                $domain = $cart['domain'];
                
                InvoiceItem::create([
                    'invoice_id'  => $invoice->id,
                    'description' => "Registro de Dominio: {$domain['name']} (1 Año)",
                    'unit_price'  => $domain['price'],
                    'total'       => $domain['price'],
                    'quantity'    => 1
                ]);
            }

            DB::commit();
            Session::forget('cart');

            // 5. Redirigir a la selección de pago
            return redirect()->route('payment.show', $invoice->id);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error en placeOrder: " . $e->getMessage());
            return back()->with('error', 'Error procesando el pedido: ' . $e->getMessage());
        }
    }

    /**
     * Lógica de descuentos
     */
    private function applyDiscounts($cart)
    {
        if (isset($cart['domain'])) {
            if (!isset($cart['domain']['price_original'])) {
                $cart['domain']['price_original'] = $cart['domain']['price'];
            }
            $hosting = $cart['hosting'] ?? null;
            
            if ($hosting && $hosting['billing_cycle'] === 'yearly' && !empty($hosting['has_free_domain'])) {
                $cart['domain']['price'] = 0.00;
                $cart['domain']['is_free'] = true;
            } else {
                $cart['domain']['price'] = $cart['domain']['price_original'];
                $cart['domain']['is_free'] = false;
            }
        }
        return $cart;
    }
}