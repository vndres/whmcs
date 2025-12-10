@extends('layouts.frontend')

@section('title', 'Factura ' . $invoice->number . ' - Linea365 Clientes')

@section('content')
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

    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <div class="flex items-start justify-between mb-6 gap-4">
            <div>
                <h1 class="text-2xl font-semibold text-slate-50">
                    Factura {{ $invoice->number }}
                </h1>
                <p class="text-sm text-slate-400 mt-1">
                    Resumen de cargos, pagos y estado actual de esta factura.
                </p>
                <p class="text-xs text-slate-500 mt-2">
                    Cliente: {{ $client->full_name }} (ID #{{ $client->id }})<br>
                    Correo: {{ $client->email }}
                </p>
            </div>

            <div class="text-right space-y-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-semibold {{ $statusClass }}">
                    {{ $statusLabel }}
                </span>
                <div class="text-xs text-slate-400">
                    Emisión: {{ $invoice->issue_date?->format('d/m/Y') ?? '—' }}<br>
                    Vencimiento: {{ $invoice->due_date?->format('d/m/Y') ?? '—' }}
                </div>
                <div class="text-xs text-slate-400">
                    Moneda: {{ $invoice->currency }}
                </div>
            </div>
        </div>

        <div class="glass rounded-2xl border border-slate-800 overflow-hidden mb-6">
            <div class="px-4 py-3 border-b border-slate-800 flex items-center justify-between">
                <div class="text-sm font-semibold text-slate-100">
                    Detalle de cargos
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-xs text-slate-200">
                    <thead class="bg-slate-900/80 border-b border-slate-800">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">Descripción</th>
                            <th class="px-4 py-3 text-right font-semibold">Cantidad</th>
                            <th class="px-4 py-3 text-right font-semibold">Precio unitario</th>
                            <th class="px-4 py-3 text-right font-semibold">Impuesto</th>
                            <th class="px-4 py-3 text-right font-semibold">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/80">
                        @forelse ($invoice->items as $item)
                            <tr class="hover:bg-slate-900/60 transition">
                                <td class="px-4 py-3 text-sm">
                                    {{ $item->description }}
                                </td>
                                <td class="px-4 py-3 text-right text-sm whitespace-nowrap">
                                    {{ $item->quantity }}
                                </td>
                                <td class="px-4 py-3 text-right text-sm whitespace-nowrap">
                                    {{ $invoice->currency }} {{ number_format($item->unit_price, 2) }}
                                </td>
                                <td class="px-4 py-3 text-right text-sm whitespace-nowrap">
                                    {{ number_format($item->tax_rate, 2) }} %
                                </td>
                                <td class="px-4 py-3 text-right text-sm whitespace-nowrap">
                                    {{ $invoice->currency }} {{ number_format($item->total, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="px-4 py-4 text-sm text-slate-400" colspan="5">
                                    Esta factura no tiene items asociados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <div class="glass rounded-2xl border border-slate-800 p-5">
                <h2 class="text-sm font-semibold text-slate-100 mb-3">
                    Resumen de montos
                </h2>

                <dl class="space-y-2 text-sm text-slate-200">
                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Subtotal</dt>
                        <dd class="font-medium">
                            {{ $invoice->currency }} {{ number_format($invoice->subtotal, 2) }}
                        </dd>
                    </div>

                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Impuestos</dt>
                        <dd class="font-medium">
                            {{ $invoice->currency }} {{ number_format($invoice->tax_total, 2) }}
                        </dd>
                    </div>

                    <div class="flex justify-between gap-4 border-t border-slate-800 pt-2 mt-1">
                        <dt class="text-slate-400">Total factura</dt>
                        <dd class="font-semibold">
                            {{ $invoice->currency }} {{ number_format($invoice->total, 2) }}
                        </dd>
                    </div>

                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Pagado</dt>
                        <dd class="font-medium">
                            {{ $invoice->currency }} {{ number_format($invoice->amount_paid, 2) }}
                        </dd>
                    </div>

                    <div class="flex justify-between gap-4">
                        <dt class="text-slate-400">Saldo pendiente</dt>
                        <dd class="font-semibold {{ $balance > 0 ? 'text-amber-300' : 'text-emerald-300' }}">
                            {{ $invoice->currency }} {{ number_format($balance, 2) }}
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="glass rounded-2xl border border-slate-800 p-5">
                <h2 class="text-sm font-semibold text-slate-100 mb-3">
                    Acciones
                </h2>

                @if($invoice->is_paid)
                    <p class="text-xs text-emerald-300 mb-3">
                        Esta factura ya aparece como pagada en el sistema.
                    </p>
                @elseif($invoice->is_overdue)
                    <p class="text-xs text-rose-300 mb-3">
                        Esta factura está vencida. Te recomendamos ponerte al día lo antes posible.
                    </p>
                @else
                    <p class="text-xs text-slate-300 mb-3">
                        Esta factura está pendiente de pago.
                    </p>
                @endif

                <button
                    type="button"
                    class="w-full inline-flex items-center justify-center px-4 py-2 rounded-xl text-xs font-semibold bg-emerald-500 hover:bg-emerald-400 text-slate-900 shadow-lg shadow-emerald-500/30 transition mb-2"
                    disabled
                >
                    Pagar ahora (integración pendiente)
                </button>

                <button
                    type="button"
                    class="w-full inline-flex items-center justify-center px-4 py-2 rounded-xl text-xs font-semibold border border-slate-700 text-slate-200 hover:bg-slate-800/80 transition"
                    disabled
                >
                    Descargar PDF (próximamente)
                </button>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-between text-xs text-slate-500">
            <a href="{{ route('invoices.index') }}" class="text-emerald-400 hover:text-emerald-300">
                ← Volver al listado de facturas
            </a>
        </div>
    </section>
@endsection
