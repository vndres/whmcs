<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Server;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    public function index()
    {
        $servers = Server::orderBy('name')->paginate(10);
        return view('admin.servers.index', compact('servers'));
    }

    public function create()
    {
        return view('admin.servers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'hostname'   => 'required|string|max:255',
            'ip_address' => 'nullable|ipv4',
            'type'       => 'required|string', // cpanel, plesk, directadmin
            'port'       => 'required|integer',
            'api_token'  => 'required|string',
            'use_ssl'    => 'boolean',
        ]);

        $data['is_active'] = $request->has('is_active');
        $data['use_ssl']   = $request->has('use_ssl');

        Server::create($data);

        return redirect()->route('admin.servers.index')->with('success', 'Servidor agregado correctamente.');
    }

    public function edit(Server $server)
    {
        return view('admin.servers.edit', compact('server'));
    }

    public function update(Request $request, Server $server)
    {
        $data = $request->validate([
            'name'       => 'required|string|max:255',
            'hostname'   => 'required|string|max:255',
            'ip_address' => 'nullable|ipv4',
            'type'       => 'required|string',
            'port'       => 'required|integer',
            'api_token'  => 'nullable|string', // Nullable para no obligar a re-escribirlo si no cambia
        ]);

        $data['is_active'] = $request->has('is_active');
        $data['use_ssl']   = $request->has('use_ssl');

        // Si el token viene vacío, no lo sobreescribimos (por seguridad visual)
        if (empty($data['api_token'])) {
            unset($data['api_token']);
        }

        $server->update($data);

        return redirect()->route('admin.servers.index')->with('success', 'Servidor actualizado.');
    }

    public function destroy(Server $server)
    {
        $server->delete();
        return redirect()->route('admin.servers.index')->with('success', 'Servidor eliminado.');
    }
}