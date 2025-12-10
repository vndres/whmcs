@extends('layouts.frontend')

@section('title', 'Crear cuenta - Linea365 Clientes')

@section('content')
    <section class="max-w-md mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14">
        <div class="glass rounded-2xl p-6 border border-slate-800">
            <div class="mb-4 text-center">
                <h1 class="text-xl sm:text-2xl font-semibold text-slate-50">
                    Crear cuenta
                </h1>
                <p class="text-xs text-slate-400 mt-1">
                    Regístrate para gestionar tus servicios de hosting y dominios.
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-4 text-xs rounded-xl border border-rose-500/40 bg-rose-500/5 text-rose-200 px-3 py-2">
                    <div class="font-semibold mb-1">Revisa los siguientes campos:</div>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
                @csrf

                <div class="space-y-1 text-xs">
                    <label for="name" class="text-slate-200 font-medium">Nombre completo</label>
                    <input
                        id="name"
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        class="w-full rounded-xl border border-slate-700 bg-slate-900/70 text-slate-100 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/70 focus:border-emerald-500"
                        placeholder="Tu nombre"
                    >
                </div>

                <div class="space-y-1 text-xs">
                    <label for="email" class="text-slate-200 font-medium">Correo electrónico</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        class="w-full rounded-xl border border-slate-700 bg-slate-900/70 text-slate-100 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/70 focus:border-emerald-500"
                        placeholder="tucorreo@ejemplo.com"
                    >
                </div>
                <div class="space-y-1 text-xs">
    <label for="locale" class="text-slate-200 font-medium">Idioma / Language</label>
    <select
        id="locale"
        name="locale"
        class="w-full rounded-xl border border-slate-700 bg-slate-900/70 text-slate-100 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/70 focus:border-emerald-500"
        required
    >
        <option value="es" {{ old('locale', 'es') === 'es' ? 'selected' : '' }}>Español</option>
        <option value="en" {{ old('locale') === 'en' ? 'selected' : '' }}>English</option>
    </select>
</div>


                <div class="space-y-1 text-xs">
                    <label for="password" class="text-slate-200 font-medium">Contraseña</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        class="w-full rounded-xl border border-slate-700 bg-slate-900/70 text-slate-100 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/70 focus:border-emerald-500"
                        placeholder="Mínimo 6 caracteres"
                    >
                </div>

                <div class="space-y-1 text-xs">
                    <label for="password_confirmation" class="text-slate-200 font-medium">Repetir contraseña</label>
                    <input
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        required
                        class="w-full rounded-xl border border-slate-700 bg-slate-900/70 text-slate-100 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/70 focus:border-emerald-500"
                        placeholder="Repite la contraseña"
                    >
                </div>

                <button
                    type="submit"
                    class="w-full btn-primary inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-sm font-semibold shadow-lg shadow-emerald-500/30"
                >
                    Crear cuenta y entrar
                </button>
            </form>

            <p class="mt-4 text-[11px] text-center text-slate-400">
                ¿Ya tienes cuenta?
                <a href="{{ route('login') }}" class="text-emerald-400 hover:text-emerald-300">
                    Iniciar sesión
                </a>
            </p>
        </div>
    </section>
@endsection
