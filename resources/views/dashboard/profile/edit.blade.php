@extends('layouts.frontend')

@section('title', 'Mi perfil - Linea365 Clientes')

@section('content')
    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-slate-50">Mi perfil</h1>
            <p class="text-sm text-slate-400 mt-1">
                Gestiona tus datos personales, de contacto y el idioma preferido para tu área de cliente.
            </p>
            <p class="text-xs text-slate-500 mt-1">
                Sesión iniciada como {{ $user->email }}
            </p>
        </div>

        @if (session('status'))
            <div class="mb-5 glass rounded-2xl border border-emerald-600/40 bg-emerald-500/10 px-4 py-3 text-xs text-emerald-200">
                {{ session('status') }}
            </div>
        @endif

        <div class="glass rounded-2xl border border-slate-800 p-5 sm:p-6 space-y-6">
            <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Datos personales --}}
                <div>
                    <h2 class="text-sm font-semibold text-slate-100 mb-3">Datos personales</h2>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-slate-300 mb-1">Nombre</label>
                            <input
                                type="text"
                                name="first_name"
                                value="{{ old('first_name', $client->first_name) }}"
                                autocomplete="given-name"
                                required
                                class="w-full rounded-xl bg-slate-900/60 border border-slate-700 px-4 py-3
                                       text-base text-slate-100 leading-normal appearance-none
                                       focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500"
                            >
                            @error('first_name')
                                <p class="text-[11px] text-rose-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-300 mb-1">Apellido</label>
                            <input
                                type="text"
                                name="last_name"
                                value="{{ old('last_name', $client->last_name) }}"
                                autocomplete="family-name"
                                required
                                class="w-full rounded-xl bg-slate-900/60 border border-slate-700 px-4 py-3
                                       text-base text-slate-100 leading-normal appearance-none
                                       focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500"
                            >
                            @error('last_name')
                                <p class="text-[11px] text-rose-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-xs font-medium text-slate-300 mb-1">Nombre de empresa (opcional)</label>
                        <input
                            type="text"
                            name="company_name"
                            value="{{ old('company_name', $client->company_name) }}"
                            autocomplete="organization"
                            class="w-full rounded-xl bg-slate-900/60 border border-slate-700 px-4 py-3
                                   text-base text-slate-100 leading-normal appearance-none
                                   focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500"
                        >
                        @error('company_name')
                            <p class="text-[11px] text-rose-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Contacto --}}
                <div>
                    <h2 class="text-sm font-semibold text-slate-100 mb-3">Información de contacto</h2>

                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-slate-300 mb-1">Teléfono</label>
                            <input
                                type="tel"
                                name="phone"
                                value="{{ old('phone', $client->phone) }}"
                                inputmode="tel"
                                autocomplete="tel"
                                class="w-full rounded-xl bg-slate-900/60 border border-slate-700 px-4 py-3
                                       text-base text-slate-100 leading-normal appearance-none
                                       focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500"
                                placeholder="Ej: +57 300 123 4567"
                            >
                            @error('phone')
                                <p class="text-[11px] text-rose-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-300 mb-1">Correo electrónico</label>
                            <input
                                type="email"
                                value="{{ $client->email }}"
                                class="w-full rounded-xl bg-slate-900/60 border border-slate-800 px-4 py-3
                                       text-base text-slate-400 leading-normal appearance-none cursor-not-allowed"
                                disabled
                            >
                            <p class="text-[11px] text-slate-500 mt-1">
                                Si deseas cambiar tu correo, más adelante crearemos un flujo seguro para actualizarlo.
                            </p>
                        </div>
                    </div>

                    <div class="mt-4 grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-slate-300 mb-1">País (código ISO 2)</label>
                            <input
                                type="text"
                                name="country"
                                value="{{ old('country', $client->country) }}"
                                placeholder="Ej: CO, MX, AR"
                                maxlength="2"
                                autocomplete="country"
                                class="w-full rounded-xl bg-slate-900/60 border border-slate-700 px-4 py-3
                                       text-base text-slate-100 leading-normal appearance-none uppercase
                                       focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500"
                            >
                            @error('country')
                                <p class="text-[11px] text-rose-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-300 mb-1">Ciudad</label>
                            <input
                                type="text"
                                name="city"
                                value="{{ old('city', $client->city) }}"
                                autocomplete="address-level2"
                                class="w-full rounded-xl bg-slate-900/60 border border-slate-700 px-4 py-3
                                       text-base text-slate-100 leading-normal appearance-none
                                       focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500"
                            >
                            @error('city')
                                <p class="text-[11px] text-rose-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4 grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-medium text-slate-300 mb-1">Departamento / Estado</label>
                            <input
                                type="text"
                                name="state"
                                value="{{ old('state', $client->state) }}"
                                autocomplete="address-level1"
                                class="w-full rounded-xl bg-slate-900/60 border border-slate-700 px-4 py-3
                                       text-base text-slate-100 leading-normal appearance-none
                                       focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500"
                            >
                            @error('state')
                                <p class="text-[11px] text-rose-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-300 mb-1">Código postal</label>
                            <input
                                type="text"
                                name="zip"
                                value="{{ old('zip', $client->zip) }}"
                                inputmode="numeric"
                                autocomplete="postal-code"
                                class="w-full rounded-xl bg-slate-900/60 border border-slate-700 px-4 py-3
                                       text-base text-slate-100 leading-normal appearance-none
                                       focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500"
                            >
                            @error('zip')
                                <p class="text-[11px] text-rose-400 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-xs font-medium text-slate-300 mb-1">Dirección</label>
                        <input
                            type="text"
                            name="address"
                            value="{{ old('address', $client->address) }}"
                            autocomplete="street-address"
                            class="w-full rounded-xl bg-slate-900/60 border border-slate-700 px-4 py-3
                                   text-base text-slate-100 leading-normal appearance-none
                                   focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500"
                        >
                        @error('address')
                            <p class="text-[11px] text-rose-400 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Idioma --}}
                <div>
                    <h2 class="text-sm font-semibold text-slate-100 mb-3">Idioma del panel</h2>
                    <p class="text-xs text-slate-400 mb-2">
                        Este idioma se usará para tu área de cliente. Por ahora los textos están principalmente en español,
                        pero vamos a ir agregando soporte completo para inglés.
                    </p>

                    <select
                        name="language"
                        class="w-full sm:w-64 rounded-xl bg-slate-900/60 border border-slate-700 px-4 py-3
                               text-base text-slate-100 leading-normal appearance-none
                               focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500"
                    >
                        @php $lang = old('language', $client->language ?? 'es'); @endphp
                        <option value="es" {{ $lang === 'es' ? 'selected' : '' }}>Español</option>
                        <option value="en" {{ $lang === 'en' ? 'selected' : '' }}>English</option>
                    </select>

                    @error('language')
                        <p class="text-[11px] text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between pt-2">
                    <a href="{{ route('dashboard') }}" class="text-xs text-slate-400 hover:text-slate-200">
                        ← Volver al panel
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-xs font-semibold
                               bg-emerald-500 hover:bg-emerald-400 text-slate-900 shadow-lg shadow-emerald-500/30 transition"
                    >
                        Guardar cambios
                    </button>
                </div>
            </form>
        </div>
    </section>
@endsection
