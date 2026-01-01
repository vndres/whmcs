@extends('layouts.frontend')

@section('title', 'Hosting Web en Colombia - Linea365 | Rápido, Seguro y con Soporte')

@section('seo')
    <meta name="description" content="Hosting web premium en Colombia. Planes Linux y Windows, SSL gratis, correos, cPanel, backups y soporte real. Compra en minutos con Linea365.">
    <link rel="canonical" href="{{ url()->current() }}">
@endsection

@section('content')

    {{-- HERO --}}
    <section class="relative pt-16 pb-14 sm:pt-24 sm:pb-20 overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-16 left-10 w-72 h-72 bg-emerald-500/10 rounded-full blur-[110px]"></div>
            <div class="absolute bottom-16 right-10 w-96 h-96 bg-cyan-500/10 rounded-full blur-[120px]"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-800/50 border border-slate-700 backdrop-blur-sm mb-6">
                    <span class="flex h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-xs font-medium text-slate-300">Hosting optimizado para velocidad, SEO y estabilidad</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white tracking-tight leading-tight">
                    Hosting Web
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-cyan-400">rápido y confiable</span>
                    para tu negocio
                </h1>

                <p class="mt-5 text-lg text-slate-400 leading-relaxed">
                    Activa tu hosting en minutos con <span class="text-slate-200 font-semibold">cPanel</span>, <span class="text-slate-200 font-semibold">SSL</span>,
                    correos profesionales, backups recomendados y soporte real. Ideal para WordPress, tiendas y páginas corporativas.
                </p>

                <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
                    <a href="#planes"
                       class="px-8 py-4 rounded-xl bg-emerald-500 text-slate-900 font-bold hover:bg-emerald-400 transition shadow-lg shadow-emerald-500/20">
                        Ver planes
                    </a>
                    <a href="#comparacion"
                       class="px-8 py-4 rounded-xl bg-slate-800 text-white hover:bg-slate-700 transition">
                        Comparar
                    </a>
                </div>

                <div class="mt-10 grid grid-cols-2 sm:grid-cols-4 gap-3 max-w-4xl mx-auto">
                    <div class="glass rounded-2xl border border-slate-800 p-4">
                        <div class="text-xs text-slate-500">Panel</div>
                        <div class="text-sm text-slate-200 font-semibold">cPanel</div>
                    </div>
                    <div class="glass rounded-2xl border border-slate-800 p-4">
                        <div class="text-xs text-slate-500">Seguridad</div>
                        <div class="text-sm text-slate-200 font-semibold">SSL + Hardening</div>
                    </div>
                    <div class="glass rounded-2xl border border-slate-800 p-4">
                        <div class="text-xs text-slate-500">Rendimiento</div>
                        <div class="text-sm text-slate-200 font-semibold">NVMe + Cache</div>
                    </div>
                    <div class="glass rounded-2xl border border-slate-800 p-4">
                        <div class="text-xs text-slate-500">Soporte</div>
                        <div class="text-sm text-slate-200 font-semibold">Humano</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- PLANES --}}
    <section id="planes" class="py-20 bg-slate-900/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center max-w-3xl mx-auto mb-14">
                <h2 class="text-3xl sm:text-4xl font-bold text-white">Planes de Hosting</h2>
                <p class="mt-3 text-slate-400">Elige un plan según tu etapa: empezar, crecer o escalar.</p>
            </div>

            @php
                // Si luego conectas a BD, reemplazas esto por $products del controlador.
                $plans = [
                    [
                        'name' => 'Starter',
                        'tag' => 'Ideal para landing o web pequeña',
                        'price' => 29900,
                        'period' => 'mes',
                        'featured' => false,
                        'bullets' => [
                            '1 sitio web',
                            '10 GB SSD/NVMe',
                            'Cuentas de correo',
                            'SSL gratis',
                            'Instalador WordPress',
                            'Soporte básico',
                        ],
                    ],
                    [
                        'name' => 'Pro',
                        'tag' => 'El más vendido (empresas)',
                        'price' => 49900,
                        'period' => 'mes',
                        'featured' => true,
                        'bullets' => [
                            'Hasta 5 sitios web',
                            '25 GB NVMe',
                            'Correos profesionales',
                            'SSL + protección básica',
                            'Mejor rendimiento',
                            'Soporte prioritario',
                        ],
                    ],
                    [
                        'name' => 'Business',
                        'tag' => 'Para tiendas y alto tráfico',
                        'price' => 89900,
                        'period' => 'mes',
                        'featured' => false,
                        'bullets' => [
                            'Hasta 10 sitios',
                            '60 GB NVMe',
                            'Recursos ampliados',
                            'Optimización de caché',
                            'Backups recomendados',
                            'Soporte dedicado',
                        ],
                    ],
                ];
            @endphp

            <div class="grid md:grid-cols-3 gap-8">
                @foreach($plans as $p)
                    @php
                        $isFeatured = $p['featured'];
                        $card = $isFeatured
                            ? 'border-emerald-500/50 bg-slate-800/60 scale-105 shadow-2xl shadow-emerald-500/10 z-10'
                            : 'border-slate-800 bg-slate-900/40 hover:border-slate-600 hover:bg-slate-800/40';

                        $btn = $isFeatured
                            ? 'bg-emerald-500 text-slate-900 hover:bg-emerald-400'
                            : 'bg-slate-800 text-white hover:bg-slate-700';
                    @endphp

                    <div class="relative rounded-2xl p-6 flex flex-col border transition duration-300 {{ $card }}">
                        @if($isFeatured)
                            <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2">
                                <span class="px-3 py-1 rounded-full bg-emerald-500 text-slate-900 text-xs font-bold shadow-lg shadow-emerald-500/20">
                                    Más Popular
                                </span>
                            </div>
                        @endif

                        <div class="mb-6">
                            <h3 class="text-xl font-bold text-white mb-2">{{ $p['name'] }}</h3>
                            <p class="text-xs text-slate-400">{{ $p['tag'] }}</p>

                            <div class="flex items-baseline gap-2 mt-4">
                                <span class="text-3xl font-bold text-white">$ {{ number_format($p['price'], 0, ',', '.') }}</span>
                                <span class="text-sm text-slate-400">COP / {{ $p['period'] }}</span>
                            </div>

                            <div class="mt-3 text-xs text-slate-500">
                                Incluye <span class="text-slate-200 font-semibold">SSL</span> y <span class="text-slate-200 font-semibold">cPanel</span>
                            </div>
                        </div>

                        <ul class="text-sm text-slate-300 space-y-2 flex-1">
                            @foreach($p['bullets'] as $b)
                                <li class="flex gap-2">
                                    <span class="text-emerald-400 font-bold">✓</span>
                                    <span>{{ $b }}</span>
                                </li>
                            @endforeach
                        </ul>

                        {{-- Botón (por ahora abre WhatsApp; luego lo conectas a tu carrito) --}}
                        <button type="button"
                                onclick="openWhatsAppPlan('{{ $p['name'] }}', '{{ number_format($p['price'], 0, ',', '.') }}')"
                                class="mt-6 w-full py-3 px-4 rounded-xl text-sm font-bold transition {{ $btn }}">
                            Quiero este plan
                        </button>

                        <p class="mt-4 text-[11px] text-slate-500">
                            *Puedes migrar tu web gratis (según plan y complejidad).
                        </p>
                    </div>
                @endforeach
            </div>

            {{-- Mini garantías --}}
            <div class="mt-16 grid lg:grid-cols-4 gap-6">
                <div class="glass p-6 rounded-2xl border border-slate-800">
                    <div class="text-2xl mb-3">⚡</div>
                    <h4 class="text-white font-bold mb-2">Velocidad</h4>
                    <p class="text-sm text-slate-400">NVMe, caché y configuración pensada para rendimiento.</p>
                </div>
                <div class="glass p-6 rounded-2xl border border-slate-800">
                    <div class="text-2xl mb-3">🛡️</div>
                    <h4 class="text-white font-bold mb-2">Seguridad</h4>
                    <p class="text-sm text-slate-400">SSL + buenas prácticas. Opciones extra bajo demanda.</p>
                </div>
                <div class="glass p-6 rounded-2xl border border-slate-800">
                    <div class="text-2xl mb-3">📩</div>
                    <h4 class="text-white font-bold mb-2">Correo</h4>
                    <p class="text-sm text-slate-400">Crea correos profesionales y adminístralos desde cPanel.</p>
                </div>
                <div class="glass p-6 rounded-2xl border border-slate-800">
                    <div class="text-2xl mb-3">🤝</div>
                    <h4 class="text-white font-bold mb-2">Soporte real</h4>
                    <p class="text-sm text-slate-400">Te atendemos humano. Nada de “bots eternos”.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- COMPARACIÓN --}}
    <section id="comparacion" class="py-20 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <h2 class="text-3xl font-bold text-white">Comparación rápida</h2>
                <p class="mt-3 text-slate-400">Así eliges sin enredos.</p>
            </div>

            <div class="glass rounded-3xl border border-slate-800 overflow-hidden">
                <div class="grid grid-cols-4 bg-slate-900/40">
                    <div class="p-4 text-xs text-slate-500 font-bold uppercase tracking-widest">Característica</div>
                    <div class="p-4 text-xs text-slate-300 font-bold uppercase tracking-widest">Starter</div>
                    <div class="p-4 text-xs text-emerald-300 font-bold uppercase tracking-widest">Pro</div>
                    <div class="p-4 text-xs text-slate-300 font-bold uppercase tracking-widest">Business</div>
                </div>

                @php
                    $rows = [
                        ['Sitios web', '1', '5', '10'],
                        ['Almacenamiento', '10 GB', '25 GB', '60 GB'],
                        ['SSL', 'Sí', 'Sí', 'Sí'],
                        ['Correos', 'Sí', 'Sí', 'Sí'],
                        ['Rendimiento', 'Base', 'Alto', 'Máximo'],
                        ['Soporte', 'Básico', 'Prioritario', 'Dedicado'],
                    ];
                @endphp

                @foreach($rows as $r)
                    <div class="grid grid-cols-4 border-t border-slate-800/70">
                        <div class="p-4 text-sm text-slate-300">{{ $r[0] }}</div>
                        <div class="p-4 text-sm text-slate-400">{{ $r[1] }}</div>
                        <div class="p-4 text-sm text-slate-200 font-semibold">{{ $r[2] }}</div>
                        <div class="p-4 text-sm text-slate-400">{{ $r[3] }}</div>
                    </div>
                @endforeach
            </div>

            <div class="mt-10 text-center">
                <p class="text-sm text-slate-500">
                    ¿No sabes cuál elegir? Te recomendamos el plan en WhatsApp según tu web y visitas.
                </p>
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section id="faq" class="py-20 bg-slate-900/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <h2 class="text-3xl font-bold text-white">Preguntas frecuentes</h2>
                <p class="mt-3 text-slate-400">Resolvemos lo típico antes de comprar.</p>
            </div>

            @php
                $faqs = [
                    ['q' => '¿Incluye dominio?', 'a' => 'El dominio se compra aparte. Si ya lo tienes, lo conectamos.'],
                    ['q' => '¿Puedo migrar mi web?', 'a' => 'Sí. Migración disponible según plan y complejidad (te confirmamos antes).'],
                    ['q' => '¿Sirve para WordPress?', 'a' => 'Sí. De hecho está pensado para WordPress, landing pages y webs corporativas.'],
                    ['q' => '¿Qué es cPanel?', 'a' => 'Es el panel donde administras archivos, correos, bases de datos y dominios fácil.'],
                    ['q' => '¿Hay backups?', 'a' => 'Recomendamos backups programados. Podemos configurarlo según tu plan.'],
                    ['q' => '¿Puedo subir de plan después?', 'a' => 'Sí. Puedes escalar cuando tu negocio crezca.'],
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

    {{-- CTA FINAL --}}
    <section class="pb-20">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass rounded-3xl p-8 sm:p-12 border border-slate-800 text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-[80px] pointer-events-none"></div>

                <h2 class="text-2xl sm:text-3xl font-bold text-white mb-3 relative z-10">
                    ¿Activamos tu hosting hoy?
                </h2>
                <p class="text-slate-400 mb-8 max-w-2xl mx-auto relative z-10">
                    Te ayudamos a elegir plan, conectar dominio y dejar tu web lista para vender.
                </p>

                <div class="flex flex-col sm:flex-row justify-center gap-4 relative z-10">
                    <a href="#planes" class="px-8 py-4 rounded-xl bg-slate-800 text-white hover:bg-slate-700 transition">
                        Ver planes
                    </a>
                    <button type="button"
                            onclick="openWhatsAppGeneral('Quiero comprar hosting')"
                            class="px-8 py-4 rounded-xl bg-emerald-500 text-slate-900 font-bold hover:bg-emerald-400 transition">
                        Hablar por WhatsApp
                    </button>
                </div>

                <p class="mt-6 text-[11px] text-slate-500">
                    Respuesta rápida • Asesoría clara • Activación profesional
                </p>
            </div>
        </div>
    </section>

    {{-- SCRIPTS --}}
    <script>
        // PON TU NÚMERO REAL: formato internacional sin + (ej: 573001234567)
        const WHATSAPP_NUMBER = '573009075093';

        function openWhatsAppGeneral(topic){
            const text = `Hola Linea365, ${topic}. ¿Me ayudas?`;
            window.open(`https://wa.me/${WHATSAPP_NUMBER}?text=${encodeURIComponent(text)}`, '_blank');
        }

        function openWhatsAppPlan(plan, price){
            const text = `Hola Linea365, quiero el hosting ${plan} por $${price} COP/mes. Mi dominio es: _____. ¿Qué sigue?`;
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
