@extends('layouts.admin')

@section('admin-content')
    <section class="space-y-6">
        <div class="flex items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-slate-50">
                    Nueva factura
                </h1>
                <p class="text-sm text-slate-400 mt-1">
                    Crea una factura para un cliente con uno o varios conceptos.
                </p>
            </div>

            <a href="{{ route('admin.invoices.index') }}"
               class="text-xs text-slate-400 hover:text-emerald-300">
                ← Volver al listado
            </a>
        </div>

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

        <form action="{{ route('admin.invoices.store') }}" method="POST" class="space-y-6">
            @csrf

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
                               value="{{ old('number', $suggestedNumber) }}"
                               class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100">
                        <p class="text-[11px] text-slate-500 mt-1">
                            Puedes dejar el número sugerido o cambiarlo.
                        </p>
                    </div>

                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Cliente <span class="text-red-400">*</span>
                        </label>
                        <select name="client_id"
                                class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100">
                            <option value="">Selecciona un cliente</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
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
                               value="{{ old('currency', 'USD') }}"
                               class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100"
                               placeholder="ej: USD, COP">
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-3">
                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Fecha de emisión <span class="text-red-400">*</span>
                        </label>
                        <input type="date" name="issue_date"
                               value="{{ old('issue_date', now()->format('Y-m-d')) }}"
                               class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100">
                    </div>

                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Fecha de vencimiento <span class="text-red-400">*</span>
                        </label>
                        <input type="date" name="due_date"
                               value="{{ old('due_date', now()->addDays(5)->format('Y-m-d')) }}"
                               class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100">
                    </div>

                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Estado <span class="text-red-400">*</span>
                        </label>
                        <select name="status"
                                class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100">
                            @foreach($statuses as $key => $label)
                                <option value="{{ $key }}" {{ old('status', 'unpaid') === $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Ítems de factura --}}
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
                            @php
                                $oldItems = old('items', [
                                    ['description' => '', 'quantity' => 1, 'unit_price' => '0.00', 'tax_rate' => '0'],
                                ]);
                            @endphp

                            @foreach($oldItems as $index => $item)
                                <tr class="hover:bg-slate-900/60 transition">
                                    <td class="px-3 py-2 align-top w-full">
                                        <input type="text"
                                               name="items[{{ $index }}][description]"
                                               value="{{ $item['description'] }}"
                                               class="w-full rounded-lg bg-slate-900/80 border border-slate-700 px-2 py-1.5 text-xs text-slate-100"
                                               placeholder="ej: Plan de hosting básico">
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
                    Los totales (subtotal, impuestos y total) se calcularán automáticamente al guardar.
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
                    Guardar factura
                </button>
            </div>
        </form>
    </section>

    <script>
        let invoiceItemIndex = {{ count($oldItems) }};

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
