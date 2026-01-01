@extends('layouts.admin')

@section('admin-content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-50">Complementos (Addons)</h1>
            <p class="text-sm text-slate-400 mt-1">Servicios extra que se venden junto a tus productos (IPs, SSL, Soporte, etc).</p>
        </div>
        <a href="{{ route('admin.addons.create') }}" 
           class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-xs font-semibold bg-emerald-500 text-slate-950 hover:bg-emerald-400 transition">
            + Nuevo Addon
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 glass rounded-xl border border-emerald-600/60 px-4 py-3 text-xs text-emerald-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="glass rounded-2xl border border-slate-800 overflow-hidden">
        @if($addons->isEmpty())
            <div class="p-8 text-center text-slate-400 text-sm">
                <p>No tienes complementos creados aún.</p>
            </div>
        @else
            <table class="min-w-full text-xs text-slate-300">
                <thead class="bg-slate-900/80 border-b border-slate-800 text-slate-100">
                    <tr>
                        <th class="px-4 py-3 text-left">Nombre</th>
                        <th class="px-4 py-3 text-left">Tipo de Cobro</th>
                        <th class="px-4 py-3 text-left">Precio</th>
                        <th class="px-4 py-3 text-left">Estado</th>
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/80">
                    @foreach($addons as $addon)
                        <tr class="hover:bg-slate-900/60 transition">
                            <td class="px-4 py-3 font-medium text-slate-100">
                                {{ $addon->name }}
                                @if($addon->description)
                                    <div class="text-[10px] text-slate-500 truncate max-w-[200px]">{{ $addon->description }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($addon->type == 'recurring')
                                    <span class="text-blue-400">Recurrente (Mensual/Anual)</span>
                                @else
                                    <span class="text-orange-400">Pago Único</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="text-emerald-400">${{ number_format($addon->price, 2) }}</div>
                                @if($addon->setup_fee > 0)
                                    <div class="text-[10px] text-slate-500">+ ${{ number_format($addon->setup_fee, 2) }} inst.</div>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 rounded-full text-[10px] border {{ $addon->is_active ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30' : 'bg-slate-700/50 text-slate-400 border-slate-600' }}">
                                    {{ $addon->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.addons.edit', $addon) }}" 
                                   class="text-blue-400 hover:text-blue-300 mr-3 font-medium">
                                    Editar
                                </a>
                                <form action="{{ route('admin.addons.destroy', $addon) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar este addon?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-rose-400 hover:text-rose-300">Borrar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="p-4 border-t border-slate-800">
                {{ $addons->links() }}
            </div>
        @endif
    </div>
@endsection