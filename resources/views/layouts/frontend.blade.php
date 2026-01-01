<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('seo')

    <title>@yield('title', 'Linea365 Clientes')</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700" rel="stylesheet" />

    {{-- TAILWIND CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        slate: {
                            50: '#f8fafc', 100: '#f1f5f9', 200: '#e2e8f0', 300: '#cbd5e1',
                            400: '#94a3b8', 500: '#64748b', 600: '#475569', 700: '#334155',
                            800: '#1e293b', 900: '#0f172a', 950: '#020617',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        body {
            background: radial-gradient(circle at top, #0f172a 0, #020617 55%, #000 100%);
            color: #e5e7eb;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .glass {
            background: rgba(15, 23, 42, 0.70);
            border: 1px solid rgba(148, 163, 184, 0.10);
            box-shadow: 0 8px 32px rgba(0,0,0,.37);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        /* Sidebar sólido: evita transparencia y “se ven letras de abajo” */
        .glass-solid {
            background: rgba(2, 6, 23, 0.96);
            border: 1px solid rgba(148, 163, 184, 0.12);
            box-shadow: 0 18px 50px rgba(0,0,0,.55);
            backdrop-filter: blur(18px);
            -webkit-backdrop-filter: blur(18px);
        }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    @stack('head')
</head>

<body class="antialiased">

{{-- ==============================================================
    HEADER SUPERIOR
============================================================== --}}
<header class="w-full border-b border-slate-800/60 bg-slate-950/80 sticky top-0 z-50 backdrop-blur-md h-16 flex-none">
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center justify-between gap-2 sm:gap-4">

        {{-- IZQUIERDA: HAMBURGUESA + LOGO --}}
        <div class="flex items-center gap-3 sm:gap-4 flex-none">
            @if(!request()->routeIs('admin.*'))
                <button type="button"
                        onclick="window.togglePrimarySidebar()"
                        class="lg:hidden p-2 text-slate-400 hover:text-white transition rounded-lg hover:bg-slate-800"
                        aria-label="Abrir menú">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            @endif

            <a href="{{ route('home') }}" class="flex items-center gap-2 sm:gap-3 group">
                <div class="h-9 w-9 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-700 flex items-center justify-center text-slate-950 font-black text-lg shadow-lg shadow-emerald-500/20 group-hover:scale-105 transition">L</div>
                <div>
                    <div class="text-sm font-bold tracking-wide text-slate-100 group-hover:text-emerald-400 transition">
                        Linea365
                    </div>
                    <div class="text-[10px] text-slate-400 uppercase tracking-widest hidden sm:block">Hosting & Cloud</div>
                </div>
            </a>
        </div>

        {{-- CENTRO: MENÚ DESKTOP (INVITADO / CLIENTE) --}}
        <nav class="hidden lg:flex items-center gap-6 text-sm font-medium text-slate-400 flex-1 min-w-0 justify-center">
            <div class="flex items-center gap-6 overflow-x-auto no-scrollbar whitespace-nowrap px-2">
                @guest
                    <a href="{{ route('home') }}" class="hover:text-emerald-400 transition">Inicio</a>
                    <a href="{{ route('hosting') }}" class="hover:text-emerald-400 transition">Hosting</a>
                    <a href="{{ route('dominios') }}" class="hover:text-emerald-400 transition">Dominios</a>
                    <a href="{{ route('vps') }}" class="hover:text-emerald-400 transition">VPS</a>
                    <a href="{{ route('paginas-web') }}" class="hover:text-emerald-400 transition">Páginas Web</a>
                    <a href="{{ route('promociones') }}" class="hover:text-emerald-400 transition">Promociones</a>
                    <a href="{{ route('portafolio') }}" class="hover:text-emerald-400 transition">Portafolio</a>
                    <a href="{{ route('contacto') }}" class="hover:text-emerald-400 transition">Contacto</a>
                @else
                    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'text-emerald-400 font-semibold' : 'hover:text-slate-200 transition' }}">Inicio</a>
                    <a href="{{ route('store.index') }}" class="{{ request()->routeIs('store.*') ? 'text-emerald-400 font-semibold' : 'hover:text-slate-200 transition' }}">Tienda</a>
                    <a href="{{ route('services.index') }}" class="{{ request()->routeIs('services.*') ? 'text-emerald-400 font-semibold' : 'hover:text-slate-200 transition' }}">Servicios</a>
                    <a href="{{ route('domains.index') }}" class="{{ request()->routeIs('domains.*') ? 'text-emerald-400 font-semibold' : 'hover:text-slate-200 transition' }}">Dominios</a>
                    <a href="{{ route('invoices.index') }}" class="{{ request()->routeIs('invoices.*') ? 'text-emerald-400 font-semibold' : 'hover:text-slate-200 transition' }}">Facturas</a>
                    <a href="{{ route('tickets.index') }}" class="{{ request()->routeIs('tickets.*') ? 'text-emerald-400 font-semibold' : 'hover:text-slate-200 transition' }}">Tickets</a>
                @endguest
            </div>
        </nav>

        {{-- DERECHA --}}
        <div class="flex items-center gap-2 sm:gap-3 flex-none">
            @guest
                {{-- ICONOS EN MÓVIL (login / register) --}}
                <a href="{{ route('login') }}"
                   class="lg:hidden p-2 text-slate-300 hover:text-white transition rounded-lg hover:bg-slate-800/50"
                   title="Ingresar" aria-label="Ingresar">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                </a>

                <a href="{{ route('register') }}"
                   class="lg:hidden p-2 bg-emerald-500 hover:bg-emerald-400 text-slate-900 rounded-xl transition shadow-lg shadow-emerald-500/20 font-bold flex items-center justify-center"
                   title="Comenzar" aria-label="Comenzar">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 4v16m8-8H4" />
                    </svg>
                </a>

                {{-- Botones DESKTOP --}}
                <a href="{{ route('login') }}"
                   class="hidden lg:inline-flex px-4 py-2 rounded-xl bg-slate-800 text-white hover:bg-slate-700 transition text-sm font-bold">
                    Ingresar
                </a>
                <a href="{{ route('register') }}"
                   class="hidden lg:inline-flex px-4 py-2 rounded-xl bg-emerald-500 text-slate-900 hover:bg-emerald-400 transition text-sm font-bold shadow-lg shadow-emerald-500/20">
                    Comenzar
                </a>
            @else
                <div class="flex items-center gap-3">
                    <div class="hidden sm:block text-right">
                        <span class="block text-xs font-bold text-slate-200">{{ Auth::user()->name }}</span>
                        <span class="block text-[10px] text-slate-500 leading-none">{{ Auth::user()->email }}</span>
                    </div>
                    <div class="h-8 w-8 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center text-xs font-bold text-white">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="h-6 w-px bg-slate-800 mx-1 hidden sm:block"></div>
                    <form method="POST" action="{{ route('logout') }}" title="Cerrar Sesión">
                        @csrf
                        <button type="submit" class="p-2 text-slate-400 hover:text-rose-400 hover:bg-rose-500/10 rounded-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                        </button>
                    </form>
                </div>
            @endguest
        </div>
    </div>
</header>

{{-- ==============================================================
    CONTENIDO PRINCIPAL
============================================================== --}}
@if(request()->routeIs('admin.*'))
    <main class="flex-1 relative z-10">
        @yield('content')
    </main>
@else
    <div class="flex flex-1 relative h-[calc(100vh-4rem)] overflow-hidden">

        {{-- SIDEBAR INVITADO (MÓVIL) --}}
        @guest
            <div id="guestBackdrop"
                 class="fixed inset-0 z-[60] bg-black/70 backdrop-blur-sm hidden"
                 onclick="window.toggleGuestSidebar(true)"></div>

            <aside id="guestSidebar"
                   class="fixed z-[70] inset-y-0 left-0 w-[86%] max-w-[340px]
                          transform -translate-x-full transition-transform duration-200 ease-out
                          p-3 sm:p-4">
                <div class="glass-solid rounded-3xl h-full overflow-hidden flex flex-col">

                    <div class="p-4 border-b border-slate-800 flex items-start justify-between">
                        <div>
                            <p class="text-sm font-bold text-white">Menú</p>
                            <p class="text-[11px] text-slate-500">Navega rápido</p>
                        </div>
                        <button onclick="window.toggleGuestSidebar(true)"
                                class="p-2 rounded-xl text-slate-300 hover:text-white hover:bg-slate-800/60 transition"
                                aria-label="Cerrar">✕</button>
                    </div>

                    @php
                        $gBase = "w-full flex items-center gap-3 px-4 py-3 rounded-2xl text-slate-200 transition border";
                        $gInactive = "bg-slate-950/20 hover:bg-slate-800/50 border-slate-800/80 hover:border-emerald-500/30";
                        $gMuted = "text-[10px] font-bold text-slate-500 uppercase px-4 pt-4 pb-2";
                    @endphp

                    <nav class="p-3 space-y-1 text-sm flex-1 overflow-y-auto no-scrollbar">
                        <a href="{{ route('home') }}" class="{{ $gBase }} {{ $gInactive }}" onclick="window.toggleGuestSidebar(true)">
                            <span class="text-[16px]">🏠</span> <span>Inicio</span>
                        </a>

                        <div class="{{ $gMuted }}">Servicios</div>
                        <a href="{{ route('hosting') }}" class="{{ $gBase }} {{ $gInactive }}" onclick="window.toggleGuestSidebar(true)">
                            <span class="text-[16px]">☁️</span> <span>Hosting</span>
                        </a>
                        <a href="{{ route('dominios') }}" class="{{ $gBase }} {{ $gInactive }}" onclick="window.toggleGuestSidebar(true)">
                            <span class="text-[16px]">🌐</span> <span>Dominios</span>
                        </a>
                        <a href="{{ route('vps') }}" class="{{ $gBase }} {{ $gInactive }}" onclick="window.toggleGuestSidebar(true)">
                            <span class="text-[16px]">🚀</span> <span>VPS</span>
                        </a>
                        <a href="{{ route('paginas-web') }}" class="{{ $gBase }} {{ $gInactive }}" onclick="window.toggleGuestSidebar(true)">
                            <span class="text-[16px]">🧩</span> <span>Páginas Web</span>
                        </a>

                        <div class="{{ $gMuted }}">Empresa</div>
                        <a href="{{ route('promociones') }}" class="{{ $gBase }} {{ $gInactive }}" onclick="window.toggleGuestSidebar(true)">
                            <span class="text-[16px]">🏷️</span> <span>Promociones</span>
                        </a>
                        <a href="{{ route('portafolio') }}" class="{{ $gBase }} {{ $gInactive }}" onclick="window.toggleGuestSidebar(true)">
                            <span class="text-[16px]">🖼️</span> <span>Portafolio</span>
                        </a>
                        <a href="{{ route('contacto') }}" class="{{ $gBase }} {{ $gInactive }}" onclick="window.toggleGuestSidebar(true)">
                            <span class="text-[16px]">📩</span> <span>Contacto</span>
                        </a>

                        <div class="{{ $gMuted }}">Legales</div>
                        <a href="{{ route('terminos') }}" class="{{ $gBase }} {{ $gInactive }}" onclick="window.toggleGuestSidebar(true)">
                            <span class="text-[16px]">📄</span> <span>Términos</span>
                        </a>
                        <a href="{{ route('privacidad') }}" class="{{ $gBase }} {{ $gInactive }}" onclick="window.toggleGuestSidebar(true)">
                            <span class="text-[16px]">🔒</span> <span>Privacidad</span>
                        </a>
                        <a href="{{ route('cookies') }}" class="{{ $gBase }} {{ $gInactive }}" onclick="window.toggleGuestSidebar(true)">
                            <span class="text-[16px]">🍪</span> <span>Cookies</span>
                        </a>

                        <div class="{{ $gMuted }}">Acceso</div>
                        <a href="{{ route('login') }}" class="{{ $gBase }} {{ $gInactive }}" onclick="window.toggleGuestSidebar(true)">
                            <span class="text-[16px]">🔐</span> <span>Ingresar</span>
                        </a>
                        <a href="{{ route('register') }}" class="{{ $gBase }} {{ $gInactive }}" onclick="window.toggleGuestSidebar(true)">
                            <span class="text-[16px]">✨</span> <span>Crear cuenta</span>
                        </a>
                    </nav>

                    <div class="p-3 border-t border-slate-800">
                        <p class="text-[11px] text-slate-500 text-center">
                            Respuesta rápida • Calidad premium • Soporte real
                        </p>
                    </div>
                </div>
            </aside>
        @endguest

        {{-- SIDEBAR CLIENTE (TU SIDEBAR ACTUAL) --}}
        @auth
            <div id="sidebarBackdrop"
                 class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm hidden lg:hidden transition-opacity"
                 onclick="window.toggleSidebar()"></div>

            <aside id="mainSidebar"
                   class="fixed z-50 inset-y-0 left-0 w-72 max-w-full transform -translate-x-full lg:translate-x-0
                          lg:static lg:w-64 lg:flex-shrink-0 transition-transform duration-200 ease-out
                          px-3 lg:px-0 lg:py-6 lg:pl-6">

                <div class="glass rounded-2xl border border-slate-800 p-4 h-full overflow-y-auto no-scrollbar flex flex-col">
                    <div class="mb-4">
                        <p class="text-[11px] uppercase tracking-wide text-slate-500">Área de Cliente</p>
                        <p class="text-sm font-semibold text-slate-100">Linea365 Panel</p>
                        <div class="lg:hidden mt-2 text-right">
                            <button onclick="window.toggleSidebar()" class="text-xs text-slate-400 border border-slate-700 px-2 py-1 rounded">Cerrar</button>
                        </div>
                    </div>

                    <nav class="space-y-1 text-sm flex-1">
                        @php
                            $linkBase = "flex items-center gap-2 px-3 py-2 rounded-xl text-slate-200 transition-all duration-200 group";
                            $linkActive = "bg-emerald-500/20 border border-emerald-500/60";
                            $linkInactive = "hover:bg-slate-900/70 border border-slate-800/80 hover:border-emerald-500/30";
                        @endphp

                        <a href="{{ route('dashboard') }}" class="{{ $linkBase }} {{ request()->routeIs('dashboard') ? $linkActive : $linkInactive }}">
                            <span class="text-[15px]">📊</span> <span>Resumen</span>
                        </a>

                        <p class="px-3 text-[10px] font-bold text-slate-500 uppercase mt-4 mb-2">Tienda</p>
                        <a href="{{ route('store.index', ['type' => 'hosting']) }}" class="{{ $linkBase }} {{ request()->fullUrlIs(route('store.index', ['type' => 'hosting'])) ? $linkActive : $linkInactive }}">
                            <span class="text-[15px]">☁️</span> <span>Hosting Linux</span>
                        </a>
                        <a href="{{ route('store.index', ['type' => 'hosting_windows']) }}" class="{{ $linkBase }} {{ request()->fullUrlIs(route('store.index', ['type' => 'hosting_windows'])) ? $linkActive : $linkInactive }}">
                            <span class="text-[15px]">🪟</span> <span>Hosting Windows</span>
                        </a>
                        <a href="{{ route('store.index', ['type' => 'vps']) }}" class="{{ $linkBase }} {{ request()->fullUrlIs(route('store.index', ['type' => 'vps'])) ? $linkActive : $linkInactive }}">
                            <span class="text-[15px]">🚀</span> <span>Servidores VPS</span>
                        </a>
                        <a href="{{ route('store.index', ['type' => 'domain']) }}" class="{{ $linkBase }} {{ request()->fullUrlIs(route('store.index', ['type' => 'domain'])) ? $linkActive : $linkInactive }}">
                            <span class="text-[15px]">🌐</span> <span>Dominios</span>
                        </a>

                        <p class="px-3 text-[10px] font-bold text-slate-500 uppercase mt-4 mb-2">Mis Servicios</p>
                        <a href="{{ route('services.index') }}" class="{{ $linkBase }} {{ request()->routeIs('services.*') ? $linkActive : $linkInactive }}">
                            <span class="text-[15px]">📦</span> <span>Mis Productos</span>
                        </a>
                        <a href="{{ route('domains.index') }}" class="{{ $linkBase }} {{ request()->routeIs('domains.*') ? $linkActive : $linkInactive }}">
                            <span class="text-[15px]">www</span> <span>Mis Dominios</span>
                        </a>
                        <a href="{{ route('invoices.index') }}" class="{{ $linkBase }} {{ request()->routeIs('invoices.*') ? $linkActive : $linkInactive }}">
                            <span class="text-[15px]">💳</span> <span>Facturación</span>
                        </a>

                        <p class="px-3 text-[10px] font-bold text-slate-500 uppercase mt-4 mb-2">Ayuda</p>
                        <a href="{{ route('tickets.index') }}" class="{{ $linkBase }} {{ request()->routeIs('tickets.*') ? $linkActive : $linkInactive }}">
                            <span class="text-[15px]">🎫</span> <span>Soporte Técnico</span>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="{{ $linkBase }} {{ request()->routeIs('profile.*') ? $linkActive : $linkInactive }}">
                            <span class="text-[15px]">⚙️</span> <span>Mi Cuenta</span>
                        </a>
                    </nav>

                    <div class="mt-4 pt-4 border-t border-slate-800 text-[11px] text-slate-500">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center gap-2 px-3 py-2 rounded-xl text-xs font-medium text-rose-400 bg-rose-500/10 border border-rose-500/20 hover:bg-rose-500/20 transition">
                                <span>🚪</span> Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            </aside>
        @endauth

        {{-- CONTENIDO --}}
        <main class="flex-1 overflow-y-auto h-full relative scroll-smooth p-4 lg:p-8">
            @if(session('success'))
                <div class="mb-6 bg-emerald-500/10 border border-emerald-500/50 text-emerald-400 px-4 py-3 rounded-xl flex items-center gap-3">
                    <span>✓</span> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 bg-red-500/10 border border-red-500/50 text-red-400 px-4 py-3 rounded-xl flex items-center gap-3">
                    <span>⚠️</span> {{ session('error') }}
                </div>
            @endif

            @yield('content')

            <div class="mt-12 border-t border-slate-800/50 pt-6 text-center text-xs text-slate-600">
                &copy; {{ date('Y') }} Linea365 Hosting & Cloud.
            </div>
        </main>
    </div>
@endif

@stack('scripts')

{{-- SCRIPTS SIDEBARS --}}
<script>
    window.togglePrimarySidebar = function () {
        const isAuth = {!! auth()->check() ? 'true' : 'false' !!};
        if (isAuth) window.toggleSidebar();
        else window.toggleGuestSidebar();
    };

    window.toggleGuestSidebar = function (forceClose = false) {
        const sidebar = document.getElementById('guestSidebar');
        const backdrop = document.getElementById('guestBackdrop');
        if (!sidebar || !backdrop) return;

        if (forceClose) {
            sidebar.classList.add('-translate-x-full');
            backdrop.classList.add('hidden');
            return;
        }

        if (sidebar.classList.contains('-translate-x-full')) {
            sidebar.classList.remove('-translate-x-full');
            backdrop.classList.remove('hidden');
        } else {
            sidebar.classList.add('-translate-x-full');
            backdrop.classList.add('hidden');
        }
    };

    window.toggleSidebar = function () {
        const sidebar = document.getElementById('mainSidebar');
        const backdrop = document.getElementById('sidebarBackdrop');
        if (!sidebar || !backdrop) return;

        if (sidebar.classList.contains('-translate-x-full')) {
            sidebar.classList.remove('-translate-x-full');
            backdrop.classList.remove('hidden');
        } else {
            sidebar.classList.add('-translate-x-full');
            backdrop.classList.add('hidden');
        }
    };
</script>

</body>
</html>
