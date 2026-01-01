@extends('layouts.admin')

@section('admin-content')
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl font-semibold text-slate-50">Editar Registrador: {{ $registrar->name }}</h1>
            <a href="{{ route('admin.registrars.index') }}" class="text-xs text-slate-400 hover:text-white">
                &larr; Volver
            </a>
        </div>

        <div class="glass rounded-2xl border border-slate-800 p-6">
            <form action="{{ route('admin.registrars.update', $registrar) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- Nombre --}}
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Nombre Identificador</label>
                    <input type="text" name="name" value="{{ old('name', $registrar->name) }}" 
                           class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-100 focus:border-emerald-500 focus:outline-none" 
                           required>
                </div>

                {{-- Tipo (Solo lectura, cambiar tipo suele requerir reconfigurar todo) --}}
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Proveedor API</label>
                    <input type="text" value="{{ ucfirst($registrar->type) }}" disabled
                           class="w-full bg-slate-800/50 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-400 cursor-not-allowed">
                    <input type="hidden" name="type" value="{{ $registrar->type }}">
                </div>

                <div class="border-t border-slate-800 my-4"></div>

                {{-- Campos Condicionales (Backend decide qué mostrar según el tipo guardado) --}}
                
                @if($registrar->type === 'godaddy')
                    <div class="space-y-4">
                        <h3 class="text-sm font-semibold text-emerald-400">Credenciales GoDaddy</h3>
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs text-slate-400 mb-1">API Key</label>
                                <input type="text" name="gd_key" value="{{ $registrar->config['api_key'] ?? '' }}" 
                                       class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-100">
                            </div>
                            <div>
                                <label class="block text-xs text-slate-400 mb-1">API Secret</label>
                                <input type="password" name="gd_secret" value="{{ $registrar->config['api_secret'] ?? '' }}" 
                                       class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-100">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs text-slate-400 mb-1">Entorno</label>
                            <select name="gd_env" class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-100">
                                <option value="production" {{ ($registrar->config['env'] ?? '') == 'production' ? 'selected' : '' }}>Producción</option>
                                <option value="ote" {{ ($registrar->config['env'] ?? '') == 'ote' ? 'selected' : '' }}>Pruebas (OTE)</option>
                            </select>
                        </div>
                    </div>

                @elseif($registrar->type === 'resellerclub')
                    <div class="space-y-4">
                        <h3 class="text-sm font-semibold text-blue-400">Credenciales ResellerClub</h3>
                        <div class="grid sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs text-slate-400 mb-1">Reseller ID</label>
                                <input type="text" name="rc_userid" value="{{ $registrar->config['user_id'] ?? '' }}" 
                                       class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-100">
                            </div>
                            <div>
                                <label class="block text-xs text-slate-400 mb-1">API Key</label>
                                <input type="password" name="rc_apikey" value="{{ $registrar->config['api_key'] ?? '' }}" 
                                       class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-100">
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="checkbox" name="rc_testmode" value="1" id="rc_testmode" 
                                   {{ !empty($registrar->config['test_mode']) ? 'checked' : '' }}
                                   class="rounded bg-slate-900 border-slate-700 text-blue-500">
                            <label for="rc_testmode" class="text-xs text-slate-300">Modo de Pruebas</label>
                        </div>
                    </div>
                @endif

                <div class="pt-2">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_active" value="1" id="is_active" 
                               {{ $registrar->is_active ? 'checked' : '' }} 
                               class="rounded bg-slate-900 border-slate-700 text-emerald-500 focus:ring-emerald-500/50">
                        <label for="is_active" class="text-xs text-slate-300">Activo</label>
                    </div>
                </div>

                <div class="flex justify-end pt-4 gap-3">
                    <a href="{{ route('admin.registrars.index') }}" class="px-4 py-2 text-xs text-slate-400 hover:text-white transition">Cancelar</a>
                    <button type="submit" class="bg-emerald-500 text-slate-950 px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-emerald-400 transition shadow-lg shadow-emerald-500/20">
                        Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection