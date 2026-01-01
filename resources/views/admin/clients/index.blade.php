@extends('layouts.admin')

@section('admin-content')
    <section class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-slate-50">
                    Clientes
                </h1>
                <p class="text-sm text-slate-400 mt-1">
                    Gestiona los clientes de Linea365: datos básicos, contacto y servicios asociados.
                </p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.clients.create') }}"
                   class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-xs font-semibold
                          bg-emerald-500 text-slate-950 hover:bg-emerald-400 transition">
                    + Nuevo cliente
                </a>
            </div>
        </div>

        {{-- Mensaje de éxito --}}
        @if (session('success'))
            <div class="glass rounded-xl border border-emerald-600/60 px-4 py-3 text-xs text-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        {{-- Filtros --}}
        <div class="glass rounded-2xl border border-slate-800 p-4">
            <form method="GET" action="{{ route('admin.clients.index') }}" class="grid gap-3 md:grid-cols-4 text-xs">
                <div class="md:col-span-3">
                    <label class="block mb-1 text-slate-300">Buscar</label>
                    <input type="text"
                           name="q" {{-- el controlador usa $request->get("q") --}}
                           value="{{ $search ?? '' }}"
                           placeholder="Nombre, email, empresa..."
                           class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-2 py-1.5 text-slate-100 placeholder-slate-500">
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit"
                            class="inline-flex items-center justify-center px-3 py-2 rounded-xl bg-slate-800 text-slate-100 hover:bg-slate-700 transition">
                        Filtrar
                    </button>
                    <a href="{{ route('admin.clients.index') }}"
                       class="inline-flex items-center justify-center px-3 py-2 rounded-xl text-slate-400 hover:text-emerald-300">
                        Limpiar
                    </a>
                </div>
            </form>
        </div>

        {{-- Tabla --}}
        @if ($clients->count() === 0)
            <div class="glass rounded-2xl border border-slate-800 p-5 text-sm text-slate-300">
                No hay clientes registrados por el momento.
                <br>
                <span class="text-xs text-slate-500">
                    Crea tu primer cliente usando el botón "Nuevo cliente".
                </span>
            </div>
        @else
            <div class="glass rounded-2xl border border-slate-800 overflow-hidden">
                <div class="px-4 py-3 border-b border-slate-800 flex items-center justify-between">
                    <div class="text-sm font-semibold text-slate-100">
                        Listado de clientes
                    </div>
                    <div class="text-[11px] text-slate-500">
                        Mostrando {{ $clients->firstItem() }} - {{ $clients->lastItem() }} de {{ $clients->total() }}
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs text-slate-200">
                        <thead class="bg-slate-900/80 border-b border-slate-800">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">Cliente</th>
                                <th class="px-4 py-3 text-left font-semibold">Contacto</th>
                                <th class="px-4 py-3 text-left font-semibold">Servicios</th>
                                <th class="px-4 py-3 text-left font-semibold">Estado</th>
                                <th class="px-4 py-3 text-left font-semibold">Registro</th>
                                <th class="px-4 py-3 text-right font-semibold">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/80">
                            @foreach ($clients as $client)
                                @php
                                    // Estado basado en is_active (bool)
                                    $isActive    = (bool) ($client->is_active ?? true);
                                    $statusLabel = $isActive ? 'Activo' : 'Inactivo';
                                    $statusClass = $isActive
                                        ? 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/40'
                                        : 'bg-slate-700/60 text-slate-200 border border-slate-500/60';

                                    // Si en el futuro usas withCount('services'), lo toma. Si no, 0.
                                    $servicesCount = $client->services_count
                                        ?? (method_exists($client, 'services') ? $client->services->count() : 0);
                                @endphp
                                <tr class="hover:bg-slate-900/60 transition">
                                    {{-- Cliente --}}
                                    <td class="px-4 py-3 align-top">
                                        <div class="text-sm text-slate-50">
                                            {{ $client->first_name }} {{ $client->last_name }}
                                        </div>
                                        <div class="text-[11px] text-slate-500 mt-0.5">
                                            ID cliente: #{{ $client->id }}
                                            @if(!empty($client->company_name))
                                                • {{ $client->company_name }}
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Contacto --}}
                                    <td class="px-4 py-3 align-top">
                                        <div class="text-sm text-slate-100">
                                            {{ $client->email }}
                                        </div>
                                        <div class="text-[11px] text-slate-500 mt-0.5">
                                            Tel: {{ $client->phone ?? '—' }}
                                            @if(!empty($client->country))
                                                • {{ strtoupper($client->country) }}
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Servicios --}}
                                    <td class="px-4 py-3 align-top">
                                        <div class="text-sm text-slate-100">
                                            {{ $servicesCount }} servicio(s)
                                        </div>
                                        <div class="text-[11px] text-slate-500 mt-0.5">
                                            Ver detalles en el módulo de servicios.
                                        </div>
                                    </td>

                                    {{-- Estado --}}
                                    <td class="px-4 py-3 align-top">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] {{ $statusClass }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>

                                    {{-- Fecha de registro --}}
                                    <td class="px-4 py-3 align-top whitespace-nowrap text-sm">
                                        {{ optional($client->created_at)->format('d/m/Y') ?? '—' }}
                                    </td>

                                    {{-- Acciones --}}
                                    <td class="px-4 py-3 align-top text-right space-x-1">
                                        {{-- Botón Ver: solo si más adelante creas admin.clients.show --}}
                                        {{--
                                        <a href="{{ route('admin.clients.show', $client) }}"
                                           class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg text-[11px] font-semibold btn-outline">
                                            Ver
                                        </a>
                                        --}}

                                        <a href="{{ route('admin.clients.edit', $client) }}"
                                           class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg text-[11px] font-semibold btn-outline">
                                            Editar
                                        </a>

                                        <form action="{{ route('admin.clients.destroy', $client) }}"
                                              method="POST"
                                              class="inline-block"
                                              onsubmit="return confirm('¿Seguro que deseas eliminar este cliente?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg text-[11px] font-semibold bg-red-500/15 text-red-300 border border-red-500/40 hover:bg-red-500/25 transition">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($clients->hasPages())
                    <div class="px-4 py-3 border-t border-slate-800">
                        {{ $clients->links() }}
                    </div>
                @endif
            </div>
        @endif
    </section>
@endsection
