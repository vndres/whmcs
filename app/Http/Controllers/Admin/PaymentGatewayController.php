<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;

class PaymentGatewayController extends Controller
{
    public function index()
    {
        $gateways = PaymentGateway::all();
        return view('admin.gateways.index', compact('gateways'));
    }

    public function edit($id)
    {
        $gateway = PaymentGateway::findOrFail($id);
        return view('admin.gateways.edit', compact('gateway'));
    }

    public function update(Request $request, $id)
    {
        $gateway = PaymentGateway::findOrFail($id);

        // Validar campos básicos
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Actualizar estado y modo
        $gateway->name = $request->name;
        $gateway->is_active = $request->has('is_active');
        $gateway->test_mode = $request->has('test_mode');

        // Actualizar Configuración (JSON)
        // Recorremos los campos específicos según la pasarela
        $currentConfig = $gateway->config;
        
        if ($gateway->slug == 'paypal') {
            $currentConfig['client_id'] = $request->input('client_id');
            $currentConfig['client_secret'] = $request->input('client_secret');
        } elseif ($gateway->slug == 'payu') {
            $currentConfig['merchant_id'] = $request->input('merchant_id');
            $currentConfig['account_id'] = $request->input('account_id');
            $currentConfig['api_key'] = $request->input('api_key');
        }

        $gateway->config = $currentConfig;
        $gateway->save();

        return redirect()->route('admin.gateways.index')
            ->with('success', 'Pasarela actualizada correctamente.');
    }
}