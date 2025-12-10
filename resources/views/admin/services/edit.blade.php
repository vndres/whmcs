@extends('layouts.admin')

@section('admin-content')
    <section class="space-y-6">
        <div class="flex items-center justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-slate-50">
                    Editar servicio #{{ $service->id }}
                </h1>
                <p class="text-sm text-slate-400 mt-1">
                    Actualiza el estado, servidor, datos de acceso y fechas de este servicio.
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

        <form action="{{ route('admin.services.update', $service) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

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
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ old('client_id', $service->client_id) == $client->id ? 'selected' : '' }}>
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
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id', $service->product_id) == $product->id ? 'selected' : '' }}>
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
                                <option value="{{ $server->id }}" {{ old('server_id', $service->server_id) == $server->id ? 'selected' : '' }}>
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
                                <option value="{{ $key }}" {{ old('status', $service->status) === $key ? 'selected' : '' }}>
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
                        <input type="text" name="domain"
                               value="{{ old('domain', $service->domain) }}"
                               class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100">
                    </div>

                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Usuario de servicio (opcional)
                        </label>
                        <input type="text" name="username"
                               value="{{ old('username', $service->username) }}"
                               class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100">
                    </div>
                </div>

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Contraseña de servicio (opcional)
                        </label>
                        <input type="text" name="password"
                               value="{{ old('password', $service->password) }}"
                               class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100">
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
                        <input type="date" name="activation_date"
                               value="{{ old('activation_date', optional($service->activation_date)->format('Y-m-d')) }}"
                               class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100">
                    </div>

                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Próximo vencimiento
                        </label>
                        <input type="date" name="next_due_date"
                               value="{{ old('next_due_date', optional($service->next_due_date)->format('Y-m-d')) }}"
                               class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100">
                    </div>

                    <div>
                        <label class="text-xs text-slate-300 mb-1 block">
                            Fecha de cancelación
                        </label>
                        <input type="date" name="cancellation_date"
                               value="{{ old('cancellation_date', optional($service->cancellation_date)->format('Y-m-d')) }}"
                               class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-sm text-slate-100">
                    </div>
                </div>
            </div>

            <div class="glass rounded-2xl border border-slate-800 p-5 space-y-4">
                <h2 class="text-sm font-semibold text-slate-100 mb-1">
                    Configuración técnica (JSON)
                </h2>

                <p class="text-[11px] text-slate-500 mb-2">
                    Puedes editar la configuración adicional guardada para este servicio.
                </p>

                <textarea name="config_raw" rows="6"
                          class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-[11px] text-slate-100">{{ old('config_raw', $configRaw) }}</textarea>
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('admin.services.index') }}"
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
