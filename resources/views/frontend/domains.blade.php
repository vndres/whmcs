@extends('layouts.frontend')

@section('title', 'Dominios en Colombia - Linea365 | Registra tu Dominio Hoy')

@section('seo')
    <meta name="description" content="Compra y registra dominios .com, .com.co, .co y más. Búsqueda rápida, precios competitivos y activación profesional con Linea365.">
    <link rel="canonical" href="{{ url()->current() }}">
@endsection

@section('content')

    {{-- HERO + BUSCADOR --}}
    <section class="relative pt-16 pb-16 sm:pt-24 sm:pb-20 overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-16 left-10 w-72 h-72 bg-emerald-500/10 rounded-full blur-[110px]"></div>
            <div class="absolute bottom-16 right-10 w-96 h-96 bg-blue-600/10 rounded-full blur-[120px]"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-4xl mx-auto">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-800/50 border border-slate-700 backdrop-blur-sm mb-6">
                    <span class="flex h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-xs font-medium text-slate-300">Búsqueda instantánea + precios claros</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white tracking-tight leading-tight">
                    Encuentra el
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-cyan-400">dominio perfecto</span>
                    para tu marca
                </h1>

                <p class="mt-5 text-lg text-slate-400 leading-relaxed">
                    Registra tu dominio y deja tu presencia lista para vender. Te ayudamos con DNS, SSL y publicación si lo necesitas.
                </p>

                {{-- BUSCADOR --}}
                <div class="max-w-3xl mx-auto mt-10">
                    <div class="glass p-2 rounded-2xl border border-slate-700/50 shadow-2xl shadow-emerald-900/20">
                        <div class="flex flex-col sm:flex-row gap-2">
                            <div class="flex-1 relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <span class="text-xl">🔍</span>
                                </div>
                                <input type="text" id="domainName"
                                       class="block w-full pl-12 pr-4 py-4 bg-transparent border-none text-white placeholder-slate-500 focus:ring-0 text-lg"
                                       placeholder="Escribe el nombre (ej: miempresa)"
                                       onkeydown="if(event.key === 'Enter') checkDomain()">
                            </div>

                            <div class="sm:w-44">
                                <select id="domainTld"
                                        class="w-full px-4 py-4 rounded-xl bg-slate-900/40 border border-slate-700 text-slate-100 focus:outline-none focus:ring-0">
                                    <option value=".com">.com</option>
                                    <option value=".co">.co</option>
                                    <option value=".com.co">.com.co</option>
                                    <option value=".net">.net</option>
                                    <option value=".org">.org</option>
                                </select>
                            </div>

                            <button onclick="checkDomain()"
                                    class="bg-emerald-500 hover:bg-emerald-400 text-slate-900 font-bold px-8 py-4 rounded-xl transition flex items-center justify-center gap-2 min-w-[160px]">
                                <span id="btnText">Buscar</span>
                                <span id="btnLoader" class="hidden animate-spin h-5 w-5 border-2 border-slate-900 border-t-transparent rounded-full"></span>
                            </button>
                        </div>
                    </div>

                    <div id="domainResult"
                         class="hidden mt-4 mx-auto max-w-3xl glass rounded-xl border border-slate-700 p-4 text-left">
                        {{-- JS Result --}}
                    </div>

                    <div class="mt-6 grid sm:grid-cols-3 gap-3 text-left">
                        <div class="rounded-xl border border-slate-800 bg-slate-900/30 p-4">
                            <div class="text-xs text-slate-500 mb-1">Recomendación</div>
                            <div class="text-sm text-slate-200 font-semibold">Asegura .com y .co si tu marca es seria</div>
                        </div>
                        <div class="rounded-xl border border-slate-800 bg-slate-900/30 p-4">
                            <div class="text-xs text-slate-500 mb-1">Tiempo</div>
                            <div class="text-sm text-slate-200 font-semibold">Activación rápida + guía DNS</div>
                        </div>
                        <div class="rounded-xl border border-slate-800 bg-slate-900/30 p-4">
                            <div class="text-xs text-slate-500 mb-1">Extra</div>
                            <div class="text-sm text-slate-200 font-semibold">Te ayudamos a conectar hosting/SSL</div>
                        </div>
                    </div>

                    <div class="pt-8 border-t border-slate-800/50 mt-10">
                        <p class="text-xs text-slate-500 uppercase tracking-widest mb-4">Extensiones populares</p>
                        <div class="flex flex-wrap justify-center gap-6 grayscale opacity-60">
                            <span class="text-lg font-bold text-slate-400">.com</span>
                            <span class="text-lg font-bold text-slate-400">.co</span>
                            <span class="text-lg font-bold text-slate-400">.com.co</span>
                            <span class="text-lg font-bold text-slate-400">.net</span>
                            <span class="text-lg font-bold text-slate-400">.org</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN: BENEFICIOS --}}
    <section class="py-20 bg-slate-900/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <h2 class="text-3xl sm:text-4xl font-bold text-white">¿Por qué tu dominio importa?</h2>
                <p class="mt-3 text-slate-400">Un buen dominio aumenta confianza, clics y recordación de marca.</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="glass p-6 rounded-2xl border border-slate-800">
                    <div class="text-2xl mb-3">🏷️</div>
                    <h4 class="text-white font-bold mb-2">Marca profesional</h4>
                    <p class="text-sm text-slate-400">Tu negocio se ve serio y confiable desde el primer contacto.</p>
                </div>
                <div class="glass p-6 rounded-2xl border border-slate-800">
                    <div class="text-2xl mb-3">📈</div>
                    <h4 class="text-white font-bold mb-2">Mejor conversión</h4>
                    <p class="text-sm text-slate-400">Dominios cortos y claros aumentan clics y contactos.</p>
                </div>
                <div class="glass p-6 rounded-2xl border border-slate-800">
                    <div class="text-2xl mb-3">🔒</div>
                    <h4 class="text-white font-bold mb-2">Seguridad</h4>
                    <p class="text-sm text-slate-400">Base para SSL y correos corporativos confiables.</p>
                </div>
                <div class="glass p-6 rounded-2xl border border-slate-800">
                    <div class="text-2xl mb-3">⚙️</div>
                    <h4 class="text-white font-bold mb-2">Control</h4>
                    <p class="text-sm text-slate-400">Tú mandas en DNS y configuración, sin depender de terceros.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="pb-20">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass rounded-3xl p-8 sm:p-12 border border-slate-800 text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-[80px] pointer-events-none"></div>

                <h2 class="text-2xl sm:text-3xl font-bold text-white mb-3 relative z-10">
                    ¿No sabes cuál dominio elegir?
                </h2>
                <p class="text-slate-400 mb-8 max-w-2xl mx-auto relative z-10">
                    Te recomendamos opciones disponibles y te decimos cuál conviene para tu negocio.
                </p>

                <div class="flex flex-col sm:flex-row justify-center gap-4 relative z-10">
                    <a href="{{ route('hosting') }}"
                       class="px-8 py-4 rounded-xl bg-slate-800 text-white hover:bg-slate-700 transition">
                        Ver hosting
                    </a>
                    <button type="button"
                            onclick="openWhatsAppGeneral('Quiero ayuda eligiendo un dominio')"
                            class="px-8 py-4 rounded-xl bg-emerald-500 text-slate-900 font-bold hover:bg-emerald-400 transition">
                        Hablar por WhatsApp
                    </button>
                </div>

                <p class="mt-6 text-[11px] text-slate-500">
                    Respuesta rápida • Recomendación clara • Activación profesional
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

        async function checkDomain(){
            const name = document.getElementById('domainName').value.trim().toLowerCase();
            const tld  = document.getElementById('domainTld').value;
            const domain = name ? (name + tld) : '';

            const btnText = document.getElementById('btnText');
            const btnLoader = document.getElementById('btnLoader');
            const resultBox = document.getElementById('domainResult');

            if(!name){
                alert('Escribe un nombre de dominio.');
                return;
            }

            btnText.classList.add('hidden');
            btnLoader.classList.remove('hidden');
            resultBox.classList.add('hidden');
            resultBox.innerHTML = '';

            try{
                const response = await fetch('{{ route('domain.check') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ domain })
                });

                const data = await response.json();
                resultBox.classList.remove('hidden');

                if(data.status === 'available'){
                    resultBox.innerHTML = `
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div>
                                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                    <span class="text-emerald-400">✓</span> ${data.domain}
                                </h3>
                                <p class="text-emerald-300 text-sm">¡Dominio disponible!</p>
                                <p class="text-xs text-slate-500 mt-2">Recomendación: registra también variantes (.co / .com) si tu marca es fuerte.</p>
                            </div>

                            <div class="text-right">
                                <div class="text-2xl font-bold text-white">$${data.price}</div>
                                <div class="text-xs text-slate-500">Precio estimado</div>

                                <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
                                    @csrf
                                    <input type="hidden" name="domain" value="${data.domain}">
                                    <input type="hidden" name="domain_price" value="${data.price}">
                                    <button type="submit"
                                            class="text-xs bg-emerald-500 text-slate-900 px-5 py-3 rounded-xl font-bold hover:bg-emerald-400 transition">
                                        Registrar dominio
                                    </button>
                                </form>
                            </div>
                        </div>
                    `;
                } else if(data.status === 'taken'){
                    resultBox.innerHTML = `
                        <div class="flex items-start gap-3 text-rose-300">
                            <span class="text-xl">✕</span>
                            <div>
                                <h3 class="font-bold text-slate-200">${data.domain}</h3>
                                <p class="text-sm">${data.message ?? 'Este dominio no está disponible.'}</p>
                                <button type="button"
                                        onclick="openWhatsAppGeneral('Busco alternativas para el dominio: ${data.domain}')"
                                        class="mt-3 text-xs font-bold px-4 py-2 rounded-xl bg-slate-800 text-white hover:bg-slate-700 transition">
                                    Pedir alternativas por WhatsApp
                                </button>
                            </div>
                        </div>
                    `;
                } else {
                    resultBox.innerHTML = `
                        <div class="p-3 bg-rose-500/10 border border-rose-500/30 rounded-lg text-rose-300 text-sm flex items-center gap-3">
                            <span class="text-xl">⚠️</span>
                            <div>
                                <strong>Algo salió mal:</strong>
                                <p>${data.message ?? 'Error desconocido.'}</p>
                            </div>
                        </div>
                    `;
                }

            } catch(e){
                console.error(e);
                resultBox.classList.remove('hidden');
                resultBox.innerHTML = `<p class="text-rose-400 text-sm">Error de conexión. Revisa consola (F12).</p>`;
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
