@extends('layouts.frontend')

@section('title', 'Términos y Condiciones - Linea365')

@section('seo')
    <meta name="description" content="Términos y Condiciones de Linea365: uso del sitio, contratación de servicios, pagos, renovaciones, reembolsos, soporte, privacidad y limitación de responsabilidad.">
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
                <span class="text-xs font-medium text-slate-300">Documento legal</span>
            </div>

            <h1 class="text-4xl sm:text-5xl font-bold text-white tracking-tight mb-4 leading-tight">
                Términos y
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-cyan-400">Condiciones</span>
            </h1>

            <p class="text-lg text-slate-400 max-w-3xl mx-auto leading-relaxed">
                Estos términos regulan el uso del sitio y la contratación de servicios de Linea365.
                Si tienes dudas, contáctanos antes de comprar.
            </p>

            <div class="mt-8 flex flex-wrap items-center justify-center gap-3 text-xs text-slate-500">
                <span class="px-3 py-1 rounded-full border border-slate-800 bg-slate-900/30">
                    Última actualización: {{ date('d/m/Y') }}
                </span>
                <span class="px-3 py-1 rounded-full border border-slate-800 bg-slate-900/30">
                    Aplica a: Hosting, Dominios, VPS, Desarrollo Web
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
                        <a href="#aceptacion" class="px-4 py-3 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-slate-600 hover:bg-slate-800/40 transition text-slate-200">
                            1. Aceptación
                        </a>
                        <a href="#servicios" class="px-4 py-3 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-slate-600 hover:bg-slate-800/40 transition text-slate-200">
                            2. Servicios
                        </a>
                        <a href="#cuentas" class="px-4 py-3 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-slate-600 hover:bg-slate-800/40 transition text-slate-200">
                            3. Cuenta y uso
                        </a>
                        <a href="#pagos" class="px-4 py-3 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-slate-600 hover:bg-slate-800/40 transition text-slate-200">
                            4. Pagos y renovaciones
                        </a>
                        <a href="#reembolsos" class="px-4 py-3 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-slate-600 hover:bg-slate-800/40 transition text-slate-200">
                            5. Reembolsos
                        </a>
                        <a href="#soporte" class="px-4 py-3 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-slate-600 hover:bg-slate-800/40 transition text-slate-200">
                            6. Soporte y SLA
                        </a>
                        <a href="#contenido" class="px-4 py-3 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-slate-600 hover:bg-slate-800/40 transition text-slate-200">
                            7. Contenido del cliente
                        </a>
                        <a href="#prohibiciones" class="px-4 py-3 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-slate-600 hover:bg-slate-800/40 transition text-slate-200">
                            8. Usos prohibidos
                        </a>
                        <a href="#limitacion" class="px-4 py-3 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-slate-600 hover:bg-slate-800/40 transition text-slate-200">
                            9. Limitación de responsabilidad
                        </a>
                        <a href="#terminacion" class="px-4 py-3 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-slate-600 hover:bg-slate-800/40 transition text-slate-200">
                            10. Terminación
                        </a>
                        <a href="#legales" class="px-4 py-3 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-slate-600 hover:bg-slate-800/40 transition text-slate-200">
                            11. Ley aplicable
                        </a>
                        <a href="#contacto" class="px-4 py-3 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-slate-600 hover:bg-slate-800/40 transition text-slate-200">
                            12. Contacto
                        </a>
                    </div>
                </div>

                {{-- Texto --}}
                <div class="p-6 sm:p-10">
                    <div class="prose prose-invert max-w-none prose-p:text-slate-300 prose-li:text-slate-300 prose-strong:text-white prose-headings:text-white">
                        <h2 id="aceptacion">1. Aceptación de los términos</h2>
                        <p>
                            Al acceder y utilizar este sitio, crear una cuenta o contratar cualquier servicio ofrecido por Linea365,
                            aceptas estos Términos y Condiciones. Si no estás de acuerdo, por favor no uses el sitio ni contrates servicios.
                        </p>

                        <h2 id="servicios">2. Servicios ofrecidos</h2>
                        <p>
                            Linea365 ofrece, entre otros: Hosting, Dominios, Servidores VPS y Desarrollo de Páginas Web. Los alcances,
                            características, precios y tiempos pueden variar según el plan y se describen en las páginas de cada servicio.
                        </p>
                        <ul>
                            <li>Los servicios pueden requerir configuraciones adicionales según el proyecto.</li>
                            <li>Algunos servicios dependen de terceros (pasarelas de pago, registradores de dominios, etc.).</li>
                        </ul>

                        <h2 id="cuentas">3. Cuenta, credenciales y uso</h2>
                        <p>
                            Si creas una cuenta, eres responsable de mantener la confidencialidad de tus credenciales y de toda actividad
                            que ocurra en tu cuenta. Debes proporcionar información veraz y actualizada.
                        </p>

                        <h2 id="pagos">4. Pagos, facturación y renovaciones</h2>
                        <ul>
                            <li>Los pagos pueden ser mensuales, anuales o según el ciclo elegido al comprar.</li>
                            <li>Las renovaciones pueden requerir pago previo para evitar suspensión del servicio.</li>
                            <li>Los precios publicados pueden cambiar; los cambios aplican a nuevas compras o renovaciones futuras.</li>
                        </ul>

                        <h2 id="reembolsos">5. Reembolsos</h2>
                        <p>
                            Los reembolsos dependen del tipo de servicio y del caso específico. En general:
                        </p>
                        <ul>
                            <li><strong>Dominios:</strong> normalmente no son reembolsables una vez registrados por costos de registrador.</li>
                            <li><strong>Hosting/VPS:</strong> puede aplicar evaluación caso a caso si no se ha usado o si hay falla atribuible al servicio.</li>
                            <li><strong>Desarrollo Web:</strong> se trabaja por hitos/avances; los pagos por avances realizados no suelen ser reembolsables.</li>
                        </ul>
                        <p class="text-slate-400 text-sm">
                            *Si quieres una política exacta por producto, podemos dejarla detallada en una sección adicional o en cada página.
                        </p>

                        <h2 id="soporte">6. Soporte y tiempos de respuesta</h2>
                        <p>
                            El soporte se presta por los canales definidos por Linea365 (por ejemplo: tickets). Los tiempos de respuesta
                            pueden variar según la carga y el plan contratado.
                        </p>

                        <h2 id="contenido">7. Contenido aportado por el cliente</h2>
                        <p>
                            Si contratas desarrollo web, eres responsable del contenido que suministres (textos, imágenes, logos, marcas).
                            Debes contar con derechos de uso. Linea365 no se hace responsable por infracciones de propiedad intelectual
                            derivadas del contenido que el cliente entregue o solicite publicar.
                        </p>

                        <h2 id="prohibiciones">8. Usos prohibidos</h2>
                        <p>Queda prohibido usar los servicios para:</p>
                        <ul>
                            <li>Actividades ilegales o que infrinjan derechos de terceros.</li>
                            <li>Distribución de malware, phishing, spam o contenido malicioso.</li>
                            <li>Uso abusivo de recursos que afecte a otros usuarios (en servicios compartidos).</li>
                        </ul>

                        <h2 id="limitacion">9. Limitación de responsabilidad</h2>
                        <p>
                            Linea365 no será responsable por pérdidas indirectas, lucro cesante, daños consecuenciales o interrupciones
                            debidas a causas fuera de su control (por ejemplo: fallas de terceros, proveedores, fuerza mayor, etc.).
                        </p>

                        <h2 id="terminacion">10. Suspensión o terminación</h2>
                        <p>
                            Linea365 puede suspender o terminar servicios si se detecta incumplimiento de estos términos, falta de pago,
                            o uso indebido. En caso de suspensión por falta de pago, la reactivación puede requerir pago de saldos pendientes.
                        </p>

                        <h2 id="legales">11. Ley aplicable y jurisdicción</h2>
                        <p>
                            Estos términos se rigen por las leyes aplicables en la jurisdicción donde opere Linea365. Si deseas,
                            podemos especificar país/ciudad exacta (por ejemplo, Colombia) según tu razón social.
                        </p>

                        <h2 id="contacto">12. Contacto</h2>
                        <p>
                            Para dudas sobre estos términos, contáctanos por los canales oficiales publicados en la página de contacto.
                        </p>
                    </div>

                    {{-- CTA --}}
                    <div class="mt-10 glass rounded-2xl border border-slate-800 p-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div>
                                <div class="text-xs text-slate-500 uppercase tracking-widest mb-1">¿Necesitas ayuda?</div>
                                <div class="text-lg font-bold text-white">Te orientamos antes de comprar</div>
                                <p class="text-sm text-slate-400 mt-1">
                                    Si tienes dudas de planes, alcances o renovaciones, escríbenos y te guiamos.
                                </p>
                            </div>
                            <a href="{{ route('contacto') }}"
                               class="px-8 py-4 rounded-xl bg-emerald-500 text-slate-900 font-bold hover:bg-emerald-400 transition text-center">
                                Ir a Contacto
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
