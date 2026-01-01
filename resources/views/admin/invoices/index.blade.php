@extends('layouts.admin')

@section('admin-content')
    <section class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-slate-50">
                    Facturas
                </h1>
                <p class="text-sm text-slate-400 mt-1">
                    Administra las facturas de tus clientes: pendiente de pago, pagadas, vencidas, canceladas.
                </p>
            </div>

            <a href="{{ route('admin.invoices.create') }}"
               class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-xs font-semibold
                      bg-emerald-500 text-slate-950 hover:bg-emerald-400 transition">
                + Nueva factura
            </a>
        </div>

        @if (session('success'))
            <div class="glass rounded-xl border border-emerald-600/60 px-4 py-3 text-xs text-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        {{-- Filtros --}}
        <div class="glass rounded-2xl border border-slate-800 p-4">
            <form method="GET" action="{{ route('admin.invoices.index') }}" class="grid gap-3 md:grid-cols-4 text-xs">
                <div>
                    <label class="block mb-1 text-slate-300">Cliente</label>
                    <select name="client_id"
                            class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-2 py-1.5 text-slate-100">
                        <option value="">Todos</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                {{ $client->first_name }} {{ $client->last_name }} (ID #{{ $client->id }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-1 text-slate-300">Estado</label>
                    <select name="status"
                            class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-2 py-1.5 text-slate-100">
                        <option value="">Todos</option>
                        @foreach($statuses as $key => $label)
                            <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit"
                            class="inline-flex items-center justify-center px-3 py-2 rounded-xl bg-slate-800 text-slate-100 hover:bg-slate-700 transition">
                        Filtrar
                    </button>
                    <a href="{{ route('admin.invoices.index') }}"
                       class="inline-flex items-center justify-center px-3 py-2 rounded-xl text-slate-400 hover:text-emerald-300">
                        Limpiar
                    </a>
                </div>
            </form>
        </div>

        @if ($invoices->count() === 0)
            <div class="glass rounded-2xl border border-slate-800 p-5 text-sm text-slate-300">
                No hay facturas registradas por el momento.
                <br>
                <span class="text-xs text-slate-500">
                    Crea tu primera factura usando el botón "Nueva factura".
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
                                <th class="px-4 py-3 text-left font-semibold">Cliente</th>
                                <th class="px-4 py-3 text-left font-semibold">Fechas</th>
                                <th class="px-4 py-3 text-left font-semibold">Total</th>
                                <th class="px-4 py-3 text-left font-semibold">Estado</th>
                                <th class="px-4 py-3 text-right font-semibold">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/80">
                            @foreach ($invoices as $invoice)
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
                                            ID factura: #{{ $invoice->id }}
                                        </div>
                                    </td>

                                    <td class="px-4 py-3 align-top">
                                        <div class="text-sm text-slate-50">
                                            {{ optional($invoice->client)->first_name }} {{ optional($invoice->client)->last_name }}
                                        </div>
                                        <div class="text-[11px] text-slate-500 mt-0.5">
                                            Cliente ID: #{{ $invoice->client_id }}
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

                                    <td class="px-4 py-3 align-top text-right space-x-1">
                                        <a href="{{ route('admin.invoices.edit', $invoice) }}"
                                           class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg text-[11px] font-semibold btn-outline">
                                            Editar
                                        </a>

                                        <form action="{{ route('admin.invoices.destroy', $invoice) }}"
                                              method="POST"
                                              class="inline-block"
                                              onsubmit="return confirm('¿Seguro que deseas eliminar esta factura?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg text-[11px] font-semibold bg-red-500/15 text-red-300 border border-red-500/40 hover:bg-red-500/25 transition">
                                                Eliminar
                                            </button>
                                        </form>
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
