<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Linea365 Clientes')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Fuente y Tailwind via CDN para no complicarnos con build --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700" rel="stylesheet" />

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: radial-gradient(circle at top, #0f172a 0, #020617 55%, #000 100%);
            color: #e5e7eb;
        }
        .glass {
            background: rgba(15, 23, 42, 0.85);
            border: 1px solid rgba(148, 163, 184, 0.3);
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.9);
            backdrop-filter: blur(18px);
        }
        .btn-primary {
            background: linear-gradient(135deg, #22c55e, #a3e635);
            color: #020617;
        }
        .btn-primary:hover {
            filter: brightness(1.05);
            transform: translateY(-1px);
        }
        .btn-outline {
            border: 1px solid rgba(148, 163, 184, 0.8);
            color: #e5e7eb;
        }
        .btn-outline:hover {
            border-color: #22c55e;
            color: #bbf7d0;
            transform: translateY(-1px);
        }
    </style>

    @stack('head')
</head>
<body class="min-h-screen flex flex-col">

    {{-- Topbar / Navbar --}}
    <header class="w-full border-b border-slate-800/80 bg-slate-950/80 sticky top-0 z-30 backdrop-blur">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between gap-4">
            <div class="flex items-center gap-2">
                <div class="h-9 w-9 rounded-xl bg-emerald-500 flex items-center justify-center text-slate-950 font-black text-lg">
                    L
                </div>
                <div>
                    <div class="text-sm font-semibold tracking-wide text-slate-100">
                        Linea365 Clientes
                    </div>
                    <div class="text-[11px] text-slate-400">
                        Panel de gestión de hosting
                    </div>
                </div>
            </div>

         <nav class="hidden sm:flex items-center gap-6 text-xs font-medium text-slate-300">
    @guest
        <a href="#planes" class="hover:text-emerald-400 transition">Planes</a>
        <a href="#caracteristicas" class="hover:text-emerald-400 transition">Características</a>
        <a href="#soporte" class="hover:text-emerald-400 transition">Soporte</a>
    @else
        <a href="{{ route('dashboard') }}" class="hover:text-emerald-400 transition">
            Panel
        </a>
        <a href="{{ route('services.index') }}" class="hover:text-emerald-400 transition">
            Mis servicios
        </a>
         
        <a href="{{ route('domains.index') }}" class="hover:text-emerald-400 transition">
            Dominios
        </a>
        
        <a href="{{ route('invoices.index') }}" class="hover:text-emerald-400 transition">
            Facturas
        </a>
        <a href="{{ route('tickets.index') }}" class="hover:text-emerald-400 transition">
            Tickets
        </a>
         <a href="{{ route('profile.edit') }}" class="hover:text-emerald-400 transition">
            Perfil
        </a>
    @endguest
</nav>



            <div class="flex items-center gap-2">
    @guest
        <a href="{{ route('login') }}"
           class="btn-outline text-xs px-3 py-1.5 rounded-lg transition">
            Ingresar
        </a>
        <a href="{{ route('register') }}"
           class="btn-primary text-xs px-3 py-1.5 rounded-lg font-semibold shadow-lg shadow-emerald-500/30 transition">
            Crear cuenta
        </a>
    @else
        <a href="{{ route('dashboard') }}"
           class="btn-outline text-xs px-3 py-1.5 rounded-lg transition">
            Mi panel
        </a>
        <form action="{{ route('logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit"
                    class="btn-primary text-xs px-3 py-1.5 rounded-lg font-semibold shadow-lg shadow-emerald-500/30 transition">
                Cerrar sesión
            </button>
        </form>
    @endguest
</div>

        </div>
    </header>

    {{-- Contenido principal --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="border-t border-slate-800/80 bg-slate-950/90 mt-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500">
            <div>
                © {{ date('Y') }} Linea365. Todos los derechos reservados.
            </div>
            <div class="flex gap-4">
                <a href="#" class="hover:text-emerald-400 transition">Términos</a>
                <a href="#" class="hover:text-emerald-400 transition">Política de privacidad</a>
                <a href="#" class="hover:text-emerald-400 transition">Estado del servicio</a>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
