<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Service;
use App\Models\Invoice;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class AdminDashboardController extends Controller
{
    /**
     * Dashboard principal del administrador.
     */
    public function index()
    {
        $user = Auth::user();

        // Seguridad básica: solo usuarios tipo "admin"
        if (!$user || $user->type !== 'admin') {
            abort(403, 'No tienes permisos para acceder al panel administrativo.');
        }

        // Métricas generales
        $totalClients       = Client::count();
        $activeServices     = Service::where('status', 'active')->count();
        $pendingInvoices    = Invoice::whereIn('status', ['unpaid', 'overdue'])->count();
        $openTickets        = Ticket::whereIn('status', ['open', 'answered'])->count();

        $recentClients      = Client::orderByDesc('id')->limit(5)->get();
        $recentInvoices     = Invoice::orderByDesc('id')->limit(5)->get();
        $recentTickets      = Ticket::orderByDesc('id')->limit(5)->get();

        return view('admin.dashboard', compact(
            'user',
            'totalClients',
            'activeServices',
            'pendingInvoices',
            'openTickets',
            'recentClients',
            'recentInvoices',
            'recentTickets'
        ));
    }
}
