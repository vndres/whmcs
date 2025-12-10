@extends('layouts.admin')

@section('admin-content')
    <section class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-slate-50">
                    Editar cliente
                </h1>
                <p class="text-sm text-slate-400 mt-1">
                    Actualiza los datos del cliente, su información de contacto y preferencias.
                </p>
                <p class="text-[11px] text-slate-500 mt-1">
                    ID cliente: #{{ $client->id }} • UUID: {{ $client->uuid ?? '—' }}
                </p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.clients.index') }}"
                   class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-xs font-semibold
                          bg-slate-800 text-slate-100 hover:bg-slate-700 transition">
                    Volver al listado
                </a>
            </div>
        </div>

        {{-- Mensaje de éxito --}}
        @if (session('success'))
            <div class="glass rounded-xl border border-emerald-600/60 px-4 py-3 text-xs text-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        {{-- Errores de validación --}}
        @if ($errors->any())
            <div class="glass rounded-xl border border-red-600/60 px-4 py-3 text-xs text-red-200 space-y-1">
                <div class="font-semibold text-red-200 text-sm">
                    Hay algunos errores en el formulario:
                </div>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Formulario --}}
        <div class="glass rounded-2xl border border-slate-800 p-5">
            <form method="POST" action="{{ route('admin.clients.update', $client) }}" class="space-y-6">
                @csrf
                @method('PUT')

                {{-- Datos básicos --}}
                <div>
                    <h2 class="text-sm font-semibold text-slate-100 mb-3">
                        Datos básicos
                    </h2>
                    <div class="grid gap-4 md:grid-cols-2 text-xs">
                        <div class="md:col-span-2">
                            <label class="block mb-1 text-slate-300">Empresa / Organización (opcional)</label>
                            <input type="text" name="company_name"
                                   value="{{ old('company_name', $client->company_name) }}"
                                   class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-slate-100">
                        </div>

                        <div>
                            <label class="block mb-1 text-slate-300">Nombre</label>
                            <input type="text" name="first_name"
                                   value="{{ old('first_name', $client->first_name) }}"
                                   class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-slate-100"
                                   required>
                        </div>

                        <div>
                            <label class="block mb-1 text-slate-300">Apellidos</label>
                            <input type="text" name="last_name"
                                   value="{{ old('last_name', $client->last_name) }}"
                                   class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-slate-100"
                                   required>
                        </div>

                        <div>
                            <label class="block mb-1 text-slate-300">Email</label>
                            <input type="email" name="email"
                                   value="{{ old('email', $client->email) }}"
                                   class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-slate-100"
                                   required>
                        </div>

                        <div>
                            <label class="block mb-1 text-slate-300">Teléfono</label>
                            <input type="text" name="phone"
                                   value="{{ old('phone', $client->phone) }}"
                                   class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-slate-100">
                        </div>
                    </div>
                </div>

                {{-- Localización --}}
                <div>
                    <h2 class="text-sm font-semibold text-slate-100 mb-3">
                        Localización
                    </h2>
                    <div class="grid gap-4 md:grid-cols-2 text-xs">
                        <div class="md:col-span-2">
                            <label class="block mb-1 text-slate-300">Dirección</label>
                            <input type="text" name="address"
                                   value="{{ old('address', $client->address) }}"
                                   class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-slate-100">
                        </div>

                        <div>
                            <label class="block mb-1 text-slate-300">Ciudad</label>
                            <input type="text" name="city"
                                   value="{{ old('city', $client->city) }}"
                                   class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-slate-100">
                        </div>

                        <div>
                            <label class="block mb-1 text-slate-300">Estado / Provincia</label>
                            <input type="text" name="state"
                                   value="{{ old('state', $client->state) }}"
                                   class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-slate-100">
                        </div>

                        <div>
                            <label class="block mb-1 text-slate-300">
                                País (código ISO 2 letras)
                            </label>
                            <input type="text" name="country"
                                   value="{{ old('country', $client->country) }}"
                                   maxlength="2"
                                   class="uppercase w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-slate-100">
                        </div>

                        <div>
                            <label class="block mb-1 text-slate-300">Código postal</label>
                            <input type="text" name="zip"
                                   value="{{ old('zip', $client->zip) }}"
                                   class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-slate-100">
                        </div>
                    </div>
                </div>

                {{-- Preferencias --}}
                <div>
                    <h2 class="text-sm font-semibold text-slate-100 mb-3">
                        Preferencias de cuenta
                    </h2>
                    <div class="grid gap-4 md:grid-cols-3 text-xs">
                        <div>
                            <label class="block mb-1 text-slate-300">Moneda</label>
                            <input type="text" name="currency"
                                   value="{{ old('currency', $client->currency) }}"
                                   maxlength="3"
                                   class="uppercase w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-slate-100">
                        </div>

                        <div>
                            <label class="block mb-1 text-slate-300">Idioma</label>
                            <input type="text" name="language"
                                   value="{{ old('language', $client->language) }}"
                                   maxlength="5"
                                   class="lowercase w-full rounded-xl bg-slate-900/80 border border-slate-700 px-3 py-2 text-slate-100">
                        </div>

                        <div class="flex items-end">
                            <label class="inline-flex items-center gap-2 text-slate-300">
                                <input type="checkbox" name="is_active" value="1"
                                       class="rounded border-slate-600 bg-slate-900"
                                       {{ old('is_active', $client->is_active) ? 'checked' : '' }}>
                                <span class="text-xs">Cliente activo</span>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- Info de crédito (solo lectura, si quieres mostrarla) --}}
                <div>
                    <h2 class="text-sm font-semibold text-slate-100 mb-2">
                        Información de crédito
                    </h2>
                    <p class="text-xs text-slate-400">
                        Crédito actual: <span class="font-semibold text-emerald-300">
                            {{ number_format($client->credit_balance ?? 0, 2) }} {{ $client->currency ?? 'USD' }}
                        </span>
                        (gestionado desde el módulo de créditos / facturación).
                    </p>
                </div>

                {{-- Botones --}}
                <div class="flex items-center justify-between gap-2 pt-2">
                    <a href="{{ route('admin.clients.index') }}"
                       class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-xs font-semibold text-slate-300 hover:text-slate-50">
                        Cancelar
                    </a>

                    <button type="submit"
                            class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-xs font-semibold
                                   bg-emerald-500 text-slate-950 hover:bg-emerald-400 transition">
                        Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
