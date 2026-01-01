@extends('layouts.admin')

@section('admin-content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-slate-50">Productos y Planes</h1>
        <p class="text-sm text-slate-400">Gestiona tus planes de hosting, dominios y servicios.</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="bg-emerald-500 text-slate-900 px-4 py-2 rounded-xl text-xs font-bold hover:bg-emerald-400 transition shadow-lg shadow-emerald-500/20">
        + Crear Producto
    </a>
</div>

@if(session('success'))
    <div class="mb-4 glass rounded-xl border border-emerald-600/60 px-4 py-3 text-xs text-emerald-200">
        {{ session('success') }}
    </div>
@endif

<div class="glass rounded-2xl border border-slate-800 overflow-hidden">
    <table class="min-w-full text-xs text-slate-300">
        <thead class="bg-slate-900/80 border-b border-slate-800 text-slate-100">
            <tr>
                <th class="px-4 py-3 text-left">Grupo / Nombre</th>
                <th class="px-4 py-3 text-left">Tipo</th>
                <th class="px-4 py-3 text-left">Precio (Mes/Año)</th>
                <th class="px-4 py-3 text-left">Infraestructura</th>
                <th class="px-4 py-3 text-left">Estado</th>
                <th class="px-4 py-3 text-right">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-800/80">
            @forelse($products as $product)
            <tr class="hover:bg-slate-900/60 transition">
                <td class="px-4 py-3">
                    <div class="text-[10px] uppercase text-slate-500 font-bold">{{ $product->group_name }}</div>
                    <div class="text-sm text-slate-100 font-medium">{{ $product->name }}</div>
                    @if($product->addons->count() > 0)
                        <div class="text-[10px] text-blue-400 mt-1">+ {{ $product->addons->count() }} Addons disp.</div>
                    @endif
                </td>
                <td class="px-4 py-3">
                    @php
                        $types = [
                            'hosting' => ['icon' => '☁️', 'text' => 'Hosting', 'class' => 'text-blue-400'],
                            'domain'  => ['icon' => '🌐', 'text' => 'Dominio', 'class' => 'text-orange-400'],
                            'website' => ['icon' => '🛍️', 'text' => 'Sitio/Tienda', 'class' => 'text-purple-400'],
                            'vps'     => ['icon' => '🖥️', 'text' => 'VPS', 'class' => 'text-pink-400'],
                            'other'   => ['icon' => '📦', 'text' => 'Otro', 'class' => 'text-slate-400'],
                        ];
                        $type = $types[$product->type] ?? $types['other'];
                    @endphp
                    <div class="flex items-center gap-2 {{ $type['class'] }}">
                        <span>{{ $type['icon'] }}</span>
                        <span>{{ $type['text'] }}</span>
                    </div>
                </td>
                <td class="px-4 py-3">
                    <div class="flex flex-col">
                        <span class="text-emerald-400">${{ number_format($product->price_monthly, 2) }} <span class="text-slate-500">/mes</span></span>
                        <span class="text-slate-400">${{ number_format($product->price_annual, 2) }} <span class="text-slate-600">/año</span></span>
                    </div>
                </td>
                <td class="px-4 py-3">
                    @if($product->server)
                        <span class="text-[10px] bg-slate-800 px-2 py-1 rounded text-slate-300 border border-slate-700">
                            SRV: {{ $product->server->name }}
                        </span>
                    @elseif($product->registrar)
                        <span class="text-[10px] bg-slate-800 px-2 py-1 rounded text-slate-300 border border-slate-700">
                            REG: {{ $product->registrar->name }}
                        </span>
                    @else
                        <span class="text-[10px] text-slate-600">-</span>
                    @endif
                </td>
                <td class="px-4 py-3">
                    <span class="px-2 py-0.5 rounded-full text-[10px] border {{ $product->is_active ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30' : 'bg-slate-700/50 text-slate-400 border-slate-600' }}">
                        {{ $product->is_active ? 'Activo' : 'Oculto' }}
                    </span>
                </td>
                <td class="px-4 py-3 text-right">
                    <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-400 hover:text-blue-300 mr-2 font-medium">Editar</a>
                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Borrar este producto?');">
                        @csrf @method('DELETE')
                        <button class="text-rose-400 hover:text-rose-300">Borrar</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="p-8 text-center text-slate-500">No hay productos creados aún.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-slate-800">
        {{ $products->links() }}
    </div>
</div>
@endsection