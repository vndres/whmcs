<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientInvoiceController extends Controller
{
    /**
     * Listado de facturas del cliente autenticado.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $client = $user->client;

        // Si aún no tiene registro en clients
        if (!$client) {
            return view('client.invoices.index', [
                'client'   => null,
                'invoices' => collect(), // colección vacía
            ]);
        }

        $invoices = Invoice::where('client_id', $client->id)
            ->orderByDesc('id')
            ->paginate(10);

        return view('client.invoices.index', compact('client', 'invoices'));
    }

    /**
     * Detalle de una factura del cliente.
     */
    public function show(Invoice $invoice)
    {
        $user = Auth::user();
        $client = $user->client;

        if (!$client || $invoice->client_id !== $client->id) {
            abort(404);
        }

        $invoice->load('items', 'client');

        return view('client.invoices.show', compact('client', 'invoice'));
    }
}
