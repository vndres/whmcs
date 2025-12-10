@extends('layouts.frontend')

@section('title', $title ?? 'Panel administrativo - Linea365')

{{-- Shell del panel admin (sidebar + layout), igual a tu ejemplo --}}
@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-8">

        {{-- Header móvil con botón de menú --}}
        <div class="lg:hidden mb-4 flex items-center justify-between gap-3">
            <div>
                <p class="text-[11px] uppercase tracking-wide text-slate-500">
                    Panel de administración
                </p>
                <p class="text-sm font-semibold text-slate-100">
                    Linea365 Manager
                </p>
                <p class="text-[11px] text-slate-500 mt-1">
                    Sesión: {{ auth()->user()->name ?? 'Admin' }}
                </p>
            </div>

            <button type="button"
                    onclick="window.toggleAdminSidebar()"
                    class="inline-flex items-center justify-center rounded-xl border border-slate-700 bg-slate-900/80 px-3 py-2 text-slate-100 text-xs font-medium hover:border-emerald-500 hover:text-emerald-300 transition">
                <span class="mr-1">☰</span> Menú
            </button>
        </div>

        <div class="flex flex-col lg:flex-row lg:gap-6">

            {{-- Backdrop móvil --}}
            <div id="adminSidebarBackdrop"
                 class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm hidden lg:hidden"
                 onclick="window.toggleAdminSidebar()">
            </div>

            {{-- Sidebar lateral (móvil off-canvas + fijo en desktop) --}}
            <aside id="adminSidebar"
                   class="fixed z-50 inset-y-0 left-0 w-72 max-w-full transform -translate-x-full lg:translate-x-0
                          lg:static lg:w-64 lg:flex-shrink-0 transition-transform duration-200 ease-out
                          px-3 lg:px-0">

                <div class="glass rounded-2xl border border-slate-800 p-4 h-full overflow-y-auto">
                    <div class="mb-4 hidden lg:block">
                        <p class="text-[11px] uppercase tracking-wide text-slate-500">
                            Panel de administración
                        </p>
                        <p class="text-sm font-semibold text-slate-100">
                            Linea365 Manager
                        </p>
                        <p class="text-[11px] text-slate-500 mt-1">
                            Sesión: {{ auth()->user()->name ?? 'Admin' }}
                        </p>
                    </div>

                    {{-- En móvil, encabezado compacto dentro del panel --}}
                    <div class="mb-4 lg:hidden">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[11px] uppercase tracking-wide text-slate-500">
                                    Panel de administración
                                </p>
                                <p class="text-sm font-semibold text-slate-100">
                                    Linea365 Manager
                                </p>
                                <p class="text-[11px] text-slate-500 mt-1">
                                    Sesión: {{ auth()->user()->name ?? 'Admin' }}
                                </p>
                            </div>
                            <button type="button"
                                    onclick="window.toggleAdminSidebar()"
                                    class="inline-flex items-center justify-center rounded-xl border border-slate-700 bg-slate-900/80 px-2 py-1.5 text-slate-300 text-xs hover:border-emerald-500 hover:text-emerald-300 transition">
                                ✕
                            </button>
                        </div>
                    </div>

                    {{-- MENÚ LATERAL --}}
                    <nav class="space-y-1 text-sm">
                        {{-- Dashboard --}}
                        <a href="{{ route('admin.dashboard') }}"
                           class="flex items-center gap-2 px-3 py-2 rounded-xl text-slate-200
                                  {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-500/20 border border-emerald-500/60' : 'hover:bg-slate-900/70 border border-transparent' }}">
                            <span class="text-[15px]">📊</span>
                            <span>Dashboard</span>
                        </a>

                        {{-- Clientes (AHORA ACTIVO) --}}
                        <a href="{{ route('admin.clients.index') }}"
                           class="w-full flex items-center gap-2 px-3 py-2 rounded-xl
                                  {{ request()->routeIs('admin.clients.*') ? 'text-slate-200 bg-emerald-500/20 border border-emerald-500/60' : 'text-slate-200 hover:bg-slate-900/70 border border-slate-800/80' }}">
                            <span class="text-[15px]">👤</span>
                            <span>Clientes</span>
                        </a>

                        {{-- Servicios --}}
                        <a href="{{ route('admin.services.index') }}"
                           class="w-full flex items-center gap-2 px-3 py-2 rounded-xl text-slate-200
                                  {{ request()->routeIs('admin.services.*') ? 'bg-emerald-500/20 border border-emerald-500/60' : 'hover:bg-slate-900/70 border border-slate-800/80' }}">
                            <span class="text-[15px]">🧩</span>
                            <span>Servicios (Hosting)</span>
                        </a>

                        {{-- Dominios (a futuro) --}}
                        <button type="button"
                                class="w-full flex items-center gap-2 px-3 py-2 rounded-xl text-slate-400
                                       hover:bg-slate-900/70 border border-slate-800/80 cursor-not-allowed opacity-60">
                            <span class="text-[15px]">🌐</span>
                            <span>Dominios</span>
                            <span class="ml-auto text-[10px] px-2 py-0.5 rounded-full bg-slate-800/90 text-slate-400">
                                Próximamente
                            </span>
                        </button>

                        {{-- Facturación --}}
                        <a href="{{ route('admin.invoices.index') }}"
                           class="w-full flex items-center gap-2 px-3 py-2 rounded-xl text-slate-200
                                  {{ request()->routeIs('admin.invoices.*') ? 'bg-emerald-500/20 border border-emerald-500/60' : 'hover:bg-slate-900/70 border border-slate-800/80' }}">
                            <span class="text-[15px]">💳</span>
                            <span>Facturación</span>
                        </a>

                        {{-- Soporte (a futuro) --}}
                        <button type="button"
                                class="w-full flex items-center gap-2 px-3 py-2 rounded-xl text-slate-400
                                       hover:bg-slate-900/70 border border-slate-800/80 cursor-not-allowed opacity-60">
                            <span class="text-[15px]">🎫</span>
                            <span>Tickets de soporte</span>
                            <span class="ml-auto text-[10px] px-2 py-0.5 rounded-full bg-slate-800/90 text-slate-400">
                                Próximamente
                            </span>
                        </button>

                        {{-- Productos & planes (a futuro) --}}
                        <button type="button"
                                class="w-full flex items-center gap-2 px-3 py-2 rounded-xl text-slate-400
                                       hover:bg-slate-900/70 border border-slate-800/80 cursor-not-allowed opacity-60">
                            <span class="text-[15px]">📦</span>
                            <span>Productos & planes</span>
                            <span class="ml-auto text-[10px] px-2 py-0.5 rounded-full bg-slate-800/90 text-slate-400">
                                Próximamente
                            </span>
                        </button>

                        {{-- Servidores / APIs (a futuro) --}}
                        <button type="button"
                                class="w-full flex items-center gap-2 px-3 py-2 rounded-xl text-slate-400
                                       hover:bg-slate-900/70 border border-slate-800/80 cursor-not-allowed opacity-60">
                            <span class="text-[15px]">🖥️</span>
                            <span>Servidores & APIs</span>
                        </button>

                        {{-- Ajustes generales (a futuro) --}}
                        <button type="button"
                                class="w-full flex items-center gap-2 px-3 py-2 rounded-xl text-slate-400
                                       hover:bg-slate-900/70 border border-slate-800/80 cursor-not-allowed opacity-60">
                            <span class="text-[15px]">⚙️</span>
                            <span>Ajustes del sistema</span>
                        </button>
                    </nav>

                    <div class="mt-6 pt-4 border-t border-slate-800 text-[11px] text-slate-500">
                        <p class="mb-1">Versión: WHMCS Linea365 v1.0</p>
                        <p>Más adelante aquí ponemos logs rápidos, licencias y estado de cron.</p>
                    </div>
                </div>
            </aside>

            {{-- Contenido principal: aquí se inyecta la vista concreta --}}
            <main class="flex-1 min-w-0 mt-4 lg:mt-0">
                @yield('admin-content')
            </main>
        </div>
    </div>

    {{-- Script simple para abrir/cerrar el sidebar en móviles --}}
    <script>
        window.toggleAdminSidebar = function () {
            const sidebar = document.getElementById('adminSidebar');
            const backdrop = document.getElementById('adminSidebarBackdrop');

            if (!sidebar || !backdrop) return;

            const isOpen = !sidebar.classList.contains('-translate-x-full');

            if (isOpen) {
                // Cerrar
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            } else {
                // Abrir
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            }
        };

        // Cerrar con ESC en móvil
        window.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                const sidebar = document.getElementById('adminSidebar');
                const backdrop = document.getElementById('adminSidebarBackdrop');
                if (!sidebar || !backdrop) return;

                if (!sidebar.classList.contains('-translate-x-full')) {
                    sidebar.classList.add('-translate-x-full');
                    backdrop.classList.add('hidden');
                }
            }
        });
    </script>
