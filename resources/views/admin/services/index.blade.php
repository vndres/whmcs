@extends('layouts.admin')

@section('admin-content')
    <section class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-slate-50">
                    Servicios (hosting / dominios)
                </h1>
                <p class="text-sm text-slate-400 mt-1">
                    Gestiona los servicios asignados a los clientes: activar, suspender, cancelar o eliminar.
                </p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.services.create') }}"
                   class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-xs font-semibold
                          bg-emerald-500 text-slate-950 hover:bg-emerald-400 transition">
                    + Nuevo servicio
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
            <form method="GET" action="{{ route('admin.services.index') }}" class="grid gap-3 md:grid-cols-4 text-xs">
                <div>
                    <label class="block mb-1 text-slate-300">Cliente</label>
                    <select name="client_id"
                            class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-2 py-1.5 text-slate-100">
                        <option value="">Todos</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
    {{ $client->first_name }} {{ $client->last_name }} (ID #{{ $client->id }})
</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-1 text-slate-300">Producto</label>
                    <select name="product_id"
                            class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-2 py-1.5 text-slate-100">
                        <option value="">Todos</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} (ID #{{ $product->id }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-1 text-slate-300">Estado</label>
                    <select name="status"
                            class="w-full rounded-xl bg-slate-900/80 border border-slate-700 px-2 py-1.5 text-slate-100">
                        <option value="">Todos</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pendiente</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Activo</option>
                        <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspendido</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                    </select>
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit"
                            class="inline-flex items-center justify-center px-3 py-2 rounded-xl bg-slate-800 text-slate-100 hover:bg-slate-700 transition">
                        Filtrar
                    </button>
                    <a href="{{ route('admin.services.index') }}"
                       class="inline-flex items-center justify-center px-3 py-2 rounded-xl text-slate-400 hover:text-emerald-300">
                        Limpiar
                    </a>
                </div>
            </form>
        </div>

        {{-- Tabla --}}
        @if ($services->count() === 0)
            <div class="glass rounded-2xl border border-slate-800 p-5 text-sm text-slate-300">
                No hay servicios registrados por el momento.
                <br>
                <span class="text-xs text-slate-500">
                    Crea tu primer servicio usando el botón "Nuevo servicio".
                </span>
            </div>
        @else
            <div class="glass rounded-2xl border border-slate-800 overflow-hidden">
                <div class="px-4 py-3 border-b border-slate-800 flex items-center justify-between">
                    <div class="text-sm font-semibold text-slate-100">
                        Listado de servicios
                    </div>
                    <div class="text-[11px] text-slate-500">
                        Mostrando {{ $services->firstItem() }} - {{ $services->lastItem() }} de {{ $services->total() }}
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs text-slate-200">
                        <thead class="bg-slate-900/80 border-b border-slate-800">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">Cliente</th>
                                <th class="px-4 py-3 text-left font-semibold">Producto</th>
                                <th class="px-4 py-3 text-left font-semibold">Dominio / Identificador</th>
                                <th class="px-4 py-3 text-left font-semibold">Estado</th>
                                <th class="px-4 py-3 text-left font-semibold">Próx. vencimiento</th>
                                <th class="px-4 py-3 text-right font-semibold">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/80">
                            @foreach ($services as $service)
                                @php
                                    $statusLabel = $service->status_label ?? ucfirst($service->status ?? 'desconocido');
                                    $statusClass = $service->status_class ?? 'bg-slate-700/50 text-slate-300 border border-slate-600/60';
                                @endphp
                                <tr class="hover:bg-slate-900/60 transition">
                                    <td class="px-4 py-3 align-top">
                                       <div class="text-sm text-slate-50">
    @if($service->client)
        {{ $service->client->first_name }} {{ $service->client->last_name }}
    @else
        Cliente eliminado
    @endif
</div>
                                        <div class="text-[11px] text-slate-500 mt-0.5">
                                            ID cliente: #{{ $service->client_id }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 align-top">
                                        <div class="text-sm text-slate-100">
                                            {{ $service->product?->name ?? 'Producto eliminado' }}
                                        </div>
                                        <div class="text-[11px] text-slate-500 mt-0.5">
                                            ID servicio: #{{ $service->id }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 align-top">
                                        <div class="text-sm text-slate-100">
                                            {{ $service->domain ?? '—' }}
                                        </div>
                                        <div class="text-[11px] text-slate-500 mt-0.5">
                                            Usuario: {{ $service->username ?? '—' }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 align-top">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] {{ $statusClass }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 align-top whitespace-nowrap text-sm">
                                        {{ $service->next_due_date?->format('d/m/Y') ?? '—' }}
                                    </td>
                                    <td class="px-4 py-3 align-top text-right space-x-1">
                                        <a href="{{ route('admin.services.edit', $service) }}"
                                           class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg text-[11px] font-semibold btn-outline">
                                            Editar
                                        </a>

                                        <form action="{{ route('admin.services.destroy', $service) }}"
                                              method="POST"
                                              class="inline-block"
                                              onsubmit="return confirm('¿Seguro que deseas eliminar este servicio?');">
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

                @if ($services->hasPages())
                    <div class="px-4 py-3 border-t border-slate-800">
                        {{ $services->links() }}
                    </div>
                @endif
            </div>
        @endif
    </section>
@endsection
