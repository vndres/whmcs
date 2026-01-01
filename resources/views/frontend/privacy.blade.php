@extends('layouts.frontend')

@section('title', 'Política de Privacidad - Linea365')

@section('seo')
    <meta name="description" content="Política de Privacidad de Linea365: datos que recopilamos, cómo los usamos, cookies, seguridad, derechos del usuario y contacto.">
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
                Política de
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-cyan-400">Privacidad</span>
            </h1>

            <p class="text-lg text-slate-400 max-w-3xl mx-auto leading-relaxed">
                Tu información es importante. Aquí explicamos qué datos recopilamos, por qué lo hacemos
                y cómo los protegemos.
            </p>

            <div class="mt-8 flex flex-wrap items-center justify-center gap-3 text-xs text-slate-500">
                <span class="px-3 py-1 rounded-full border border-slate-800 bg-slate-900/30">
                    Última actualización: {{ date('d/m/Y') }}
                </span>
                <span class="px-3 py-1 rounded-full border border-slate-800 bg-slate-900/30">
                    Aplica a: Sitio web, Área de Cliente y servicios Linea365
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
                        <a href="#responsable" class="px-4 py-3 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-slate-600 hover:bg-slate-800/40 transition text-slate-200">1. Responsable</a>
                        <a href="#datos" class="px-4 py-3 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-slate-600 hover:bg-slate-800/40 transition text-slate-200">2. Datos que recopilamos</a>
                        <a href="#uso" class="px-4 py-3 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-slate-600 hover:bg-slate-800/40 transition text-slate-200">3. Cómo usamos tus datos</a>
                        <a href="#base" class="px-4 py-3 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-slate-600 hover:bg-slate-800/40 transition text-slate-200">4. Base legal</a>
                        <a href="#compartimos" class="px-4 py-3 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-slate-600 hover:bg-slate-800/40 transition text-slate-200">5. Con quién compartimos</a>
                        <a href="#cookies" class="px-4 py-3 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-slate-600 hover:bg-slate-800/40 transition text-slate-200">6. Cookies</a>
                        <a href="#seguridad" class="px-4 py-3 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-slate-600 hover:bg-slate-800/40 transition text-slate-200">7. Seguridad</a>
                        <a href="#derechos" class="px-4 py-3 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-slate-600 hover:bg-slate-800/40 transition text-slate-200">8. Derechos del usuario</a>
                        <a href="#retencion" class="px-4 py-3 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-slate-600 hover:bg-slate-800/40 transition text-slate-200">9. Retención</a>
                        <a href="#cambios" class="px-4 py-3 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-slate-600 hover:bg-slate-800/40 transition text-slate-200">10. Cambios</a>
                        <a href="#contacto" class="px-4 py-3 rounded-xl bg-slate-900/40 border border-slate-800 hover:border-slate-600 hover:bg-slate-800/40 transition text-slate-200">11. Contacto</a>
                    </div>
                </div>

                {{-- Texto --}}
                <div class="p-6 sm:p-10">
                    <div class="prose prose-invert max-w-none prose-p:text-slate-300 prose-li:text-slate-300 prose-strong:text-white prose-headings:text-white">
                        <h2 id="responsable">1. Responsable del tratamiento</h2>
                        <p>
                            Linea365 (en adelante, “Linea365”) actúa como responsable del tratamiento de los datos personales
                            recopilados a través de este sitio web, el área de cliente y los canales asociados.
                        </p>
                        <p class="text-slate-400 text-sm">
                            Linea 365 SAS. Nit: 901484906
                        </p>

                        <h2 id="datos">2. Datos personales que recopilamos</h2>
                        <p>Podemos recopilar los siguientes datos, según el servicio:</p>
                        <ul>
                            <li><strong>Identificación y contacto:</strong> nombre, correo, teléfono/WhatsApp.</li>
                            <li><strong>Cuenta:</strong> credenciales, actividad de inicio de sesión (seguridad).</li>
                            <li><strong>Facturación:</strong> información de pago, facturas, historial de transacciones.</li>
                            <li><strong>Servicios:</strong> dominio, IP, configuraciones del hosting/VPS, tickets de soporte.</li>
                            <li><strong>Analítica:</strong> datos de navegación, dispositivo, páginas visitadas (cuando aplica).</li>
                        </ul>

                        <h2 id="uso">3. Cómo usamos tus datos</h2>
                        <p>Usamos tus datos para:</p>
                        <ul>
                            <li>Crear y administrar tu cuenta.</li>
                            <li>Procesar compras, pagos, renovaciones y facturación.</li>
                            <li>Prestar soporte técnico y atención al cliente (tickets).</li>
                            <li>Enviar notificaciones operativas (por ejemplo, vencimientos, alertas de seguridad).</li>
                            <li>Mejorar el rendimiento del sitio y la experiencia del usuario.</li>
                            <li>Cumplir obligaciones legales y prevenir fraude.</li>
                        </ul>

                        <h2 id="base">4. Base legal del tratamiento</h2>
                        <p>Tratamos tus datos con base en:</p>
                        <ul>
                            <li><strong>Ejecución de contrato:</strong> para prestarte el servicio.</li>
                            <li><strong>Consentimiento:</strong> cuando lo otorgas (por ejemplo, comunicaciones opcionales).</li>
                            <li><strong>Interés legítimo:</strong> seguridad, prevención de abuso y mejora del servicio.</li>
                            <li><strong>Obligación legal:</strong> facturación, contabilidad y requerimientos regulatorios.</li>
                        </ul>

                        <h2 id="compartimos">5. Con quién compartimos tus datos</h2>
                        <p>
                            Podemos compartir información estrictamente necesaria con proveedores para operar los servicios, por ejemplo:
                        </p>
                        <ul>
                            <li><strong>Procesadores de pago</strong> (para validar y procesar transacciones).</li>
                            <li><strong>Registradores de dominios</strong> (para registro/renovación de dominios).</li>
                            <li><strong>Infraestructura</strong> (datacenters/proveedores de hosting/VPS, DNS, correo).</li>
                            <li><strong>Herramientas de analítica</strong> (cuando se usan para medición).</li>
                        </ul>
                        <p>
                            No vendemos tus datos personales. Solo se comparten cuando es necesario para prestarte el servicio
                            o por obligación legal.
                        </p>

                        <h2 id="cookies">6. Cookies</h2>
                        <p>
                            Podemos utilizar cookies y tecnologías similares para autenticación, preferencias, seguridad y analítica.
                            Puedes controlar cookies desde tu navegador. Para detalles, revisa nuestra política de cookies.
                        </p>
                        <p>
                            <a href="{{ route('cookies') }}" class="text-emerald-400 font-semibold hover:text-emerald-300">
                                Ver Política de Cookies →
                            </a>
                        </p>

                        <h2 id="seguridad">7. Seguridad</h2>
                        <p>
                            Implementamos medidas técnicas y organizacionales para proteger tus datos (por ejemplo: cifrado en tránsito,
                            control de acceso y monitoreo). Aun así, ningún sistema es 100% infalible, por lo que te recomendamos
                            usar contraseñas seguras y no compartir tus credenciales.
                        </p>

                        <h2 id="derechos">8. Derechos del usuario</h2>
                        <p>Puedes solicitar:</p>
                        <ul>
                            <li>Acceso a tus datos.</li>
                            <li>Corrección/actualización.</li>
                            <li>Eliminación (cuando aplique).</li>
                            <li>Revocar consentimiento (cuando aplique).</li>
                            <li>Oposición o limitación del tratamiento en ciertos casos.</li>
                        </ul>
                        <p>
                            Para ejercer tus derechos, contáctanos con el asunto “Privacidad” y te responderemos en un plazo razonable.
                        </p>

                        <h2 id="retencion">9. Retención de datos</h2>
                        <p>
                            Conservamos tus datos mientras tengas una cuenta activa o sea necesario para prestarte el servicio, y
                            posteriormente por el tiempo requerido por obligaciones legales (por ejemplo, facturación/contabilidad),
                            o para resolver disputas y hacer cumplir acuerdos.
                        </p>

                        <h2 id="cambios">10. Cambios a esta política</h2>
                        <p>
                            Podemos actualizar esta política cuando sea necesario. Publicaremos cambios en esta página con fecha
                            de actualización.
                        </p>

                        <h2 id="contacto">11. Contacto</h2>
                        <p>
                            Para dudas o solicitudes relacionadas con privacidad, contáctanos desde nuestra página de contacto.
                        </p>
                    </div>

                    {{-- CTA --}}
                    <div class="mt-10 glass rounded-2xl border border-slate-800 p-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div>
                                <div class="text-xs text-slate-500 uppercase tracking-widest mb-1">Privacidad</div>
                                <div class="text-lg font-bold text-white">¿Quieres que personalicemos esta política?</div>
                                <p class="text-sm text-slate-400 mt-1">
                                    Si tienes razón social, NIT y datos legales, lo dejamos perfecto para Colombia.
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
