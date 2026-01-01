@extends('layouts.admin')

@section('admin-content')
    <section class="space-y-6">
        {{-- Encabezado --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-slate-50">
                    Dashboard administrativo
                </h1>
                <p class="text-sm text-slate-400 mt-1">
                    Control central de clientes, servicios, dominios, facturación y soporte.
                </p>
            </div>

            <div class="text-xs text-right text-slate-400">
                Sesión iniciada como
                <span class="text-slate-100 font-medium">{{ $user->name }} ({{ $user->email }})</span><br>
                <span class="text-[11px] text-emerald-400">
                    Rol: Administrador
                </span>
            </div>
        </div>

        {{-- Tarjetas resumen principales --}}
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            {{-- Clientes --}}
            <div class="glass rounded-2xl border border-slate-800 p-4 flex flex-col justify-between">
                <div>
                    <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400">
                        Clientes
                    </p>
                    <p class="text-3xl font-semibold text-slate-50 mt-1">
                        {{ $totalClients }}
                    </p>
                    <p class="text-[11px] text-slate-500 mt-1">
                        Total de clientes registrados en el sistema.
                    </p>
                </div>
                <div class="mt-3 text-[11px] text-emerald-300 flex items-center justify-between">
                    <span>Gestión de clientes (próximamente)</span>
                    <span>→</span>
                </div>
            </div>

            {{-- Servicios activos --}}
            <div class="glass rounded-2xl border border-slate-800 p-4 flex flex-col justify-between">
                <div>
                    <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400">
                        Servicios activos
                    </p>
                    <p class="text-3xl font-semibold text-slate-50 mt-1">
                        {{ $activeServices }}
                    </p>
                    <p class="text-[11px] text-slate-500 mt-1">
                        Hosting, VPS u otros servicios en estado activo.
                    </p>
                </div>
                <div class="mt-3 text-[11px] text-emerald-300 flex items-center justify-between">
                    <span>Ver servicios (próximamente)</span>
                    <span>→</span>
                </div>
            </div>

            {{-- Facturas pendientes --}}
            <div class="glass rounded-2xl border border-slate-800 p-4 flex flex-col justify-between">
                <div>
                    <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400">
                        Facturas pendientes
                    </p>
                    <p class="text-3xl font-semibold text-slate-50 mt-1">
                        {{ $pendingInvoices }}
                    </p>
                    <p class="text-[11px] text-slate-500 mt-1">
                        Facturas en estado pendiente o vencido.
                    </p>
                </div>
                <div class="mt-3 text-[11px] text-emerald-300 flex items-center justify-between">
                    <span>Ver facturación (próximamente)</span>
                    <span>→</span>
                </div>
            </div>

            {{-- Tickets abiertos --}}
            <div class="glass rounded-2xl border border-slate-800 p-4 flex flex-col justify-between">
                <div>
                    <p class="text-[11px] font-medium uppercase tracking-wide text-slate-400">
                        Tickets abiertos
                    </p>
                    <p class="text-3xl font-semibold text-slate-50 mt-1">
                        {{ $openTickets }}
                    </p>
                    <p class="text-[11px] text-slate-500 mt-1">
                        Solicitudes de soporte que aún requieren atención.
                    </p>
                </div>
                <div class="mt-3 text-[11px] text-emerald-300 flex items-center justify-between">
                    <span>Centro de soporte (próximamente)</span>
                    <span>→</span>
                </div>
            </div>
        </div>

        {{-- Listas recientes: clientes, facturas, tickets --}}
        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            {{-- Clientes recientes --}}
            <div class="glass rounded-2xl border border-slate-800 p-4">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-sm font-semibold text-slate-100">
                        Clientes recientes
                    </h2>
                    <span class="text-[11px] text-slate-500">
                        Últimos 5
                    </span>
                </div>

                @if($recentClients->isEmpty())
                    <p class="text-xs text-slate-500">
                        No hay clientes registrados aún.
                    </p>
                @else
                    <ul class="divide-y divide-slate-800 text-xs">
                        @foreach($recentClients as $clientItem)
                            <li class="py-2 flex items-center justify-between gap-3">
                                <div>
                                    <p class="text-slate-100">
                                        {{ $clientItem->full_name }}
                                    </p>
                                    <p class="text-[11px] text-slate-500">
                                        {{ $clientItem->email }} · ID #{{ $clientItem->id }}
                                    </p>
                                </div>
                                <span class="text-[11px] px-2 py-0.5 rounded-full
                                             {{ $clientItem->is_active ? 'bg-emerald-500/15 text-emerald-300 border border-emerald-500/40' : 'bg-slate-700/50 text-slate-300 border border-slate-600/60' }}">
                                    {{ $clientItem->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- Facturas recientes --}}
            <div class="glass rounded-2xl border border-slate-800 p-4">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-sm font-semibold text-slate-100">
                        Facturas recientes
                    </h2>
                    <span class="text-[11px] text-slate-500">
                        Últimas 5
                    </span>
                </div>

                @if($recentInvoices->isEmpty())
                    <p class="text-xs text-slate-500">
                        Aún no hay facturas registradas.
                    </p>
                @else
                    <ul class="divide-y divide-slate-800 text-xs">
                        @foreach($recentInvoices as $invoice)
                            <li class="py-2 flex items-center justify-between gap-3">
                                <div>
                                    <p class="text-slate-100">
                                        {{ $invoice->number ?? ('Factura #'.$invoice->id) }}
                                    </p>
                                    <p class="text-[11px] text-slate-500">
                                        Cliente ID #{{ $invoice->client_id }} · Total: {{ $invoice->currency ?? 'USD' }} {{ number_format($invoice->total ?? 0, 2) }}
                                    </p>
                                </div>
                                <span class="text-[11px] px-2 py-0.5 rounded-full
                                    @class([
                                        'bg-emerald-500/15 text-emerald-300 border border-emerald-500/40' => $invoice->status === 'paid',
                                        'bg-amber-500/15 text-amber-200 border border-amber-500/40' => in_array($invoice->status, ['unpaid', 'overdue']),
                                        'bg-slate-700/50 text-slate-300 border border-slate-600/60' => !in_array($invoice->status, ['paid','unpaid','overdue']),
                                    ])">
                                    {{ ucfirst($invoice->status) }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- Tickets recientes --}}
            <div class="glass rounded-2xl border border-slate-800 p-4">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-sm font-semibold text-slate-100">
                        Tickets recientes
                    </h2>
                    <span class="text-[11px] text-slate-500">
                        Últimos 5
                    </span>
                </div>

                @if($recentTickets->isEmpty())
                    <p class="text-xs text-slate-500">
                        Todavía no hay tickets de soporte.
                    </p>
                @else
                    <ul class="divide-y divide-slate-800 text-xs">
                        @foreach($recentTickets as $ticket)
                            <li class="py-2 flex items-center justify-between gap-3">
                                <div>
                                    <p class="text-slate-100">
                                        [#{{ $ticket->id }}] {{ $ticket->subject }}
                                    </p>
                                    <p class="text-[11px] text-slate-500">
                                        Cliente ID #{{ $ticket->client_id }} · Prioridad: {{ ucfirst($ticket->priority ?? 'normal') }}
                                    </p>
                                </div>
                                <span class="text-[11px] px-2 py-0.5 rounded-full
                                    @class([
                                        'bg-emerald-500/15 text-emerald-300 border border-emerald-500/40' => $ticket->status === 'closed',
                                        'bg-amber-500/15 text-amber-200 border border-amber-500/40' => in_array($ticket->status, ['open','answered']),
                                        'bg-slate-700/50 text-slate-300 border border-slate-600/60' => !in_array($ticket->status, ['open','answered','closed']),
                                    ])">
                                    {{ ucfirst($ticket->status) }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </section>
@endsection
