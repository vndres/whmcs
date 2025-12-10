<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClientController extends Controller
{
    /**
     * Listado de clientes.
     */
    public function index(Request $request)
    {
        $search = $request->get('q');

        $clients = Client::query()
            ->when($search, function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('company_name', 'like', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('admin.clients.index', compact('clients', 'search'));
    }

    /**
     * Formulario de creación.
     */
    public function create()
    {
        return view('admin.clients.create');
    }

    /**
     * Guardar nuevo cliente.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'company_name' => ['nullable', 'string', 'max:255'],
            'first_name'   => ['required', 'string', 'max:255'],
            'last_name'    => ['required', 'string', 'max:255'],
            'email'        => ['required', 'email', 'max:255', 'unique:clients,email'],
            'phone'        => ['nullable', 'string', 'max:100'],
            'country'      => ['nullable', 'string', 'max:2'],
            'state'        => ['nullable', 'string', 'max:255'],
            'city'         => ['nullable', 'string', 'max:255'],
            'address'      => ['nullable', 'string', 'max:255'],
            'zip'          => ['nullable', 'string', 'max:50'],
            'currency'     => ['nullable', 'string', 'max:3'],
            'language'     => ['nullable', 'string', 'max:5'],
            'is_active'    => ['nullable', 'boolean'],
        ]);

        $data['uuid']          = (string) Str::uuid();
        $data['currency']      = $data['currency'] ?? 'USD';
        $data['language']      = $data['language'] ?? 'es';
        $data['is_active']     = $request->boolean('is_active', true);
        $data['credit_balance'] = 0;

        Client::create($data);

        return redirect()
            ->route('admin.clients.index')
            ->with('success', 'Cliente creado correctamente.');
    }

    /**
     * Formulario de edición.
     */
    public function edit(Client $client)
    {
        return view('admin.clients.edit', compact('client'));
    }

    /**
     * Actualizar cliente.
     */
    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'company_name' => ['nullable', 'string', 'max:255'],
            'first_name'   => ['required', 'string', 'max:255'],
            'last_name'    => ['required', 'string', 'max:255'],
            'email'        => ['required', 'email', 'max:255', 'unique:clients,email,' . $client->id],
            'phone'        => ['nullable', 'string', 'max:100'],
            'country'      => ['nullable', 'string', 'max:2'],
            'state'        => ['nullable', 'string', 'max:255'],
            'city'         => ['nullable', 'string', 'max:255'],
            'address'      => ['nullable', 'string', 'max:255'],
            'zip'          => ['nullable', 'string', 'max:50'],
            'currency'     => ['nullable', 'string', 'max:3'],
            'language'     => ['nullable', 'string', 'max:5'],
            'is_active'    => ['nullable', 'boolean'],
        ]);

        $data['is_active'] = $request->boolean('is_active', true);

        $client->update($data);

        return redirect()
            ->route('admin.clients.index')
            ->with('success', 'Cliente actualizado correctamente.');
    }

    /**
     * Eliminar cliente.
     * (Ojo: en producción normalmente preferirías desactivar antes que borrar).
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()
            ->route('admin.clients.index')
            ->with('success', 'Cliente eliminado correctamente.');
    }
}
