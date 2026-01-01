@extends('layouts.frontend')

@section('title', 'Crear cuenta - Linea365 Clientes')

@section('content')
    {{-- Librería intl-tel-input --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">

    <style>
        /* ====== intl-tel-input fixes (modo oscuro + glass) ====== */
        .iti { width: 100%; display: block; }

        /* IMPORTANTE: 16px para evitar auto-zoom en iOS */
        #phone_visible,
        .iti__tel-input,
        input[type="tel"]{
            font-size: 16px !important;
            line-height: 1.25rem !important;
            color: #ffffff !important;
            background-color: rgba(15, 23, 42, 0.5) !important; /* slate-900/50 */
            border: 1px solid #334155 !important; /* slate-700 */
            border-radius: 0.75rem !important; /* rounded-xl */
            padding-top: 0.75rem !important;   /* match py-3 */
            padding-bottom: 0.75rem !important;
            padding-right: 1rem !important;
            outline: none !important;
            transition: all 0.2s ease;
            appearance: none !important;
            -webkit-appearance: none !important;
        }

        /* espacio para bandera y dial code */
        .iti__tel-input { padding-left: 92px !important; }

        /* dial code en blanco */
        .iti__selected-dial-code { color: #ffffff !important; }

        /* focus */
        .iti__tel-input:focus,
        #phone_visible:focus{
            border-color: #10b981 !important;
            box-shadow: 0 0 0 2px rgba(16,185,129,.25) !important;
        }

        /* dropdown países oscuro */
        .iti__country-list{
            background-color: #1e293b !important; /* slate-800 */
            border: 1px solid #475569 !important;
            color: #ffffff !important;
            border-radius: 0.75rem !important;
            box-shadow: 0 10px 15px -3px rgba(0,0,0,.5);
            margin-top: 6px;
            z-index: 60;
        }
        .iti__country.iti__highlight{ background-color: #0f172a !important; }
        .iti__arrow{ border-top-color:#94a3b8 !important; }
        .iti__arrow--up{ border-bottom-color:#94a3b8 !important; }

        /* autofill oscuro (Chrome) */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active{
            -webkit-box-shadow: 0 0 0 30px #0f172a inset !important;
            -webkit-text-fill-color: #ffffff !important;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>

    <section class="max-w-md mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14">
        <div class="glass rounded-2xl p-6 border border-slate-800 bg-slate-900/40 backdrop-blur-md relative z-10 shadow-2xl">

            {{-- HEADER --}}
            <div class="mb-6 text-center">
                <h1 class="text-xl sm:text-2xl font-bold text-white tracking-tight">
                    Crear cuenta Global
                </h1>
                <p class="text-xs text-slate-400 mt-2">
                    Regístrate para gestionar tus servicios.
                </p>
            </div>

            {{-- ERRORES --}}
            @if ($errors->any())
                <div class="mb-6 text-xs rounded-xl border border-rose-500/40 bg-rose-500/10 text-rose-300 px-4 py-3">
                    <div class="font-bold mb-1 flex items-center gap-2">
                        <span>⚠️</span> Corrige los errores:
                    </div>
                    <ul class="list-disc list-inside space-y-0.5 opacity-90">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form id="registerForm" method="POST" action="{{ route('register.post') }}" class="space-y-5">
                @csrf

                {{-- NOMBRE --}}
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-slate-300 uppercase tracking-wider ml-1">Nombre completo</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        required
                        autofocus
                        autocomplete="name"
                        class="w-full rounded-xl border border-slate-700 bg-slate-900/50 text-white px-4 py-3
                               text-base leading-normal appearance-none
                               focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500
                               placeholder-slate-500 transition-all"
                        placeholder="Ej: Juan Pérez">
                </div>

                {{-- EMAIL --}}
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-slate-300 uppercase tracking-wider ml-1">Correo electrónico</label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                        inputmode="email"
                        autocomplete="email"
                        class="w-full rounded-xl border border-slate-700 bg-slate-900/50 text-white px-4 py-3
                               text-base leading-normal appearance-none
                               focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500
                               placeholder-slate-500 transition-all"
                        placeholder="tucorreo@ejemplo.com">
                </div>

                {{-- WHATSAPP / CELULAR --}}
                <div class="space-y-1.5 relative">
                    <label class="text-xs font-semibold text-slate-300 uppercase tracking-wider ml-1">WhatsApp / Celular</label>

                    {{-- Input Visible --}}
                    <input id="phone_visible" type="tel" inputmode="tel" autocomplete="tel"
                           class="w-full placeholder-slate-500"
                           placeholder="Número celular">

                    {{-- Input Oculto --}}
                    <input type="hidden" name="phone" id="phone_hidden">

                    {{-- Feedback visual --}}
                    <div id="phone-feedback" class="hidden mt-1.5 text-[11px] font-medium ml-1 flex items-center gap-1"></div>
                </div>

                {{-- IDIOMA --}}
                <div class="space-y-1.5">
                    <label class="text-xs font-semibold text-slate-300 uppercase tracking-wider ml-1">Idioma</label>
                    <div class="relative">
                        <select name="locale"
                                class="w-full appearance-none rounded-xl border border-slate-700 bg-slate-900/50 text-white px-4 py-3
                                       text-base leading-normal
                                       focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500
                                       cursor-pointer transition-all">
                            <option value="es" {{ old('locale', 'es') === 'es' ? 'selected' : '' }}>🇪🇸 Español</option>
                            <option value="en" {{ old('locale') === 'en' ? 'selected' : '' }}>🇺🇸 English</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- PASSWORD --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-slate-300 uppercase tracking-wider ml-1">Contraseña</label>
                        <input
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            class="w-full rounded-xl border border-slate-700 bg-slate-900/50 text-white px-4 py-3
                                   text-base leading-normal appearance-none
                                   focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500
                                   placeholder-slate-500 transition-all"
                            placeholder="******">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-semibold text-slate-300 uppercase tracking-wider ml-1">Repetir</label>
                        <input
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            class="w-full rounded-xl border border-slate-700 bg-slate-900/50 text-white px-4 py-3
                                   text-base leading-normal appearance-none
                                   focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500
                                   placeholder-slate-500 transition-all"
                            placeholder="******">
                    </div>
                </div>

                {{-- BOTÓN --}}
                <button type="submit"
                        class="w-full mt-4 bg-emerald-600 hover:bg-emerald-500 text-white inline-flex items-center justify-center
                               px-4 py-3 rounded-xl text-sm font-bold shadow-lg shadow-emerald-500/20
                               transform hover:-translate-y-0.5 transition-all duration-200">
                    🚀 Crear cuenta y entrar
                </button>
            </form>

            <p class="mt-6 text-xs text-center text-slate-400">
                ¿Ya tienes una cuenta?
                <a href="{{ route('login') }}" class="text-emerald-400 font-bold hover:underline">
                    Iniciar sesión
                </a>
            </p>
        </div>
    </section>

    {{-- SCRIPT --}}
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const input = document.querySelector("#phone_visible");
            const hiddenInput = document.querySelector("#phone_hidden");
            const feedback = document.querySelector("#phone-feedback");
            const form = document.querySelector("#registerForm");

            const iti = window.intlTelInput(input, {
                initialCountry: "auto",
                geoIpLookup: callback => {
                    fetch("https://ipapi.co/json")
                        .then(res => res.json())
                        .then(data => callback(data.country_code))
                        .catch(() => callback("co"));
                },
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js",
                separateDialCode: true,
                preferredCountries: ['co', 'mx', 'us', 'es', 'pe', 'cl', 'ar'],
                autoPlaceholder: "aggressive",
            });

            const validate = () => {
                feedback.classList.remove("hidden", "text-rose-400", "text-emerald-400");

                if (input.value.trim()) {
                    if (iti.isValidNumber()) {
                        feedback.innerHTML = "<span>✓</span> Número válido";
                        feedback.classList.add("text-emerald-400");
                        hiddenInput.value = iti.getNumber();
                        return true;
                    } else {
                        feedback.innerHTML = "<span>⚠</span> Número incorrecto para este país";
                        feedback.classList.add("text-rose-400");
                        return false;
                    }
                }
                feedback.classList.add("hidden");
                return false;
            };

            input.addEventListener('blur', validate);

            form.addEventListener('submit', function(e) {
                if (!validate()) {
                    e.preventDefault();
                    input.focus();
                    input.classList.add('animate-pulse');
                    setTimeout(() => input.classList.remove('animate-pulse'), 500);
                } else {
                    hiddenInput.value = iti.getNumber();
                }
            });
        });
    </script>
@endsection
