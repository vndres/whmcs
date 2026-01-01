@extends('layouts.admin')

@section('admin-content')
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-xl font-semibold text-slate-50">Nuevo Registrador</h1>
            <a href="{{ route('admin.registrars.index') }}" class="text-xs text-slate-400 hover:text-white">
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
            <form action="{{ route('admin.registrars.store') }}" method="POST" class="space-y-5">
                @csrf

                {{-- Nombre --}}
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Nombre Identificador</label>
                    <input type="text" name="name" value="{{ old('name') }}" 
                           class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-100 focus:border-emerald-500 focus:outline-none" 
                           placeholder="Ej: GoDaddy Principal" required>
                    <p class="text-[10px] text-slate-500 mt-1">Un nombre para identificar esta cuenta internamente.</p>
                </div>

                {{-- Tipo --}}
                <div>
                    <label class="block text-xs font-medium text-slate-300 mb-1">Proveedor API</label>
                    <select name="type" id="registrarType" 
                            class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-100 focus:border-emerald-500 focus:outline-none"
                            onchange="toggleFields()">
                        <option value="godaddy" {{ old('type') == 'godaddy' ? 'selected' : '' }}>GoDaddy</option>
                        <option value="resellerclub" {{ old('type') == 'resellerclub' ? 'selected' : '' }}>ResellerClub / LogicBoxes</option>
                        <option value="namecheap" {{ old('type') == 'namecheap' ? 'selected' : '' }}>Namecheap (Próximamente)</option>
                    </select>
                </div>

                <div class="border-t border-slate-800 my-4"></div>

                {{-- Campos GoDaddy --}}
                <div id="godaddy_fields" class="space-y-4">
                    <h3 class="text-sm font-semibold text-emerald-400">Configuración GoDaddy</h3>
                    
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs text-slate-400 mb-1">API Key</label>
                            <input type="text" name="gd_key" value="{{ old('gd_key') }}" 
                                   class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-100">
                        </div>
                        <div>
                            <label class="block text-xs text-slate-400 mb-1">API Secret</label>
                            <input type="password" name="gd_secret" value="{{ old('gd_secret') }}" 
                                   class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-100">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs text-slate-400 mb-1">Entorno</label>
                        <select name="gd_env" class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-100">
                            <option value="production" {{ old('gd_env') == 'production' ? 'selected' : '' }}>Producción (api.godaddy.com)</option>
                            <option value="ote" {{ old('gd_env') == 'ote' ? 'selected' : '' }}>Pruebas / OTE (api.ote-godaddy.com)</option>
                        </select>
                    </div>
                </div>

                {{-- Campos ResellerClub --}}
                <div id="resellerclub_fields" class="space-y-4 hidden">
                    <h3 class="text-sm font-semibold text-blue-400">Configuración ResellerClub</h3>
                    
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs text-slate-400 mb-1">Reseller ID (User ID)</label>
                            <input type="text" name="rc_userid" value="{{ old('rc_userid') }}" 
                                   class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-100">
                        </div>
                        <div>
                            <label class="block text-xs text-slate-400 mb-1">API Key</label>
                            <input type="password" name="rc_apikey" value="{{ old('rc_apikey') }}" 
                                   class="w-full bg-slate-900/80 border border-slate-700 rounded-xl px-3 py-2 text-sm text-slate-100">
                        </div>
                    </div>
                    
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="rc_testmode" value="1" id="rc_testmode" class="rounded bg-slate-900 border-slate-700 text-blue-500">
                        <label for="rc_testmode" class="text-xs text-slate-300">Modo de Pruebas (Test Mode)</label>
                    </div>
                </div>

                <div class="pt-2">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_active" value="1" id="is_active" 
                               {{ old('is_active', '1') ? 'checked' : '' }} 
                               class="rounded bg-slate-900 border-slate-700 text-emerald-500 focus:ring-emerald-500/50">
                        <label for="is_active" class="text-xs text-slate-300">Activar este registrador</label>
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="submit" class="bg-emerald-500 text-slate-950 px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-emerald-400 transition shadow-lg shadow-emerald-500/20">
                        Guardar Configuración
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleFields() {
            const type = document.getElementById('registrarType').value;
            
            // Ocultar todos
            document.getElementById('godaddy_fields').classList.add('hidden');
            document.getElementById('resellerclub_fields').classList.add('hidden');

            // Mostrar seleccionado
            if (type === 'godaddy') {
                document.getElementById('godaddy_fields').classList.remove('hidden');
            } else if (type === 'resellerclub') {
                document.getElementById('resellerclub_fields').classList.remove('hidden');
            }
        }

        // Ejecutar al cargar por si hay old input
        document.addEventListener('DOMContentLoaded', toggleFields);
    </script>
@endsection