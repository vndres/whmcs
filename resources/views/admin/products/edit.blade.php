@extends('layouts.admin')

@section('admin-content')
    <section class="space-y-6">
        <div class="flex items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-slate-50">
                    Editar producto / plan
                </h1>
                <p class="text-sm text-slate-400 mt-1">
                    Actualiza la configuración de este plan.
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

        <form action="{{ route('admin.products.update', $product) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="glass rounded-2xl border border-slate-800 p-5 space-y-4">
                <h2 class="text-sm font-semibold text-slate-100 mb-1">
                    Datos generales
                </h2>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Nombre del producto <span class="text-red-400">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}"
                               class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100">
                    </div>

                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Slug
                        </label>
                        <input type="text" name="slug" value="{{ old('slug', $product->slug) }}"
                               class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100">
                        <p class="text-[11px] text-slate-500 mt-1">
                            Si lo dejas vacío, se regenerará desde el nombre.
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
                            <option value="hosting" {{ old('type', $product->type) === 'hosting' ? 'selected' : '' }}>Hosting</option>
                            <option value="domain" {{ old('type', $product->type) === 'domain' ? 'selected' : '' }}>Dominio</option>
                            <option value="vps" {{ old('type', $product->type) === 'vps' ? 'selected' : '' }}>VPS / Servidor</option>
                            <option value="other" {{ old('type', $product->type) === 'other' ? 'selected' : '' }}>Otro servicio</option>
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
                                <option value="{{ $server->id }}" {{ old('server_id', $product->server_id) == $server->id ? 'selected' : '' }}>
                                    {{ $server->name }} ({{ $server->hostname }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="text-xs text-slate-300 mb-1 block">
                        Descripción
                    </label>
                    <textarea name="description" rows="4"
                              class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100">{{ old('description', $product->description) }}</textarea>
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
                        <input type="number" step="0.01" name="price_monthly"
                               value="{{ old('price_monthly', $product->price_monthly) }}"
                               class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100">
                    </div>

                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Precio anual
                        </label>
                        <input type="number" step="0.01" name="price_yearly"
                               value="{{ old('price_yearly', $product->price_yearly) }}"
                               class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100">
                    </div>

                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Cargo de instalación (setup)
                        </label>
                        <input type="number" step="0.01" name="setup_fee"
                               value="{{ old('setup_fee', $product->setup_fee) }}"
                               class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100">
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
                                   {{ old('is_recurring', $product->is_recurring) ? 'checked' : '' }}>
                            <span>Facturación recurrente (mensual/anual)</span>
                        </label>
                    </div>

                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Ciclos de facturación
                        </label>
                        <input type="number" name="billing_cycles"
                               value="{{ old('billing_cycles', $product->billing_cycles) }}"
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
                                   {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
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
                    Guardar cambios
                </button>
            </div>
        </form>
    </section>
@endsection
