@extends('layouts.frontend')

@section('title', 'Iniciar sesión - Linea365 Clientes')

@section('content')
    <section class="max-w-md mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14">
        <div class="glass rounded-2xl p-6 border border-slate-800">
            <div class="mb-4 text-center">
                <h1 class="text-xl sm:text-2xl font-semibold text-slate-50">
                    Iniciar sesión
                </h1>
                <p class="text-xs text-slate-400 mt-1">
                    Ingresa a tu panel de Linea365 Clientes para gestionar tus servicios.
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-4 text-xs rounded-xl border border-rose-500/40 bg-rose-500/5 text-rose-200 px-3 py-2">
                    <div class="font-semibold mb-1">Ups, algo salió mal:</div>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                @csrf

                <div class="space-y-1 text-xs">
                    <label for="email" class="text-slate-200 font-medium">Correo electrónico</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        inputmode="email"
                        autocomplete="email"
                        class="w-full rounded-xl border border-slate-700 bg-slate-900/70 text-slate-100 px-3 py-3 text-base leading-normal appearance-none
                               focus:outline-none focus:ring-2 focus:ring-emerald-500/70 focus:border-emerald-500"
                        placeholder="tucorreo@ejemplo.com"
                    >
                </div>

                <div class="space-y-1 text-xs">
                    <label for="password" class="text-slate-200 font-medium">Contraseña</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        required
                        inputmode="text"
                        autocomplete="current-password"
                        class="w-full rounded-xl border border-slate-700 bg-slate-900/70 text-slate-100 px-3 py-3 text-base leading-normal appearance-none
                               focus:outline-none focus:ring-2 focus:ring-emerald-500/70 focus:border-emerald-500"
                        placeholder="••••••••"
                    >
                </div>

                <div class="flex items-center justify-between text-xs text-slate-400">
                    <label class="inline-flex items-center gap-2">
                        <input
                            type="checkbox"
                            name="remember"
                            class="h-4 w-4 rounded border-slate-700 bg-slate-900 text-emerald-500 focus:ring-emerald-500/70"
                        >
                        <span>Recordarme</span>
                    </label>
                    <span class="text-[11px] text-slate-500">
                        (Recuperación de contraseña la configuramos luego)
                    </span>
                </div>

                <button
                    type="submit"
                    class="w-full mt-4 bg-emerald-600 hover:bg-emerald-500 text-white inline-flex items-center justify-center
                           px-4 py-3 rounded-xl text-sm font-bold shadow-lg shadow-emerald-500/20 transform hover:-translate-y-0.5
                           transition-all duration-200">
                    Entrar al panel
                </button>
            </form>

            <p class="mt-4 text-[11px] text-center text-slate-400">
                ¿Aún no tienes cuenta?
                <a href="{{ route('register') }}" class="text-emerald-400 hover:text-emerald-300">
                    Crear una nueva cuenta
                </a>
            </p>
        </div>
    </section>
@endsection
