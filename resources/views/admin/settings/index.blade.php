@extends('layouts.admin')

@section('admin-content')
<div class="max-w-4xl mx-auto" x-data="{ tab: 'general' }">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-50">Ajustes del Sistema</h1>
            <p class="text-sm text-slate-400">Configuración global de tu empresa y la plataforma.</p>
        </div>
        <button type="submit" form="settingsForm" class="bg-emerald-500 text-slate-900 px-6 py-2 rounded-xl text-sm font-bold hover:bg-emerald-400 transition shadow-lg shadow-emerald-500/20">
            Guardar Cambios
        </button>
    </div>

    @if(session('success'))
        <div class="mb-6 glass rounded-xl border border-emerald-600/60 px-4 py-3 text-xs text-emerald-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex gap-6 items-start">
        
        {{-- Menú Lateral de Pestañas --}}
        <div class="w-48 flex-shrink-0 glass rounded-2xl border border-slate-800 p-2 space-y-1">
            <button @click="tab = 'general'" 
                    :class="{ 'bg-slate-800 text-white': tab === 'general', 'text-slate-400 hover:text-slate-200': tab !== 'general' }"
                    class="w-full text-left px-3 py-2 rounded-xl text-xs font-medium transition">
                🏢 General
            </button>
            <button @click="tab = 'billing'" 
                    :class="{ 'bg-slate-800 text-white': tab === 'billing', 'text-slate-400 hover:text-slate-200': tab !== 'billing' }"
                    class="w-full text-left px-3 py-2 rounded-xl text-xs font-medium transition">
                💳 Facturación
            </button>
            <button @click="tab = 'security'" 
                    :class="{ 'bg-slate-800 text-white': tab === 'security', 'text-slate-400 hover:text-slate-200': tab !== 'security' }"
                    class="w-full text-left px-3 py-2 rounded-xl text-xs font-medium transition">
                🔒 Seguridad
            </button>
        </div>

        {{-- Contenido del Formulario --}}
        <form id="settingsForm" action="{{ route('admin.settings.update') }}" method="POST" class="flex-1">
            @csrf

            {{-- TAB: GENERAL --}}
            <div x-show="tab === 'general'" class="glass rounded-2xl border border-slate-800 p-6 space-y-5">
                <h2 class="text-sm font-bold text-slate-100 mb-4 border-b border-slate-800 pb-2">Identidad de la Empresa</h2>
                
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Nombre de la Empresa</label>
                    <input type="text" name="company_name" value="{{ $settings['company_name'] ?? '' }}" 
                           class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-100 focus:border-emerald-500 focus:outline-none" required>
                    <p class="text-[10px] text-slate-500 mt-1">Aparecerá en el título de la web y correos.</p>
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Correo Electrónico Principal</label>
                    <input type="email" name="company_email" value="{{ $settings['company_email'] ?? '' }}" 
                           class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-100" required>
                    <p class="text-[10px] text-slate-500 mt-1">Usado como remitente en notificaciones.</p>
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Dirección Física</label>
                    <textarea name="company_address" rows="3" 
                              class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-100">{{ $settings['company_address'] ?? '' }}</textarea>
                    <p class="text-[10px] text-slate-500 mt-1">Se mostrará en el pie de página de las facturas PDF.</p>
                </div>
            </div>

            {{-- TAB: FACTURACIÓN --}}
            <div x-show="tab === 'billing'" class="glass rounded-2xl border border-slate-800 p-6 space-y-5 hidden" :class="{ 'hidden': tab !== 'billing' }">
                <h2 class="text-sm font-bold text-blue-400 mb-4 border-b border-slate-800 pb-2">Moneda e Impuestos</h2>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1">Código de Moneda</label>
                        <input type="text" name="currency_code" value="{{ $settings['currency_code'] ?? 'USD' }}" 
                               class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-100 uppercase" placeholder="USD">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1">Símbolo</label>
                        <input type="text" name="currency_symbol" value="{{ $settings['currency_symbol'] ?? '$' }}" 
                               class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-100" placeholder="$">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Impuesto por Defecto (%)</label>
                    <div class="relative w-32">
                        <input type="number" name="tax_rate" value="{{ $settings['tax_rate'] ?? '0' }}" 
                               class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-100">
                        <span class="absolute right-3 top-2 text-slate-500">%</span>
                    </div>
                    <p class="text-[10px] text-slate-500 mt-1">Se aplicará a nuevos pedidos si no se especifica otro.</p>
                </div>
            </div>

            {{-- TAB: SEGURIDAD --}}
            <div x-show="tab === 'security'" class="glass rounded-2xl border border-slate-800 p-6 space-y-5 hidden" :class="{ 'hidden': tab !== 'security' }">
                <h2 class="text-sm font-bold text-rose-400 mb-4 border-b border-slate-800 pb-2">Acceso y Mantenimiento</h2>
                
                <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-700 bg-slate-900/30 cursor-pointer hover:bg-slate-800 transition">
                    <input type="checkbox" name="enable_registrations" value="1" 
                           {{ ($settings['enable_registrations'] ?? '0') == '1' ? 'checked' : '' }}
                           class="rounded bg-slate-800 border-slate-600 text-emerald-500 focus:ring-emerald-500/50 w-5 h-5">
                    <div>
                        <div class="text-xs font-semibold text-slate-200">Permitir Registro de Usuarios</div>
                        <div class="text-[10px] text-slate-400">Si se desactiva, solo los administradores podrán crear cuentas.</div>
                    </div>
                </label>

                <label class="flex items-center gap-3 p-3 rounded-xl border border-slate-700 bg-slate-900/30 cursor-pointer hover:bg-slate-800 transition">
                    <input type="checkbox" name="maintenance_mode" value="1" 
                           {{ ($settings['maintenance_mode'] ?? '0') == '1' ? 'checked' : '' }}
                           class="rounded bg-slate-800 border-slate-600 text-rose-500 focus:ring-rose-500/50 w-5 h-5">
                    <div>
                        <div class="text-xs font-semibold text-rose-300">Modo Mantenimiento</div>
                        <div class="text-[10px] text-slate-400">Bloquea el acceso al área de clientes. Solo admins podrán entrar.</div>
                    </div>
                </label>
            </div>

        </form>
    </div>
</div>

{{-- Script de Alpine para Tabs (Si no usas Alpine, este pequeño JS lo hace funcionar) --}}
@if(!app()->bound('livewire')) 
<script src="//unpkg.com/alpinejs" defer></script>
@endif
@endsection