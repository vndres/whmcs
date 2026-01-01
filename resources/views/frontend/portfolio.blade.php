@extends('layouts.frontend')

@section('title', 'Portafolio - Linea365 | Proyectos y Ejemplos')

@section('seo')
    <meta name="description" content="Portafolio Linea365: ejemplos de landing pages, webs corporativas y tiendas online. Diseño moderno, responsive, rápido y optimizado para convertir.">
    <link rel="canonical" href="{{ url()->current() }}">
@endsection

@section('content')

    {{-- HERO --}}
    <section class="relative pt-16 pb-16 sm:pt-24 sm:pb-20 overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-16 left-10 w-72 h-72 bg-emerald-500/12 rounded-full blur-[110px]"></div>
            <div class="absolute bottom-16 right-10 w-96 h-96 bg-blue-600/10 rounded-full blur-[120px]"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-800/50 border border-slate-700 backdrop-blur-sm mb-8">
                <span class="flex h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="text-xs font-medium text-slate-300">Ejemplos tipo premium</span>
            </div>

            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white tracking-tight mb-5 leading-tight">
                Portafolio que
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-cyan-400">vende y se ve pro</span>
            </h1>

            <p class="text-lg text-slate-400 max-w-3xl mx-auto leading-relaxed">
                Aquí tienes ejemplos de lo que construimos: <span class="text-slate-200 font-semibold">Landing Pages</span>,
                <span class="text-slate-200 font-semibold">Webs Corporativas</span> y <span class="text-slate-200 font-semibold">Tiendas Online</span>.
                Plantillas con diseño moderno, velocidad y estructura lista para convertir.
            </p>

            <div class="mt-10 flex flex-col sm:flex-row gap-3 justify-center">
                <a href="#proyectos" class="px-8 py-4 rounded-xl bg-emerald-500 text-slate-900 font-bold hover:bg-emerald-400 transition">
                    Ver proyectos
                </a>
                <button type="button"
                        onclick="openWhatsAppGeneral('Quiero una web como las del portafolio')"
                        class="px-8 py-4 rounded-xl bg-slate-800 text-white hover:bg-slate-700 transition">
                    Cotizar por WhatsApp
                </button>
            </div>

            <div class="pt-10 border-t border-slate-800/50 mt-10">
                <p class="text-xs text-slate-500 uppercase tracking-widest mb-4">En todos cuidamos</p>
                <div class="flex flex-wrap justify-center gap-6 grayscale opacity-60">
                    <span class="text-lg font-bold text-slate-400">UI/UX</span>
                    <span class="text-lg font-bold text-slate-400">Mobile</span>
                    <span class="text-lg font-bold text-slate-400">SEO Base</span>
                    <span class="text-lg font-bold text-slate-400">Velocidad</span>
                    <span class="text-lg font-bold text-slate-400">WhatsApp</span>
                </div>
            </div>
        </div>
    </section>

    {{-- FILTROS + PROYECTOS --}}
    <section id="proyectos" class="py-20 bg-slate-900/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-10">
                <div class="max-w-2xl">
                    <h2 class="text-3xl font-bold text-white mb-3">Proyectos por categoría</h2>
                    <p class="text-slate-400">
                        Puedes usar estos ejemplos como referencia. Si tienes un diseño de inspiración, lo adaptamos a tu marca
                        (sin copiar contenido protegido).
                    </p>
                </div>

                <div class="glass rounded-2xl border border-slate-800 p-3 flex flex-wrap gap-2">
                    <button class="filterBtn px-4 py-2 rounded-xl text-sm font-bold bg-emerald-500 text-slate-900 hover:bg-emerald-400 transition"
                            data-filter="all">
                        Todo
                    </button>
                    <button class="filterBtn px-4 py-2 rounded-xl text-sm font-bold bg-slate-800 text-white hover:bg-slate-700 transition"
                            data-filter="landing">
                        Landing
                    </button>
                    <button class="filterBtn px-4 py-2 rounded-xl text-sm font-bold bg-slate-800 text-white hover:bg-slate-700 transition"
                            data-filter="corporativa">
                        Corporativa
                    </button>
                    <button class="filterBtn px-4 py-2 rounded-xl text-sm font-bold bg-slate-800 text-white hover:bg-slate-700 transition"
                            data-filter="ecommerce">
                        E-commerce
                    </button>
                </div>
            </div>

            @php
                // “Mock” de portafolio: después lo conectamos a BD si quieres
                $projects = [
                    ['type' => 'landing', 'title' => 'Landing Servicios a Domicilio', 'desc' => 'Héroe potente + beneficios + testimonios + FAQ + CTA fijo a WhatsApp.', 'stack' => 'WordPress / Elementor', 'goal' => 'Generar leads', 'badge' => 'Landing'],
                    ['type' => 'landing', 'title' => 'Landing Inmobiliaria', 'desc' => 'Propiedades destacadas + formulario rápido + agendamiento y mapa.', 'stack' => 'WordPress', 'goal' => 'Captar contactos', 'badge' => 'Landing'],
                    ['type' => 'corporativa', 'title' => 'Web Corporativa Empresa', 'desc' => 'Inicio, servicios, nosotros, blog/FAQ, contacto con formularios y WhatsApp.', 'stack' => 'WordPress / CMS', 'goal' => 'Confianza + ventas', 'badge' => 'Corporativa'],
                    ['type' => 'corporativa', 'title' => 'Clínica / Consultorio', 'desc' => 'Especialidades, doctores, reseñas, formulario y botón de reserva.', 'stack' => 'WordPress', 'goal' => 'Reservas', 'badge' => 'Corporativa'],
                    ['type' => 'ecommerce', 'title' => 'Tienda Online Moda', 'desc' => 'Tallas/colores, stock, cupones, checkout optimizado y pagos.', 'stack' => 'WooCommerce', 'goal' => 'Ventas 24/7', 'badge' => 'E-commerce'],
                    ['type' => 'ecommerce', 'title' => 'E-commerce Accesorios', 'desc' => 'Catálogo, filtros, variaciones, envíos y WhatsApp post-compra.', 'stack' => 'WooCommerce', 'goal' => 'Aumentar ticket', 'badge' => 'E-commerce'],
                    ['type' => 'corporativa', 'title' => 'Servicios B2B (Agencia)', 'desc' => 'Secciones de servicio, casos de éxito, lead magnet y CTA a reunión.', 'stack' => 'Laravel / Blade', 'goal' => 'Prospección', 'badge' => 'Corporativa'],
                    ['type' => 'landing', 'title' => 'Landing Curso / Lanzamiento', 'desc' => 'Sección de módulos, bonos, testimonios, countdown y CTA a pago o WhatsApp.', 'stack' => 'WordPress', 'goal' => 'Conversión', 'badge' => 'Landing'],
                    ['type' => 'ecommerce', 'title' => 'Tienda Restaurantes (Pedidos)', 'desc' => 'Menú por categorías, productos, pedidos, WhatsApp y horarios.', 'stack' => 'WooCommerce', 'goal' => 'Pedidos', 'badge' => 'E-commerce'],
                ];
            @endphp

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6" id="portfolioGrid">
                @foreach($projects as $p)
                    <div class="portfolioItem glass p-6 rounded-2xl border border-slate-800 hover:border-slate-600 transition group"
                         data-type="{{ $p['type'] }}">

                        <div class="flex items-center justify-between mb-4">
                            <span class="text-[11px] px-3 py-1 rounded-full bg-slate-800 border border-slate-700 text-slate-300">
                                {{ $p['badge'] }}
                            </span>

                            <span class="text-slate-600 group-hover:text-emerald-400 transition">↗</span>
                        </div>

                        {{-- “Preview” falso (sin imágenes) --}}
                        <div class="rounded-2xl border border-slate-800 bg-slate-900/30 p-4 mb-5">
                            <div class="h-28 rounded-xl bg-gradient-to-br from-slate-800/70 to-slate-900/40 border border-slate-800 flex items-center justify-center text-slate-500 text-xs">
                                Preview / Mockup
                            </div>
                        </div>

                        <h3 class="text-lg font-bold text-white mb-2">{{ $p['title'] }}</h3>
                        <p class="text-sm text-slate-400 leading-relaxed">{{ $p['desc'] }}</p>

                        <div class="mt-5 grid grid-cols-2 gap-3 text-xs">
                            <div class="rounded-xl border border-slate-800 bg-slate-900/30 p-3">
                                <div class="text-[11px] text-slate-500 mb-1">Stack</div>
                                <div class="text-slate-200 font-semibold">{{ $p['stack'] }}</div>
                            </div>
                            <div class="rounded-xl border border-slate-800 bg-slate-900/30 p-3">
                                <div class="text-[11px] text-slate-500 mb-1">Objetivo</div>
                                <div class="text-slate-200 font-semibold">{{ $p['goal'] }}</div>
                            </div>
                        </div>

                        <div class="mt-5 pt-5 border-t border-slate-800 flex items-center justify-between gap-3">
                            <div class="text-xs text-slate-500">Móvil + SEO + velocidad</div>
                            <button type="button"
                                    onclick="openWhatsAppProject('{{ $p['title'] }}')"
                                    class="text-xs font-bold px-4 py-2 rounded-xl bg-slate-800 text-white hover:bg-slate-700 transition">
                                Quiero uno así
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-10 text-center">
                <p class="text-sm text-slate-500">
                    *Si quieres, luego conectamos esta sección a BD para que admin suba proyectos desde panel.
                </p>
            </div>
        </div>
    </section>

    {{-- PROCESO / CONFIANZA --}}
    <section class="py-20 relative overflow-hidden">
        <div class="absolute top-1/2 left-0 w-full h-px bg-gradient-to-r from-transparent via-slate-800 to-transparent"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <h2 class="text-3xl font-bold text-white mb-4">¿Cómo lo hacemos?</h2>
                <p class="text-slate-400">Metodología simple: rápido, ordenado y sin sorpresas.</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="glass p-6 rounded-2xl border border-slate-800">
                    <div class="h-12 w-12 rounded-xl bg-emerald-500/10 flex items-center justify-center text-2xl mb-4">1</div>
                    <h3 class="text-white font-bold mb-2">Brief</h3>
                    <p class="text-sm text-slate-400">Definimos objetivo, público, CTA y estilo.</p>
                </div>
                <div class="glass p-6 rounded-2xl border border-slate-800">
                    <div class="h-12 w-12 rounded-xl bg-blue-500/10 flex items-center justify-center text-2xl mb-4">2</div>
                    <h3 class="text-white font-bold mb-2">Diseño</h3>
                    <p class="text-sm text-slate-400">UI moderna, mobile-first y jerarquía clara.</p>
                </div>
                <div class="glass p-6 rounded-2xl border border-slate-800">
                    <div class="h-12 w-12 rounded-xl bg-purple-500/10 flex items-center justify-center text-2xl mb-4">3</div>
                    <h3 class="text-white font-bold mb-2">Desarrollo</h3>
                    <p class="text-sm text-slate-400">Implementación rápida, SEO base y rendimiento.</p>
                </div>
                <div class="glass p-6 rounded-2xl border border-slate-800">
                    <div class="h-12 w-12 rounded-xl bg-cyan-500/10 flex items-center justify-center text-2xl mb-4">4</div>
                    <h3 class="text-white font-bold mb-2">Entrega</h3>
                    <p class="text-sm text-slate-400">Publicación, pruebas, soporte y guía de uso.</p>
                </div>
            </div>

            <div class="mt-12 glass rounded-2xl p-8 border border-slate-800">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                    <div>
                        <div class="text-xs text-slate-500 uppercase tracking-widest mb-2">Garantía</div>
                        <div class="text-lg font-bold text-white">Soporte 15 días + correcciones menores</div>
                        <p class="text-sm text-slate-400 mt-2">
                            Entrega estable, rápida y lista para vender. Te guiamos con contenido y publicación.
                        </p>
                    </div>
                    <button type="button"
                            onclick="openWhatsAppGeneral('Quiero cotizar una web (portafolio)')"
                            class="px-8 py-4 rounded-xl bg-emerald-500 text-slate-900 font-bold hover:bg-emerald-400 transition">
                        Cotizar ahora
                    </button>
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
                    ¿Quieres una web con este nivel?
                </h2>
                <p class="text-slate-400 mb-8 max-w-2xl mx-auto relative z-10">
                    Te proponemos el plan ideal según tu negocio y tu meta: leads, ventas o posicionamiento.
                </p>

                <div class="flex flex-col sm:flex-row justify-center gap-4 relative z-10">
                    <a href="{{ route('paginas-web') }}"
                       class="px-8 py-4 rounded-xl bg-slate-800 text-white hover:bg-slate-700 transition">
                        Ver planes de páginas web
                    </a>
                    <button type="button"
                            onclick="openWhatsAppGeneral('Quiero una web como las del portafolio')"
                            class="px-8 py-4 rounded-xl bg-emerald-500 text-slate-900 font-bold hover:bg-emerald-400 transition">
                        Hablar por WhatsApp
                    </button>
                </div>

                <p class="mt-6 text-[11px] text-slate-500">
                    Diseño premium • Mobile-first • SEO base • Rápida
                </p>
            </div>
        </div>
    </section>

    {{-- SCRIPTS --}}
    <script>
        // Cambia esto por tu número real (ej: 573001234567)
        const WHATSAPP_NUMBER = '573009075093';

        function openWhatsAppGeneral(topic){
            const text = `Hola Linea365, ${topic}. ¿Me ayudas?`;
            window.open(`https://wa.me/${WHATSAPP_NUMBER}?text=${encodeURIComponent(text)}`, '_blank');
        }

        function openWhatsAppProject(project){
            const text = `Hola Linea365, quiero una web como: ${project}. Mi negocio es: _____. Mi WhatsApp es: _____.`;
            window.open(`https://wa.me/${WHATSAPP_NUMBER}?text=${encodeURIComponent(text)}`, '_blank');
        }

        // Filtros
        const btns = document.querySelectorAll('.filterBtn');
        const items = document.querySelectorAll('.portfolioItem');

        btns.forEach(b => {
            b.addEventListener('click', () => {
                const filter = b.dataset.filter;

                // UI botones
                btns.forEach(x => {
                    x.classList.remove('bg-emerald-500','text-slate-900');
                    x.classList.add('bg-slate-800','text-white');
                });
                b.classList.remove('bg-slate-800','text-white');
                b.classList.add('bg-emerald-500','text-slate-900');

                // Filtrar cards
                items.forEach(it => {
                    const type = it.dataset.type;
                    if(filter === 'all' || type === filter){
                        it.classList.remove('hidden');
                    } else {
                        it.classList.add('hidden');
                    }
                });
            });
        });
    </script>

    <style>
        .glass {
            background: rgba(15, 23, 42, 0.35);
            backdrop-filter: blur(10px);
        }
    </style>

@endsection
