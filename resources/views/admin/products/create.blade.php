@extends('layouts.admin')

@section('admin-content')
    <section class="space-y-6">
        <div class="flex items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-slate-50">
                    Nuevo producto / plan
                </h1>
                <p class="text-sm text-slate-400 mt-1">
                    Define un plan de hosting, dominio u otro servicio que luego podrás asignar a tus clientes.
                </p>
            </div>

            <a href="{{ route('admin.products.index') }}"
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

        <form action="{{ route('admin.products.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="glass rounded-2xl border border-slate-800 p-5 space-y-4">
                <h2 class="text-sm font-semibold text-slate-100 mb-1">
                    Datos generales
                </h2>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Nombre del producto <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100"
                               placeholder="Ej: Hosting Básico SSD">
                    </div>

                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Slug (opcional)
                        </label>
                        <input type="text" name="slug" value="{{ old('slug') }}"
                               class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100"
                               placeholder="ej: hosting-basico-ssd">
                        <p class="text-[11px] text-slate-500 mt-1">
                            Si lo dejas vacío, se generará automáticamente a partir del nombre.
                        </p>
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Tipo de producto <span class="text-red-400">*</span>
                        </label>
                        <select name="type"
                                class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100">
                            <option value="hosting" {{ old('type') === 'hosting' ? 'selected' : '' }}>Hosting</option>
                            <option value="domain" {{ old('type') === 'domain' ? 'selected' : '' }}>Dominio</option>
                            <option value="vps" {{ old('type') === 'vps' ? 'selected' : '' }}>VPS / Servidor</option>
                            <option value="other" {{ old('type') === 'other' ? 'selected' : '' }}>Otro servicio</option>
                        </select>
                    </div>

                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Servidor asociado (opcional)
                        </label>
                        <select name="server_id"
                                class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100">
                            <option value="">Sin servidor</option>
                            @foreach($servers as $server)
                                <option value="{{ $server->id }}" {{ old('server_id') == $server->id ? 'selected' : '' }}>
                                    {{ $server->name }} ({{ $server->hostname }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="text-xs text-slate-300 mb-1 block">
                        Descripción (opcional)
                    </label>
                    <textarea name="description" rows="4"
                              class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100"
                              placeholder="Descripción corta del plan, características, recursos, etc.">{{ old('description') }}</textarea>
                </div>
            </div>

            <div class="glass rounded-2xl border border-slate-800 p-5 space-y-4">
                <h2 class="text-sm font-semibold text-slate-100 mb-1">
                    Precios y facturación
                </h2>

                <div class="grid gap-4 md:grid-cols-3">
                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Precio mensual
                        </label>
                        <input type="number" step="0.01" name="price_monthly" value="{{ old('price_monthly') }}"
                               class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100"
                               placeholder="Ej: 9.99">
                    </div>

                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Precio anual
                        </label>
                        <input type="number" step="0.01" name="price_yearly" value="{{ old('price_yearly') }}"
                               class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100"
                               placeholder="Ej: 99.00">
                    </div>

                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Cargo de instalación (setup)
                        </label>
                        <input type="number" step="0.01" name="setup_fee" value="{{ old('setup_fee') }}"
                               class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100"
                               placeholder="Ej: 0.00">
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-3">
                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            ¿Es recurrente?
                        </label>
                        <label class="inline-flex items-center gap-2 text-xs text-slate-300">
                            <input type="checkbox" name="is_recurring" value="1"
                                   class="rounded border-slate-600 bg-slate-900"
                                   {{ old('is_recurring', true) ? 'checked' : '' }}>
                            <span>Facturación recurrente (mensual/anual)</span>
                        </label>
                    </div>

                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Ciclos de facturación
                        </label>
                        <input type="number" name="billing_cycles" value="{{ old('billing_cycles') }}"
                               class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100"
                               placeholder="0 = ilimitado">
                        <p class="text-[11px] text-slate-500 mt-1">
                            0 para sin límite, o un número de ciclos (ej: 12 meses).
                        </p>
                    </div>

                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Estado del producto
                        </label>
                        <label class="inline-flex items-center gap-2 text-xs text-slate-300">
                            <input type="checkbox" name="is_active" value="1"
                                   class="rounded border-slate-600 bg-slate-900"
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <span>Activo (visible para uso)</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.products.index') }}"
                   class="text-xs text-slate-400 hover:text-emerald-300">
                    Cancelar
                </a>
                <button type="submit"
                        class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-xs font-semibold
                               bg-emerald-500 text-slate-950 hover:bg-emerald-400 transition">
                    Guardar producto
                </button>
            </div>
        </form>
    </section>
@endsection
