@extends('layouts.admin')

@section('title', 'Configurar ' . $gateway->name)

@section('admin-content')
<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.gateways.index') }}" class="text-slate-400 hover:text-white text-sm mb-2 inline-block">← Volver al listado</a>
        <h1 class="text-2xl font-bold text-white">Configurar {{ $gateway->name }}</h1>
    </div>

    <form action="{{ route('admin.gateways.update', $gateway->id) }}" method="POST" class="glass p-8 rounded-2xl border border-slate-800">
        @csrf
        @method('PUT')

        {{-- Nombre Visible --}}
        <div class="mb-6">
            <label class="block text-sm font-medium text-slate-300 mb-2">Nombre para mostrar al cliente</label>
            <input type="text" name="name" value="{{ $gateway->name }}" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none">
        </div>

        {{-- Switches de Estado --}}
        <div class="grid grid-cols-2 gap-6 mb-8 p-4 bg-slate-800/50 rounded-xl border border-slate-700">
            <div class="flex items-center justify-between">
                <div>
                    <span class="block text-sm font-bold text-white">Activar Pasarela</span>
                    <span class="text-xs text-slate-400">¿Mostrar en el checkout?</span>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="is_active" class="sr-only peer" {{ $gateway->is_active ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                </label>
            </div>

            <div class="flex items-center justify-between">
                <div>
                    <span class="block text-sm font-bold text-white">Modo de Pruebas</span>
                    <span class="text-xs text-slate-400">Usar Sandbox / Test</span>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="test_mode" class="sr-only peer" {{ $gateway->test_mode ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                </label>
            </div>
        </div>

        <hr class="border-slate-700 mb-8">

        {{-- CAMPOS ESPECÍFICOS SEGÚN LA PASARELA --}}
        
        @if($gateway->slug == 'paypal')
            <h3 class="text-lg font-bold text-white mb-4">Credenciales API (PayPal REST)</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Client ID</label>
                    <input type="text" name="client_id" value="{{ $gateway->config['client_id'] ?? '' }}" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2 text-white font-mono text-sm focus:border-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Client Secret</label>
                    <input type="password" name="client_secret" value="{{ $gateway->config['client_secret'] ?? '' }}" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2 text-white font-mono text-sm focus:border-blue-500 outline-none">
                </div>
            </div>
        
        @elseif($gateway->slug == 'payu')
            <h3 class="text-lg font-bold text-white mb-4">Credenciales PayU Latam</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Merchant ID</label>
                    <input type="text" name="merchant_id" value="{{ $gateway->config['merchant_id'] ?? '' }}" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2 text-white font-mono text-sm focus:border-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-1">Account ID</label>
                    <input type="text" name="account_id" value="{{ $gateway->config['account_id'] ?? '' }}" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2 text-white font-mono text-sm focus:border-blue-500 outline-none">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase mb-1">API Key</label>
                    <input type="password" name="api_key" value="{{ $gateway->config['api_key'] ?? '' }}" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-4 py-2 text-white font-mono text-sm focus:border-blue-500 outline-none">
                </div>
            </div>
        @endif

        <div class="mt-8 flex justify-end">
            <button type="submit" class="bg-emerald-500 hover:bg-emerald-400 text-slate-900 font-bold py-2 px-6 rounded-lg transition shadow-lg shadow-emerald-500/20">
                Guardar Cambios
            </button>
        </div>
    </form>
</div>
@endsection