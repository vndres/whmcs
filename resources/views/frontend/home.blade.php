@extends('layouts.frontend')

@section('title', 'Linea365 - Hosting y Dominios Premium')

@section('seo')
    <meta name="description" content="Hosting de alta velocidad, dominios y servidores VPS. Soporte 24/7 en español.">
    <link rel="canonical" href="{{ url()->current() }}">
@endsection

@section('content')
    {{-- SECCIÓN 1: HERO + BUSCADOR --}}
    <section class="relative pt-16 pb-20 sm:pt-24 sm:pb-32 overflow-hidden">
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full z-0 pointer-events-none">
            <div class="absolute top-20 left-10 w-72 h-72 bg-emerald-500/10 rounded-full blur-[100px]"></div>
            <div class="absolute bottom-20 right-10 w-96 h-96 bg-blue-600/10 rounded-full blur-[100px]"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            
            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-slate-800/50 border border-slate-700 backdrop-blur-sm mb-8 animate-fade-in-up">
                <span class="flex h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="text-xs font-medium text-slate-300">Infraestructura lista para producción</span>
            </div>

            {{-- Título --}}
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white tracking-tight mb-6 max-w-4xl mx-auto leading-tight">
                Construye tu presencia digital con <br class="hidden sm:block" />
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-cyan-400">Hosting y Dominios de Calidad</span>
            </h1>

            <p class="text-lg text-slate-400 mb-10 max-w-2xl mx-auto leading-relaxed">
                Todo lo que necesitas para lanzar tu sitio web: dominio propio, hosting veloz, correos corporativos y soporte 24/7 en español.
            </p>

            {{-- BUSCADOR --}}
            <div class="max-w-3xl mx-auto mb-16">
                <div class="glass p-2 rounded-2xl border border-slate-700/50 shadow-2xl shadow-emerald-900/20 transform hover:scale-[1.01] transition duration-300">
                    <div class="flex flex-col sm:flex-row gap-2">
                        <div class="flex-1 relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-xl">🔍</span>
                            </div>
                            <input type="text" id="domainInput" 
                                   class="block w-full pl-12 pr-4 py-4 bg-transparent border-none text-white placeholder-slate-500 focus:ring-0 text-lg" 
                                   placeholder="Encuentra tu dominio ideal (ej: miempresa.com)..."
                                   onkeydown="if(event.key === 'Enter') checkDomain()">
                        </div>
                        <button onclick="checkDomain()" 
                                class="bg-emerald-500 hover:bg-emerald-400 text-slate-900 font-bold px-8 py-4 rounded-xl transition flex items-center justify-center gap-2 min-w-[160px]">
                            <span id="btnText">Buscar</span>
                            <span id="btnLoader" class="hidden animate-spin h-5 w-5 border-2 border-slate-900 border-t-transparent rounded-full"></span>
                        </button>
                    </div>
                </div>

                <div id="domainResult" class="hidden mt-4 mx-auto max-w-2xl glass rounded-xl border border-slate-700 p-4 text-left animate-fade-in-up">
                    {{-- JS Result --}}
                </div>
            </div>

            {{-- Logos --}}
            <div class="pt-8 border-t border-slate-800/50">
                <p class="text-xs text-slate-500 uppercase tracking-widest mb-4">Tecnología de confianza</p>
                <div class="flex justify-center gap-8 grayscale opacity-50">
                    <span class="text-xl font-bold text-slate-400">cPanel</span>
                    <span class="text-xl font-bold text-slate-400">CloudLinux</span>
                    <span class="text-xl font-bold text-slate-400">Softaculous</span>
                </div>
            </div>
        </div>
    </section>

    {{-- SECCIÓN 2: PLANES --}}
    <section id="planes" class="py-20 bg-slate-900/30 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl font-bold text-white mb-4">Planes diseñados para crecer</h2>
                <p class="text-slate-400">Elige el plan perfecto para tu proyecto. Todos incluyen SSL gratis y cPanel.</p>
            </div>

            @if($products->isEmpty())
                <div class="glass rounded-2xl p-10 text-center border border-slate-800">
                    <p class="text-slate-400 text-lg">No hay planes activos disponibles por el momento.</p>
                </div>
            @else
                <div class="grid md:grid-cols-3 gap-8">
                    @foreach($products as $product)
                        @php
                            $isFeatured = ($products->count() == 3 && $loop->iteration == 2);
                            $cardClass = $isFeatured 
                                ? 'border-emerald-500/50 bg-slate-800/60 scale-105 shadow-2xl shadow-emerald-500/10 z-10' 
                                : 'border-slate-800 bg-slate-900/40 hover:border-slate-600 hover:bg-slate-800/40';
                            
                            // CORRECCIÓN: Definimos btnClass aquí
                            $btnClass = $isFeatured 
                                ? 'bg-emerald-500 text-slate-900 hover:bg-emerald-400 hover:shadow-lg' 
                                : 'bg-slate-700 text-white hover:bg-slate-600';
                        @endphp

                        <div class="rounded-2xl p-6 flex flex-col border transition duration-300 {{ $cardClass }}">
                            @if($isFeatured)
                                <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2">
                                    <span class="px-3 py-1 rounded-full bg-emerald-500 text-slate-900 text-xs font-bold shadow-lg shadow-emerald-500/20">
                                        Más Popular
                                    </span>
                                </div>
                            @endif

                            <div class="mb-6">
                                <h3 class="text-lg font-semibold text-white mb-2">{{ $product->name }}</h3>
                                <div class="flex items-baseline gap-1">
                                    <span class="text-3xl font-bold text-white">${{ number_format($product->price_monthly, 2) }}</span>
                                    <span class="text-sm text-slate-400">/mes</span>
                                </div>
                                <p class="text-xs text-slate-500 mt-2 min-h-[40px]">
                                    {{ Str::limit(strip_tags($product->description), 60) }}
                                </p>
                            </div>

                            <div class="flex-1 space-y-3 mb-8">
                                <div class="prose prose-invert prose-sm text-slate-300 text-xs feature-list">
                                    {!! $product->description !!}
                                </div>
                            </div>

                            <form action="{{ route('cart.add') }}" method="POST" class="mt-auto">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" 
                                        class="w-full py-3 px-4 rounded-xl text-sm font-bold transition-all duration-200 {{ $btnClass }}">
                                    {{ $isFeatured ? 'Elegir Plan' : 'Comprar Ahora' }}
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    {{-- SECCIÓN 3: CARACTERÍSTICAS TÉCNICAS (REDISENADA) --}}
    <section id="caracteristicas" class="py-20 relative overflow-hidden">
        {{-- Fondo decorativo sutil --}}
        <div class="absolute top-1/2 left-0 w-full h-px bg-gradient-to-r from-transparent via-slate-800 to-transparent"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-emerald-400 font-bold tracking-wider uppercase text-xs">Potencia sin límites</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-white mt-2 mb-4">
                    Todo lo que un Hosting Premium debe tener
                </h2>
                <p class="text-slate-400 text-lg">
                    No solo te damos espacio en un servidor. Te damos una plataforma optimizada para que tu negocio vuele.
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                {{-- Feature 1: cPanel --}}
                <div class="glass p-6 rounded-2xl border border-slate-800 hover:border-slate-600 transition group">
                    <div class="h-12 w-12 rounded-xl bg-orange-500/10 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                        ⚙️
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Panel de Control cPanel®</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        El estándar mundial de la industria. Administra tus archivos, correos, bases de datos y dominios desde una interfaz gráfica, intuitiva y en español.
                    </p>
                </div>

                {{-- Feature 2: NVMe --}}
                <div class="glass p-6 rounded-2xl border border-slate-800 hover:border-slate-600 transition group">
                    <div class="h-12 w-12 rounded-xl bg-blue-500/10 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                        🚀
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Discos NVMe SSD</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Olvídate de los discos lentos. Nuestra infraestructura NVMe es hasta <span class="text-white font-semibold">20 veces más rápida</span> que los SSD tradicionales. Tu web cargará al instante.
                    </p>
                </div>

                {{-- Feature 3: LiteSpeed --}}
                <div class="glass p-6 rounded-2xl border border-slate-800 hover:border-slate-600 transition group">
                    <div class="h-12 w-12 rounded-xl bg-purple-500/10 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                        ⚡
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Servidor LiteSpeed + LSCache</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Usamos el servidor web más rápido del mercado. Incluye caché a nivel de servidor para WordPress, haciendo que tu sitio vuele sin configurar nada.
                    </p>
                </div>

                {{-- Feature 4: Softaculous --}}
                <div class="glass p-6 rounded-2xl border border-slate-800 hover:border-slate-600 transition group">
                    <div class="h-12 w-12 rounded-xl bg-pink-500/10 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                        📦
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Instalador en 1 Clic</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        ¿Necesitas WordPress, Joomla o PrestaShop? Con Softaculous puedes instalar más de 400 aplicaciones en segundos, sin tocar código.
                    </p>
                </div>

                {{-- Feature 5: Seguridad --}}
                <div class="glass p-6 rounded-2xl border border-slate-800 hover:border-slate-600 transition group">
                    <div class="h-12 w-12 rounded-xl bg-emerald-500/10 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                        🛡️
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Imunify360 Blindado</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Duerme tranquilo. Nuestro Firewall con Inteligencia Artificial bloquea ataques y elimina malware automáticamente antes de que afecten tu sitio.
                    </p>
                </div>

                {{-- Feature 6: Backup --}}
                <div class="glass p-6 rounded-2xl border border-slate-800 hover:border-slate-600 transition group">
                    <div class="h-12 w-12 rounded-xl bg-cyan-500/10 flex items-center justify-center text-2xl mb-4 group-hover:scale-110 transition">
                        🔄
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Copias de Seguridad Diarias</h3>
                    <p class="text-sm text-slate-400 leading-relaxed">
                        Tus datos son sagrados. Realizamos copias automáticas diarias (JetBackup) para que puedas restaurar archivos o bases de datos si algo sale mal.
                    </p>
                </div>

            </div>
            
          {{-- Barra inferior de logos de tecnologías --}}
            <div class="mt-16 pt-8 border-t border-slate-800 flex flex-wrap justify-center items-center gap-8 md:gap-16 opacity-60 grayscale hover:grayscale-0 transition duration-500">
                
                {{-- WordPress --}}
                <div class="flex items-center gap-2 group hover:text-[#21759b] transition">
                    <svg class="h-8 w-8" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12.04 0C5.4 0 .04 5.36.04 12S5.4 24 12.04 24c6.64 0 12-5.36 12-12S18.68 0 12.04 0zm0 1.64c2.4 0 4.6 1.04 6.2 2.68l-8.6 11.72L5.4 6.48c1.64-1.64 3.84-2.68 6.24-2.68h.4zm-7.92 3.84l4.24 11.56L3.96 7.6c.04-.64.08-1.28.16-2.12zm3.32 12.08L4.32 9.4c-.08.64-.12 1.32-.12 2 0 3.32 2.08 6.16 5 7.4l-1.76-1.24zm4.6-2.28l-2.68 7.36c-.28.08-.56.12-.88.12-1.92 0-3.64-.84-4.84-2.16l8.4-12.72v7.4zm1.96-7.4v6.6l2.84-7.96c.08-.24.12-.48.12-.76 0-2.36-1.16-4.44-2.96-5.8z"/>
                    </svg>
                    <span class="text-lg font-bold text-slate-300 group-hover:text-[#21759b]">WordPress</span>
                </div>

                {{-- cPanel --}}
                <div class="flex items-center gap-2 group hover:text-[#FF6C2C] transition">
                    <svg class="h-9 w-9" viewBox="0 0 64 64" fill="currentColor">
                        <path d="M32 2C15.432 2 2 15.432 2 32s13.432 30 30 30 30-13.432 30-30S48.568 2 32 2zm15.4 41.2H27.8c-1.7 0-3-1.3-3-3V20.8c0-1.7 1.3-3 3-3h21.6c1.7 0 3 1.3 3 3v19.4c0 1.7-1.3 3-3 3z" opacity="0.2"/>
                        <path d="M19.5 22h25v20h-25z" fill="currentColor"/> 
                        <path d="M19.5 22h8v8h-8zM36.5 22h8v8h-8zM19.5 34h8v8h-8z" fill="#FFF" fill-opacity="0.3"/>
                    </svg>
                    <span class="text-xl font-bold text-slate-300 group-hover:text-[#FF6C2C]">cPanel</span>
                </div>

                {{-- LiteSpeed --}}
                <div class="flex items-center gap-2 group hover:text-blue-400 transition">
                    <svg class="h-8 w-8" viewBox="0 0 32 32" fill="currentColor">
                        <path d="M16 2L4 14h10v16l12-12H16z"/>
                    </svg>
                    <span class="text-lg font-bold text-slate-300 group-hover:text-blue-400">LiteSpeed</span>
                </div>

                {{-- CloudLinux --}}
                <div class="flex items-center gap-2 group hover:text-[#2c77ba] transition">
                    <svg class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
                    </svg>
                    <span class="text-lg font-bold text-slate-300 group-hover:text-[#2c77ba]">CloudLinux</span>
                </div>

            </div>
    </section>

    {{-- SECCIÓN 4: CTA --}}
    <section class="pb-20">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass rounded-3xl p-8 sm:p-12 border border-slate-800 text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-[80px] pointer-events-none"></div>
                <h2 class="text-2xl sm:text-3xl font-bold text-white mb-4 relative z-10">¿Tienes dudas?</h2>
                <div class="flex justify-center gap-4 relative z-10">
                    <a href="#" class="px-6 py-3 rounded-xl bg-slate-800 text-white hover:bg-slate-700 transition">Contactar</a>
                    <a href="{{ route('login') }}" class="px-6 py-3 rounded-xl bg-emerald-500 text-slate-900 font-bold hover:bg-emerald-400 transition">Area Cliente</a>
                </div>
            </div>
        </div>
    </section>

    {{-- SCRIPT --}}
    <script>
        async function checkDomain() {
            const domainInput = document.getElementById('domainInput');
            const domain = domainInput.value.trim(); // Limpiamos espacios
            const btnText = document.getElementById('btnText');
            const btnLoader = document.getElementById('btnLoader');
            const resultBox = document.getElementById('domainResult');

            if (!domain) {
                alert("Por favor escribe un dominio.");
                return;
            }

            // UI Loading
            btnText.classList.add('hidden');
            btnLoader.classList.remove('hidden');
            resultBox.classList.add('hidden');
            resultBox.innerHTML = ''; // Limpiar resultados anteriores

            try {
                const response = await fetch('{{ route('domain.check') }}', {
                    method: 'POST',
                    headers: { 
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                    },
                    body: JSON.stringify({ domain: domain })
                });
                
                const data = await response.json();
                resultBox.classList.remove('hidden');
                
                if (data.status === 'available') {
                    // DOMINIO DISPONIBLE
                    resultBox.innerHTML = `
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-white flex items-center gap-2">
                                    <span class="text-emerald-400">✓</span> ${data.domain}
                                </h3>
                                <p class="text-emerald-400 text-sm">¡Dominio disponible!</p>
                            </div>
                            <div class="text-right">
                                <div class="text-xl font-bold text-white">$${data.price}</div>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="domain" value="${data.domain}">
                                    <input type="hidden" name="domain_price" value="${data.price}">
                                    <button type="submit" class="mt-2 text-xs bg-emerald-500 text-slate-900 px-4 py-2 rounded-lg font-bold hover:bg-emerald-400 transition">
                                        Registrar
                                    </button>
                                </form>
                            </div>
                        </div>`;
                        
                } else if (data.status === 'taken') {
                    // DOMINIO OCUPADO
                    resultBox.innerHTML = `
                        <div class="flex items-center gap-3 text-rose-400">
                            <span class="text-xl">✕</span>
                            <div>
                                <h3 class="font-bold text-slate-200">${data.domain}</h3>
                                <p class="text-sm">${data.message}</p>
                            </div>
                        </div>`;
                        
                } else {
                    // ERROR DEL SERVIDOR (Aquí estaba el fallo de "undefined")
                    console.error("Error backend:", data);
                    resultBox.innerHTML = `
                        <div class="p-3 bg-rose-500/10 border border-rose-500/30 rounded-lg text-rose-300 text-sm flex items-center gap-3">
                            <span class="text-xl">⚠️</span>
                            <div>
                                <strong>Algo salió mal:</strong>
                                <p>${data.message}</p>
                            </div>
                        </div>`;
                }

            } catch (e) { 
                console.error(e);
                resultBox.innerHTML = '<p class="text-rose-400 text-sm">Error crítico de conexión (Revisa la consola con F12).</p>';
                resultBox.classList.remove('hidden');
            } 
            finally { 
                btnText.classList.remove('hidden'); 
                btnLoader.classList.add('hidden'); 
            }
        }
    </script>

    <style>
        .feature-list ul { padding-left: 0; list-style: none; }
        .feature-list li { position: relative; padding-left: 1.5rem; margin-bottom: 0.5rem; display: flex; }
        .feature-list li::before { content: '✓'; color: #34d399; position: absolute; left: 0; font-weight: bold; }
    </style>
@endsection