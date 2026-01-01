@extends('layouts.admin')

@section('admin-content')
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl font-semibold text-slate-50">Nuevo Servidor</h1>
            <a href="{{ route('admin.servers.index') }}" class="text-xs text-slate-400 hover:text-white">
                &larr; Volver
            </a>
        </div>

        @if ($errors->any())
            <div class="glass rounded-xl border border-red-600/60 px-4 py-3 text-xs text-red-200 mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="glass rounded-2xl border border-slate-800 p-6">
            <form action="{{ route('admin.servers.store') }}" method="POST" class="space-y-5">
                @csrf

                {{-- Datos Principales --}}
                <div class="grid sm:grid-cols-2 gap-5">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-medium text-slate-300 mb-1">Nombre del Servidor</label>
                        <input type="text" name="name" value="{{ old('name') }}" 
                               class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-100 focus:border-emerald-500 focus:outline-none" 
                               placeholder="Ej: cPanel Miami 01" required>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1">Hostname</label>
                        <input type="text" name="hostname" value="{{ old('hostname') }}" 
                               class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-100" 
                               placeholder="server1.midominio.com" required>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1">Dirección IP</label>
                        <input type="text" name="ip_address" value="{{ old('ip_address') }}" 
                               class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-100" 
                               placeholder="192.168.1.1">
                    </div>
                </div>

                <div class="border-t border-slate-800 my-4"></div>

                {{-- Configuración de Conexión --}}
                <h3 class="text-sm font-semibold text-emerald-400">Datos de Conexión (API)</h3>

                <div class="grid sm:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1">Tipo de Servidor</label>
                        <select name="type" class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-100">
                            <option value="cpanel" {{ old('type') == 'cpanel' ? 'selected' : '' }}>cPanel / WHM</option>
                            <option value="plesk" {{ old('type') == 'plesk' ? 'selected' : '' }}>Plesk</option>
                            <option value="virtualizor" {{ old('type') == 'virtualizor' ? 'selected' : '' }}>Virtualizor</option>
                            <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1">Puerto</label>
                        <input type="number" name="port" value="{{ old('port', '2087') }}" 
                               class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-100" 
                               placeholder="2087">
                        <p class="text-[10px] text-slate-500 mt-1">2087 para WHM SSL, 2086 sin SSL.</p>
                    </div>

                    <div class="flex items-center h-full pt-6">
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="use_ssl" value="1" id="use_ssl" 
                                   {{ old('use_ssl', '1') ? 'checked' : '' }}
                                   class="rounded bg-slate-900 border-slate-700 text-emerald-500">
                            <label for="use_ssl" class="text-xs text-slate-300">Usar Conexión Segura (SSL)</label>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">API Token / Hash Remoto</label>
                    <textarea name="api_token" rows="4" 
                              class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-xs text-slate-100 font-mono"
                              placeholder="Pega aquí el token generado en WHM > Manage API Tokens" required>{{ old('api_token') }}</textarea>
                </div>

                <div class="pt-2">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_active" value="1" id="is_active" 
                               {{ old('is_active', '1') ? 'checked' : '' }} 
                               class="rounded bg-slate-900 border-slate-700 text-emerald-500">
                        <label for="is_active" class="text-xs text-slate-300">Servidor Activo (Disponible para nuevos pedidos)</label>
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-emerald-500 text-slate-950 px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-emerald-400 transition shadow-lg shadow-emerald-500/20">
                        Guardar Servidor
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection