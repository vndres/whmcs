@extends('layouts.frontend')

@section('title', 'Linea365 - Desarrollo de Páginas Web Profesionales')

@section('seo')
    <meta name="description" content="Diseño y desarrollo web profesional en Colombia. Landing pages, páginas corporativas y tiendas online con SEO, rendimiento y soporte. Precios competitivos y entrega rápida.">
    <link rel="canonical" href="{{ url()->current() }}">
@endsection

@section('content')
    {{-- SECCIÓN 1: HERO + COTIZADOR --}}
    <section class="relative pt-16 pb-20 sm:pt-24 sm:pb-32 overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full z-0 pointer-events-none">
            <div class="absolute top-20 left-10 w-72 h-72 bg-emerald-500/10 rounded-full blur-[100px]"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-blue-600/10 rounded-full blur-[100px]"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-800/50 border border-slate-700 backdrop-blur-sm mb-8 animate-fade-in-up">
                <span class="flex h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="text-xs font-medium text-slate-300">Webs listas para vender: rápidas, confiables y optimizadas</span>
            </div>

            {{-- Título --}}
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white tracking-tight mb-6 max-w-5xl mx-auto leading-tight">
                Tu negocio merece una web que
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-cyan-400">convierta visitas en clientes</span>
            </h1>

            <p class="text-lg text-slate-400 mb-10 max-w-3xl mx-auto leading-relaxed">
                Diseñamos y desarrollamos páginas web profesionales en Colombia:
                <span class="text-slate-200 font-semibold">Landing Pages</span>, <span class="text-slate-200 font-semibold">Web Corporativas</span> y
                <span class="text-slate-200 font-semibold">Tiendas Online</span>. Entrega rápida, SEO base, rendimiento y soporte real.
            </p>

            {{-- COTIZADOR --}}
            <div class="max-w-4xl mx-auto mb-14">
                <div class="glass p-4 sm:p-5 rounded-2xl border border-slate-700/50 shadow-2xl shadow-emerald-900/20 transform hover:scale-[1.01] transition duration-300">
                    <div class="grid sm:grid-cols-5 gap-3 items-stretch">
                        <div class="sm:col-span-2">
                            <label class="block text-xs text-slate-500 mb-2 text-left">Tipo de página</label>
                            <select id="webType" class="w-full px-4 py-4 rounded-xl bg-slate-900/40 border border-slate-700 text-slate-100 focus:outline-none focus:ring-0">
                                <option value="landing">Landing Page (1 página)</option>
                                <option value="corporativa">Web Corporativa (hasta 5 secciones)</option>
                                <option value="tienda">Tienda Online (e-commerce)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs text-slate-500 mb-2 text-left">Entrega</label>
                            <select id="delivery" class="w-full px-4 py-4 rounded-xl bg-slate-900/40 border border-slate-700 text-slate-100 focus:outline-none focus:ring-0">
                                <option value="normal">Normal</option>
                                <option value="prioritaria">Prioritaria</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs text-slate-500 mb-2 text-left">Incluye</label>
                            <select id="extras" class="w-full px-4 py-4 rounded-xl bg-slate-900/40 border border-slate-700 text-slate-100 focus:outline-none focus:ring-0">
                                <option value="seo">SEO Base</option>
                                <option value="seo_ads">SEO + Pixel/Ads</option>
                                <option value="seo_crm">SEO + Formulario a WhatsApp/CRM</option>
                            </select>
                        </div>

                        <div class="sm:col-span-1 flex flex-col justify-end">
                            <button onclick="quoteWeb()"
                                    class="w-full bg-emerald-500 hover:bg-emerald-400 text-slate-900 font-bold px-6 py-4 rounded-xl transition flex items-center justify-center gap-2">
                                <span id="qBtnText">Cotizar</span>
                                <span id="qBtnLoader" class="hidden animate-spin h-5 w-5 border-2 border-slate-900 border-t-transparent rounded-full"></span>
                            </button>
                        </div>
                    </div>

                    <div id="quoteResult" class="hidden mt-4 glass rounded-xl border border-slate-700 p-4 text-left animate-fade-in-up">
                        {{-- JS Result --}}
                    </div>

                    <div class="mt-4 grid md:grid-cols-3 gap-3 text-left">
                        <div class="rounded-xl border border-slate-800 bg-slate-900/30 p-4">
                            <div class="text-xs text-slate-500 mb-1">Incluye siempre</div>
                            <div class="text-sm text-slate-200 font-semibold">Diseño moderno + versión móvil + SSL + analytics</div>
                        </div>
                        <div class="rounded-xl border border-slate-800 bg-slate-900/30 p-4">
                            <div class="text-xs text-slate-500 mb-1">Entrega típica</div>
                            <div class="text-sm text-slate-200 font-semibold">3–12 días hábiles (según plan)</div>
                        </div>
                        <div class="rounded-xl border border-slate-800 bg-slate-900/30 p-4">
                            <div class="text-xs text-slate-500 mb-1">Pago</div>
                            <div class="text-sm text-slate-200 font-semibold">50% inicio / 50% entrega</div>
                        </div>
                    </div>
                </div>

                {{-- Logos --}}
                <div class="pt-8 border-t border-slate-800/50 mt-10">
                    <p class="text-xs text-slate-500 uppercase tracking-widest mb-4">Tecnologías y buenas prácticas</p>
                    <div class="flex flex-wrap justify-center gap-6 grayscale opacity-60">
                        <span class="text-lg font-bold text-slate-400">WordPress</span>
                        <span class="text-lg font-bold text-slate-400">Laravel</span>
                        <span class="text-lg font-bold text-slate-400">SEO</span>
                        <span class="text-lg font-bold text-slate-400">Core Web Vitals</span>
                        <span class="text-lg font-bold text-slate-400">WhatsApp</span>
                    </div>
                </div>
            </div>

            {{-- Mini-CTAs --}}
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="#planes" class="px-8 py-4 rounded-xl bg-emerald-500 text-slate-900 font-bold hover:bg-emerald-400 transition">
                    Ver planes y precios
                </a>
                <a href="#portafolio" class="px-8 py-4 rounded-xl bg-slate-800 text-white hover:bg-slate-700 transition">
                    Ver ejemplos
                </a>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 2: PLANES (3 MÁS VENDIDOS) --}}
    <section id="planes" class="py-20 bg-slate-900/30 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-bold text-white mb-4">Los 3 tipos de páginas más vendidas en Colombia</h2>
                <p class="text-slate-400">Precios competitivos, calidad premium y enfoque total en conversión. Elige el plan según tu meta.</p>
            </div>

            @php
                // Ajusta estos IDs si vas a conectarlo a tu carrito/BD de productos
                $webPlans = [
                    [
                        'id' => 101,
                        'name' => 'Landing Page Pro',
                        'tag' => 'Ideal para campañas y WhatsApp',
                        'price' => 690000,
                        'days' => '3–5 días hábiles',
                        'featured' => false,
                        'bullets' => [
                            '1 página de alta conversión (secciones ilimitadas)',
                            'Formulario + botón WhatsApp + mapa',
                            'Copy básico persuasivo (si envías info)',
                            'SEO base + Analytics + Pixel (si aplica)',
                            'Optimización velocidad y móvil (Core Web Vitals)',
                            'Entrega con manual corto de uso',
                        ],
                    ],
                    [
                        'id' => 102,
                        'name' => 'Web Corporativa Premium',
                        'tag' => 'La más popular para empresas',
                        'price' => 1290000,
                        'days' => '6–9 días hábiles',
                        'featured' => true,
                        'bullets' => [
                            'Hasta 5 secciones/páginas (Inicio, Servicios, Nosotros, Blog/FAQ, Contacto)',
                            'Diseño UI profesional + identidad visual ligera',
                            'Panel editable (WordPress o CMS según proyecto)',
                            'SEO base + estructura para posicionar',
                            'Integración WhatsApp, formularios y correos',
                            '1 ronda de cambios incluida',
                        ],
                    ],
                    [
                        'id' => 103,
                        'name' => 'Tienda Online (E-commerce)',
                        'tag' => 'Vende 24/7 con pagos y envíos',
                        'price' => 2490000,
                        'days' => '9–12 días hábiles',
                        'featured' => false,
                        'bullets' => [
                            'Catálogo, categorías, variaciones y stock',
                            'Carrito + checkout optimizado',
                            'Pagos (Wompi/MercadoPago/transferencia) según disponibilidad',
                            'Integración de envíos (manual o proveedor)',
                            'Automatizaciones: correo de compra + WhatsApp',
                            'Capacitación rápida para administrar productos',
                        ],
                    ],
                ];
            @endphp

            <div class="grid md:grid-cols-3 gap-8">
                @foreach($webPlans as $plan)
                    @php
                        $isFeatured = $plan['featured'];
                        $cardClass = $isFeatured
                            ? 'border-emerald-500/50 bg-slate-800/60 scale-105 shadow-2xl shadow-emerald-500/10 z-10'
                            : 'border-slate-800 bg-slate-900/40 hover:border-slate-600 hover:bg-slate-800/40';

                        $btnClass = $isFeatured
                            ? 'bg-emerald-500 text-slate-900 hover:bg-emerald-400 hover:shadow-lg'
                            : 'bg-slate-700 text-white hover:bg-slate-600';
                    @endphp

                    <div class="relative rounded-2xl p-6 flex flex-col border transition duration-300 {{ $cardClass }}">
                        @if($isFeatured)
                            <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2">
                                <span class="px-3 py-1 rounded-full bg-emerald-500 text-slate-900 text-xs font-bold shadow-lg shadow-emerald-500/20">
                                    Más Popular
                                </span>
                            </div>
                        @endif

                        <div class="mb-6">
                            <h3 class="text-xl font-bold text-white mb-2">{{ $plan['name'] }}</h3>
                            <p class="text-xs text-slate-400">{{ $plan['tag'] }}</p>

                            <div class="flex items-baseline gap-2 mt-4">
                                <span class="text-3xl font-bold text-white">${{ number_format($plan['price'], 0, ',', '.') }}</span>
                                <span class="text-sm text-slate-400">COP</span>
                            </div>

                            <div class="mt-3 text-xs text-slate-500">
                                <span class="text-slate-300 font-semibold">Entrega:</span> {{ $plan['days'] }}
                                <span class="mx-2 text-slate-700">•</span>
                                <span class="text-slate-300 font-semibold">Incluye:</span> SSL + móvil + velocidad
                            </div>
                        </div>

                        <div class="flex-1 space-y-3 mb-8">
                            <ul class="text-sm text-slate-300 space-y-2">
                                @foreach($plan['bullets'] as $b)
                                    <li class="flex gap-2">
                                        <span class="text-emerald-400 font-bold">✓</span>
                                        <span>{{ $b }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="grid grid-cols-2 gap-3 mb-4">
                            <div class="rounded-xl border border-slate-800 bg-slate-900/30 p-4">
                                <div class="text-[11px] text-slate-500 mb-1">Garantía</div>
                                <div class="text-sm text-slate-200 font-semibold">Soporte 15 días</div>
                            </div>
                            <div class="rounded-xl border border-slate-800 bg-slate-900/30 p-4">
                                <div class="text-[11px] text-slate-500 mb-1">Optimización</div>
                                <div class="text-sm text-slate-200 font-semibold">Rápida y móvil</div>
                            </div>
                        </div>

                        {{-- BOTÓN (conecta a tu carrito si quieres) --}}
                        <form action="{{ route('cart.add') }}" method="POST" class="mt-auto">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $plan['id'] }}">
                            <button type="submit"
                                    class="w-full py-3 px-4 rounded-xl text-sm font-bold transition-all duration-200 {{ $btnClass }}">
                                {{ $isFeatured ? 'Elegir este plan' : 'Quiero este plan' }}
                            </button>
                        </form>

                        <button type="button"
                                onclick="openWhatsAppQuote('{{ $plan['name'] }}', '{{ number_format($plan['price'], 0, ',', '.') }}')"
                                class="mt-3 w-full py-3 px-4 rounded-xl text-sm font-bold bg-slate-800 text-white hover:bg-slate-700 transition">
                            Cotizar por WhatsApp
                        </button>

                        <p class="mt-4 text-[11px] text-slate-500">
                            *No incluye dominio/hosting. Si lo necesitas, Linea365 te lo deja listo al publicar.
                        </p>
                    </div>
                @endforeach
            </div>

            {{-- Garantías / Diferenciales --}}
            <div class="mt-16 grid lg:grid-cols-4 gap-6">
                <div class="glass p-6 rounded-2xl border border-slate-800">
                    <div class="text-2xl mb-3">⚡</div>
                    <h4 class="text-white font-bold mb-2">Rendimiento real</h4>
                    <p class="text-sm text-slate-400">Web ligera, optimizada y rápida. Más velocidad = más ventas y mejor SEO.</p>
                </div>
                <div class="glass p-6 rounded-2xl border border-slate-800">
                    <div class="text-2xl mb-3">🎯</div>
                    <h4 class="text-white font-bold mb-2">Enfoque en conversión</h4>
                    <p class="text-sm text-slate-400">Diseño pensado para que el usuario te contacte: WhatsApp, formularios y CTAs claros.</p>
                </div>
                <div class="glass p-6 rounded-2xl border border-slate-800">
                    <div class="text-2xl mb-3">🛡️</div>
                    <h4 class="text-white font-bold mb-2">Buenas prácticas</h4>
                    <p class="text-sm text-slate-400">Seguridad base, SSL, backups recomendados y estructura profesional.</p>
                </div>
                <div class="glass p-6 rounded-2xl border border-slate-800">
                    <div class="text-2xl mb-3">🤝</div>
                    <h4 class="text-white font-bold mb-2">Acompañamiento</h4>
                    <p class="text-sm text-slate-400">Te guiamos en contenido, imágenes y publicación. No te dejamos tirado.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 3: PROCESO (CONFIANZA) --}}
    <section id="proceso" class="py-20 relative overflow-hidden">
        <div class="absolute top-1/2 left-0 w-full h-px bg-gradient-to-r from-transparent via-slate-800 to-transparent"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-emerald-400 font-bold tracking-wider uppercase text-xs">Método probado</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-white mt-2 mb-4">
                    Así construimos tu web para que funcione
                </h2>
                <p class="text-slate-400 text-lg">
                    Nada de “te hago una página y ya”. Te entregamos un activo digital listo para captar clientes.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="glass p-6 rounded-2xl border border-slate-800 hover:border-slate-600 transition group">
                    <div class="h-12 w-12 rounded-xl bg-emerald-500/10 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">1</div>
                    <h3 class="text-lg font-bold text-white mb-2">Brief + objetivos</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">Definimos tu oferta, público, CTA principal y estilo visual.</p>
                </div>

                <div class="glass p-6 rounded-2xl border border-slate-800 hover:border-slate-600 transition group">
                    <div class="h-12 w-12 rounded-xl bg-blue-500/10 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">2</div>
                    <h3 class="text-lg font-bold text-white mb-2">Diseño UI</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">Creamos un diseño moderno, móvil primero, con jerarquía clara.</p>
                </div>

                <div class="glass p-6 rounded-2xl border border-slate-800 hover:border-slate-600 transition group">
                    <div class="h-12 w-12 rounded-xl bg-purple-500/10 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">3</div>
                    <h3 class="text-lg font-bold text-white mb-2">Desarrollo</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">Implementamos la web con buenas prácticas, velocidad y SEO base.</p>
                </div>

                <div class="glass p-6 rounded-2xl border border-slate-800 hover:border-slate-600 transition group">
                    <div class="h-12 w-12 rounded-xl bg-cyan-500/10 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">4</div>
                    <h3 class="text-lg font-bold text-white mb-2">Publicación</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">Conectamos dominio, SSL, analytics y dejamos todo funcionando.</p>
                </div>
            </div>

            <div class="mt-12 glass rounded-2xl p-8 border border-slate-800">
                <div class="grid md:grid-cols-3 gap-6">
                    <div>
                        <div class="text-xs text-slate-500 uppercase tracking-widest mb-2">Entregables</div>
                        <ul class="text-sm text-slate-300 space-y-2">
                            <li class="flex gap-2"><span class="text-emerald-400 font-bold">✓</span> Diseño responsive</li>
                            <li class="flex gap-2"><span class="text-emerald-400 font-bold">✓</span> SEO base (titles, meta, headings)</li>
                            <li class="flex gap-2"><span class="text-emerald-400 font-bold">✓</span> Conexión WhatsApp / formularios</li>
                        </ul>
                    </div>
                    <div>
                        <div class="text-xs text-slate-500 uppercase tracking-widest mb-2">Calidad</div>
                        <ul class="text-sm text-slate-300 space-y-2">
                            <li class="flex gap-2"><span class="text-emerald-400 font-bold">✓</span> Buen rendimiento (carga rápida)</li>
                            <li class="flex gap-2"><span class="text-emerald-400 font-bold">✓</span> Accesibilidad base</li>
                            <li class="flex gap-2"><span class="text-emerald-400 font-bold">✓</span> Compatibilidad móvil</li>
                        </ul>
                    </div>
                    <div>
                        <div class="text-xs text-slate-500 uppercase tracking-widest mb-2">Soporte</div>
                        <ul class="text-sm text-slate-300 space-y-2">
                            <li class="flex gap-2"><span class="text-emerald-400 font-bold">✓</span> 15 días de soporte post-entrega</li>
                            <li class="flex gap-2"><span class="text-emerald-400 font-bold">✓</span> Correcciones menores incluidas</li>
                            <li class="flex gap-2"><span class="text-emerald-400 font-bold">✓</span> Guía rápida de administración</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 4: PORTAFOLIO / EJEMPLOS --}}
    <section id="portafolio" class="py-20 bg-slate-900/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-bold text-white mb-4">Ejemplos de lo que entregamos</h2>
                <p class="text-slate-400">Plantillas tipo premium (sin “look barato”), listas para adaptar a tu marca.</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                    $portfolio = [
                        ['title' => 'Landing para Servicios (WhatsApp)', 'desc' => 'Sección héroe, beneficios, testimonios, FAQs y CTA fijo.', 'tag' => 'Landing'],
                        ['title' => 'Corporativa para Empresa', 'desc' => 'Inicio, servicios, nosotros, blog/FAQ, contacto y formularios.', 'tag' => 'Corporativa'],
                        ['title' => 'Tienda Online', 'desc' => 'Catálogo, filtros, variaciones, checkout y pagos.', 'tag' => 'E-commerce'],
                        ['title' => 'Landing para Inmobiliaria', 'desc' => 'Propiedades destacadas, lead form y agendamiento.', 'tag' => 'Landing'],
                        ['title' => 'Corporativa para Clínica', 'desc' => 'Especialidades, doctores, reseñas y reserva.', 'tag' => 'Corporativa'],
                        ['title' => 'E-commerce para Moda', 'desc' => 'Tallas, colores, stock, envíos y promociones.', 'tag' => 'E-commerce'],
                    ];
                @endphp

                @foreach($portfolio as $p)
                    <div class="glass p-6 rounded-2xl border border-slate-800 hover:border-slate-600 transition group">
                        <div class="flex items-center justify-between mb-4">
                            <span class="text-[11px] px-3 py-1 rounded-full bg-slate-800 border border-slate-700 text-slate-300">
                                {{ $p['tag'] }}
                            </span>
                            <span class="text-slate-600 group-hover:text-emerald-400 transition">↗</span>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">{{ $p['title'] }}</h3>
                        <p class="text-sm text-slate-400 leading-relaxed">{{ $p['desc'] }}</p>

                        <div class="mt-5 pt-5 border-t border-slate-800 flex items-center justify-between">
                            <div class="text-xs text-slate-500">Entrega con SEO + móvil</div>
                            <button type="button"
                                    onclick="openWhatsAppGeneral('{{ $p['title'] }}')"
                                    class="text-xs font-bold px-4 py-2 rounded-xl bg-slate-800 text-white hover:bg-slate-700 transition">
                                Quiero uno así
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-10 text-center">
                <p class="text-sm text-slate-500">
                    *Si ya tienes un diseño de referencia, lo replicamos con tu marca (sin copiar contenido protegido).
                </p>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 5: FAQ + OBJECIONES --}}
    <section id="faq" class="py-20 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-bold text-white mb-4">Preguntas frecuentes</h2>
                <p class="text-slate-400">Resolvemos lo que normalmente frena una compra (tiempos, pagos, contenido y soporte).</p>
            </div>

            @php
                $faqs = [
                    ['q' => '¿Qué necesito para empezar?', 'a' => 'Nombre del negocio, logo (si tienes), 3–6 fotos, lista de servicios/productos y un número de WhatsApp. Si no tienes todo, te guiamos con una plantilla.'],
                    ['q' => '¿Incluye dominio y hosting?', 'a' => 'No necesariamente. Podemos cotizarlo aparte o usar lo que ya tengas. Si compras hosting/dominio con Linea365 lo dejamos publicado y con SSL.'],
                    ['q' => '¿Puedo editar mi web luego?', 'a' => 'Sí. En corporativas y tiendas lo normal es entregar con un panel administrable. También podemos entregar en código si tu equipo lo gestiona.'],
                    ['q' => '¿Cómo es el pago?', 'a' => '50% para iniciar y 50% al entregar. Si es e-commerce, podemos dividir por hitos (diseño, catálogo, pagos).'],
                    ['q' => '¿Hacen SEO?', 'a' => 'Incluimos SEO base (estructura, metadatos, headings y rendimiento). Para SEO avanzado (contenido, linkbuilding, estrategia) se cotiza como servicio mensual.'],
                    ['q' => '¿Y si quiero funciones extra?', 'a' => 'Se puede: reservas, chat, multi-idioma, CRM, pasarelas, integraciones. Lo cotizamos según alcance, sin sorpresas.'],
                ];
            @endphp

            <div class="grid lg:grid-cols-2 gap-6">
                @foreach($faqs as $f)
                    <div class="glass p-6 rounded-2xl border border-slate-800 hover:border-slate-600 transition">
                        <h3 class="text-white font-bold mb-2">{{ $f['q'] }}</h3>
                        <p class="text-sm text-slate-400 leading-relaxed">{{ $f['a'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- SECCIÓN 6: CTA FINAL --}}
    <section class="pb-20">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass rounded-3xl p-8 sm:p-12 border border-slate-800 text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-[80px] pointer-events-none"></div>

                <h2 class="text-2xl sm:text-3xl font-bold text-white mb-3 relative z-10">
                    ¿Listo para vender más con una web profesional?
                </h2>
                <p class="text-slate-400 mb-8 max-w-2xl mx-auto relative z-10">
                    Te ayudamos a elegir el plan ideal, armar el contenido y publicarlo. Sin estrés, sin enredos.
                </p>

                <div class="flex flex-col sm:flex-row justify-center gap-4 relative z-10">
                    <a href="#planes" class="px-8 py-4 rounded-xl bg-slate-800 text-white hover:bg-slate-700 transition">
                        Ver planes
                    </a>
                    <button type="button"
                            onclick="openWhatsAppGeneral('Quiero una página web (asesoría)')"
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
        // Cambia esto por tu número en formato internacional sin + (ej: 573001234567)
        const WHATSAPP_NUMBER = '57XXXXXXXXXX';

        function money(n){
            try { return new Intl.NumberFormat('es-CO').format(n); } catch(e) { return n; }
        }

        function openWhatsAppGeneral(topic){
            const text = `Hola Linea365, quiero cotizar: ${topic}. ¿Me ayudas?`;
            const url = `https://wa.me/${WHATSAPP_NUMBER}?text=${encodeURIComponent(text)}`;
            window.open(url, '_blank');
        }

        function openWhatsAppQuote(plan, price){
            const text = `Hola Linea365, quiero el plan: ${plan} por $${price} COP. Mi negocio es: _____. Mi WhatsApp es: _____.`;
            const url = `https://wa.me/${WHATSAPP_NUMBER}?text=${encodeURIComponent(text)}`;
            window.open(url, '_blank');
        }

        async function quoteWeb(){
            const btnText = document.getElementById('qBtnText');
            const btnLoader = document.getElementById('qBtnLoader');
            const resultBox = document.getElementById('quoteResult');

            btnText.classList.add('hidden');
            btnLoader.classList.remove('hidden');
            resultBox.classList.add('hidden');
            resultBox.innerHTML = '';

            try {
                const type = document.getElementById('webType').value;
                const delivery = document.getElementById('delivery').value;
                const extras = document.getElementById('extras').value;

                // Precios base (competitivos COP)
                let base = 0;
                let title = '';
                let time = '';
                let includes = [];

                if(type === 'landing'){
                    base = 690000; title = 'Landing Page Pro'; time = '3–5 días hábiles';
                    includes = ['1 página de conversión', 'WhatsApp + formulario', 'SEO base', 'Móvil + velocidad'];
                } else if(type === 'corporativa'){
                    base = 1290000; title = 'Web Corporativa Premium'; time = '6–9 días hábiles';
                    includes = ['Hasta 5 secciones', 'Panel editable', 'SEO base', 'WhatsApp + formularios'];
                } else {
                    base = 2490000; title = 'Tienda Online (E-commerce)'; time = '9–12 días hábiles';
                    includes = ['Catálogo + carrito', 'Checkout optimizado', 'Pagos', 'Capacitación'];
                }

                // Extras
                let extraValue = 0;
                let extraLabel = '';
                if(extras === 'seo'){
                    extraValue = 0; extraLabel = 'SEO Base (incluido)';
                } else if(extras === 'seo_ads'){
                    extraValue = 180000; extraLabel = 'SEO + Pixel/Ads';
                } else {
                    extraValue = 220000; extraLabel = 'SEO + WhatsApp/CRM';
                }

                // Entrega prioritaria
                let rush = 0;
                let deliveryLabel = 'Normal';
                if(delivery === 'prioritaria'){
                    rush = Math.round(base * 0.18);
                    deliveryLabel = 'Prioritaria (+18%)';
                }

                const total = base + extraValue + rush;

                // Render result
                resultBox.classList.remove('hidden');
                resultBox.innerHTML = `
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                <span class="text-emerald-400">✓</span> Cotización estimada: ${title}
                            </h3>
                            <p class="text-sm text-slate-400 mt-1">Entrega: <span class="text-slate-200 font-semibold">${time}</span> • Modalidad: <span class="text-slate-200 font-semibold">${deliveryLabel}</span></p>
                            <div class="mt-3 flex flex-wrap gap-2">
                                ${includes.map(x => `<span class="text-[11px] px-3 py-1 rounded-full bg-slate-800 border border-slate-700 text-slate-300">${x}</span>`).join('')}
                                <span class="text-[11px] px-3 py-1 rounded-full bg-slate-800 border border-slate-700 text-slate-300">${extraLabel}</span>
                            </div>
                        </div>

                        <div class="text-right">
                            <div class="text-3xl font-bold text-white">$${money(total)}</div>
                            <div class="text-xs text-slate-500">COP (estimado)</div>
                            <button onclick="openWhatsAppQuote('${title}', '${money(total)}')"
                                    class="mt-3 text-xs bg-emerald-500 text-slate-900 px-5 py-3 rounded-xl font-bold hover:bg-emerald-400 transition">
                                Cotizar por WhatsApp
                            </button>
                        </div>
                    </div>

                    <div class="mt-4 p-4 rounded-xl border border-slate-800 bg-slate-900/30 text-sm text-slate-300">
                        <div class="font-semibold text-white mb-1">¿Qué sigue?</div>
                        Te pedimos el contenido (o te guiamos), definimos estilo y empezamos. Pagas 50% para iniciar y 50% al entregar.
                    </div>
                `;

            } catch (e){
                console.error(e);
                resultBox.innerHTML = '<p class="text-rose-400 text-sm">Error al cotizar. Revisa la consola (F12).</p>';
                resultBox.classList.remove('hidden');
            } finally {
                btnText.classList.remove('hidden');
                btnLoader.classList.add('hidden');
            }
        }
    </script>

    <style>
        .glass {
            background: rgba(15, 23, 42, 0.35);
            backdrop-filter: blur(10px);
        }
    </style>
@endsection
