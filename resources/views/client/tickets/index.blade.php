@extends('layouts.frontend')

@section('title', 'Mis Tickets de Soporte')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    {{-- Encabezado --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-white">Centro de Soporte</h1>
            <p class="text-slate-400 text-sm">Gestiona tus consultas y solicitudes de ayuda.</p>
        </div>
        <a href="{{ route('tickets.create') }}" class="btn-primary bg-emerald-600 hover:bg-emerald-500 text-white px-5 py-2.5 rounded-xl font-bold text-sm shadow-lg shadow-emerald-900/20 transition flex items-center gap-2">
            <span>+</span> Abrir Nuevo Ticket
        </a>
    </div>

    {{-- Estado Vacío --}}
    @if($tickets->isEmpty())
        <div class="glass p-12 rounded-2xl border border-slate-800 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-800/50 text-4xl mb-4 text-slate-500">
                🎫
            </div>
            <h3 class="text-lg font-bold text-white">No tienes tickets abiertos</h3>
            <p class="text-slate-400 mt-2 text-sm max-w-md mx-auto">
                Si tienes alguna duda técnica o de facturación, crea un ticket y nuestro equipo te responderá rápidamente.
            </p>
        </div>
    @else
        {{-- Tabla de Tickets --}}
        <div class="glass rounded-2xl border border-slate-800 overflow-hidden shadow-2xl shadow-black/20">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-400">
                    <thead class="bg-slate-900/90 text-slate-300 uppercase text-[10px] font-bold tracking-wider border-b border-slate-800">
                        <tr>
                            <th class="px-6 py-4">Asunto / ID</th>
                            <th class="px-6 py-4">Departamento</th>
                            <th class="px-6 py-4">Última Actualización</th>
                            <th class="px-6 py-4 text-center">Estado</th>
                            <th class="px-6 py-4 text-right">Acción</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/50">
                        @foreach($tickets as $ticket)
                        <tr class="hover:bg-slate-800/40 transition group">
                            {{-- Asunto e ID --}}
                            <td class="px-6 py-4 align-top">
                                <div class="font-bold text-white text-base group-hover:text-emerald-400 transition">
                                    {{ $ticket->subject }}
                                </div>
                                <div class="text-[11px] text-slate-500 font-mono mt-1">
                                    #{{ $ticket->number }}
                                </div>
                            </td>
                            
                            {{-- Departamento --}}
                            <td class="px-6 py-4 align-top text-slate-300">
                                {{ $ticket->department }}
                            </td>

                            {{-- Fecha --}}
                            <td class="px-6 py-4 align-top">
                                {{ $ticket->updated_at->diffForHumans() }}
                            </td>

                            {{-- Estado --}}
                            <td class="px-6 py-4 text-center align-top">
                                @php
                                    $statusColors = [
                                        'open' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                                        'answered' => 'bg-blue-500/10 text-blue-400 border-blue-500/20', // Respondido por Staff
                                        'customer-reply' => 'bg-amber-500/10 text-amber-400 border-amber-500/20', // Esperando Staff
                                        'closed' => 'bg-slate-700/50 text-slate-400 border-slate-600/50',
                                    ];
                                    $statusClass = $statusColors[$ticket->status] ?? 'bg-slate-700 text-slate-300';
                                    
                                    $statusLabels = [
                                        'open' => 'Abierto',
                                        'answered' => 'Respondido',
                                        'customer-reply' => 'Esperando Respuesta',
                                        'closed' => 'Cerrado',
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $statusClass }}">
                                    {{ $statusLabels[$ticket->status] ?? ucfirst($ticket->status) }}
                                </span>
                            </td>

                            {{-- Botón --}}
                            <td class="px-6 py-4 text-right align-top">
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="inline-flex items-center gap-1 border border-slate-700 hover:bg-slate-800 text-slate-300 hover:text-white text-xs font-medium px-4 py-2 rounded-lg transition">
                                    Ver Conversación
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($tickets->hasPages())
                <div class="px-6 py-4 border-t border-slate-800">
                    {{ $tickets->links() }}
                </div>
            @endif
        </div>
    @endif
</div>
@endsection