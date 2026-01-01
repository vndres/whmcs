@extends('layouts.admin')

@section('admin-content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-50">Registradores de Dominio</h1>
            <p class="text-sm text-slate-400 mt-1">Configura las conexiones API con proveedores como GoDaddy, ResellerClub, etc.</p>
        </div>
        <a href="{{ route('admin.registrars.create') }}" 
           class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-xs font-semibold bg-emerald-500 text-slate-950 hover:bg-emerald-400 transition">
            + Nuevo Registrador
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 glass rounded-xl border border-emerald-600/60 px-4 py-3 text-xs text-emerald-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="glass rounded-2xl border border-slate-800 overflow-hidden">
        @if($registrars->isEmpty())
            <div class="p-8 text-center text-slate-400 text-sm">
                <p>No tienes registradores configurados aún.</p>
            </div>
        @else
            <table class="min-w-full text-xs text-slate-300">
                <thead class="bg-slate-900/80 border-b border-slate-800 text-slate-100">
                    <tr>
                        <th class="px-4 py-3 text-left">Nombre (Interno)</th>
                        <th class="px-4 py-3 text-left">Proveedor (API)</th>
                        <th class="px-4 py-3 text-left">Estado</th>
                        <th class="px-4 py-3 text-left">Fecha Creación</th>
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/80">
                    @foreach($registrars as $registrar)
                        <tr class="hover:bg-slate-900/60 transition">
                            <td class="px-4 py-3 font-medium text-slate-100">
                                {{ $registrar->name }}
                            </td>
                            <td class="px-4 py-3 capitalize">
                                {{ ucfirst($registrar->type) }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 rounded-full text-[10px] border {{ $registrar->is_active ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30' : 'bg-slate-700/50 text-slate-400 border-slate-600' }}">
                                    {{ $registrar->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                {{ $registrar->created_at->format('d/m/Y') }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.registrars.edit', $registrar) }}" 
                                   class="text-blue-400 hover:text-blue-300 mr-3 font-medium">
                                    Editar
                                </a>
                                {{-- Opcional: Botón eliminar --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection