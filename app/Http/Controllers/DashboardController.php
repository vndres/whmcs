<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Invoice;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Panel principal del cliente.
     */
    public function index(Request $request)
    {
        $user   = Auth::user();
        $client = $user->client;

        // Si por alguna razon el usuario no tiene cliente vinculado
        if (!$client) {
            return view('dashboard.index', [
                'user'               => $user,
                'client'             => null,
                'activeServices'     => 0,
                'pendingInvoices'    => 0,
                'openTickets'        => 0,
            ]);
        }

        // Servicios activos
        $activeServices = Service::where('client_id', $client->id)
            ->where('status', 'active')
            ->count();

        // Facturas pendientes (unpaid y overdue)
        $pendingInvoices = Invoice::where('client_id', $client->id)
            ->whereIn('status', ['unpaid', 'overdue'])
            ->count();

        // Tickets abiertos (open, answered)
        $openTickets = Ticket::where('client_id', $client->id)
            ->whereIn('status', ['open', 'answered'])
            ->count();

        return view('dashboard.index', compact(
            'user',
            'client',
            'activeServices',
            'pendingInvoices',
            'openTickets'
        ));
    }
}
