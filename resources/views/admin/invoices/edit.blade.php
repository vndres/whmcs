@extends('layouts.admin')

@section('admin-content')
    <section class="space-y-6">
        <div class="flex items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-slate-50">
                    Editar factura #{{ $invoice->id }}
                </h1>
                <p class="text-sm text-slate-400 mt-1">
                    Actualiza los datos generales y los conceptos de esta factura.
                </p>
            </div>

            <a href="{{ route('admin.invoices.index') }}"
               class="text-xs text-slate-400 hover:text-emerald-300">
                ← Volver al listado
            </a>
        </div>

        @if (session('success'))
            <div class="glass rounded-xl border border-emerald-600/60 px-4 py-3 text-xs text-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="glass rounded-xl border border-red-600/60 px-4 py-3 text-xs text-red-200">
                <p class="font-semibold mb-1">Hay errores en el formulario:</p>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.invoices.update', $invoice) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="glass rounded-2xl border border-slate-800 p-5 space-y-4">
                <h2 class="text-sm font-semibold text-slate-100 mb-1">
                    Datos generales
                </h2>

                <div class="grid gap-4 md:grid-cols-3">
                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Número de factura
                        </label>
                        <input type="text" name="number"
                               value="{{ old('number', $invoice->number) }}"
                               class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100">
                    </div>

                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Cliente <span class="text-red-400">*</span>
                        </label>
                        <select name="client_id"
                                class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100">
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ old('client_id', $invoice->client_id) == $client->id ? 'selected' : '' }}>
                                    {{ $client->first_name }} {{ $client->last_name }} (ID #{{ $client->id }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Moneda <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="currency"
                               value="{{ old('currency', $invoice->currency) }}"
                               class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100">
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-3">
                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Fecha de emisión <span class="text-red-400">*</span>
                        </label>
                        <input type="date" name="issue_date"
                               value="{{ old('issue_date', optional($invoice->issue_date)->format('Y-m-d')) }}"
                               class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100">
                    </div>

                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Fecha de vencimiento <span class="text-red-400">*</span>
                        </label>
                        <input type="date" name="due_date"
                               value="{{ old('due_date', optional($invoice->due_date)->format('Y-m-d')) }}"
                               class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100">
                    </div>

                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Estado <span class="text-red-400">*</span>
                        </label>
                        <select name="status"
                                class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100">
                            @foreach($statuses as $key => $label)
                                <option value="{{ $key }}" {{ old('status', $invoice->status) === $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <p class="text-[11px] text-slate-500 mt-2">
                    Totales actuales: Subtotal {{ $invoice->currency }} {{ number_format($invoice->subtotal, 2) }},
                    Impuestos {{ $invoice->currency }} {{ number_format($invoice->tax_total, 2) }},
                    Total {{ $invoice->currency }} {{ number_format($invoice->total, 2) }}.
                    Se recalcularán al guardar.
                </p>
            </div>

            {{-- Ítems --}}
            <div class="glass rounded-2xl border border-slate-800 p-5 space-y-4">
                <div class="flex items-center justify-between gap-3">
                    <h2 class="text-sm font-semibold text-slate-100">
                        Conceptos de la factura
                    </h2>
                    <button type="button"
                            onclick="addInvoiceItemRow()"
                            class="inline-flex items-center justify-center px-3 py-1.5 rounded-xl text-[11px] font-semibold
                                   bg-slate-800 text-slate-100 hover:bg-slate-700 transition">
                        + Agregar concepto
                    </button>
                </div>

                @if ($errors->has('items'))
                    <p class="text-[11px] text-red-300 mb-2">
                        {{ $errors->first('items') }}
                    </p>
                @endif

                @php
                    $oldItems = old('items');
                    $itemsToShow = $oldItems ?: $invoice->items->map(function ($item) {
                        return [
                            'description' => $item->description,
                            'quantity'    => $item->quantity,
                            'unit_price'  => $item->unit_price,
                            'tax_rate'    => $item->tax_rate,
                        ];
                    })->toArray();

                    if (empty($itemsToShow)) {
                        $itemsToShow = [
                            ['description' => '', 'quantity' => 1, 'unit_price' => '0.00', 'tax_rate' => '0'],
                        ];
                    }
                @endphp

                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs text-slate-200">
                        <thead class="bg-slate-900/80 border-b border-slate-800">
                            <tr>
                                <th class="px-3 py-2 text-left font-semibold">Descripción</th>
                                <th class="px-3 py-2 text-left font-semibold">Cantidad</th>
                                <th class="px-3 py-2 text-left font-semibold">Precio unitario</th>
                                <th class="px-3 py-2 text-left font-semibold">% IVA</th>
                                <th class="px-3 py-2 text-right font-semibold">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="invoice-items-body" class="divide-y divide-slate-800/80">
                            @foreach($itemsToShow as $index => $item)
                                <tr class="hover:bg-slate-900/60 transition">
                                    <td class="px-3 py-2 align-top w-full">
                                        <input type="text"
                                               name="items[{{ $index }}][description]"
                                               value="{{ $item['description'] }}"
                                               class="w-full rounded-lg bg-slate-900/80 border border-slate-700 px-2 py-1.5 text-xs text-slate-100">
                                    </td>
                                    <td class="px-3 py-2 align-top">
                                        <input type="number" step="0.01" min="0"
                                               name="items[{{ $index }}][quantity]"
                                               value="{{ $item['quantity'] }}"
                                               class="w-24 rounded-lg bg-slate-900/80 border border-slate-700 px-2 py-1.5 text-xs text-slate-100">
                                    </td>
                                    <td class="px-3 py-2 align-top">
                                        <input type="number" step="0.01"
                                               name="items[{{ $index }}][unit_price]"
                                               value="{{ $item['unit_price'] }}"
                                               class="w-28 rounded-lg bg-slate-900/80 border border-slate-700 px-2 py-1.5 text-xs text-slate-100">
                                    </td>
                                    <td class="px-3 py-2 align-top">
                                        <input type="number" step="0.01" min="0"
                                               name="items[{{ $index }}][tax_rate]"
                                               value="{{ $item['tax_rate'] }}"
                                               class="w-20 rounded-lg bg-slate-900/80 border border-slate-700 px-2 py-1.5 text-xs text-slate-100">
                                    </td>
                                    <td class="px-3 py-2 align-top text-right">
                                        <button type="button"
                                                onclick="removeInvoiceItemRow(this)"
                                                class="inline-flex items-center justify-center px-2 py-1 rounded-lg text-[11px] font-semibold bg-red-500/15 text-red-300 border border-red-500/40 hover:bg-red-500/25 transition">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <p class="text-[11px] text-slate-500 mt-2">
                    Los totales se recalcularán al guardar.
                </p>
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.invoices.index') }}"
                   class="text-xs text-slate-400 hover:text-emerald-300">
                    Cancelar
                </a>
                <button type="submit"
                        class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-xs font-semibold
                               bg-emerald-500 text-slate-950 hover:bg-emerald-400 transition">
                    Guardar cambios
                </button>
            </div>
        </form>
    </section>

    <script>
        let invoiceItemIndex = {{ count($itemsToShow) }};

        function addInvoiceItemRow() {
            const tbody = document.getElementById('invoice-items-body');
            const index = invoiceItemIndex++;

            const tr = document.createElement('tr');
            tr.className = 'hover:bg-slate-900/60 transition';
            tr.innerHTML = `
                <td class="px-3 py-2 align-top w-full">
                    <input type="text"
                           name="items[${index}][description]"
                           class="w-full rounded-lg bg-slate-900/80 border border-slate-700 px-2 py-1.5 text-xs text-slate-100"
                           placeholder="Descripción del concepto">
                </td>
                <td class="px-3 py-2 align-top">
                    <input type="number" step="0.01" min="0"
                           name="items[${index}][quantity]"
                           value="1"
                           class="w-24 rounded-lg bg-slate-900/80 border border-slate-700 px-2 py-1.5 text-xs text-slate-100">
                </td>
                <td class="px-3 py-2 align-top">
                    <input type="number" step="0.01"
                           name="items[${index}][unit_price]"
                           value="0.00"
                           class="w-28 rounded-lg bg-slate-900/80 border border-slate-700 px-2 py-1.5 text-xs text-slate-100">
                </td>
                <td class="px-3 py-2 align-top">
                    <input type="number" step="0.01" min="0"
                           name="items[${index}][tax_rate]"
                           value="0"
                           class="w-20 rounded-lg bg-slate-900/80 border border-slate-700 px-2 py-1.5 text-xs text-slate-100">
                </td>
                <td class="px-3 py-2 align-top text-right">
                    <button type="button"
                            onclick="removeInvoiceItemRow(this)"
                            class="inline-flex items-center justify-center px-2 py-1 rounded-lg text-[11px] font-semibold bg-red-500/15 text-red-300 border border-red-500/40 hover:bg-red-500/25 transition">
                        Eliminar
                    </button>
                </td>
            `;

            tbody.appendChild(tr);
        }

        function removeInvoiceItemRow(button) {
            const row = button.closest('tr');
            const tbody = document.getElementById('invoice-items-body');
            if (tbody.children.length > 1) {
                row.remove();
            }
        }
    </script>
@endsection
