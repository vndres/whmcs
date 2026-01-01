@extends('layouts.admin')

@section('admin-content')
<div class="max-w-5xl mx-auto">
    <div class="flex items-center justify-between mb-6">
        <div>
            <a href="{{ route('admin.tickets.index') }}" class="text-xs text-slate-400 hover:text-white mb-2 inline-block">&larr; Volver a la lista</a>
            <h1 class="text-xl font-semibold text-slate-50">Ticket #{{ $ticket->number }}</h1>
            <p class="text-sm text-slate-400">{{ $ticket->subject }}</p>
        </div>
        <div class="flex gap-3">
            <form action="{{ route('admin.tickets.destroy', $ticket) }}" method="POST" onsubmit="return confirm('¿Borrar ticket?');">
                @csrf @method('DELETE')
                <button class="px-3 py-2 rounded-xl border border-rose-900/50 text-rose-400 text-xs hover:bg-rose-900/20">Eliminar</button>
            </form>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        {{-- Columna Izquierda: Conversación --}}
        <div class="lg:col-span-2 space-y-4">
            
            {{-- Caja de mensajes --}}
            <div class="glass rounded-2xl border border-slate-800 p-4 space-y-4 max-h-[600px] overflow-y-auto">
                @foreach($ticket->messages as $msg)
                    @php
                        // Si tiene client_id es un mensaje del cliente (Izquierda)
                        // Si tiene user_id es un mensaje del staff/admin (Derecha)
                        $isStaff = !is_null($msg->user_id);
                    @endphp
                    
                    <div class="flex w-full {{ $isStaff ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-[85%] {{ $isStaff ? 'bg-emerald-900/20 border-emerald-500/20' : 'bg-slate-800/50 border-slate-700' }} border rounded-2xl p-3">
                            <div class="flex items-center justify-between gap-4 mb-1 text-[10px]">
                                <span class="font-bold {{ $isStaff ? 'text-emerald-400' : 'text-slate-300' }}">
                                    {{ $isStaff ? ($msg->user->name ?? 'Staff') : ($msg->client->first_name ?? 'Cliente') }}
                                </span>
                                <span class="text-slate-500">{{ $msg->created_at->format('d/m H:i') }}</span>
                            </div>
                            <div class="text-sm text-slate-200 whitespace-pre-wrap">{{ $msg->message }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Caja de respuesta --}}
            <div class="glass rounded-2xl border border-slate-800 p-4">
                <h3 class="text-sm font-semibold text-slate-100 mb-3">Responder Ticket</h3>
                <form action="{{ route('admin.tickets.reply', $ticket) }}" method="POST">
                    @csrf
                    <textarea name="message" rows="4" class="w-full bg-slate-900/50 border border-slate-700 rounded-xl p-3 text-sm text-slate-200 focus:border-emerald-500 focus:outline-none mb-3" placeholder="Escribe tu respuesta aquí..."></textarea>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="text-xs text-slate-400">Cambiar estado a:</span>
                            <select name="status" class="bg-slate-900 border border-slate-700 text-xs text-slate-200 rounded-lg px-2 py-1">
                                <option value="answered" selected>Respondido</option>
                                <option value="open">Abierto (En progreso)</option>
                                <option value="closed">Cerrado</option>
                            </select>
                        </div>
                        <button type="submit" class="bg-emerald-500 text-slate-950 px-4 py-2 rounded-xl text-xs font-bold hover:bg-emerald-400 transition">Enviar Respuesta</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Columna Derecha: Info Cliente --}}
        <div class="space-y-4">
            <div class="glass rounded-2xl border border-slate-800 p-4">
                <h3 class="text-xs font-semibold text-slate-400 uppercase mb-3">Información del Cliente</h3>
                @if($ticket->client)
                    <div class="flex items-center gap-3 mb-3">
                        <div class="h-8 w-8 rounded-full bg-slate-700 flex items-center justify-center text-xs font-bold">
                            {{ substr($ticket->client->first_name, 0, 1) }}
                        </div>
                        <div>
                            <div class="text-sm text-slate-200">{{ $ticket->client->first_name }} {{ $ticket->client->last_name }}</div>
                            <div class="text-xs text-slate-500">{{ $ticket->client->email }}</div>
                        </div>
                    </div>
                    <div class="border-t border-slate-800 pt-3 space-y-2 text-xs">
                        <div class="flex justify-between">
                            <span class="text-slate-500">Servicios Activos:</span>
                            <span class="text-slate-200">{{ $ticket->client->services()->where('status', 'active')->count() }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-500">País:</span>
                            <span class="text-slate-200">{{ $ticket->client->country }}</span>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.clients.edit', $ticket->client) }}" class="block w-full text-center py-2 rounded-lg border border-slate-700 text-xs text-slate-300 hover:bg-slate-800">Ver Perfil Completo</a>
                    </div>
                @else
                    <p class="text-xs text-slate-500 italic">Este ticket no está asociado a un cliente registrado (Ticket interno o usuario eliminado).</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection