@extends('layouts.admin')

@section('admin-content')
    <section class="space-y-6">
        <div class="flex items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-slate-50">
                    Nuevo servicio
                </h1>
                <p class="text-sm text-slate-400 mt-1">
                    Asigna un servicio a un cliente usando un producto/plan.
                </p>
            </div>

            <a href="{{ route('admin.services.index') }}"
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

        <form action="{{ route('admin.services.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="glass rounded-2xl border border-slate-800 p-5 space-y-4">
                <h2 class="text-sm font-semibold text-slate-100 mb-1">
                    Datos principales
                </h2>

                <div class="grid gap-4 md:grid-cols-2">
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
                            Producto / plan <span class="text-red-400">*</span>
                        </label>
                        <select name="product_id"
                                class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100">
                            <option value="">Selecciona un producto</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} ({{ $product->type }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Servidor (opcional)
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

                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Estado <span class="text-red-400">*</span>
                        </label>
                        <select name="status"
                                class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100">
                            @foreach($statuses as $key => $label)
                                <option value="{{ $key }}" {{ old('status', 'active') === $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Dominio / identificador
                        </label>
                        <input type="text" name="domain" value="{{ old('domain') }}"
                               class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100"
                               placeholder="ej: midominio.com">
                    </div>

                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Usuario de servicio (opcional)
                        </label>
                        <input type="text" name="username" value="{{ old('username') }}"
                               class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100"
                               placeholder="ej: cpaneluser">
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Contraseña de servicio (opcional)
                        </label>
                        <input type="text" name="password" value="{{ old('password') }}"
                               class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100"
                               placeholder="Puedes dejarla en blanco">
                    </div>
                </div>
            </div>

            <div class="glass rounded-2xl border border-slate-800 p-5 space-y-4">
                <h2 class="text-sm font-semibold text-slate-100 mb-1">
                    Fechas y ciclo de vida
                </h2>

                <div class="grid gap-4 md:grid-cols-3">
                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Fecha de activación
                        </label>
                        <input type="date" name="activation_date" value="{{ old('activation_date') }}"
                               class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100">
                    </div>

                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Próximo vencimiento
                        </label>
                        <input type="date" name="next_due_date" value="{{ old('next_due_date') }}"
                               class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100">
                    </div>

                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Fecha de cancelación
                        </label>
                        <input type="date" name="cancellation_date" value="{{ old('cancellation_date') }}"
                               class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100">
                    </div>
                </div>
            </div>

            <div class="glass rounded-2xl border border-slate-800 p-5 space-y-4">
                <h2 class="text-sm font-semibold text-slate-100 mb-1">
                    Configuración técnica (JSON opcional)
                </h2>

                <p class="text-[11px] text-slate-500 mb-2">
                    Aquí puedes guardar configuración adicional del servicio en formato JSON,
                    por ejemplo límites de recursos, IDs de cuenta en el panel remoto, etc.
                </p>

                <textarea name="config_raw" rows="5"
                          class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-[11px] text-slate-100"
                          placeholder='{"plan":"starter","disk_limit":"10GB"}'>{{ old('config_raw') }}</textarea>
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.services.index') }}"
                   class="text-xs text-slate-400 hover:text-emerald-300">
                    Cancelar
                </a>
                <button type="submit"
                        class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-xs font-semibold
                               bg-emerald-500 text-slate-950 hover:bg-emerald-400 transition">
                    Guardar servicio
                </button>
            </div>
        </form>
    </section>
@endsection
