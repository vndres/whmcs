<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DomainController extends Controller
{
    /**
     * Lista los dominios del cliente.
     * Aqui consideramos como dominio todo servicio cuyo producto sea type = 'domain'.
     */
    public function index(Request $request)
    {
        $user   = Auth::user();
        $client = $user->client;

        if (!$client) {
            $domains = collect();
            return view('dashboard.domains.index', compact('user', 'client', 'domains'));
        }

        $domains = Service::with(['product', 'server'])
            ->where('client_id', $client->id)
            ->whereHas('product', function ($q) {
                $q->where('type', 'domain');
            })
            ->orderBy('domain')
            ->orderBy('id', 'desc')
            ->get();

        return view('dashboard.domains.index', compact('user', 'client', 'domains'));
    }

    /**
     * Muestra el detalle de un dominio.
     * Usamos Service como modelo, pero lo tratamos como dominio.
     */
    public function show(Service $domain)
    {
        $user   = Auth::user();
        $client = $user->client;

        if (!$client || $domain->client_id !== $client->id) {
            abort(404);
        }

        // Aseguramos que realmente sea un producto tipo dominio
        $domain->load(['product', 'server']);

        if (!$domain->product || $domain->product->type !== 'domain') {
            abort(404);
        }

        return view('dashboard.domains.show', [
            'user'   => $user,
            'client'=> $client,
            'domain'=> $domain,
        ]);
    }
}
