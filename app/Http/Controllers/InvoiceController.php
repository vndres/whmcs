<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Listado de facturas del cliente logueado.
     */
    public function index(Request $request)
    {
        $user   = Auth::user();
        $client = $user->client;

        if (!$client) {
            $invoices = collect();
            return view('dashboard.invoices.index', compact('user', 'client', 'invoices'));
        }

        $invoices = Invoice::where('client_id', $client->id)
            ->orderByRaw("FIELD(status, 'unpaid', 'overdue', 'paid', 'cancelled')")
            ->orderByDesc('issue_date')
            ->paginate(10);

        return view('dashboard.invoices.index', compact('user', 'client', 'invoices'));
    }

    /**
     * Detalle de una factura.
     */
    public function show(Invoice $invoice)
    {
        $user   = Auth::user();
        $client = $user->client;

        if (!$client || $invoice->client_id !== $client->id) {
            abort(404);
        }

        $invoice->load(['client', 'items']);

        return view('dashboard.invoices.show', compact('user', 'client', 'invoice'));
    }
}
