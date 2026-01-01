@extends('layouts.admin')

@section('title', 'Pasarelas de Pago')

@section('admin-content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-bold text-white">Pasarelas de Pago</h1>
        <p class="text-slate-400 text-sm">Gestiona los métodos de cobro de tu empresa.</p>
    </div>
</div>

<div class="glass rounded-2xl border border-slate-800 overflow-hidden">
    <table class="w-full text-left text-sm text-slate-400">
        <thead class="bg-slate-900/50 text-slate-200 uppercase font-bold">
            <tr>
                <th class="px-6 py-4">Nombre</th>
                <th class="px-6 py-4">Estado</th>
                <th class="px-6 py-4">Modo</th>
                <th class="px-6 py-4 text-right">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-800">
            @foreach($gateways as $gateway)
            <tr class="hover:bg-slate-800/30 transition">
                <td class="px-6 py-4 font-medium text-white flex items-center gap-3">
                    @if($gateway->slug == 'paypal') <span class="text-blue-400 text-xl">🅿️</span>
                    @elseif($gateway->slug == 'payu') <span class="text-green-400 text-xl">💳</span>
                    @else <span class="text-slate-400 text-xl">💰</span> @endif
                    {{ $gateway->name }}
                </td>
                <td class="px-6 py-4">
                    @if($gateway->is_active)
                        <span class="px-2 py-1 rounded-full text-xs font-bold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">Activa</span>
                    @else
                        <span class="px-2 py-1 rounded-full text-xs font-bold bg-slate-700 text-slate-400">Inactiva</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    @if($gateway->test_mode)
                        <span class="text-amber-400 text-xs font-mono">TEST (Sandbox)</span>
                    @else
                        <span class="text-blue-400 text-xs font-mono">PRODUCCIÓN</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-right">
                    <a href="{{ route('admin.gateways.edit', $gateway->id) }}" class="text-blue-400 hover:text-blue-300 font-medium">Configurar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection