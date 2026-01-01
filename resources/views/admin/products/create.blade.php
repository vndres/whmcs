@extends('layouts.admin')

@section('admin-content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-xl font-semibold text-slate-50">Nuevo Producto</h1>
        <a href="{{ route('admin.products.index') }}" class="text-xs text-slate-400 hover:text-white">&larr; Volver</a>
    </div>

    @if ($errors->any())
        <div class="mb-6 glass rounded-xl border border-rose-900/50 p-4 text-xs text-rose-300">
            <ul class="list-disc pl-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Panel Principal --}}
        <div class="glass rounded-2xl border border-slate-800 p-6">
            <h2 class="text-sm font-bold text-slate-100 mb-4 border-b border-slate-800 pb-2">Información Básica</h2>
            <div class="grid md:grid-cols-2 gap-5">
                <div class="col-span-2 md:col-span-1">
                    <label class="text-xs text-slate-400 mb-1 block">Nombre del Producto</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-200 focus:border-emerald-500 focus:outline-none" placeholder="Ej: Plan Emprendedor" required>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <label class="text-xs text-slate-400 mb-1 block">Grupo / Categoría</label>
                    <input type="text" name="group_name" value="{{ old('group_name') }}" class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-200" placeholder="Ej: Web Hosting, Servidores VPS" required>
                </div>
                <div class="col-span-2">
                    <label class="text-xs text-slate-400 mb-1 block">Descripción (HTML permitido)</label>
                    <textarea name="description" rows="3" class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-200">{{ old('description') }}</textarea>
                </div>
            </div>
        </div>

        {{-- Panel Configuración Técnica --}}
        <div class="glass rounded-2xl border border-slate-800 p-6">
            <h2 class="text-sm font-bold text-emerald-400 mb-4 border-b border-slate-800 pb-2">Configuración Técnica</h2>
            
            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="text-xs text-slate-400 mb-1 block">Tipo de Producto</label>
                    <select name="type" id="productType" onchange="toggleFields()" class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-200">
                        <option value="hosting" {{ old('type') == 'hosting' ? 'selected' : '' }}>Hosting (cPanel/Plesk)</option>
                        <option value="domain" {{ old('type') == 'domain' ? 'selected' : '' }}>Dominio</option>
                        <option value="website" {{ old('type') == 'website' ? 'selected' : '' }}>Sitio Web / Tienda</option>
                        <option value="vps" {{ old('type') == 'vps' ? 'selected' : '' }}>Servidor VPS</option>
                        <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>

                {{-- Selector de Servidor (Solo hosting) --}}
                <div id="serverField" class="hidden">
                    <label class="text-xs text-slate-400 mb-1 block">Servidor de Aprovisionamiento</label>
                    <select name="server_id" class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-200">
                        <option value="">-- Seleccionar Servidor --</option>
                        @foreach($servers as $server)
                            <option value="{{ $server->id }}" {{ old('server_id') == $server->id ? 'selected' : '' }}>{{ $server->name }} ({{ $server->type }})</option>
                        @endforeach
                    </select>
                    <p class="text-[10px] text-slate-500 mt-1">Donde se creará la cuenta automáticamente.</p>
                </div>

                {{-- Selector de Registrador (Solo dominios) --}}
                <div id="registrarField" class="hidden">
                    <label class="text-xs text-slate-400 mb-1 block">Registrador de Dominios</label>
                    <select name="registrar_id" class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-200">
                        <option value="">-- Seleccionar API --</option>
                        @foreach($registrars as $registrar)
                            <option value="{{ $registrar->id }}" {{ old('registrar_id') == $registrar->id ? 'selected' : '' }}>{{ $registrar->name }} ({{ ucfirst($registrar->type) }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-span-2">
                    <label class="text-xs text-slate-400 mb-1 block">Configuración Avanzada / JSON (Opcional)</label>
                    <textarea name="config_raw" rows="3" class="w-full bg-slate-900/50 border border-slate-700 rounded-xl px-3 py-2 text-xs font-mono text-emerald-400 placeholder-slate-600" placeholder='{"whm_package": "gold_plan", "disk_limit": 5000}'>{{ old('config_raw') }}</textarea>
                    <p class="text-[10px] text-slate-500 mt-1">Para hosting cPanel, usa <code>{"whm_package": "nombre_en_whm"}</code>.</p>
                </div>
            </div>
        </div>

        {{-- Panel Precios --}}
        <div class="glass rounded-2xl border border-slate-800 p-6">
            <h2 class="text-sm font-bold text-blue-400 mb-4 border-b border-slate-800 pb-2">Precios y Facturación</h2>
            <div class="grid md:grid-cols-3 gap-5">
                <div>
                    <label class="text-xs text-slate-400 mb-1 block">Precio Mensual</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-slate-500">$</span>
                        <input type="number" step="0.01" name="price_monthly" value="{{ old('price_monthly', '0.00') }}" class="w-full bg-slate-900/50 border border-slate-700 rounded-xl pl-6 pr-3 py-2 text-sm text-slate-200">
                    </div>
                </div>
                <div>
                    <label class="text-xs text-slate-400 mb-1 block">Precio Anual</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-slate-500">$</span>
                        <input type="number" step="0.01" name="price_annual" value="{{ old('price_annual', '0.00') }}" class="w-full bg-slate-900/50 border border-slate-700 rounded-xl pl-6 pr-3 py-2 text-sm text-slate-200">
                    </div>
                </div>
                <div>
                    <label class="text-xs text-slate-400 mb-1 block">Costo Instalación</label>
                    <div class="relative">
                        <span class="absolute left-3 top-2 text-slate-500">$</span>
                        <input type="number" step="0.01" name="setup_fee" value="{{ old('setup_fee', '0.00') }}" class="w-full bg-slate-900/50 border border-slate-700 rounded-xl pl-6 pr-3 py-2 text-sm text-slate-200">
                    </div>
                </div>
            </div>
        </div>

        {{-- Panel ADDONS --}}
        <div class="glass rounded-2xl border border-slate-800 p-6">
            <h2 class="text-sm font-bold text-purple-400 mb-4 border-b border-slate-800 pb-2">Complementos (Addons)</h2>
            <p class="text-xs text-slate-400 mb-4">Selecciona los extras que el cliente puede agregar a este producto.</p>
            
            @if($addons->isEmpty())
                <p class="text-xs text-slate-500 italic">No hay addons creados. Ve a Configuración > Addons.</p>
            @else
                <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($addons as $addon)
                        <label class="flex items-start gap-3 p-3 rounded-xl border border-slate-700 bg-slate-900/30 hover:bg-slate-800 cursor-pointer transition">
                            <input type="checkbox" name="addons[]" value="{{ $addon->id }}" 
                                   class="mt-1 rounded bg-slate-800 border-slate-600 text-purple-500 focus:ring-purple-500/50"
                                   {{ is_array(old('addons')) && in_array($addon->id, old('addons')) ? 'checked' : '' }}>
                            <div>
                                <div class="text-xs font-semibold text-slate-200">{{ $addon->name }}</div>
                                <div class="text-[10px] text-slate-400">
                                    +${{ number_format($addon->price, 2) }}
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Opciones Finales --}}
        <div class="flex items-center gap-4 pt-2">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="is_active" value="1" {{ old('is_active', '1') ? 'checked' : '' }} class="rounded bg-slate-900 border-slate-700 text-emerald-500">
                <span class="text-sm text-slate-300">Producto Activo y Visible</span>
            </label>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-emerald-500 text-slate-950 px-8 py-3 rounded-xl text-sm font-bold hover:bg-emerald-400 transition shadow-lg shadow-emerald-500/20">
                Guardar Producto
            </button>
        </div>
    </form>
</div>

<script>
    function toggleFields() {
        const type = document.getElementById('productType').value;
        const serverField = document.getElementById('serverField');
        const registrarField = document.getElementById('registrarField');

        // Reset
        serverField.classList.add('hidden');
        registrarField.classList.add('hidden');

        if (type === 'hosting') {
            serverField.classList.remove('hidden');
        } else if (type === 'domain') {
            registrarField.classList.remove('hidden');
        }
    }
    // Init
    document.addEventListener('DOMContentLoaded', toggleFields);
</script>
@endsection