@endsection

{{-- AQUÍ va el contenido específico de "Clientes" --}}
@section('admin-content')
<section class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-semibold text-slate-50">Clientes</h1>
        <a href="{{ route('admin.clients.create') }}" class="btn-primary text-xs">
            + Nuevo cliente
        </a>
    </div>

    <form method="GET" class="glass rounded-2xl border border-slate-800 p-4 mb-4">
        <div class="flex gap-2 items-center">
            <input
                type="text"
                name="q"
                value="{{ $search }}"
                placeholder="Buscar por nombre, empresa o email..."
                class="input-dark w-full"
            >
            <button class="btn-outline text-xs px-4 py-2">
                Buscar
            </button>
        </div>
    </form>

    <div class="glass rounded-2xl border border-slate-800 overflow-hidden">
        <table class="min-w-full text-xs text-slate-200">
            <thead class="bg-slate-900/80 border-b border-slate-800">
                <tr>
                    <th class="px-4 py-3 text-left">Cliente</th>
                    <th class="px-4 py-3 text-left">Empresa</th>
                    <th class="px-4 py-3 text-left">Email</th>
                    <th class="px-4 py-3 text-left">País</th>
                    <th class="px-4 py-3 text-left">Estado</th>
                    <th class="px-4 py-3 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/80">
                @forelse($clients as $client)
                    <tr class="hover:bg-slate-900/60 transition">
                        <td class="px-4 py-3">
                            <div class="text-sm text-slate-50">
                                {{ $client->full_name }}
                            </div>
                            <div class="text-[11px] text-slate-500">
                                ID #{{ $client->id }}
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ $client->company_name ?: '—' }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ $client->email }}
                        </td>
                        <td class="px-4 py-3 text-sm">
                            {{ $client->country ?: '—' }}
                        </td>
                        <td class="px-4 py-3">
                            @if($client->is_active)
                                <span class="badge-success">Activo</span>
                            @else
                                <span class="badge-danger">Inactivo</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.clients.edit', $client) }}" class="text-xs text-emerald-300 mr-2">
                                Editar
                            </a>
                            <form action="{{ route('admin.clients.destroy', $client) }}" method="POST" class="inline-block"
                                  onsubmit="return confirm('¿Seguro que quieres eliminar este cliente?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-red-400">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-5 text-center text-sm text-slate-400">
                            No hay clientes registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($clients->hasPages())
            <div class="px-4 py-3 border-t border-slate-800">
                {{ $clients->links() }}
            </div>
        @endif
    </div>
</section>
@endsection
