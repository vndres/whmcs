@extends('layouts.frontend')

@section('title', 'Configurar Producto - ' . $product->name)

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="mb-8">
        <a href="{{ route('home') }}" class="text-xs text-slate-400 hover:text-white transition">&larr; Volver a planes</a>
        <h1 class="text-3xl font-bold text-slate-50 mt-2">Configurar {{ $product->name }}</h1>
        <p class="text-slate-400">Personaliza tu servicio antes de continuar.</p>
    </div>

    <form action="{{ route('cart.add') }}" method="POST" id="configForm">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">

        <div class="grid gap-8">
            
            {{-- 1. CICLO DE FACTURACIÓN --}}
            <div class="glass rounded-2xl border border-slate-800 p-6">
                <h3 class="text-lg font-semibold text-slate-100 mb-4 flex items-center gap-2">
                    <span class="bg-emerald-500/20 text-emerald-400 text-xs px-2 py-1 rounded">Paso 1</span>
                    Elige tu ciclo de facturación
                </h3>

                <div class="grid sm:grid-cols-2 gap-4">
                    {{-- Opción Mensual --}}
                    @if(in_array('monthly', $allowedCycles))
                    <label class="cursor-pointer relative">
                        <input type="radio" name="billing_cycle" value="monthly" class="peer sr-only" checked>
                        <div class="p-4 rounded-xl border border-slate-700 bg-slate-900/50 hover:bg-slate-800 peer-checked:border-emerald-500 peer-checked:bg-emerald-500/10 transition">
                            <div class="font-bold text-slate-200">Mensual</div>
                            <div class="text-emerald-400 text-xl font-bold">${{ number_format($product->price_monthly, 2) }}</div>
                            <div class="text-xs text-slate-500 mt-1">Facturado cada mes</div>
                        </div>
                    </label>
                    @endif

                    {{-- Opción Anual --}}
                    @if(in_array('yearly', $allowedCycles))
                    <label class="cursor-pointer relative">
                        <input type="radio" name="billing_cycle" value="yearly" class="peer sr-only" {{ !in_array('monthly', $allowedCycles) ? 'checked' : '' }}>
                        <div class="p-4 rounded-xl border border-slate-700 bg-slate-900/50 hover:bg-slate-800 peer-checked:border-emerald-500 peer-checked:bg-emerald-500/10 transition">
                            <div class="flex justify-between">
                                <div class="font-bold text-slate-200">Anual</div>
                                @if(isset($product->config['free_domain']) && $product->config['free_domain'])
                                    <span class="bg-yellow-500/20 text-yellow-300 text-[10px] px-2 py-0.5 rounded uppercase font-bold">¡Dominio Gratis!</span>
                                @endif
                            </div>
                            <div class="text-emerald-400 text-xl font-bold">${{ number_format($product->price_yearly, 2) }}</div>
                            <div class="text-xs text-slate-500 mt-1">
                                Equivale a ${{ number_format($product->price_yearly / 12, 2) }}/mes
                            </div>
                        </div>
                    </label>
                    @endif
                </div>
            </div>

            {{-- 2. DOMINIO --}}
            <div class="glass rounded-2xl border border-slate-800 p-6" x-data="{ domainMode: 'new' }">
                <h3 class="text-lg font-semibold text-slate-100 mb-4 flex items-center gap-2">
                    <span class="bg-emerald-500/20 text-emerald-400 text-xs px-2 py-1 rounded">Paso 2</span>
                    Configura tu Dominio
                </h3>

                {{-- Selector de tipo de dominio --}}
                <div class="flex gap-4 mb-4 text-sm border-b border-slate-800 pb-4">
                    <label class="cursor-pointer flex items-center gap-2">
                        <input type="radio" name="domain_option" value="register" x-model="domainMode" class="text-emerald-500 focus:ring-0">
                        <span class="text-slate-300">Registrar nuevo dominio</span>
                    </label>
                    <label class="cursor-pointer flex items-center gap-2">
                        <input type="radio" name="domain_option" value="own" x-model="domainMode" class="text-emerald-500 focus:ring-0">
                        <span class="text-slate-300">Usar mi propio dominio</span>
                    </label>
                </div>

                {{-- Campo Registrar Nuevo --}}
                <div x-show="domainMode === 'new'">
                    <div class="flex flex-col sm:flex-row gap-2">
                        <input type="text" id="configDomainInput" class="flex-1 bg-slate-900 border-slate-700 rounded-xl px-4 py-3 text-slate-200 focus:border-emerald-500 focus:outline-none" placeholder="ejemplo.com">
                        <button type="button" onclick="checkConfigDomain()" class="bg-emerald-600 hover:bg-emerald-500 text-white px-6 py-3 rounded-xl font-bold transition">
                            Comprobar
                        </button>
                    </div>
                    
                    {{-- Resultados AJAX --}}
                    <div id="configDomainResult" class="mt-4 hidden p-4 rounded-xl border border-slate-700/50 bg-slate-900/30">
                        </div>
                    
                    {{-- Inputs ocultos para enviar al carrito --}}
                    <input type="hidden" name="domain_name" id="finalDomainName">
                    <input type="hidden" name="domain_price" id="finalDomainPrice">
                </div>

                {{-- Campo Usar Propio --}}
                <div x-show="domainMode === 'own'" class="hidden" :class="{ 'hidden': domainMode !== 'own' }">
                    <p class="text-xs text-slate-400 mb-2">Ingresa tu dominio existente. Deberás cambiar los DNS luego.</p>
                    <input type="text" name="own_domain" class="w-full bg-slate-900 border-slate-700 rounded-xl px-4 py-3 text-slate-200" placeholder="midominio.com">
                </div>
            </div>

            {{-- RESUMEN FLOTANTE O BOTÓN FINAL --}}
            <div class="flex justify-end">
                <button type="submit" class="bg-emerald-500 hover:bg-emerald-400 text-slate-900 font-bold px-8 py-4 rounded-xl shadow-lg shadow-emerald-500/20 transition transform hover:-translate-y-1">
                    Continuar al Pedido &rarr;
                </button>
            </div>

        </div>
    </form>
