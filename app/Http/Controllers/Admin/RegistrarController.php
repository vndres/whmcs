<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registrar;
use Illuminate\Http\Request;

class RegistrarController extends Controller
{
    public function index()
    {
        $registrars = Registrar::all();
        return view('admin.registrars.index', compact('registrars'));
    }

    public function create()
    {
        return view('admin.registrars.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|in:godaddy,resellerclub,namecheap',
        ]);

        // Lógica para guardar credenciales según el tipo
        $config = [];
        if ($request->type === 'godaddy') {
            $config = [
                'api_key'    => $request->input('gd_key'),
                'api_secret' => $request->input('gd_secret'),
                'env'        => $request->input('gd_env', 'production'),
            ];
        } elseif ($request->type === 'resellerclub') {
            $config = [
                'user_id' => $request->input('rc_userid'),
                'api_key' => $request->input('rc_apikey'),
                'test_mode' => $request->has('rc_testmode'),
            ];
        }

        Registrar::create([
            'name'      => $request->name,
            'type'      => $request->type,
            'config'    => $config,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.registrars.index')->with('success', 'Registrador configurado.');
    }

    public function edit(Registrar $registrar)
    {
        return view('admin.registrars.edit', compact('registrar'));
    }

    public function update(Request $request, Registrar $registrar)
    {
        // Similar al store, pero actualizando el array $config existente
        // o sobreescribiéndolo.
        
        $config = $registrar->config;

        if ($registrar->type === 'godaddy') {
            if($request->filled('gd_key')) $config['api_key'] = $request->gd_key;
            if($request->filled('gd_secret')) $config['api_secret'] = $request->gd_secret;
            $config['env'] = $request->gd_env;
        } elseif ($registrar->type === 'resellerclub') {
            if($request->filled('rc_userid')) $config['user_id'] = $request->rc_userid;
            if($request->filled('rc_apikey')) $config['api_key'] = $request->rc_apikey;
        }

        $registrar->update([
            'name' => $request->name,
            'config' => $config,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.registrars.index')->with('success', 'Credenciales actualizadas.');
    }
}