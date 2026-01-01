<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Obtenemos el cliente asociado al usuario logueado
        // Asegúrate de que en tu modelo User tengas la relación: public function client() { return $this->hasOne(Client::class); }
        $client = $user->client; 

        // Valores por defecto (para evitar errores si no es cliente aún)
        $activeServices = 0;
        $pendingInvoices = 0;
        $openTickets = 0;
        $recentInvoices = collect([]);

        if ($client) {
            // 1. Contar Servicios Activos
            $activeServices = $client->services()
                ->where('status', 'active')
                ->count();

            // 2. Contar Facturas Pendientes (Unpaid)
            // Asegúrate que el estado en tu DB sea 'Unpaid' (o 'unpaid' según tus datos)
            $pendingInvoices = $client->invoices()
                ->where('status', 'Unpaid')
                ->count();

            // 3. Contar Tickets Abiertos (Todos menos los cerrados)
            $openTickets = $client->tickets()
                ->where('status', '!=', 'Closed')
                ->count();
                
            // 4. Traer últimas 3 facturas para el widget de "Actividad Reciente"
            $recentInvoices = $client->invoices()
                ->latest()
                ->take(3)
                ->get();
        }

        // CORRECCIÓN IMPORTANTE:
        // Apuntamos a 'dashboard.index' porque tu archivo está en resources/views/dashboard/index.blade.php
        return view('dashboard.index', compact(
            'user', 
            'client', 
            'activeServices', 
            'pendingInvoices', 
            'openTickets',
            'recentInvoices'
        ));
    }
}