</div>

{{-- Script para búsqueda en esta página --}}
<script>
    async function checkConfigDomain() {
        const domain = document.getElementById('configDomainInput').value;
        const resultBox = document.getElementById('configDomainResult');
        const finalName = document.getElementById('finalDomainName');
        const finalPrice = document.getElementById('finalDomainPrice');

        if(!domain) return;

        resultBox.innerHTML = '<span class="text-slate-400 text-xs animate-pulse">Verificando...</span>';
        resultBox.classList.remove('hidden');

        try {
            const response = await fetch('{{ route('domain.check') }}', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ domain: domain })
            });
            const data = await response.json();

            if (data.status === 'available') {
                // Guardar en inputs ocultos para el POST del formulario
                finalName.value = data.domain;
                finalPrice.value = data.price;

                resultBox.innerHTML = `
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center gap-2">
                            <span class="text-emerald-400 text-lg">✓</span>
                            <span class="font-bold text-slate-200">${data.domain}</span>
                            <span class="text-emerald-400 bg-emerald-500/10 px-2 py-0.5 rounded text-xs">Disponible</span>
                        </div>
                        <div class="font-bold text-slate-200">$${data.price}</div>
                    </div>
                    <p class="text-xs text-slate-500 mt-2">¡Dominio seleccionado! Se agregará al carrito al continuar.</p>
                `;
                resultBox.className = "mt-4 p-4 rounded-xl border border-emerald-500/30 bg-emerald-500/5 block";
            } else {
                finalName.value = '';
                resultBox.innerHTML = `<span class="text-rose-400 text-sm font-medium">✕ ${data.domain} no está disponible.</span>`;
                resultBox.className = "mt-4 p-4 rounded-xl border border-rose-500/30 bg-rose-500/5 block";
            }
        } catch (e) {
            console.error(e);
        }
    }
</script>
{{-- Cargar AlpineJS si no está --}}
@if(!app()->bound('livewire')) <script src="//unpkg.com/alpinejs" defer></script> @endif
@endsection