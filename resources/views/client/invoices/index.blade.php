@extends('layouts.app')

@section('content')
    <section class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-slate-50">
                    Mis facturas
                </h1>
                <p class="text-sm text-slate-400 mt-1">
                    Consulta el estado de tus facturas, montos pendientes y pagos registrados.
                </p>
            </div>
        </div>

        <div class="glass rounded-2xl border border-slate-800 p-4 text-xs text-slate-300">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <div>
                    <div class="text-slate-400">
                        Sesión iniciada como
                        <span class="text-slate-100 font-medium">{{ auth()->user()->email }}</span>
                    </div>

                    @if($client)
                        <div class="text-[11px] text-slate-500 mt-0.5">
                            Cliente: <span class="text-slate-100">{{ $client->first_name }} {{ $client->last_name }}</span>
                            (ID #{{ $client->id }})
                        </div>
                    @else
                        <div class="text-[11px] text-red-300 mt-0.5">
                            Aún no tienes un perfil de cliente asociado. Contacta soporte si ves este mensaje.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @if(!$client || $invoices->count() === 0)
            <div class="glass rounded-2xl border border-slate-800 p-5 text-sm text-slate-300">
                No tienes facturas generadas por el momento.
                <br>
                <span class="text-[11px] text-slate-500">
                    Cuando contrates servicios o generes pedidos, las facturas aparecerán aquí.
                </span>
            </div>
        @else
            <div class="glass rounded-2xl border border-slate-800 overflow-hidden">
                <div class="px-4 py-3 border-b border-slate-800 flex items-center justify-between">
                    <div class="text-sm font-semibold text-slate-100">
                        Listado de facturas
                    </div>
                    <div class="text-[11px] text-slate-500">
                        Mostrando {{ $invoices->firstItem() }} - {{ $invoices->lastItem() }} de {{ $invoices->total() }}
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs text-slate-200">
                        <thead class="bg-slate-900/80 border-b border-slate-800">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">Factura</th>
                                <th class="px-4 py-3 text-left font-semibold">Fechas</th>
                                <th class="px-4 py-3 text-left font-semibold">Total</th>
                                <th class="px-4 py-3 text-left font-semibold">Estado</th>
                                <th class="px-4 py-3 text-right font-semibold">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/80">
                            @foreach($invoices as $invoice)
                                @php
                                    $statusLabel = $invoice->status_label ?? ucfirst($invoice->status ?? 'desconocido');
                                    $statusClass = $invoice->status_class ?? 'bg-slate-700/50 text-slate-300 border border-slate-600/60';
                                @endphp

                                <tr class="hover:bg-slate-900/60 transition">
                                    <td class="px-4 py-3 align-top">
                                        <div class="text-sm text-slate-50">
                                            {{ $invoice->number }}
                                        </div>
                                        <div class="text-[11px] text-slate-500 mt-0.5">
                                            ID: #{{ $invoice->id }}
                                        </div>
                                    </td>

                                    <td class="px-4 py-3 align-top text-sm whitespace-nowrap">
                                        <div>Emisión: {{ $invoice->issue_date?->format('d/m/Y') }}</div>
                                        <div class="text-[11px] text-slate-400 mt-0.5">
                                            Vencimiento: {{ $invoice->due_date?->format('d/m/Y') }}
                                        </div>
                                    </td>

                                    <td class="px-4 py-3 align-top text-sm whitespace-nowrap">
                                        {{ $invoice->currency }} {{ number_format($invoice->total, 2) }}
                                        <div class="text-[11px] text-slate-500 mt-0.5">
                                            Pagado: {{ $invoice->currency }} {{ number_format($invoice->amount_paid, 2) }}
                                        </div>
                                    </td>

                                    <td class="px-4 py-3 align-top">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] {{ $statusClass }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-3 align-top text-right">
                                        <a href="{{ route('client.invoices.show', $invoice) }}"
                                           class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg text-[11px] font-semibold btn-outline">
                                            Ver detalle
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($invoices->hasPages())
                    <div class="px-4 py-3 border-t border-slate-800">
                        {{ $invoices->links() }}
                    </div>
                @endif
            </div>
        @endif
    </section>
@endsection
