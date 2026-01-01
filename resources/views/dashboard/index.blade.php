@extends('layouts.frontend')

@section('title', 'Panel de cliente - Linea365 Clientes')

@section('content')
    @php
        // Valores por defecto por seguridad
        $activeServices   = $activeServices   ?? 0;
        $pendingInvoices  = $pendingInvoices  ?? 0;
        $openTickets      = $openTickets      ?? 0;
        $recentInvoices   = $recentInvoices   ?? collect([]);
    @endphp

    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        
        {{-- ENCABEZADO --}}
        <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-slate-50">
                    Hola, {{ $client ? $client->first_name : 'Administrador' }} 👋
                </h1>
                <p class="text-sm text-slate-400 mt-1">
                    Bienvenido a tu área de cliente.
                </p>
                <p class="text-xs text-slate-500 mt-2">
                    Sesión iniciada como {{ $user->email }}
                    @if($client)
                        · Cliente: {{ $client->full_name }} (ID #{{ $client->id }})
                    @endif
                </p>
            </div>

            @if($client)
            <div class="px-4 py-2 bg-slate-800/50 rounded-full border border-slate-700">
                <p class="text-xs text-slate-400">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block mr-1"></span>
                    Crédito: <span class="text-slate-200 font-bold">${{ number_format($client->credit_balance ?? 0, 2) }}</span>
                </p>
            </div>
            @endif
        </div>

        @if (!$client)
            {{-- ALERTA: PERFIL INCOMPLETO --}}
            <div class="glass rounded-2xl p-6 border border-yellow-500/30 bg-yellow-500/10 text-slate-200 mb-8">
                <div class="flex items-start gap-4">
                    <div class="p-2 bg-yellow-500/20 rounded-lg text-yellow-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-yellow-500">Completa tu perfil</h3>
                        <p class="text-sm mt-1 text-slate-300">
                            Para poder contratar servicios y generar facturas, necesitamos tus datos de facturación.
                        </p>
                        <a href="{{ route('profile.edit') }}" class="inline-block mt-3 text-xs font-bold uppercase tracking-wider text-yellow-500 border border-yellow-500 hover:bg-yellow-500 hover:text-black px-4 py-2 rounded transition">
                            Completar Perfil
                        </a>
                    </div>
                </div>
            </div>
        @else

            {{-- 1. ACCIONES RÁPIDAS (NUEVO: BUSCADOR Y TIENDA) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <div class="glass p-6 rounded-2xl border border-slate-700 relative overflow-hidden">
                    <h3 class="text-lg font-bold text-white mb-1">Registrar Dominio</h3>
                    <p class="text-sm text-slate-400 mb-4">Encuentra tu nombre en internet.</p>
                    
                    {{-- Envía a la tienda para procesar la búsqueda --}}
                    {{-- Nota: Ajusta 'domain_query' si tu OrderController espera otro nombre, pero esto es estándar para GET --}}
                    <form action="{{ route('store.index') }}" method="GET" class="flex gap-2">
                        <input type="text" name="domain_query" placeholder="tu-idea.com" class="w-full bg-slate-900/50 border border-slate-600 rounded-lg px-3 py-2 text-sm text-white focus:ring-2 focus:ring-blue-500 outline-none">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-4 py-2 rounded-lg text-sm font-semibold transition">
                            Buscar
                        </button>
                    </form>
                </div>

                <a href="{{ route('store.index') }}" class="glass p-6 rounded-2xl border border-slate-700 relative overflow-hidden group hover:border-purple-500/50 transition flex flex-col justify-center">
                    <div class="absolute right-0 top-0 p-4 opacity-10 group-hover:opacity-20 transition transform group-hover:scale-110">
                        <svg class="w-24 h-24 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-1 group-hover:text-purple-400 transition">Contratar Hosting</h3>
                    <p class="text-sm text-slate-400">Servidores de alto rendimiento y soporte 24/7.</p>
                </a>
            </div>

            {{-- 2. ESTADÍSTICAS (TUS BOTONES ORIGINALES) --}}
            <div class="grid gap-5 md:grid-cols-3 mb-8">
                {{-- Servicios activos --}}
                <a href="{{ route('services.index') }}"
                   class="glass rounded-2xl border border-slate-800 p-4 hover:border-emerald-500/60 hover:shadow-lg hover:shadow-emerald-500/20 transition flex flex-col justify-between">
                    <div>
                        <p class="text-xs font-medium text-slate-400 mb-1">Servicios activos</p>
                        <p class="text-3xl font-semibold text-slate-50">{{ $activeServices }}</p>
                    </div>
                    <div class="mt-4 text-[11px] text-emerald-300 flex items-center justify-between">
                        <span>Ver mis servicios</span> <span>→</span>
                    </div>
                </a>

                {{-- Facturas pendientes --}}
                <a href="{{ route('invoices.index') }}"
                   class="glass rounded-2xl border border-slate-800 p-4 hover:border-emerald-500/60 hover:shadow-lg hover:shadow-emerald-500/20 transition flex flex-col justify-between">
                    <div>
                        <p class="text-xs font-medium text-slate-400 mb-1">Facturas pendientes</p>
                        <p class="text-3xl font-semibold text-slate-50">{{ $pendingInvoices }}</p>
                    </div>
                    <div class="mt-4 text-[11px] text-emerald-300 flex items-center justify-between">
                        <span>Ver mis facturas</span> <span>→</span>
                    </div>
                </a>

                {{-- Tickets abiertos --}}
                <a href="{{ route('tickets.index') }}"
                   class="glass rounded-2xl border border-slate-800 p-4 hover:border-emerald-500/60 hover:shadow-lg hover:shadow-emerald-500/20 transition flex flex-col justify-between">
                    <div>
                        <p class="text-xs font-medium text-slate-400 mb-1">Tickets abiertos</p>
                        <p class="text-3xl font-semibold text-slate-50">{{ $openTickets }}</p>
                    </div>
                    <div class="mt-4 text-[11px] text-emerald-300 flex items-center justify-between">
                        <span>Ver mis tickets</span> <span>→</span>
                    </div>
                </a>
            </div>

            {{-- 3. FACTURAS RECIENTES (TABLA CON DATOS REALES) --}}
            @if(isset($recentInvoices) && $recentInvoices->count() > 0)
            <div class="glass rounded-2xl border border-slate-800 p-6">
                <h3 class="text-sm font-semibold text-slate-100 mb-4">Facturas recientes</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-400">
                        <thead class="text-xs uppercase bg-slate-800/50 text-slate-300">
                            <tr>
                                <th class="px-4 py-3 rounded-l-lg">Nº Factura</th>
                                <th class="px-4 py-3">Fecha</th>
                                <th class="px-4 py-3">Total</th>
                                <th class="px-4 py-3">Estado</th>
                                <th class="px-4 py-3 rounded-r-lg"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @foreach($recentInvoices as $invoice)
                            <tr>
                                <td class="px-4 py-3">#{{ $invoice->number ?? $invoice->id }}</td>
                                <td class="px-4 py-3">{{ $invoice->created_at->format('d/m/Y') }}</td>
                                <td class="px-4 py-3 font-semibold text-slate-200">${{ number_format($invoice->total, 2) }}</td>
                                <td class="px-4 py-3">
                                    {{-- Lógica de colores según estado --}}
                                    <span class="px-2 py-1 rounded-full text-xs 
                                        {{ $invoice->status == 'paid' ? 'bg-green-500/20 text-green-400' : 
                                           ($invoice->status == 'unpaid' ? 'bg-red-500/20 text-red-400' : 'bg-slate-500/20 text-slate-400') }}">
                                        {{ $invoice->status == 'paid' ? 'Pagada' : 'Pendiente' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('invoices.show', $invoice->id) }}" class="text-blue-400 hover:text-blue-300">Ver</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

        @endif
    </section>
@endsection