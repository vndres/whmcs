@extends('layouts.frontend')

@section('title', 'Mis facturas - Linea365 Clientes')

@section('content')
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-slate-50">
                    Mis facturas
                </h1>
                <p class="text-sm text-slate-400 mt-1">
                    Consulta el estado de tus facturas, montos pendientes y pagos registrados.
                </p>
            </div>

            <div class="text-xs text-slate-400 text-right">
                Sesión iniciada como
                <span class="text-slate-100 font-medium">{{ $user->email }}</span><br>
                @if($client)
                    <span class="text-[11px] text-slate-500">
                        Cliente: {{ $client->full_name }} (ID #{{ $client->id }})
                    </span>
                @endif
            </div>
        </div>

        @if (!$client)
            <div class="glass rounded-2xl p-5 border border-slate-800 text-sm text-slate-300">
                Tu usuario aún no tiene un perfil de cliente asociado.
                <br>
                <span class="text-slate-400 text-xs">
                    Vincula este usuario a un cliente para poder ver facturas y pagos.
                </span>
            </div>
        @elseif ($invoices->count() === 0)
            <div class="glass rounded-2xl p-5 border border-slate-800 text-sm text-slate-300">
                No tienes facturas generadas por el momento.
                <br>
                <span class="text-slate-400 text-xs">
                    Cuando contrates servicios o generes pedidos, las facturas aparecerán aquí.
                </span>
            </div>
        @else
            <div class="glass rounded-2xl border border-slate-800 overflow-hidden">
                <div class="px-4 py-3 border-b border-slate-800 flex items-center justify-between">
                    <div class="text-sm font-semibold text-slate-100">
                        Facturas de {{ $client->full_name }}
                    </div>
                    <div class="text-[11px] text-slate-400">
                        Mostrando {{ $invoices->firstItem() }} - {{ $invoices->lastItem() }}
                        de {{ $invoices->total() }} facturas
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs text-slate-200">
                        <thead class="bg-slate-900/80 border-b border-slate-800">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">Número</th>
                                <th class="px-4 py-3 text-left font-semibold">Estado</th>
                                <th class="px-4 py-3 text-left font-semibold">Emisión</th>
                                <th class="px-4 py-3 text-left font-semibold">Vencimiento</th>
                                <th class="px-4 py-3 text-right font-semibold">Total</th>
                                <th class="px-4 py-3 text-right font-semibold">Pagado</th>
                                <th class="px-4 py-3 text-right font-semibold">Saldo</th>
                                <th class="px-4 py-3 text-right font-semibold">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/80">
                            @foreach ($invoices as $invoice)
                                @php
                                    $status = $invoice->status ?? 'unpaid';

                                    $statusLabel = match ($status) {
                                        'paid'      => 'Pagada',
                                        'unpaid'    => 'Pendiente',
                                        'overdue'   => 'Vencida',
                                        'cancelled' => 'Cancelada',
                                        default     => ucfirst($status),
                                    };

                                    $statusClass = match ($status) {
                                        'paid'      => 'bg-emerald-500/15 text-emerald-300 border border-emerald-500/40',
                                        'overdue'   => 'bg-rose-500/15 text-rose-200 border border-rose-500/40',
                                        'cancelled' => 'bg-slate-600/30 text-slate-200 border border-slate-500/50',
                                        'unpaid'    => 'bg-yellow-500/15 text-yellow-300 border border-yellow-500/40',
                                        default     => 'bg-slate-700/40 text-slate-200 border border-slate-500/40',
                                    };

                                    $balance = $invoice->balance;
                                @endphp

                                <tr class="hover:bg-slate-900/60 transition">
                                    <td class="px-4 py-3 align-top">
                                        <div class="text-sm text-slate-50">
                                            {{ $invoice->number }}
                                        </div>
                                        <div class="text-[11px] text-slate-500 mt-0.5">
                                            ID #{{ $invoice->id }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 align-top">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] {{ $statusClass }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 align-top text-sm whitespace-nowrap">
                                        {{ $invoice->issue_date?->format('d/m/Y') ?? '—' }}
                                    </td>
                                    <td class="px-4 py-3 align-top text-sm whitespace-nowrap">
                                        {{ $invoice->due_date?->format('d/m/Y') ?? '—' }}
                                    </td>
                                    <td class="px-4 py-3 align-top text-right text-sm whitespace-nowrap">
                                        {{ $invoice->currency }} {{ number_format($invoice->total, 2) }}
                                    </td>
                                    <td class="px-4 py-3 align-top text-right text-sm whitespace-nowrap">
                                        {{ $invoice->currency }} {{ number_format($invoice->amount_paid, 2) }}
                                    </td>
                                    <td class="px-4 py-3 align-top text-right text-sm whitespace-nowrap">
                                        {{ $invoice->currency }} {{ number_format($balance, 2) }}
                                    </td>
                                    <td class="px-4 py-3 align-top text-right">
                                        <a href="{{ route('invoices.show', $invoice) }}"
                                           class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg text-[11px] font-semibold btn-outline">
                                            Ver detalle
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($invoices->hasPages())
                    <div class="px-4 py-3 border-t border-slate-800">
                        {{ $invoices->links() }}
                    </div>
                @endif
            </div>
        @endif
    </section>
@endsection
