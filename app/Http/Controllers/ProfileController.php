<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Muestra el formulario de perfil del cliente.
     */
    public function edit()
    {
        $user   = Auth::user();
        $client = $user->client;

        if (!$client) {
            abort(403, 'Tu usuario no tiene un cliente asociado.');
        }

        return view('dashboard.profile.edit', compact('user', 'client'));
    }

    /**
     * Actualiza los datos del cliente.
     */
    public function update(Request $request)
    {
        $user   = Auth::user();
        $client = $user->client;

        if (!$client) {
            abort(403, 'Tu usuario no tiene un cliente asociado.');
        }

        $data = $request->validate([
            'first_name'   => ['required', 'string', 'max:255'],
            'last_name'    => ['required', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'phone'        => ['nullable', 'string', 'max:100'],
            'country'      => ['nullable', 'string', 'size:2'],
            'state'        => ['nullable', 'string', 'max:255'],
            'city'         => ['nullable', 'string', 'max:255'],
            'address'      => ['nullable', 'string', 'max:255'],
            'zip'          => ['nullable', 'string', 'max:50'],
            'language'     => ['nullable', 'in:es,en'],
        ], [
            'first_name.required' => 'El nombre es obligatorio.',
            'last_name.required'  => 'El apellido es obligatorio.',
        ]);

        $client->first_name   = $data['first_name'];
        $client->last_name    = $data['last_name'];
        $client->company_name = $data['company_name'] ?? null;
        $client->phone        = $data['phone'] ?? null;
        $client->country      = $data['country'] ? strtoupper($data['country']) : null;
        $client->state        = $data['state'] ?? null;
        $client->city         = $data['city'] ?? null;
        $client->address      = $data['address'] ?? null;
        $client->zip          = $data['zip'] ?? null;

        if (!empty($data['language'])) {
            $client->language = $data['language'];
        }

        $client->save();

        // Si quisieras sincronizar el nombre "bonito" del usuario:
        $user->name = trim($client->first_name . ' ' . $client->last_name);
        $user->save();

        return redirect()
            ->route('profile.edit')
            ->with('status', 'Tus datos se han actualizado correctamente.');
    }
}
