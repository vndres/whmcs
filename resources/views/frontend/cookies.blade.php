@extends('layouts.frontend')

@section('title', 'Política de Cookies - Linea365')

@section('seo')
    <meta name="description" content="Política de Cookies de Linea365: qué son, para qué se usan, tipos de cookies, cómo desactivarlas y preferencias del usuario.">
    <link rel="canonical" href="{{ url()->current() }}">
@endsection

@section('content')

    {{-- HERO --}}
    <section class="relative pt-16 pb-14 sm:pt-24 sm:pb-16 overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-16 left-10 w-72 h-72 bg-emerald-500/12 rounded-full blur-[110px]"></div>
            <div class="absolute bottom-16 right-10 w-96 h-96 bg-blue-600/10 rounded-full blur-[120px]"></div>
        </div>

        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-800/50 border border-slate-700 backdrop-blur-sm mb-8">
                <span class="flex h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="text-xs font-medium text-slate-300">Preferencias y transparencia</span>
            </div>

            <h1 class="text-4xl sm:text-5xl font-bold text-white tracking-tight mb-4 leading-tight">
                Política de
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-cyan-400">Cookies</span>
            </h1>

            <p class="text-lg text-slate-400 max-w-3xl mx-auto leading-relaxed">
                Explicamos qué cookies usamos, para qué sirven y cómo puedes controlarlas.
            </p>

            <div class="mt-8 flex flex-wrap items-center justify-center gap-3 text-xs text-slate-500">
                <span class="px-3 py-1 rounded-full border border-slate-800 bg-slate-900/30">
                    Última actualización: {{ date('d/m/Y') }}
                </span>
                <span class="px-3 py-1 rounded-full border border-slate-800 bg-slate-900/30">
                    Aplica a: sitio público y área de cliente
                </span>
            </div>
        </div>
    </section>

    {{-- CONTENIDO --}}
    <section class="pb-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass rounded-3xl border border-slate-800 overflow-hidden">

                {{-- Índice --}}
                <div class="p-6 sm:p-8 border-b border-slate-800 bg-slate-950/40">
                    <h2 class="text-xl font-bold text-white mb-3">Índice</h2>
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-3 text-sm">
                        <a href="#que-son" class="px-4 py-3 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-slate-600 hover:bg-slate-800/40 transition text-slate-200">1. ¿Qué son?</a>
                        <a href="#para-que" class="px-4 py-3 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-slate-600 hover:bg-slate-800/40 transition text-slate-200">2. ¿Para qué se usan?</a>
                        <a href="#tipos" class="px-4 py-3 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-slate-600 hover:bg-slate-800/40 transition text-slate-200">3. Tipos de cookies</a>
                        <a href="#gestion" class="px-4 py-3 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-slate-600 hover:bg-slate-800/40 transition text-slate-200">4. Cómo gestionarlas</a>
                        <a href="#terceros" class="px-4 py-3 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-slate-600 hover:bg-slate-800/40 transition text-slate-200">5. Cookies de terceros</a>
                        <a href="#contacto" class="px-4 py-3 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-slate-600 hover:bg-slate-800/40 transition text-slate-200">6. Contacto</a>
                    </div>
                </div>

                <div class="p-6 sm:p-10">
                    <div class="prose prose-invert max-w-none prose-p:text-slate-300 prose-li:text-slate-300 prose-strong:text-white prose-headings:text-white">
                        <h2 id="que-son">1. ¿Qué son las cookies?</h2>
                        <p>
                            Las cookies son pequeños archivos de texto que se almacenan en tu navegador cuando visitas un sitio web.
                            Sirven para recordar información (por ejemplo, mantener tu sesión iniciada o guardar preferencias).
                        </p>

                        <h2 id="para-que">2. ¿Para qué se usan?</h2>
                        <p>En Linea365 las cookies pueden usarse para:</p>
                        <ul>
                            <li><strong>Autenticación:</strong> mantener tu sesión en el área de cliente.</li>
                            <li><strong>Seguridad:</strong> prevenir abuso, fraude o accesos no autorizados.</li>
                            <li><strong>Preferencias:</strong> recordar configuraciones básicas (cuando aplique).</li>
                            <li><strong>Analítica:</strong> medir rendimiento y mejorar la experiencia (cuando se habilite).</li>
                        </ul>

                        <h2 id="tipos">3. Tipos de cookies</h2>
                        <div class="not-prose grid lg:grid-cols-3 gap-6 mt-6">
                            <div class="rounded-2xl border border-slate-800 bg-slate-900/30 p-6">
                                <div class="text-2xl mb-3">🔐</div>
                                <div class="text-white font-bold mb-2">Esenciales</div>
                                <p class="text-sm text-slate-400">
                                    Necesarias para que el sitio funcione (inicio de sesión, seguridad, formularios).
                                </p>
                            </div>
                            <div class="rounded-2xl border border-slate-800 bg-slate-900/30 p-6">
                                <div class="text-2xl mb-3">⚙️</div>
                                <div class="text-white font-bold mb-2">Funcionales</div>
                                <p class="text-sm text-slate-400">
                                    Guardan preferencias para mejorar tu experiencia (según funciones habilitadas).
                                </p>
                            </div>
                            <div class="rounded-2xl border border-slate-800 bg-slate-900/30 p-6">
                                <div class="text-2xl mb-3">📈</div>
                                <div class="text-white font-bold mb-2">Analítica</div>
                                <p class="text-sm text-slate-400">
                                    Nos ayudan a entender uso y mejorar rendimiento. Se usan solo si están activadas.
                                </p>
                            </div>
                        </div>

                        <h2 id="gestion" class="mt-10">4. Cómo gestionar o desactivar cookies</h2>
                        <p>
                            Puedes permitir, bloquear o eliminar cookies desde la configuración de tu navegador.
                            Si desactivas cookies esenciales, algunas partes del sitio pueden no funcionar correctamente
                            (por ejemplo, el área de cliente).
                        </p>

                        <div class="not-prose mt-6 rounded-2xl border border-slate-800 bg-slate-900/30 p-6">
                            <div class="text-xs text-slate-500 uppercase tracking-widest mb-2">Tip</div>
                            <div class="text-white font-bold mb-1">¿Quieres un banner de cookies?</div>
                            <p class="text-sm text-slate-400">
                                Si deseas, te integro un banner simple (Aceptar / Rechazar / Configurar) para cumplir mejor con prácticas de consentimiento.
                            </p>
                        </div>

                        <h2 id="terceros" class="mt-10">5. Cookies de terceros</h2>
                        <p>
                            Algunas integraciones pueden establecer cookies (por ejemplo, analítica o marketing) si las habilitas.
                            En ese caso, dichas cookies se rigen por las políticas del proveedor tercero correspondiente.
                        </p>

                        <h2 id="contacto" class="mt-10">6. Contacto</h2>
                        <p>
                            Si tienes dudas sobre esta política, puedes escribirnos desde la página de contacto.
                        </p>

                        <p>
                            <a href="{{ route('contacto') }}" class="text-emerald-400 font-semibold hover:text-emerald-300">
                                Ir a Contacto →
                            </a>
                        </p>

                        <div class="not-prose mt-10 grid md:grid-cols-2 gap-4">
                            <a href="{{ route('privacidad') }}"
                               class="block px-6 py-4 rounded-2xl border border-slate-800 bg-slate-900/30 hover:bg-slate-800/40 hover:border-slate-600 transition">
                                <div class="text-xs text-slate-500 mb-1">Siguiente</div>
                                <div class="text-white font-bold">Política de Privacidad</div>
                                <div class="text-sm text-slate-400">Datos personales, derechos y retención</div>
                            </a>

                            <a href="{{ route('terminos') }}"
                               class="block px-6 py-4 rounded-2xl border border-slate-800 bg-slate-900/30 hover:bg-slate-800/40 hover:border-slate-600 transition">
                                <div class="text-xs text-slate-500 mb-1">Siguiente</div>
                                <div class="text-white font-bold">Términos y Condiciones</div>
                                <div class="text-sm text-slate-400">Reglas de uso y contratación</div>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <style>
        .glass { background: rgba(15, 23, 42, 0.35); backdrop-filter: blur(10px); }
        html { scroll-behavior: smooth; }
    </style>

@endsection
