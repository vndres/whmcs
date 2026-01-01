@extends('layouts.frontend')

@section('title', 'Mis tickets - Linea365 Clientes')

@section('content')
    <section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
    <div>
        <h1 class="text-2xl font-semibold text-slate-50">
            Mis tickets de soporte
        </h1>
        <p class="text-sm text-slate-400 mt-1">
            Consulta el estado de tus solicitudes y el historial de conversaciones con soporte.
        </p>
    </div>

    <div class="flex flex-col sm:items-end gap-2">
        <div class="text-xs text-slate-400 text-right">
            Sesión iniciada como
            <span class="text-slate-100 font-medium">{{ $user->email }}</span><br>
            @if($client)
                <span class="text-[11px] text-slate-500">
                    Cliente: {{ $client->full_name }} (ID #{{ $client->id }})
                </span>
            @endif
        </div>

        @if($client)
            <a href="{{ route('tickets.create') }}"
               class="inline-flex items-center justify-center px-4 py-2 rounded-xl text-xs font-semibold bg-emerald-500 hover:bg-emerald-400 text-slate-900 shadow-lg shadow-emerald-500/30 transition">
                + Nuevo ticket
            </a>
        @endif
    </div>
</div>


        @if (!$client)
            <div class="glass rounded-2xl p-5 border border-slate-800 text-sm text-slate-300">
                Tu usuario aún no tiene un perfil de cliente asociado.
                <br>
                <span class="text-slate-400 text-xs">
                    Verifica que la tabla <code>clients</code> tenga el campo <code>user_id</code> vinculado a tu usuario.
                </span>
            </div>
        @elseif ($tickets->count() === 0)
            <div class="glass rounded-2xl p-5 border border-slate-800 text-sm text-slate-300">
                No tienes tickets de soporte por el momento.
                <br>
                <span class="text-slate-400 text-xs">
                    Cuando abras un ticket de soporte, aparecerá listado aquí.
                </span>
            </div>
        @else
            <div class="glass rounded-2xl border border-slate-800 overflow-hidden">
                <div class="px-4 py-3 border-b border-slate-800 flex items-center justify-between">
                    <div class="text-sm font-semibold text-slate-100">
                        Tickets de {{ $client->full_name }}
                    </div>
                    <div class="text-[11px] text-slate-400">
                        Total: {{ $tickets->total() }}
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-xs text-slate-200">
                        <thead class="bg-slate-900/80 border-b border-slate-800">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">Ticket</th>
                                <th class="px-4 py-3 text-left font-semibold">Departamento</th>
                                <th class="px-4 py-3 text-left font-semibold">Estado</th>
                                <th class="px-4 py-3 text-left font-semibold">Prioridad</th>
                                <th class="px-4 py-3 text-left font-semibold">Última actualización</th>
                                <th class="px-4 py-3 text-right font-semibold">Mensajes</th>
                                <th class="px-4 py-3 text-right font-semibold">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/80">
                            @foreach ($tickets as $ticket)
                                @php
                                    $statusLabel = match ($ticket->status) {
                                        'open'     => 'Abierto',
                                        'answered' => 'Respondido',
                                        'closed'   => 'Cerrado',
                                        default    => ucfirst($ticket->status ?? 'Desconocido'),
                                    };

                                    $statusClass = match ($ticket->status) {
                                        'open'     => 'bg-emerald-500/15 text-emerald-300 border border-emerald-500/40',
                                        'answered' => 'bg-yellow-500/15 text-yellow-300 border border-yellow-500/40',
                                        'closed'   => 'bg-slate-600/30 text-slate-200 border border-slate-500/50',
                                        default    => 'bg-slate-700/40 text-slate-200 border border-slate-500/40',
                                    };

                                    $priorityLabel = match ($ticket->priority) {
                                        'low'    => 'Baja',
                                        'medium' => 'Media',
                                        'high'   => 'Alta',
                                        default  => ucfirst($ticket->priority ?? '—'),
                                    };

                                    $priorityClass = match ($ticket->priority) {
                                        'low'    => 'text-slate-300',
                                        'medium' => 'text-yellow-300',
                                        'high'   => 'text-rose-300',
                                        default  => 'text-slate-300',
                                    };
                                @endphp

                                <tr class="hover:bg-slate-900/60 transition">
                                    <td class="px-4 py-3 align-top">
                                        <div class="text-sm text-slate-50">
                                            #{{ $ticket->number }} · {{ $ticket->subject }}
                                        </div>
                                        <div class="text-[11px] text-slate-400 mt-0.5">
                                            ID interna: {{ $ticket->id }}
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 align-top text-sm">
                                        {{ $ticket->department ?? 'General' }}
                                    </td>
                                    <td class="px-4 py-3 align-top">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] {{ $statusClass }}">
                                            {{ $statusLabel }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 align-top">
                                        <span class="text-[11px] {{ $priorityClass }}">
                                            {{ $priorityLabel }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 align-top text-sm whitespace-nowrap">
                                        {{ $ticket->updated_at?->format('d/m/Y H:i') ?? '—' }}
                                    </td>
                                    <td class="px-4 py-3 align-top text-right text-sm">
                                        {{ $ticket->messages_count ?? 0 }}
                                    </td>
                                    <td class="px-4 py-3 align-top text-right">
                                        <a href="{{ route('tickets.show', $ticket) }}"
                                           class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg text-[11px] font-semibold btn-outline">
                                            Ver conversación
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if (method_exists($tickets, 'hasPages') && $tickets->hasPages())
                    <div class="px-4 py-3 border-t border-slate-800">
                        <div class="text-[11px] text-slate-400 mb-2">
                            Mostrando {{ $tickets->firstItem() }}–{{ $tickets->lastItem() }} de {{ $tickets->total() }} tickets
                        </div>
                        <div class="text-xs">
                            {{ $tickets->links() }}
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </section>
@endsection
