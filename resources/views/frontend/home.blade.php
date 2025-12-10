@extends('layouts.frontend')

@section('title', 'Linea365 Clientes - Panel de Hosting')

@section('content')
    {{-- Hero principal --}}
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-16">
        <div class="grid md:grid-cols-2 gap-10 items-center">
            <div>
                <p class="inline-flex items-center gap-2 text-[11px] font-medium px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-300 border border-emerald-500/30 mb-4">
                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    Panel de clientes listo para producción
                </p>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-semibold text-slate-50 leading-tight">
                    Administra tus
                    <span class="text-emerald-400">servicios de hosting</span>
                    y dominios en un solo lugar.
                </h1>

                <p class="mt-4 text-sm sm:text-base text-slate-300/90 max-w-xl">
                    Linea365 Clientes es tu panel centralizado para gestionar planes de hosting,
                    dominios, facturas, tickets de soporte y todo lo relacionado con tus proyectos en línea.
                </p>

                <div class="mt-6 flex flex-col sm:flex-row gap-3">
                    <a href="{{ url('/register') }}"
                       class="btn-primary inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-sm font-semibold shadow-lg shadow-emerald-500/30">
                        Crear mi cuenta ahora
                    </a>
                    <a href="#planes"
                       class="btn-outline inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-sm">
                        Ver planes disponibles
                    </a>
                </div>

                <div class="mt-6 grid grid-cols-3 gap-3 text-[11px] text-slate-400">
                    <div>
                        <div class="text-sm font-semibold text-slate-100">Facturación clara</div>
                        <div>Historial de pagos, facturas y servicios en un clic.</div>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-slate-100">Gestión total</div>
                        <div>Dominios, DNS, correos y más desde un solo panel.</div>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-slate-100">Soporte rápido</div>
                        <div>Tickets centralizados y seguimiento en tiempo real.</div>
                    </div>
                </div>
            </div>

            <div>
                <div class="glass rounded-2xl p-4 sm:p-5 border border-emerald-500/20 relative overflow-hidden">
                    <div class="absolute -top-24 -right-24 h-48 w-48 bg-emerald-500/20 rounded-full blur-3xl"></div>

                    <div class="flex items-center justify-between mb-4">
                        <div class="text-xs text-slate-400">Resumen de cuenta</div>
                        <span class="px-2 py-0.5 rounded-full bg-emerald-500/15 text-[10px] text-emerald-300 border border-emerald-500/40">
                            Demo visual
                        </span>
                    </div>

                    <div class="grid grid-cols-3 gap-3 mb-4">
                        <div class="rounded-xl bg-slate-900/80 border border-slate-800 px-3 py-3">
                            <div class="text-[11px] text-slate-400 mb-1">Servicios activos</div>
                            <div class="text-lg font-semibold text-slate-50">5</div>
                            <div class="text-[10px] text-emerald-400 mt-1">+2 este mes</div>
                        </div>
                        <div class="rounded-xl bg-slate-900/80 border border-slate-800 px-3 py-3">
                            <div class="text-[11px] text-slate-400 mb-1">Dominios</div>
                            <div class="text-lg font-semibold text-slate-50">3</div>
                            <div class="text-[10px] text-slate-400 mt-1">1 por vencer</div>
                        </div>
                        <div class="rounded-xl bg-slate-900/80 border border-slate-800 px-3 py-3">
                            <div class="text-[11px] text-slate-400 mb-1">Facturas</div>
                            <div class="text-lg font-semibold text-slate-50">2</div>
                            <div class="text-[10px] text-rose-400 mt-1">1 pendiente</div>
                        </div>
                    </div>

                    <div class="rounded-xl bg-slate-900/80 border border-slate-800 p-3 text-xs mb-3">
                        <div class="flex items-center justify-between mb-2">
                            <div class="text-slate-300">Últimos tickets</div>
                            <a href="#" class="text-emerald-400 hover:text-emerald-300 text-[11px]">
                                Ver todo
                            </a>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center justify-between">
                                <div class="text-slate-300">Migración de sitio</div>
                                <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-500/15 text-emerald-300 border border-emerald-500/40">
                                    Resuelto
                                </span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="text-slate-300">Error 500 en WordPress</div>
                                <span class="text-[10px] px-2 py-0.5 rounded-full bg-yellow-500/15 text-yellow-300 border border-yellow-500/40">
                                    En progreso
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl bg-slate-900/80 border border-slate-800 p-3 text-[11px] text-slate-400">
                        <div class="flex items-center justify-between mb-2">
                            <div>Progreso de uso de recursos</div>
                        </div>

                        <div class="space-y-2">
                            <div>
                                <div class="flex justify-between mb-0.5">
                                    <span>Almacenamiento</span>
                                    <span class="text-slate-300">18 GB / 50 GB</span>
                                </div>
                                <div class="h-1.5 rounded-full bg-slate-800 overflow-hidden">
                                    <div class="h-full w-2/5 bg-emerald-500 rounded-full"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-0.5">
                                    <span>Ancho de banda</span>
                                    <span class="text-slate-300">120 GB / 500 GB</span>
                                </div>
                                <div class="h-1.5 rounded-full bg-slate-800 overflow-hidden">
                                    <div class="h-full w-1/4 bg-sky-400 rounded-full"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-0.5">
                                    <span>Cuentas de correo</span>
                                    <span class="text-slate-300">7 / 50</span>
                                </div>
                                <div class="h-1.5 rounded-full bg-slate-800 overflow-hidden">
                                    <div class="h-full w-1/6 bg-violet-400 rounded-full"></div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 text-[10px] text-slate-500">
                            * Los datos son ilustrativos. Luego conectamos esto a tu base real.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Sección de planes --}}
    <section id="planes" class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-6">
            <div>
                <h2 class="text-xl sm:text-2xl font-semibold text-slate-50">
                    Planes de hosting pensados para tu negocio
                </h2>
                <p class="text-sm text-slate-400 mt-1">
                    Más adelante estos planes podrán salir directamente de tu base de datos.
                </p>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-4">
            {{-- Plan básico --}}
            <div class="glass rounded-2xl p-4 flex flex-col border border-slate-800">
                <div class="text-xs font-semibold text-slate-300 mb-1">Start</div>
                <div class="text-2xl font-bold text-slate-50">$4.99 <span class="text-xs text-slate-400">/mes</span></div>
                <div class="text-xs text-slate-400 mt-1 mb-4">
                    Ideal para proyectos personales o landing pages.
                </div>
                <ul class="text-xs text-slate-300 space-y-1.5 mb-4">
                    <li>✅ 5 GB de almacenamiento SSD</li>
                    <li>✅ 1 dominio</li>
                    <li>✅ SSL gratuito</li>
                    <li>✅ Panel de control amigable</li>
                </ul>
                <a href="{{ url('/register') }}" class="mt-auto inline-flex justify-center items-center px-3 py-2 rounded-xl text-xs font-semibold btn-outline">
                    Empezar con este plan
                </a>
            </div>

            {{-- Plan recomendado --}}
            <div class="glass rounded-2xl p-4 flex flex-col border border-emerald-500/50 relative">
                <span class="absolute -top-2 right-3 text-[10px] px-2 py-0.5 rounded-full bg-emerald-500 text-slate-950 font-semibold">
                    Más elegido
                </span>
                <div class="text-xs font-semibold text-slate-300 mb-1">Business</div>
                <div class="text-2xl font-bold text-slate-50">$9.99 <span class="text-xs text-slate-400">/mes</span></div>
                <div class="text-xs text-slate-400 mt-1 mb-4">
                    Perfecto para negocios que quieren crecer en línea.
                </div>
                <ul class="text-xs text-slate-300 space-y-1.5 mb-4">
                    <li>✅ 30 GB de almacenamiento SSD</li>
                    <li>✅ Sitios web ilimitados</li>
                    <li>✅ Cuentas de correo ilimitadas</li>
                    <li>✅ Soporte prioritario</li>
                </ul>
                <a href="{{ url('/register') }}" class="mt-auto inline-flex justify-center items-center px-3 py-2 rounded-xl text-xs font-semibold btn-primary">
                    Elegir este plan
                </a>
            </div>

            {{-- Plan avanzado --}}
            <div class="glass rounded-2xl p-4 flex flex-col border border-slate-800">
                <div class="text-xs font-semibold text-slate-300 mb-1">Enterprise</div>
                <div class="text-2xl font-bold text-slate-50">$24.99 <span class="text-xs text-slate-400">/mes</span></div>
                <div class="text-xs text-slate-400 mt-1 mb-4">
                    Recursos dedicados y máxima estabilidad para proyectos grandes.
                </div>
                <ul class="text-xs text-slate-300 space-y-1.5 mb-4">
                    <li>✅ 100 GB de almacenamiento SSD</li>
                    <li>✅ Recursos ampliados</li>
                    <li>✅ IP dedicada</li>
                    <li>✅ Soporte 24/7</li>
                </ul>
                <a href="{{ url('/register') }}" class="mt-auto inline-flex justify-center items-center px-3 py-2 rounded-xl text-xs font-semibold btn-outline">
                    Hablar con un asesor
                </a>
            </div>
        </div>
    </section>

    {{-- Características --}}
    <section id="caracteristicas" class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10">
        <h2 class="text-xl sm:text-2xl font-semibold text-slate-50 mb-4">
            Todo lo que tus clientes necesitan, en un panel moderno
        </h2>

        <div class="grid md:grid-cols-3 gap-4 text-xs text-slate-300">
            <div class="glass rounded-2xl p-4 border border-slate-800">
                <div class="text-sm font-semibold text-slate-100 mb-1">Gestión de servicios</div>
                <p>Resumen de servicios activos, fechas de vencimiento, upgrades y renovaciones en un solo lugar.</p>
            </div>
            <div class="glass rounded-2xl p-4 border border-slate-800">
                <div class="text-sm font-semibold text-slate-100 mb-1">Facturación integrada</div>
                <p>Facturas generadas automáticamente, historial de pagos y métodos de pago configurables.</p>
            </div>
            <div class="glass rounded-2xl p-4 border border-slate-800">
                <div class="text-sm font-semibold text-slate-100 mb-1">Soporte centralizado</div>
                <p>Sistema de tickets para que tus clientes contacten soporte técnico y comercial.</p>
            </div>
        </div>
    </section>

    {{-- Soporte --}}
    <section id="soporte" class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-10">
        <div class="glass rounded-2xl p-5 border border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-semibold text-slate-50">
                    ¿Necesitas ayuda con tu panel de clientes?
                </h3>
                <p class="text-xs text-slate-400 mt-1 max-w-xl">
                    Más adelante aquí podemos conectar directamente con tu sistema de tickets o tu bot de soporte.
                    Por ahora puedes usar este espacio para explicar a tus clientes cómo contactar asistencia.
                </p>
            </div>
            <a href="#" class="btn-primary inline-flex items-center justify-center px-4 py-2.5 rounded-xl text-xs font-semibold">
                Contactar soporte
            </a>
        </div>
    </section>
@endsection
