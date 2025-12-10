@extends('layouts.frontend')

@section('title', 'Panel de cliente - Linea365 Clientes')

@section('content')
    @php
        // Valores por defecto por si algún controlador no envía las variables
        $activeServices   = $activeServices   ?? 0;
        $pendingInvoices  = $pendingInvoices  ?? 0;
        $openTickets      = $openTickets      ?? 0;
    @endphp

    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-slate-50">
                Hola, {{ $client ? $client->first_name : 'Administrador' }}
            </h1>
            <p class="text-sm text-slate-400 mt-1">
                Este es el inicio de tu panel de cliente. Más adelante conectamos aquí: servicios, facturas,
                dominios, tickets, etc.
            </p>
            <p class="text-xs text-slate-500 mt-2">
                Sesión iniciada como {{ $user->email }}
                @if($client)
                    · Cliente: {{ $client->full_name }} (ID #{{ $client->id }})
                @endif
            </p>
        </div>

        @if (!$client)
            <div class="glass rounded-2xl p-5 border border-slate-800 text-sm text-slate-300">
                Tu usuario aún no tiene un perfil de cliente asociado.
                <br>
                <span class="text-slate-400 text-xs">
                    Cuando vinculemos este usuario a un cliente, verás aquí el resumen de tus servicios, facturas y tickets.
                </span>
            </div>
        @else
            <div class="grid gap-5 md:grid-cols-3 mb-8">
                {{-- Servicios activos --}}
                <a href="{{ route('services.index') }}"
                   class="glass rounded-2xl border border-slate-800 p-4 hover:border-emerald-500/60 hover:shadow-lg hover:shadow-emerald-500/20 transition flex flex-col justify-between">
                    <div>
                        <p class="text-xs font-medium text-slate-400 mb-1">
                            Servicios activos
                        </p>
                        <p class="text-3xl font-semibold text-slate-50">
                            {{ $activeServices }}
                        </p>
                        <p class="text-[11px] text-slate-500 mt-1">
                            Luego lo conectamos a tu tabla de servicios (ya está leyendo la tabla <code>services</code>).
                        </p>
                    </div>
                    <div class="mt-4 text-[11px] text-emerald-300 flex items-center justify-between">
                        <span>Ver mis servicios</span>
                        <span>→</span>
                    </div>
                </a>

                {{-- Facturas pendientes --}}
                <a href="{{ route('invoices.index') }}"
                   class="glass rounded-2xl border border-slate-800 p-4 hover:border-emerald-500/60 hover:shadow-lg hover:shadow-emerald-500/20 transition flex flex-col justify-between">
                    <div>
                        <p class="text-xs font-medium text-slate-400 mb-1">
                            Facturas pendientes
                        </p>
                        <p class="text-3xl font-semibold text-slate-50">
                            {{ $pendingInvoices }}
                        </p>
                        <p class="text-[11px] text-slate-500 mt-1">
                            Aquí verás rápidamente lo que tus clientes deben (facturas con estado pendiente o vencida).
                        </p>
                    </div>
                    <div class="mt-4 text-[11px] text-emerald-300 flex items-center justify-between">
                        <span>Ver mis facturas</span>
                        <span>→</span>
                    </div>
                </a>

                {{-- Tickets abiertos --}}
                <a href="{{ route('tickets.index') }}"
                   class="glass rounded-2xl border border-slate-800 p-4 hover:border-emerald-500/60 hover:shadow-lg hover:shadow-emerald-500/20 transition flex flex-col justify-between">
                    <div>
                        <p class="text-xs font-medium text-slate-400 mb-1">
                            Tickets abiertos
                        </p>
                        <p class="text-3xl font-semibold text-slate-50">
                            {{ $openTickets }}
                        </p>
                        <p class="text-[11px] text-slate-500 mt-1">
                            Integraremos el sistema de soporte aquí (ya conectado a la tabla <code>tickets</code>).
                        </p>
                    </div>
                    <div class="mt-4 text-[11px] text-emerald-300 flex items-center justify-between">
                        <span>Ver mis tickets</span>
                        <span>→</span>
                    </div>
                </a>
            </div>

            {{-- Bloque informativo para futuro --}}
            <div class="glass rounded-2xl border border-slate-800 p-5">
                <h2 class="text-sm font-semibold text-slate-100 mb-2">
                    Próximamente en tu panel
                </h2>
                <p class="text-xs text-slate-400">
                    Aquí vamos a mostrar:
                </p>
                <ul class="mt-2 text-xs text-slate-300 list-disc list-inside space-y-1">
                    <li>Próximos vencimientos de servicios y dominios.</li>
                    <li>Últimas facturas emitidas y pagos recientes.</li>
                    <li>Actividad reciente: tickets nuevos, respuestas, cambios de estado.</li>
                </ul>
            </div>
        @endif
    </section>
@endsection
