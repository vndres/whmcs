@extends('layouts.frontend')

@section('title', 'Servidores VPS - Linea365 | Potencia, Control y Rendimiento')

@section('seo')
    <meta name="description" content="Servidores VPS en Colombia con NVMe, recursos dedicados y soporte real. Planes escalables para proyectos, tiendas, apps y sistemas. Linea365 VPS premium.">
    <link rel="canonical" href="{{ url()->current() }}">
@endsection

@section('content')

    {{-- HERO --}}
    <section class="relative pt-16 pb-16 sm:pt-24 sm:pb-20 overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-16 left-10 w-72 h-72 bg-emerald-500/10 rounded-full blur-[110px]"></div>
            <div class="absolute bottom-16 right-10 w-96 h-96 bg-blue-600/10 rounded-full blur-[120px]"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-800/50 border border-slate-700 backdrop-blur-sm mb-6">
                    <span class="flex h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-xs font-medium text-slate-300">Recursos dedicados • NVMe • Escalable</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white tracking-tight leading-tight">
                    Servidores
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-cyan-400">VPS</span>
                    para proyectos serios
                </h1>

                <p class="mt-5 text-lg text-slate-400 leading-relaxed">
                    Ideal si necesitas más potencia, estabilidad y control para tu web, tienda, app o sistema.
                    Te configuramos el VPS y lo dejamos listo para producción si lo necesitas.
                </p>

                <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="#planes" class="px-8 py-4 rounded-xl bg-emerald-500 text-slate-900 font-bold hover:bg-emerald-400 transition">
                        Ver planes VPS
                    </a>
                    <button type="button"
                            onclick="openWhatsAppGeneral('Quiero un VPS recomendado según mi proyecto')"
                            class="px-8 py-4 rounded-xl bg-slate-800 text-white hover:bg-slate-700 transition">
                        Hablar por WhatsApp
                    </button>
                </div>

                <div class="pt-10 border-t border-slate-800/50 mt-10">
                    <p class="text-xs text-slate-500 uppercase tracking-widest mb-4">Casos típicos de VPS</p>
                    <div class="flex flex-wrap justify-center gap-6 grayscale opacity-60">
                        <span class="text-lg font-bold text-slate-400">E-commerce</span>
                        <span class="text-lg font-bold text-slate-400">APIs</span>
                        <span class="text-lg font-bold text-slate-400">Sistemas</span>
                        <span class="text-lg font-bold text-slate-400">Bots</span>
                        <span class="text-lg font-bold text-slate-400">Alta demanda</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- BENEFICIOS --}}
    <section class="py-20 bg-slate-900/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <h2 class="text-3xl sm:text-4xl font-bold text-white">¿Por qué un VPS?</h2>
                <p class="mt-3 text-slate-400">Cuando el proyecto crece, necesitas recursos dedicados y estabilidad real.</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="glass p-6 rounded-2xl border border-slate-800">
                    <div class="text-2xl mb-3">🧠</div>
                    <h4 class="text-white font-bold mb-2">Recursos dedicados</h4>
                    <p class="text-sm text-slate-400">CPU/RAM para ti. No dependes de “vecinos” del servidor compartido.</p>
                </div>
                <div class="glass p-6 rounded-2xl border border-slate-800">
                    <div class="text-2xl mb-3">⚡</div>
                    <h4 class="text-white font-bold mb-2">Más rendimiento</h4>
                    <p class="text-sm text-slate-400">NVMe + configuración optimizada para carga rápida y estabilidad.</p>
                </div>
                <div class="glass p-6 rounded-2xl border border-slate-800">
                    <div class="text-2xl mb-3">🔧</div>
                    <h4 class="text-white font-bold mb-2">Control total</h4>
                    <p class="text-sm text-slate-400">Instala lo que necesites: Nginx/Apache, Docker, Node, Java, etc.</p>
                </div>
                <div class="glass p-6 rounded-2xl border border-slate-800">
                    <div class="text-2xl mb-3">📈</div>
                    <h4 class="text-white font-bold mb-2">Escalable</h4>
                    <p class="text-sm text-slate-400">Sube recursos cuando creces sin cambiar de plataforma.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- PLANES VPS --}}
    <section id="planes" class="py-20 relative overflow-hidden">
        <div class="absolute top-1/2 left-0 w-full h-px bg-gradient-to-r from-transparent via-slate-800 to-transparent"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-emerald-400 font-bold tracking-wider uppercase text-xs">Planes VPS</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-white mt-2 mb-4">Elige el VPS ideal</h2>
                <p class="text-slate-400 text-lg">Precios competitivos. Si no sabes cuál, te lo recomendamos según tu caso.</p>
            </div>

            @php
                // Ajusta precios y specs a tu oferta real
                $vpsPlans = [
                    [
                        'name' => 'VPS Start',
                        'tag' => 'Ideal para web corporativa o proyecto pequeño',
                        'price' => 149000,
                        'featured' => false,
                        'specs' => [
                            '2 vCPU',
                            '4 GB RAM',
                            '60 GB NVMe',
                            '1 IPv4',
                            'Acceso root',
                        ],
                        'bestFor' => ['Web corporativa', 'Landing con tráfico', 'Paneles básicos'],
                    ],
                    [
                        'name' => 'VPS Pro',
                        'tag' => 'El más recomendado para tiendas y sistemas',
                        'price' => 249000,
                        'featured' => true,
                        'specs' => [
                            '4 vCPU',
                            '8 GB RAM',
                            '120 GB NVMe',
                            '1 IPv4',
                            'Acceso root',
                        ],
                        'bestFor' => ['E-commerce', 'APIs', 'Laravel/Node', 'Sistemas con usuarios'],
                    ],
                    [
                        'name' => 'VPS Power',
                        'tag' => 'Para alta demanda y cargas pesadas',
                        'price' => 399000,
                        'featured' => false,
                        'specs' => [
                            '8 vCPU',
                            '16 GB RAM',
                            '200 GB NVMe',
                            '1 IPv4',
                            'Acceso root',
                        ],
                        'bestFor' => ['Alta concurrencia', 'Microservicios', 'Bots/Procesos', 'SaaS'],
                    ],
                ];
            @endphp

            <div class="grid md:grid-cols-3 gap-8">
                @foreach($vpsPlans as $p)
                    @php
                        $isFeatured = $p['featured'];
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
                            <h3 class="text-xl font-bold text-white">{{ $p['name'] }}</h3>
                            <p class="text-xs text-slate-400 mt-1">{{ $p['tag'] }}</p>

                            <div class="flex items-baseline gap-2 mt-4">
                                <span class="text-3xl font-bold text-white">${{ number_format($p['price'], 0, ',', '.') }}</span>
                                <span class="text-sm text-slate-400">COP / mes</span>
                            </div>
                        </div>

                        <div class="space-y-2 mb-6">
                            @foreach($p['specs'] as $s)
                                <div class="flex items-center gap-2 text-sm text-slate-300">
                                    <span class="text-emerald-400 font-bold">✓</span> <span>{{ $s }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="rounded-xl border border-slate-800 bg-slate-900/30 p-4 mb-6">
                            <div class="text-[11px] text-slate-500 uppercase tracking-widest mb-2">Recomendado para</div>
                            <div class="flex flex-wrap gap-2">
                                @foreach($p['bestFor'] as $bf)
                                    <span class="text-[11px] px-3 py-1 rounded-full bg-slate-800 border border-slate-700 text-slate-200">
                                        {{ $bf }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <button type="button"
                                onclick="openWhatsAppPlan('{{ $p['name'] }}', '{{ number_format($p['price'], 0, ',', '.') }}')"
                                class="w-full py-3 px-4 rounded-xl text-sm font-bold transition-all duration-200 {{ $btnClass }}">
                            Quiero este VPS
                        </button>

                        <button type="button"
                                onclick="openWhatsAppGeneral('Quiero configuración administrada para {{ $p['name'] }}')"
                                class="mt-3 w-full py-3 px-4 rounded-xl text-sm font-bold bg-slate-800 text-white hover:bg-slate-700 transition">
                            Configuración administrada
                        </button>

                        <p class="mt-4 text-[11px] text-slate-500">
                            *Podemos instalar: cPanel/CloudLinux, Plesk, Nginx, Docker, Node, Laravel, SSL, etc. (según alcance).
                        </p>
                    </div>
                @endforeach
            </div>

            {{-- BLOQUE: SERVICIOS OPCIONALES --}}
            <div class="mt-14 glass rounded-2xl p-8 border border-slate-800">
                <div class="grid md:grid-cols-3 gap-6">
                    <div>
                        <div class="text-xs text-slate-500 uppercase tracking-widest mb-2">Incluye</div>
                        <ul class="text-sm text-slate-300 space-y-2">
                            <li class="flex gap-2"><span class="text-emerald-400 font-bold">✓</span> Acceso root</li>
                            <li class="flex gap-2"><span class="text-emerald-400 font-bold">✓</span> NVMe rápido</li>
                            <li class="flex gap-2"><span class="text-emerald-400 font-bold">✓</span> IP dedicada</li>
                        </ul>
                    </div>
                    <div>
                        <div class="text-xs text-slate-500 uppercase tracking-widest mb-2">Opcional</div>
                        <ul class="text-sm text-slate-300 space-y-2">
                            <li class="flex gap-2"><span class="text-emerald-400 font-bold">✓</span> Instalación cPanel / Plesk</li>
                            <li class="flex gap-2"><span class="text-emerald-400 font-bold">✓</span> Hardening + Firewall</li>
                            <li class="flex gap-2"><span class="text-emerald-400 font-bold">✓</span> Backups y monitoreo</li>
                        </ul>
                    </div>
                    <div>
                        <div class="text-xs text-slate-500 uppercase tracking-widest mb-2">Soporte</div>
                        <ul class="text-sm text-slate-300 space-y-2">
                            <li class="flex gap-2"><span class="text-emerald-400 font-bold">✓</span> Guía de uso</li>
                            <li class="flex gap-2"><span class="text-emerald-400 font-bold">✓</span> Optimización base</li>
                            <li class="flex gap-2"><span class="text-emerald-400 font-bold">✓</span> Recomendación de stack</li>
                        </ul>
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
                    ¿Quieres que te lo dejemos listo?
                </h2>
                <p class="text-slate-400 mb-8 max-w-2xl mx-auto relative z-10">
                    Si me dices qué vas a montar (WordPress, Laravel, tienda, sistema), te recomiendo el VPS y la configuración ideal.
                </p>

                <div class="flex flex-col sm:flex-row justify-center gap-4 relative z-10">
                    <a href="{{ route('hosting') }}"
                       class="px-8 py-4 rounded-xl bg-slate-800 text-white hover:bg-slate-700 transition">
                        Ver hosting
                    </a>
                    <button type="button"
                            onclick="openWhatsAppGeneral('Quiero un VPS recomendado según mi proyecto')"
                            class="px-8 py-4 rounded-xl bg-emerald-500 text-slate-900 font-bold hover:bg-emerald-400 transition">
                        Hablar por WhatsApp
                    </button>
                </div>

                <p class="mt-6 text-[11px] text-slate-500">
                    Respuesta rápida • Recomendación clara • Soporte real
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

        function openWhatsAppPlan(plan, price){
            const text = `Hola Linea365, quiero el plan ${plan} por $${price} COP/mes. Mi proyecto es: _____. ¿Me recomiendas configuración?`;
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
