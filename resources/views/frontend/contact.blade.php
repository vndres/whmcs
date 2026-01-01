@extends('layouts.frontend')

@section('title', 'Contacto - Linea365 | Asesoría y Cotización Rápida')

@section('seo')
    <meta name="description" content="Contacta a Linea365 para cotizar hosting, dominios, VPS y desarrollo web. Respuesta rápida por WhatsApp. Atención profesional.">
    <link rel="canonical" href="{{ url()->current() }}">
@endsection

@section('content')

    {{-- HERO --}}
    <section class="relative pt-16 pb-14 sm:pt-24 sm:pb-18 overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-16 left-10 w-72 h-72 bg-emerald-500/10 rounded-full blur-[110px]"></div>
            <div class="absolute bottom-16 right-10 w-96 h-96 bg-blue-600/10 rounded-full blur-[120px]"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-800/50 border border-slate-700 backdrop-blur-sm mb-6">
                    <span class="flex h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-xs font-medium text-slate-300">Respuesta rápida • Asesoría clara</span>
                </div>

                <h1 class="text-4xl sm:text-5xl font-bold text-white tracking-tight leading-tight">
                    Hablemos de tu
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-cyan-400">proyecto</span>
                </h1>

                <p class="mt-5 text-lg text-slate-400 leading-relaxed">
                    Cuéntanos qué necesitas y te recomendamos la mejor opción.
                    Hosting, dominios, VPS o desarrollo web. Sin enredos.
                </p>

                <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
                    <button type="button"
                            onclick="openWhatsAppGeneral('Quiero una asesoría / cotización')"
                            class="px-8 py-4 rounded-xl bg-emerald-500 text-slate-900 font-bold hover:bg-emerald-400 transition">
                        Hablar por WhatsApp
                    </button>
                    <a href="#formulario"
                       class="px-8 py-4 rounded-xl bg-slate-800 text-white hover:bg-slate-700 transition">
                        Enviar formulario
                    </a>
                </div>

                <div class="pt-10 border-t border-slate-800/50 mt-10">
                    <p class="text-xs text-slate-500 uppercase tracking-widest mb-4">Áreas</p>
                    <div class="flex flex-wrap justify-center gap-6 grayscale opacity-60">
                        <span class="text-lg font-bold text-slate-400">Hosting</span>
                        <span class="text-lg font-bold text-slate-400">Dominios</span>
                        <span class="text-lg font-bold text-slate-400">VPS</span>
                        <span class="text-lg font-bold text-slate-400">Desarrollo Web</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- MÉTODOS DE CONTACTO --}}
    <section class="py-16 bg-slate-900/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-6">
                <div class="glass p-6 rounded-2xl border border-slate-800">
                    <div class="text-2xl mb-3">📲</div>
                    <h3 class="text-white font-bold mb-2">WhatsApp</h3>
                    <p class="text-sm text-slate-400">La vía más rápida. Te respondemos y te guiamos para elegir bien.</p>
                    <button type="button"
                            onclick="openWhatsAppGeneral('Hola, quiero información')"
                            class="mt-4 w-full py-3 px-4 rounded-xl text-sm font-bold bg-emerald-500 text-slate-900 hover:bg-emerald-400 transition">
                        Escribir por WhatsApp
                    </button>
                </div>

                <div class="glass p-6 rounded-2xl border border-slate-800">
                    <div class="text-2xl mb-3">✉️</div>
                    <h3 class="text-white font-bold mb-2">Correo</h3>
                    <p class="text-sm text-slate-400">Para solicitudes formales o requerimientos técnicos detallados.</p>

                    {{-- Cambia este correo por el tuyo real --}}
                    <a href="mailto:soporte@linea365apps.com"
                       class="mt-4 inline-flex w-full items-center justify-center py-3 px-4 rounded-xl text-sm font-bold bg-slate-800 text-white hover:bg-slate-700 transition">
                        soporte@linea365apps.com
                    </a>
                </div>

                <div class="glass p-6 rounded-2xl border border-slate-800">
                    <div class="text-2xl mb-3">🕒</div>
                    <h3 class="text-white font-bold mb-2">Horario</h3>
                    <p class="text-sm text-slate-400">Atención y seguimiento. Si escribes fuera de horario, igual te respondemos.</p>
                    <div class="mt-4 rounded-xl border border-slate-800 bg-slate-900/30 p-4 text-sm text-slate-300">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400">Lunes - Sábado</span>
                            <span class="font-semibold text-slate-200">9:00am - 8:00pm</span>
                        </div>
                        <div class="mt-2 flex items-center justify-between">
                            <span class="text-slate-400">Domingos</span>
                            <span class="font-semibold text-slate-200">Soporte limitado</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- MINI GARANTÍAS --}}
            <div class="mt-10 grid lg:grid-cols-4 gap-6">
                <div class="glass p-6 rounded-2xl border border-slate-800">
                    <div class="text-2xl mb-3">⚡</div>
                    <h4 class="text-white font-bold mb-2">Respuesta clara</h4>
                    <p class="text-sm text-slate-400">Te decimos lo que sí necesitas y lo que no.</p>
                </div>
                <div class="glass p-6 rounded-2xl border border-slate-800">
                    <div class="text-2xl mb-3">🧩</div>
                    <h4 class="text-white font-bold mb-2">Solución completa</h4>
                    <p class="text-sm text-slate-400">Dominio + hosting + web + publicación (si lo pides).</p>
                </div>
                <div class="glass p-6 rounded-2xl border border-slate-800">
                    <div class="text-2xl mb-3">🛡️</div>
                    <h4 class="text-white font-bold mb-2">Buenas prácticas</h4>
                    <p class="text-sm text-slate-400">Seguridad base, SSL y rendimiento real.</p>
                </div>
                <div class="glass p-6 rounded-2xl border border-slate-800">
                    <div class="text-2xl mb-3">🤝</div>
                    <h4 class="text-white font-bold mb-2">Acompañamiento</h4>
                    <p class="text-sm text-slate-400">No te dejamos tirado al entregar. Te guiamos.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- FORMULARIO --}}
    <section id="formulario" class="py-20 relative overflow-hidden">
        <div class="absolute top-1/2 left-0 w-full h-px bg-gradient-to-r from-transparent via-slate-800 to-transparent"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-8 items-start">

                <div class="glass rounded-2xl border border-slate-800 p-7">
                    <h2 class="text-2xl font-bold text-white">Envíanos tu solicitud</h2>
                    <p class="text-slate-400 mt-2 text-sm">
                        Este formulario queda listo para conectar a una ruta (POST) cuando quieras.
                        Por ahora también puedes enviarlo directo a WhatsApp.
                    </p>

                    <form onsubmit="sendContactToWhatsApp(event)" class="mt-6 space-y-4">
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs text-slate-500 mb-2">Nombre</label>
                                <input id="c_name" type="text" required
                                       class="w-full px-4 py-3 rounded-xl bg-slate-900/40 border border-slate-700 text-slate-100 focus:outline-none focus:ring-0"
                                       placeholder="Tu nombre" />
                            </div>
                            <div>
                                <label class="block text-xs text-slate-500 mb-2">WhatsApp</label>
                                <input id="c_whatsapp" type="text" required
                                       class="w-full px-4 py-3 rounded-xl bg-slate-900/40 border border-slate-700 text-slate-100 focus:outline-none focus:ring-0"
                                       placeholder="Ej: 3001234567" />
                            </div>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs text-slate-500 mb-2">Correo</label>
                                <input id="c_email" type="email"
                                       class="w-full px-4 py-3 rounded-xl bg-slate-900/40 border border-slate-700 text-slate-100 focus:outline-none focus:ring-0"
                                       placeholder="tucorreo@correo.com" />
                            </div>
                            <div>
                                <label class="block text-xs text-slate-500 mb-2">Tema</label>
                                <select id="c_topic"
                                        class="w-full px-4 py-3 rounded-xl bg-slate-900/40 border border-slate-700 text-slate-100 focus:outline-none focus:ring-0">
                                    <option value="Hosting">Hosting</option>
                                    <option value="Dominios">Dominios</option>
                                    <option value="VPS">VPS</option>
                                    <option value="Desarrollo Web">Desarrollo Web</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs text-slate-500 mb-2">Mensaje</label>
                            <textarea id="c_message" rows="5" required
                                      class="w-full px-4 py-3 rounded-xl bg-slate-900/40 border border-slate-700 text-slate-100 focus:outline-none focus:ring-0"
                                      placeholder="Cuéntanos qué necesitas, objetivo, referencia, etc."></textarea>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3 pt-2">
                            <button type="submit"
                                    class="flex-1 py-3 px-4 rounded-xl text-sm font-bold bg-emerald-500 text-slate-900 hover:bg-emerald-400 transition">
                                Enviar a WhatsApp
                            </button>

                            <button type="button"
                                    onclick="openWhatsAppGeneral('Quiero asesoría y cotización')"
                                    class="flex-1 py-3 px-4 rounded-xl text-sm font-bold bg-slate-800 text-white hover:bg-slate-700 transition">
                                Solo WhatsApp
                            </button>
                        </div>

                        <p class="text-[11px] text-slate-500">
                            *Para conectar el formulario a backend luego, creamos una ruta POST y guardamos en BD o enviamos correo.
                        </p>
                    </form>
                </div>

                {{-- LADO DERECHO: INFORMACIÓN --}}
                <div class="space-y-6">
                    <div class="glass rounded-2xl border border-slate-800 p-7">
                        <h3 class="text-white font-bold text-lg">¿Qué información acelera la cotización?</h3>
                        <div class="mt-4 space-y-2 text-sm text-slate-300">
                            <div class="flex gap-2"><span class="text-emerald-400 font-bold">✓</span> Tipo de servicio (hosting, web, VPS)</div>
                            <div class="flex gap-2"><span class="text-emerald-400 font-bold">✓</span> Referencias (web ejemplo / estilo)</div>
                            <div class="flex gap-2"><span class="text-emerald-400 font-bold">✓</span> Urgencia / fecha objetivo</div>
                            <div class="flex gap-2"><span class="text-emerald-400 font-bold">✓</span> Si ya tienes dominio/hosting o no</div>
                        </div>
                    </div>

                    <div class="glass rounded-2xl border border-slate-800 p-7">
                        <h3 class="text-white font-bold text-lg">¿Necesitas soporte técnico?</h3>
                        <p class="text-sm text-slate-400 mt-2">
                            Si ya eres cliente, lo ideal es crear un ticket desde tu panel para seguimiento.
                        </p>
                        <div class="mt-4 flex gap-3">
                            @auth
                                <a href="{{ route('tickets.index') }}"
                                   class="flex-1 text-center py-3 px-4 rounded-xl text-sm font-bold bg-slate-800 text-white hover:bg-slate-700 transition">
                                    Ir a Tickets
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                   class="flex-1 text-center py-3 px-4 rounded-xl text-sm font-bold bg-slate-800 text-white hover:bg-slate-700 transition">
                                    Ingresar
                                </a>
                            @endauth

                            <button type="button"
                                    onclick="openWhatsAppGeneral('Tengo una consulta técnica')"
                                    class="flex-1 py-3 px-4 rounded-xl text-sm font-bold bg-emerald-500 text-slate-900 hover:bg-emerald-400 transition">
                                WhatsApp
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- CTA FINAL --}}
    <section class="pb-20">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass rounded-3xl p-8 sm:p-12 border border-slate-800 text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-[80px] pointer-events-none"></div>

                <h2 class="text-2xl sm:text-3xl font-bold text-white mb-3 relative z-10">
                    ¿Listo para empezar?
                </h2>
                <p class="text-slate-400 mb-8 max-w-2xl mx-auto relative z-10">
                    Te ayudamos a elegir el plan ideal y te guiamos paso a paso.
                </p>

                <div class="flex flex-col sm:flex-row justify-center gap-4 relative z-10">
                    <a href="{{ route('home') }}"
                       class="px-8 py-4 rounded-xl bg-slate-800 text-white hover:bg-slate-700 transition">
                        Volver al inicio
                    </a>
                    <button type="button"
                            onclick="openWhatsAppGeneral('Quiero cotizar y comenzar hoy')"
                            class="px-8 py-4 rounded-xl bg-emerald-500 text-slate-900 font-bold hover:bg-emerald-400 transition">
                        Hablar por WhatsApp
                    </button>
                </div>

                <p class="mt-6 text-[11px] text-slate-500">
                    Respuesta rápida • Asesoría clara • Entrega profesional
                </p>
            </div>
        </div>
    </section>

    {{-- SCRIPTS --}}
    <script>
        // Cambia esto por tu número real en formato internacional sin + (ej: 573001234567)
        const WHATSAPP_NUMBER = '573009075093';

        function openWhatsAppGeneral(topic){
            const text = `Hola Linea365, ${topic}. ¿Me ayudas?`;
            window.open(`https://wa.me/${WHATSAPP_NUMBER}?text=${encodeURIComponent(text)}`, '_blank');
        }

        function sendContactToWhatsApp(e){
            e.preventDefault();

            const name = (document.getElementById('c_name')?.value || '').trim();
            const wa = (document.getElementById('c_whatsapp')?.value || '').trim();
            const email = (document.getElementById('c_email')?.value || '').trim();
            const topic = (document.getElementById('c_topic')?.value || '').trim();
            const msg = (document.getElementById('c_message')?.value || '').trim();

            const text =
`Hola Linea365 👋
Soy: ${name}
Mi WhatsApp: ${wa}
Correo: ${email || 'No indicado'}
Tema: ${topic}

Mensaje:
${msg}`;

            window.open(`https://wa.me/${WHATSAPP_NUMBER}?text=${encodeURIComponent(text)}`, '_blank');
        }
    </script>

    <style>
        .glass {
            background: rgba(15, 23, 42, 0.35);
            backdrop-filter: blur(10px);
        }
    </style>

@endsection
