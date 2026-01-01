@extends('layouts.admin')

@section('admin-content')
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl font-semibold text-slate-50">Editar Servidor: {{ $server->name }}</h1>
            <a href="{{ route('admin.servers.index') }}" class="text-xs text-slate-400 hover:text-white">
                &larr; Volver
            </a>
        </div>

        <div class="glass rounded-2xl border border-slate-800 p-6">
            <form action="{{ route('admin.servers.update', $server) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- Datos Principales --}}
                <div class="grid sm:grid-cols-2 gap-5">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-medium text-slate-300 mb-1">Nombre del Servidor</label>
                        <input type="text" name="name" value="{{ old('name', $server->name) }}" 
                               class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-100 focus:border-emerald-500 focus:outline-none" 
                               required>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1">Hostname</label>
                        <input type="text" name="hostname" value="{{ old('hostname', $server->hostname) }}" 
                               class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-100" 
                               required>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1">Dirección IP</label>
                        <input type="text" name="ip_address" value="{{ old('ip_address', $server->ip_address) }}" 
                               class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-100">
                    </div>
                </div>

                <div class="border-t border-slate-800 my-4"></div>

                {{-- Configuración de Conexión --}}
                <h3 class="text-sm font-semibold text-emerald-400">Datos de Conexión (API)</h3>

                <div class="grid sm:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1">Tipo de Servidor</label>
                        <select name="type" class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-100">
                            <option value="cpanel" {{ old('type', $server->type) == 'cpanel' ? 'selected' : '' }}>cPanel / WHM</option>
                            <option value="plesk" {{ old('type', $server->type) == 'plesk' ? 'selected' : '' }}>Plesk</option>
                            <option value="virtualizor" {{ old('type', $server->type) == 'virtualizor' ? 'selected' : '' }}>Virtualizor</option>
                            <option value="other" {{ old('type', $server->type) == 'other' ? 'selected' : '' }}>Otro</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-300 mb-1">Puerto</label>
                        <input type="number" name="port" value="{{ old('port', $server->port) }}" 
                               class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-100">
                    </div>

                    <div class="flex items-center h-full pt-6">
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="use_ssl" value="1" id="use_ssl" 
                                   {{ old('use_ssl', $server->use_ssl) ? 'checked' : '' }}
                                   class="rounded bg-slate-900 border-slate-700 text-emerald-500">
                            <label for="use_ssl" class="text-xs text-slate-300">Usar Conexión Segura (SSL)</label>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">
                        API Token / Hash Remoto 
                        <span class="text-slate-500 font-normal">(Dejar en blanco para mantener el actual)</span>
                    </label>
                    <textarea name="api_token" rows="4" 
                              class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-xs text-slate-100 font-mono"
                              placeholder="Solo rellena esto si deseas cambiar el token actual">{{ old('api_token') }}</textarea>
                </div>

                <div class="pt-2">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_active" value="1" id="is_active" 
                               {{ old('is_active', $server->is_active) ? 'checked' : '' }} 
                               class="rounded bg-slate-900 border-slate-700 text-emerald-500">
                        <label for="is_active" class="text-xs text-slate-300">Servidor Activo</label>
                    </div>
                </div>

                <div class="flex justify-end pt-4 gap-3">
                    <a href="{{ route('admin.servers.index') }}" class="px-4 py-2 text-xs text-slate-400 hover:text-white transition">Cancelar</a>
                    <button type="submit" class="bg-emerald-500 text-slate-950 px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-emerald-400 transition shadow-lg shadow-emerald-500/20">
                        Actualizar Servidor
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection