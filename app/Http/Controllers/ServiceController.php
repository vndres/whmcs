<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    /**
     * Listado de servicios del cliente.
     */
    public function index(Request $request)
    {
        $user   = Auth::user();
        $client = $user->client;

        if (!$client) {
            $services = collect();

            return view('dashboard.services.index', compact('user', 'client', 'services'));
        }

        $services = Service::with(['product', 'server'])
            ->where('client_id', $client->id)
            ->orderByDesc('id')
            ->paginate(10);

        return view('dashboard.services.index', compact('user', 'client', 'services'));
    }

    /**
     * Detalle de un servicio.
     */
    public function show(Service $service)
    {
        $user   = Auth::user();
        $client = $user->client;

        if (!$client || $service->client_id !== $client->id) {
            abort(404);
        }

        $service->load(['product', 'server']);

        return view('dashboard.services.show', compact('user', 'client', 'service'));
    }
}
