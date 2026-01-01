@extends('layouts.frontend')

@section('title', 'Finalizar Compra')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-12">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-50">Resumen de tu Pedido</h1>
            <p class="text-slate-400 text-sm">Revisa tus servicios antes de pagar.</p>
        </div>
        <a href="{{ route('home') }}#planes" class="inline-flex items-center gap-2 text-emerald-400 hover:text-emerald-300 font-medium transition text-sm">
            <span>+ Agregar otro servicio</span>
        </a>
    </div>

    @if(session('error'))
        <div class="bg-rose-500/10 border border-rose-500/50 text-rose-400 p-4 rounded-xl mb-6 flex items-center gap-3">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-8">
        
        {{-- COLUMNA IZQUIERDA: CARRITO --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- 1. LISTA DE PRODUCTOS --}}
            <div class="glass rounded-2xl border border-slate-800 overflow-hidden">
                <div class="bg-slate-900/50 px-6 py-4 border-b border-slate-800 flex justify-between items-center">
                    <h3 class="text-sm font-semibold text-slate-300">Servicios en el carrito</h3>
                    <span class="text-xs text-slate-500">{{ count($cart) }} ítems</span>
                </div>
                
                <div class="p-6 space-y-6">
                    @if(empty($cart))
                        <div class="text-center py-8">
                            <p class="text-slate-500">Tu carrito está vacío.</p>
                            <a href="{{ route('home') }}" class="mt-4 inline-block px-6 py-2 rounded-xl bg-emerald-500 text-slate-900 font-bold hover:bg-emerald-400">Ir a comprar</a>
                        </div>
                    @else
                        {{-- HOSTING / VPS / RESELLER --}}
                        @if(isset($cart['hosting']))
                        <div class="flex justify-between items-start group">
                            <div class="flex items-start gap-4">
                                {{-- Icono Dinámico según el nombre del plan o tipo --}}
                                @php
                                    $icon = '☁️'; // Default Hosting
                                    $name = strtolower($cart['hosting']['name']);
                                    if(str_contains($name, 'vps')) $icon = '🖥️';
                                    if(str_contains($name, 'reseller')) $icon = '💼';
                                @endphp
                                <div class="h-12 w-12 rounded-xl bg-emerald-500/10 text-2xl flex items-center justify-center mt-1 border border-emerald-500/20">
                                    {{ $icon }}
                                </div>
                                <div>
                                    <div class="font-bold text-slate-100 flex items-center gap-2 text-lg">
                                        {{ $cart['hosting']['name'] }}
                                        <a href="{{ route('cart.remove', 'hosting') }}" class="text-[10px] text-rose-400 hover:text-rose-300 opacity-0 group-hover:opacity-100 transition px-2 py-0.5 rounded border border-rose-500/30 hover:bg-rose-500/10">
                                            Eliminar
                                        </a>
                                    </div>
                                    <div class="text-sm text-slate-400 mt-1">
                                        Ciclo: <span class="text-emerald-400 font-medium">{{ $cart['hosting']['period_name'] }}</span>
                                    </div>
                                    
                                    @if(!empty($cart['hosting']['has_free_domain']) && $cart['hosting']['billing_cycle'] == 'yearly')
                                        <div class="text-xs text-yellow-400 mt-1 flex items-center gap-1">
                                            <span>🎁</span> Aplica para Dominio Gratis
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="font-mono text-xl text-slate-200">${{ number_format($cart['hosting']['price'], 2) }}</div>
                            </div>
                        </div>
                        @endif

                        {{-- DOMINIO --}}
                        @if(isset($cart['domain']))
                        <div class="flex justify-between items-start group {{ isset($cart['hosting']) ? 'pt-6 border-t border-slate-800' : '' }}">
                            <div class="flex items-start gap-4">
                                <div class="h-12 w-12 rounded-xl bg-indigo-500/10 text-2xl flex items-center justify-center mt-1 border border-indigo-500/20">
                                    🌐
                                </div>
                                <div>
                                    <div class="font-bold text-slate-100 flex items-center gap-2 text-lg">
                                        {{ $cart['domain']['name'] }}
                                        <a href="{{ route('cart.remove', 'domain') }}" class="text-[10px] text-rose-400 hover:text-rose-300 opacity-0 group-hover:opacity-100 transition px-2 py-0.5 rounded border border-rose-500/30 hover:bg-rose-500/10">
                                            Eliminar
                                        </a>
                                    </div>
                                    <div class="text-sm text-indigo-400 mt-1">Registro de Dominio (1 Año)</div>
                                </div>
                            </div>
                            <div class="text-right">
                                @if(isset($cart['domain']['is_free']) && $cart['domain']['is_free'])
                                    <div class="font-mono text-emerald-400 font-bold text-xl">GRATIS</div>
                                    <div class="text-xs text-slate-500 line-through">${{ number_format($cart['domain']['price_original'], 2) }}</div>
                                @else
                                    <div class="font-mono text-xl text-slate-200">${{ number_format($cart['domain']['price'], 2) }}</div>
                                @endif
                            </div>
                        </div>
                        @endif
                    @endif
                </div>
                
                {{-- TOTAL --}}
                @if(!empty($cart))
                <div class="bg-slate-900/80 px-6 py-5 border-t border-slate-800 flex justify-between items-center">
                    <span class="text-slate-400 font-medium">Total a Pagar</span>
                    <div class="text-right">
                        <span class="text-3xl font-bold text-emerald-400 tracking-tight">${{ number_format($total ?? 0, 2) }}</span>
                        <div class="text-[10px] text-slate-500 uppercase tracking-widest">Impuestos incluidos</div>
                    </div>
                </div>
                @endif
            </div>

            {{-- 2. CROSS-SELLING: AGREGAR DOMINIO SI FALTA --}}
            @if(isset($cart['hosting']) && !isset($cart['domain']))
            <div class="glass rounded-2xl border border-indigo-500/30 p-6 relative overflow-hidden" x-data="{ searching: false, result: null }">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-indigo-500/10 rounded-full blur-2xl"></div>
                
                <h3 class="text-lg font-bold text-white mb-2 relative z-10">¿Olvidaste tu dominio?</h3>
                <p class="text-sm text-slate-400 mb-4 relative z-10">
                    Tu plan de hosting o VPS necesita una dirección web. Agrega una ahora.
                    @if(!empty($cart['hosting']['has_free_domain']) && $cart['hosting']['billing_cycle'] == 'yearly')
                        <span class="text-emerald-400 font-bold ml-1">¡Te sale GRATIS!</span>
                    @endif
                </p>

                <div class="flex flex-col sm:flex-row gap-3 relative z-10">
                    <input type="text" id="checkoutDomainInput" class="flex-1 bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 focus:border-indigo-500 focus:outline-none" placeholder="buscatudominio.com">
                    <button type="button" @click="checkCheckoutDomain()" class="bg-indigo-600 hover:bg-indigo-500 text-white font-bold px-6 py-3 rounded-xl transition flex items-center justify-center gap-2 min-w-[120px]">
                        <span x-show="!searching">Agregar</span>
                        <span x-show="searching" class="animate-spin h-4 w-4 border-2 border-white border-t-transparent rounded-full"></span>
                    </button>
                </div>

                <div id="checkoutDomainResult" class="mt-4 hidden p-3 rounded-lg border"></div>
            </div>
            
            <script>
                async function checkCheckoutDomain() {
                    const input = document.getElementById('checkoutDomainInput');
                    const resultBox = document.getElementById('checkoutDomainResult');
                    const domain = input.value;
                    
                    if(!domain) return;

                    resultBox.classList.add('hidden');

                    try {
                        const response = await fetch('{{ route('domain.check') }}', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            body: JSON.stringify({ domain: domain })
                        });
                        const data = await response.json();
                        
                        resultBox.classList.remove('hidden');
                        if(data.status === 'available') {
                            resultBox.className = "mt-4 p-3 rounded-lg border border-emerald-500/30 bg-emerald-500/10 flex justify-between items-center";
                            resultBox.innerHTML = `
                                <div class="text-sm">
                                    <span class="font-bold text-white">${data.domain}</span>
                                    <span class="text-emerald-400 block text-xs">Disponible - $${data.price}</span>
                                </div>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="domain" value="${data.domain}">
                                    <input type="hidden" name="domain_price" value="${data.price}">
                                    <button class="text-xs bg-emerald-500 text-slate-900 font-bold px-3 py-1.5 rounded hover:bg-emerald-400">Añadir</button>
                                </form>
                            `;
                        } else {
                            resultBox.className = "mt-4 p-3 rounded-lg border border-rose-500/30 bg-rose-500/10 text-rose-300 text-sm";
                            resultBox.innerText = "Dominio no disponible o inválido.";
                        }
                    } catch(e) { console.error(e); }
                }
            </script>
            @endif

            {{-- 3. DATOS DE CLIENTE / PAGO --}}
            @if(!empty($cart))
                @guest
                {{-- MODO INVITADO: REGISTRO --}}
                <div class="glass rounded-2xl border border-slate-800 p-6 md:p-8">
                    <h3 class="text-xl font-bold text-slate-100 mb-6 flex items-center gap-2">
                        <span class="bg-blue-500/20 text-blue-400 text-xs px-2 py-1 rounded">Paso Final</span>
                        Crea tu cuenta y Paga
                    </h3>
                    
                    <form action="{{ route('register.post') }}" method="POST" class="space-y-5">
                        @csrf
                        <input type="hidden" name="redirect_to" value="checkout">
                        <input type="hidden" name="locale" value="es">

                        <div class="grid md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-medium text-slate-400 mb-1.5">Nombre Completo</label>
                                <input type="text" name="name" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 focus:outline-none transition" required placeholder="Juan Pérez">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-400 mb-1.5">Correo Electrónico</label>
                                <input type="email" name="email" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 focus:outline-none transition" required placeholder="juan@empresa.com">
                            </div>
                        </div>
                        <div class="grid md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-xs font-medium text-slate-400 mb-1.5">Contraseña</label>
                                <input type="password" name="password" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 focus:outline-none transition" required>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-400 mb-1.5">Confirmar Contraseña</label>
                                <input type="password" name="password_confirmation" class="w-full bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 text-slate-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 focus:outline-none transition" required>
                            </div>
                        </div>
                        
                        <div class="pt-4">
                            <button type="submit" class="w-full bg-gradient-to-r from-emerald-500 to-emerald-400 hover:from-emerald-400 hover:to-emerald-300 text-slate-900 font-bold py-4 rounded-xl shadow-xl shadow-emerald-500/20 transition transform hover:-translate-y-0.5">
                                Completar Pedido &rarr;
                            </button>
                            <p class="text-center text-xs text-slate-500 mt-4">
                                Al registrarte aceptas nuestros <a href="#" class="text-emerald-400 hover:underline">Términos de Servicio</a>.
                            </p>
                        </div>
                    </form>

                    <div class="mt-6 pt-6 border-t border-slate-800 text-center text-sm text-slate-400">
                        ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-emerald-400 font-semibold hover:underline">Inicia sesión aquí</a>
                    </div>
                </div>
                
                @else
                
                {{-- MODO USUARIO LOGUEADO: CONFIRMAR COMPRA --}}
                <div class="glass rounded-2xl border border-slate-800 p-6 md:p-8">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-slate-100">Información del Cliente</h3>
                            <p class="text-sm text-slate-400">{{ Auth::user()->name }} ({{ Auth::user()->email }})</p>
                        </div>
                        <div class="h-10 w-10 rounded-full bg-slate-700 flex items-center justify-center text-lg">👤</div>
                    </div>

                    {{-- FORMULARIO DE ACCIÓN DE PAGO --}}
                    {{-- Corrección: Se envuelve el botón en un Form hacia cart.placeOrder --}}
                    <form action="{{ route('cart.placeOrder') }}" method="POST">
                        @csrf
                        
                        <div class="space-y-4 mb-6">
                            <label class="flex items-center gap-4 p-4 rounded-xl border border-emerald-500/50 bg-emerald-500/5 cursor-pointer">
                                <input type="radio" name="payment_method" checked class="text-emerald-500 focus:ring-emerald-500 bg-slate-900 border-slate-600">
                                <div class="flex-1">
                                    <span class="font-bold text-white block">Proceder al Pago</span>
                                    <span class="text-xs text-slate-400">Generar orden y seleccionar pasarela (PayPal/PayU)</span>
                                </div>
                                <span class="text-2xl">💳</span>
                            </label>
                        </div>

                        <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-400 text-slate-900 font-bold py-4 rounded-xl shadow-lg shadow-emerald-500/20 transition transform hover:-translate-y-0.5">
                            Pagar ${{ number_format($total ?? 0, 2) }} Ahora
                        </button>
                    </form>
                </div>
                @endguest
            @endif

        </div>

        {{-- COLUMNA DERECHA: GARANTÍAS --}}
        <div class="space-y-6">
            <div class="glass rounded-2xl border border-slate-800 p-6">
                <h4 class="font-bold text-slate-100 mb-4 flex items-center gap-2">
                    <span class="text-emerald-400">🛡️</span> Garantía Linea365
                </h4>
                <ul class="space-y-4 text-sm text-slate-400">
                    <li class="flex gap-3">
                        <span class="h-5 w-5 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xs flex-shrink-0">✓</span>
                        <span>Activación automática inmediata tras el pago.</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="h-5 w-5 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xs flex-shrink-0">✓</span>
                        <span>Soporte técnico prioritario 24/7 en español.</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="h-5 w-5 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-xs flex-shrink-0">✓</span>
                        <span>Garantía de devolución de 30 días.</span>
                    </li>
                </ul>
            </div>
            
            <div class="glass rounded-2xl border border-slate-800 p-6 text-center">
                <p class="text-xs text-slate-500 mb-2">Pagos procesados de forma segura</p>
                <div class="flex justify-center gap-4 opacity-50 grayscale hover:grayscale-0 transition">
                    <span class="text-2xl">💳</span>
                    <span class="text-2xl">🔒</span>
                    <span class="text-2xl">🏦</span>
                </div>
            </div>
        </div>

    </div>
</div>

@if(!app()->bound('livewire')) <script src="//unpkg.com/alpinejs" defer></script> @endif
@endsection