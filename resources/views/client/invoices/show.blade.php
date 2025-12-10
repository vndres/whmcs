@extends('layouts.app')

@section('content')
    <section class="space-y-6">
        <div class="flex items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-slate-50">
                    Factura {{ $invoice->number }}
                </h1>
                <p class="text-sm text-slate-400 mt-1">
                    Detalle de conceptos, totales y estado de tu factura.
                </p>
            </div>

            <a href="{{ route('client.invoices.index') }}"
               class="text-xs text-slate-400 hover:text-emerald-300">
                ← Volver a mis facturas
            </a>
        </div>

        <div class="glass rounded-2xl border border-slate-800 p-5 text-xs text-slate-300 space-y-2">
            <div class="flex flex-col md:flex-row md:justify-between gap-3">
                <div>
                    <div class="text-slate-400">
                        Cliente:
                        <span class="text-slate-100">
                            {{ $client->first_name }} {{ $client->last_name }}
                        </span>
                        (ID #{{ $client->id }})
                    </div>
                    <div class="text-[11px] text-slate-500 mt-1">
                        Sesión iniciada como {{ auth()->user()->email }}
                    </div>
                </div>

                @php
                    $statusLabel = $invoice->status_label ?? ucfirst($invoice->status ?? 'desconocido');
                    $statusClass = $invoice->status_class ?? 'bg-slate-700/50 text-slate-300 border border-slate-600/60';
                @endphp

                <div class="text-right">
                    <div class="text-slate-400 text-xs mb-1">
                        Estado de la factura
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] {{ $statusClass }}">
                        {{ $statusLabel }}
                    </span>
                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-3 mt-4">
                <div>
                    <div class="text-[11px] text-slate-400 mb-1">Número de factura</div>
                    <div class="text-sm text-slate-100">{{ $invoice->number }}</div>
                    <div class="text-[11px] text-slate-500 mt-0.5">ID interno: #{{ $invoice->id }}</div>
                </div>
                <div>
                    <div class="text-[11px] text-slate-400 mb-1">Fechas</div>
                    <div class="text-sm text-slate-100">
                        Emisión: {{ $invoice->issue_date?->format('d/m/Y') }}
                    </div>
                    <div class="text-[11px] text-slate-500 mt-0.5">
                        Vencimiento: {{ $invoice->due_date?->format('d/m/Y') }}
                    </div>
                </div>
                <div>
                    <div class="text-[11px] text-slate-400 mb-1">Totales</div>
                    <div class="text-sm text-slate-100">
                        Total: {{ $invoice->currency }} {{ number_format($invoice->total, 2) }}
                    </div>
                    <div class="text-[11px] text-slate-500 mt-0.5">
                        Subtotal: {{ $invoice->currency }} {{ number_format($invoice->subtotal, 2) }}
                    </div>
                    <div class="text-[11px] text-slate-500">
                        Impuestos: {{ $invoice->currency }} {{ number_format($invoice->tax_total, 2) }}
                    </div>
                    <div class="text-[11px] text-slate-500 mt-0.5">
                        Pagado: {{ $invoice->currency }} {{ number_format($invoice->amount_paid, 2) }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Conceptos --}}
        <div class="glass rounded-2xl border border-slate-800 overflow-hidden">
            <div class="px-4 py-3 border-b border-slate-800">
                <div class="text-sm font-semibold text-slate-100">
                    Conceptos de la factura
                </div>
            </div>

            @if($invoice->items->count() === 0)
                <div class="p-5 text-sm text-slate-300">
                    No hay conceptos registrados para esta factura.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs text-slate-200">
                        <thead class="bg-slate-900/80 border-b border-slate-800">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">Descripción</th>
                                <th class="px-4 py-3 text-right font-semibold">Cantidad</th>
                                <th class="px-4 py-3 text-right font-semibold">Precio unitario</th>
                                <th class="px-4 py-3 text-right font-semibold">% IVA</th>
                                <th class="px-4 py-3 text-right font-semibold">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/80">
                            @foreach($invoice->items as $item)
                                <tr class="hover:bg-slate-900/60 transition">
                                    <td class="px-4 py-3 align-top">
                                        <div class="text-sm text-slate-50">
                                            {{ $item->description }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 align-top text-right">
                                        {{ number_format($item->quantity, 2) }}
                                    </td>
                                    <td class="px-4 py-3 align-top text-right">
                                        {{ $invoice->currency }} {{ number_format($item->unit_price, 2) }}
                                    </td>
                                    <td class="px-4 py-3 align-top text-right">
                                        {{ number_format($item->tax_rate, 2) }}%
                                    </td>
                                    <td class="px-4 py-3 align-top text-right">
                                        {{ $invoice->currency }} {{ number_format($item->total, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <div class="px-4 py-4 border-t border-slate-800 flex flex-col sm:flex-row sm:justify-end gap-2 text-xs text-slate-300">
                <div class="sm:text-right">
                    <div>Subtotal: {{ $invoice->currency }} {{ number_format($invoice->subtotal, 2) }}</div>
                    <div>Impuestos: {{ $invoice->currency }} {{ number_format($invoice->tax_total, 2) }}</div>
                    <div class="text-sm text-slate-100 mt-1">
                        Total a pagar: {{ $invoice->currency }} {{ number_format($invoice->total, 2) }}
                    </div>
                    <div class="text-[11px] text-slate-500 mt-1">
                        * Más adelante conectaremos aquí el botón de pago en línea.
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
