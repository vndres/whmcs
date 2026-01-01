@extends('layouts.admin')

@section('admin-content')
<div class="max-w-2xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold text-slate-50">Editar Addon: {{ $addon->name }}</h1>
        <a href="{{ route('admin.addons.index') }}" class="text-xs text-slate-400 hover:text-white">&larr; Volver</a>
    </div>

    <div class="glass rounded-2xl border border-slate-800 p-6">
        <form action="{{ route('admin.addons.update', $addon) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-xs font-medium text-slate-300 mb-1">Nombre del Addon</label>
                <input type="text" name="name" value="{{ old('name', $addon->name) }}" 
                       class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-100 focus:border-emerald-500 focus:outline-none" required>
            </div>

            <div>
                <label class="block text-xs font-medium text-slate-300 mb-1">Descripción</label>
                <textarea name="description" rows="2" 
                          class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-100">{{ old('description', $addon->description) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Tipo de Facturación</label>
                    <select name="type" class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-100">
                        <option value="recurring" {{ $addon->type == 'recurring' ? 'selected' : '' }}>Recurrente</option>
                        <option value="onetime" {{ $addon->type == 'onetime' ? 'selected' : '' }}>Pago Único</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Precio</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-slate-500">$</span>
                        <input type="number" step="0.01" name="price" value="{{ old('price', $addon->price) }}" 
                               class="w-full bg-slate-900/80 border border-slate-700 rounded-xl pl-6 pr-3 py-2 text-sm text-slate-100">
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-medium text-slate-300 mb-1">Costo de Instalación</label>
                <div class="relative">
                    <span class="absolute left-3 top-2 text-slate-500">$</span>
                    <input type="number" step="0.01" name="setup_fee" value="{{ old('setup_fee', $addon->setup_fee) }}" 
                           class="w-full bg-slate-900/80 border border-slate-700 rounded-xl pl-6 pr-3 py-2 text-sm text-slate-100">
                </div>
            </div>

            <div class="pt-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ $addon->is_active ? 'checked' : '' }} class="rounded bg-slate-900 border-slate-700 text-emerald-500">
                    <span class="text-sm text-slate-300">Activo</span>
                </label>
            </div>

            <div class="flex justify-end pt-4 gap-3">
                <a href="{{ route('admin.addons.index') }}" class="px-4 py-2 text-xs text-slate-400 hover:text-white transition">Cancelar</a>
                <button type="submit" class="bg-emerald-500 text-slate-950 px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-emerald-400 transition shadow-lg shadow-emerald-500/20">
                    Actualizar Addon
                </button>
            </div>
        </form>
    </div>
</div>
@endsection