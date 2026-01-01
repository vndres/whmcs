@extends('layouts.frontend')

@section('title', 'Promociones - Linea365 | Ofertas en Hosting, Dominios y Web')

@section('seo')
    <meta name="description" content="Promociones y combos en Linea365: hosting, dominios, VPS y páginas web con precios especiales. Aprovecha ofertas por tiempo limitado.">
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
                <span class="text-xs font-medium text-slate-300">Ofertas por tiempo limitado</span>
            </div>

            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white tracking-tight mb-5 leading-tight">
                Promociones que
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-cyan-400">sí valen la pena</span>
            </h1>

            <p class="text-lg text-slate-400 max-w-3xl mx-auto leading-relaxed">
                Ahorra en hosting, dominios, VPS y páginas web. Combos listos para que lances tu proyecto rápido,
                con soporte real y calidad premium.
            </p>

            <div class="mt-10 flex flex-col sm:flex-row gap-3 justify-center">
                <a href="#ofertas" class="px-8 py-4 rounded-xl bg-emerald-500 text-slate-900 font-bold hover:bg-emerald-400 transition">
                    Ver promociones
                </a>
                <button type="button"
                        onclick="openWhatsAppGeneral('Quiero aprovechar una promoción')"
                        class="px-8 py-4 rounded-xl bg-slate-800 text-white hover:bg-slate-700 transition">
                    Hablar por WhatsApp
                </button>
            </div>

            <div class="pt-10 border-t border-slate-800/50 mt-10">
                <p class="text-xs text-slate-500 uppercase tracking-widest mb-4">Incluye</p>
                <div class="flex flex-wrap justify-center gap-6 grayscale opacity-60">
                    <span class="text-lg font-bold text-slate-400">SSL</span>
                    <span class="text-lg font-bold text-slate-400">Optimización</span>
                    <span class="text-lg font-bold text-slate-400">Soporte</span>
                    <span class="text-lg font-bold text-slate-400">Asesoría</span>
                </div>
            </div>
        </div>
    </section>

    {{-- OFERTAS DESTACADAS --}}
    <section id="ofertas" class="py-20 bg-slate-900/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center max-w-3xl mx-auto mb-14">
                <h2 class="text-3xl font-bold text-white mb-4">Promociones destacadas</h2>
                <p class="text-slate-400">Elige la oferta ideal según tu necesidad. Si quieres algo a medida, te lo armamos por WhatsApp.</p>
            </div>

            @php
                // Ajusta precios / textos a tu estrategia comercial
                $deals = [
                    [
                        'title' => 'Combo Emprendedor',
                        'tag' => 'Para empezar rápido',
                        'price' => 'Desde $199.000',
                        'unit' => 'COP / mes',
                        'featured' => true,
                        'items' => [
                            'Hosting Linux optimizado',
                            'SSL gratis + correo corporativo',
                            'Asesoría para publicar tu web',
                            'Soporte en español',
                        ],
                        'cta' => 'Quiero este combo',
                    ],
                    [
                        'title' => 'Dominio + Hosting (Ahorro)',
                        'tag' => 'Ideal para tu marca',
                        'price' => 'Desde $159.000',
                        'unit' => 'COP / mes',
                        'featured' => false,
                        'items' => [
                            'Registro de dominio (según disponibilidad)',
                            'Hosting Linux rápido',
                            'SSL + DNS configurado',
                            'Panel cPanel (según plan)',
                        ],
                        'cta' => 'Cotizar dominio + hosting',
                    ],
                    [
                        'title' => 'Web + Hosting Listo',
                        'tag' => 'Te lo dejamos andando',
                        'price' => 'Desde $690.000',
                        'unit' => 'COP (único)',
                        'featured' => false,
                        'items' => [
                            'Landing Page profesional',
                            'WhatsApp + formulario',
                            'SEO base + rendimiento',
                            'Publicación (si tienes dominio/hosting)',
                        ],
                        'cta' => 'Quiero web + hosting',
                    ],
                ];
            @endphp

            <div class="grid md:grid-cols-3 gap-8">
                @foreach($deals as $d)
                    @php
                        $isFeatured = $d['featured'];
                        $cardClass = $isFeatured
                            ? 'border-emerald-500/50 bg-slate-800/60 shadow-2xl shadow-emerald-500/10'
                            : 'border-slate-800 bg-slate-900/40 hover:border-slate-600 hover:bg-slate-800/40';
                        $btnClass = $isFeatured
                            ? 'bg-emerald-500 text-slate-900 hover:bg-emerald-400'
                            : 'bg-slate-800 text-white hover:bg-slate-700';
                    @endphp

                    <div class="relative rounded-2xl p-6 border transition duration-300 {{ $cardClass }}">
                        @if($isFeatured)
                            <div class="absolute -top-3 left-1/2 -translate-x-1/2">
                                <span class="px-3 py-1 rounded-full bg-emerald-500 text-slate-900 text-xs font-bold shadow-lg shadow-emerald-500/20">
                                    Mejor oferta
                                </span>
                            </div>
                        @endif

                        <div class="mb-5">
                            <h3 class="text-xl font-bold text-white">{{ $d['title'] }}</h3>
                            <p class="text-xs text-slate-400 mt-1">{{ $d['tag'] }}</p>
                        </div>

                        <div class="mb-6">
                            <div class="flex items-end gap-2">
                                <div class="text-3xl font-bold text-white">{{ $d['price'] }}</div>
                            </div>
                            <div class="text-xs text-slate-500">{{ $d['unit'] }}</div>
                        </div>

                        <ul class="text-sm text-slate-300 space-y-2 mb-6">
                            @foreach($d['items'] as $it)
                                <li class="flex gap-2">
                                    <span class="text-emerald-400 font-bold">✓</span>
                                    <span>{{ $it }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <button type="button"
                                onclick="openWhatsAppGeneral('{{ $d['cta'] }}')"
                                class="w-full py-3 px-4 rounded-xl text-sm font-bold transition {{ $btnClass }}">
                            {{ $d['cta'] }}
                        </button>

                        <p class="mt-4 text-[11px] text-slate-500">
                            *Sujeto a disponibilidad / alcance. Te confirmamos por WhatsApp.
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CUPONES --}}
    <section id="cupones" class="py-20 relative overflow-hidden">
        <div class="absolute top-1/2 left-0 w-full h-px bg-gradient-to-r from-transparent via-slate-800 to-transparent"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <h2 class="text-3xl font-bold text-white mb-4">Cupones y beneficios</h2>
                <p class="text-slate-400">Para campañas, lanzamientos o clientes que quieren migrar su web.</p>
            </div>

            <div class="grid lg:grid-cols-3 gap-6">
                <div class="glass p-6 rounded-2xl border border-slate-800">
                    <div class="text-2xl mb-3">🎁</div>
                    <h3 class="text-white font-bold mb-2">CUPÓN: LINEA365</h3>
                    <p class="text-sm text-slate-400">Descuento aplicable (según plan) al contratar hosting anual.</p>
                    <div class="mt-4 rounded-xl border border-slate-800 bg-slate-900/30 p-4 text-sm text-slate-300">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400">Código</span>
                            <span class="font-bold text-slate-200">LINEA365</span>
                        </div>
                        <div class="mt-2 text-xs text-slate-500">*Validez: confirmar por WhatsApp</div>
                    </div>
                    <button type="button"
                            onclick="openWhatsAppGeneral('Quiero usar el cupón LINEA365')"
                            class="mt-4 w-full py-3 px-4 rounded-xl text-sm font-bold bg-slate-800 text-white hover:bg-slate-700 transition">
                        Activar cupón
                    </button>
                </div>

                <div class="glass p-6 rounded-2xl border border-slate-800">
                    <div class="text-2xl mb-3">🚚</div>
                    <h3 class="text-white font-bold mb-2">Migración (según caso)</h3>
                    <p class="text-sm text-slate-400">Si vienes de otro proveedor, te ayudamos a migrar (según el plan).</p>
                    <ul class="mt-4 text-sm text-slate-300 space-y-2">
                        <li class="flex gap-2"><span class="text-emerald-400 font-bold">✓</span> WordPress / sitios simples</li>
                        <li class="flex gap-2"><span class="text-emerald-400 font-bold">✓</span> Correos (según proveedor)</li>
                        <li class="flex gap-2"><span class="text-emerald-400 font-bold">✓</span> Ajustes DNS / SSL</li>
                    </ul>
                    <button type="button"
                            onclick="openWhatsAppGeneral('Quiero migrar mi web a Linea365')"
                            class="mt-4 w-full py-3 px-4 rounded-xl text-sm font-bold bg-emerald-500 text-slate-900 hover:bg-emerald-400 transition">
                        Cotizar migración
                    </button>
                </div>

                <div class="glass p-6 rounded-2xl border border-slate-800">
                    <div class="text-2xl mb-3">⚡</div>
                    <h3 class="text-white font-bold mb-2">Entrega prioritaria</h3>
                    <p class="text-sm text-slate-400">Si necesitas tu web “para ya”, podemos priorizar tu entrega.</p>
                    <div class="mt-4 rounded-xl border border-slate-800 bg-slate-900/30 p-4 text-sm text-slate-300">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400">Modalidad</span>
                            <span class="font-semibold text-slate-200">Prioritaria</span>
                        </div>
                        <div class="mt-2 text-xs text-slate-500">*Depende del alcance y agenda</div>
                    </div>
                    <button type="button"
                            onclick="openWhatsAppGeneral('Quiero entrega prioritaria')"
                            class="mt-4 w-full py-3 px-4 rounded-xl text-sm font-bold bg-slate-800 text-white hover:bg-slate-700 transition">
                        Consultar prioridad
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
                    ¿Quieres que te armemos el mejor combo?
                </h2>
                <p class="text-slate-400 mb-8 max-w-2xl mx-auto relative z-10">
                    Dinos tu presupuesto y tu meta (vender, posicionar, recibir contactos) y te proponemos la mejor opción.
                </p>

                <div class="flex flex-col sm:flex-row justify-center gap-4 relative z-10">
                    <a href="{{ route('home') }}"
                       class="px-8 py-4 rounded-xl bg-slate-800 text-white hover:bg-slate-700 transition">
                        Volver al inicio
                    </a>
                    <button type="button"
                            onclick="openWhatsAppGeneral('Quiero un combo personalizado')"
                            class="px-8 py-4 rounded-xl bg-emerald-500 text-slate-900 font-bold hover:bg-emerald-400 transition">
                        Hablar por WhatsApp
                    </button>
                </div>

                <p class="mt-6 text-[11px] text-slate-500">
                    Promos limitadas • Asesoría real • Soporte en español
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
    </script>

    <style>
        .glass {
            background: rgba(15, 23, 42, 0.35);
            backdrop-filter: blur(10px);
        }
    </style>

@endsection
