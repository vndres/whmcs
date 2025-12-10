@extends('layouts.frontend')

@section('title', 'Ticket #' . $ticket->number . ' - Linea365 Clientes')

@section('content')
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

    <section class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-slate-50">
                    Ticket #{{ $ticket->number }}
                </h1>
                <p class="text-sm text-slate-400 mt-1">
                    {{ $ticket->subject }}
                </p>
                <p class="text-xs text-slate-500 mt-1">
                    Cliente: {{ $client->full_name }} (ID #{{ $client->id }}) · {{ $client->email }}<br>
                    Departamento: {{ $ticket->department ?? 'General' }}
                </p>
            </div>

            <div class="text-right space-y-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-[11px] font-semibold {{ $statusClass }}">
                    {{ $statusLabel }}
                </span>
                <div class="text-xs {{ $priorityClass }}">
                    Prioridad: {{ $priorityLabel }}
                </div>
                <div class="text-xs text-slate-400">
                    Creado: {{ $ticket->created_at?->format('d/m/Y H:i') ?? '—' }}<br>
                    Actualizado: {{ $ticket->updated_at?->format('d/m/Y H:i') ?? '—' }}
                </div>
            </div>
        </div>

        {{-- Conversación --}}
        <div class="glass rounded-2xl border border-slate-800 p-4 sm:p-5 mb-6">
            <div class="text-sm font-semibold text-slate-100 mb-4">
                Conversación
            </div>

            @forelse($ticket->messages as $message)
                @php
                    $isClientMessage = $message->client_id === $client->id;
                    $isInternal      = $message->is_internal;
                    $authorLabel = $isClientMessage
                        ? 'Tú'
                        : ($message->user?->name ?? 'Soporte');

                    $alignClass = $isClientMessage ? 'items-end' : 'items-start';
                    $bubbleClass = $isClientMessage
                        ? 'bg-emerald-500/15 border border-emerald-500/40 text-emerald-50'
                        : 'bg-slate-800/70 border border-slate-700 text-slate-50';
                @endphp

                @if(!$isInternal)
                    <div class="flex {{ $alignClass }} mb-4">
                        <div class="max-w-[80%]">
                            <div class="text-[11px] text-slate-400 mb-1">
                                {{ $authorLabel }}
                                <span class="mx-1 text-slate-600">·</span>
                                {{ $message->created_at?->format('d/m/Y H:i') ?? '' }}
                            </div>
                            <div class="rounded-2xl px-3 py-2 text-sm leading-relaxed {{ $bubbleClass }}">
                                {!! nl2br(e($message->message)) !!}
                            </div>
                        </div>
                    </div>
                @endif
            @empty
                <div class="text-sm text-slate-400">
                    No hay mensajes registrados en este ticket.
                </div>
            @endforelse
        </div>

        <div class="flex items-center justify-between text-xs text-slate-500">
            <a href="{{ route('tickets.index') }}" class="text-emerald-400 hover:text-emerald-300">
                ← Volver al listado de tickets
            </a>

            <div class="flex items-center gap-3">
                {{-- Botón futuro para responder desde el cliente --}}
                <button
                    type="button"
                    class="px-3 py-1.5 rounded-lg text-[11px] font-semibold border border-slate-700 text-slate-200 hover:bg-slate-800/80 transition"
                    disabled
                >
                    Responder (próximamente)
                </button>
            </div>
        </div>
    </section>
@endsection
