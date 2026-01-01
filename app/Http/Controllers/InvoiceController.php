<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoiceController extends Controller
{
    /**
     * Listado de facturas.
     */
    public function index()
    {
        $user = Auth::user();
        $client = $user->client;

        // Si el usuario no tiene perfil de cliente, mostramos vista vac¨ªa
        if (!$client) {
            return view('client.invoices.index', [
                'user' => $user, 
                'client' => null, 
                'invoices' => collect()
            ]);
        }

        // Obtener facturas ordenadas por estado (Pendientes primero)
        $invoices = Invoice::where('client_id', $client->id)
            ->orderByRaw("FIELD(status, 'unpaid', 'overdue', 'paid', 'cancelled')")
            ->orderByDesc('issue_date')
            ->paginate(10);

        return view('client.invoices.index', compact('user', 'client', 'invoices'));
    }

    /**
     * Detalle de factura.
     */
    public function show($id)
    {
        $user = Auth::user();
        $client = $user->client;

        // 1. Verificar que el usuario tenga perfil de cliente
        if (!$client) {
            return redirect()->route('dashboard')->with('error', 'No tienes un perfil de cliente asociado.');
        }

        // 2. Buscar la factura (Usamos find para manejar el fallo manualmente)
        $invoice = Invoice::with(['items', 'client'])->find($id);

        if (!$invoice) {
            abort(404, 'Factura no encontrada.');
        }

        // 3. SEGURIDAD CORREGIDA: Usamos != (no estricto) para evitar error entre "2" y 2
        if ($invoice->client_id != $client->id) {
            abort(404); // Si no es tuya, simulamos que no existe
        }

        return view('client.invoices.show', compact('user', 'client', 'invoice'));
    }
}