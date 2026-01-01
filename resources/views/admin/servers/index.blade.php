@extends('layouts.admin')

@section('admin-content')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-slate-50">Servidores & APIs</h1>
            <p class="text-sm text-slate-400 mt-1">Administra las conexiones a tus servidores de hosting (cPanel/WHM, Plesk, etc).</p>
        </div>
        <a href="{{ route('admin.servers.create') }}" 
           class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-xs font-semibold bg-emerald-500 text-slate-950 hover:bg-emerald-400 transition">
            + Nuevo Servidor
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 glass rounded-xl border border-emerald-600/60 px-4 py-3 text-xs text-emerald-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="glass rounded-2xl border border-slate-800 overflow-hidden">
        @if($servers->isEmpty())
            <div class="p-8 text-center text-slate-400 text-sm">
                <p>No hay servidores configurados. Agrega el primero para empezar a aprovisionar cuentas.</p>
            </div>
        @else
            <table class="min-w-full text-xs text-slate-300">
                <thead class="bg-slate-900/80 border-b border-slate-800 text-slate-100">
                    <tr>
                        <th class="px-4 py-3 text-left">Nombre</th>
                        <th class="px-4 py-3 text-left">Hostname / IP</th>
                        <th class="px-4 py-3 text-left">Tipo</th>
                        <th class="px-4 py-3 text-left">Conexión</th>
                        <th class="px-4 py-3 text-left">Estado</th>
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/80">
                    @foreach($servers as $server)
                        <tr class="hover:bg-slate-900/60 transition">
                            <td class="px-4 py-3 font-medium text-slate-100">
                                {{ $server->name }}
                            </td>
                            <td class="px-4 py-3">
                                <div>{{ $server->hostname }}</div>
                                <div class="text-slate-500 text-[10px]">{{ $server->ip_address }}</div>
                            </td>
                            <td class="px-4 py-3 capitalize">
                                {{ $server->type }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="text-[10px] px-1.5 py-0.5 rounded border {{ $server->use_ssl ? 'border-emerald-500/30 text-emerald-400' : 'border-slate-600 text-slate-400' }}">
                                    {{ $server->use_ssl ? 'SSL (https)' : 'No SSL' }}
                                </span>
                                <span class="ml-1 text-[10px] text-slate-500">Puerto: {{ $server->port }}</span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-0.5 rounded-full text-[10px] border {{ $server->is_active ? 'bg-emerald-500/10 text-emerald-400 border-emerald-500/30' : 'bg-slate-700/50 text-slate-400 border-slate-600' }}">
                                    {{ $server->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.servers.edit', $server) }}" 
                                   class="text-blue-400 hover:text-blue-300 mr-3 font-medium">
                                    Editar
                                </a>
                                <form action="{{ route('admin.servers.destroy', $server) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar servidor? Esto afectará a los productos asignados.');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-rose-400 hover:text-rose-300">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        
        @if($servers->hasPages())
            <div class="p-4 border-t border-slate-800">
                {{ $servers->links() }}
            </div>
        @endif
    </div>
@endsection