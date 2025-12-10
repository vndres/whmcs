@extends('layouts.admin')

@section('admin-content')
    <section class="space-y-6">
        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-2xl font-semibold text-slate-50">
                    Productos & planes
                </h1>
                <p class="text-sm text-slate-400 mt-1">
                    Gestiona los planes de hosting, dominios y otros servicios que podrás asignar a los clientes.
                </p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.products.create') }}"
                   class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-xs font-semibold
                          bg-emerald-500 text-slate-950 hover:bg-emerald-400 transition">
                    + Nuevo producto
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="glass rounded-xl border border-emerald-600/60 px-4 py-3 text-xs text-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        @if ($products->count() === 0)
            <div class="glass rounded-2xl border border-slate-800 p-5 text-sm text-slate-300">
                No hay productos creados por el momento.
                <br>
                <span class="text-xs text-slate-500">
                    Crea tu primer plan de hosting, dominio u otro servicio con el botón "Nuevo producto".
                </span>
            </div>
        @else
            <div class="glass rounded-2xl border border-slate-800 overflow-hidden">
                <div class="px-4 py-3 border-b border-slate-800 flex items-center justify-between">
                    <div class="text-sm font-semibold text-slate-100">
                        Listado de productos
                    </div>
                    <div class="text-[11px] text-slate-500">
                        Mostrando {{ $products->firstItem() }} - {{ $products->lastItem() }} de {{ $products->total() }}
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs text-slate-200">
                        <thead class="bg-slate-900/80 border-b border-slate-800">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">Nombre</th>
                                <th class="px-4 py-3 text-left font-semibold">Tipo</th>
                                <th class="px-4 py-3 text-left font-semibold">Precio mensual</th>
                                <th class="px-4 py-3 text-left font-semibold">Precio anual</th>
                                <th class="px-4 py-3 text-left font-semibold">Servidor</th>
                                <th class="px-4 py-3 text-left font-semibold">Estado</th>
                                <th class="px-4 py-3 text-right font-semibold">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/80">
                            @foreach ($products as $product)
                                <tr class="hover:bg-slate-900/60 transition">
                                    <td class="px-4 py-3 align-top">
                                        <div class="text-sm text-slate-50">
                                            {{ $product->name }}
                                        </div>
                                        <div class="text-[11px] text-slate-500 mt-0.5">
                                            Slug: {{ $product->slug ?? '—' }} · ID #{{ $product->id }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 align-top text-sm">
                                        {{ ucfirst($product->type ?? 'otro') }}
                                    </td>
                                    <td class="px-4 py-3 align-top text-sm whitespace-nowrap">
                                        {{ $product->price_monthly !== null ? ('$'.number_format($product->price_monthly, 2)) : '—' }}
                                    </td>
                                    <td class="px-4 py-3 align-top text-sm whitespace-nowrap">
                                        {{ $product->price_yearly !== null ? ('$'.number_format($product->price_yearly, 2)) : '—' }}
                                    </td>
                                    <td class="px-4 py-3 align-top text-sm">
                                        {{ $product->server?->name ?? 'Sin servidor' }}
                                    </td>
                                    <td class="px-4 py-3 align-top">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px]
                                            {{ $product->is_active ? 'bg-emerald-500/15 text-emerald-300 border border-emerald-500/40'
                                                                   : 'bg-slate-700/50 text-slate-300 border border-slate-600/60' }}">
                                            {{ $product->is_active ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 align-top text-right space-x-1">
                                        <a href="{{ route('admin.products.edit', $product) }}"
                                           class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg text-[11px] font-semibold btn-outline">
                                            Editar
                                        </a>

                                        <form action="{{ route('admin.products.destroy', $product) }}"
                                              method="POST"
                                              class="inline-block"
                                              onsubmit="return confirm('¿Seguro que deseas eliminar este producto?');">
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

                @if ($products->hasPages())
                    <div class="px-4 py-3 border-t border-slate-800">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        @endif
    </section>
@endsection
