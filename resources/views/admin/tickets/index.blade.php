@extends('layouts.admin')

@section('admin-content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-semibold text-slate-50">Soporte Técnico</h1>
</div>

{{-- Filtros rápidos --}}
<div class="flex gap-2 mb-4 text-xs">
    <a href="{{ route('admin.tickets.index') }}" class="px-3 py-1.5 rounded-lg border border-slate-700 text-slate-300 hover:bg-slate-800 {{ !request('status') ? 'bg-slate-800 text-white' : '' }}">Todos</a>
    <a href="{{ route('admin.tickets.index', ['status' => 'open']) }}" class="px-3 py-1.5 rounded-lg border border-slate-700 text-emerald-400 hover:bg-slate-800 {{ request('status') == 'open' ? 'bg-slate-800' : '' }}">Abiertos</a>
    <a href="{{ route('admin.tickets.index', ['status' => 'answered']) }}" class="px-3 py-1.5 rounded-lg border border-slate-700 text-blue-400 hover:bg-slate-800 {{ request('status') == 'answered' ? 'bg-slate-800' : '' }}">Respondidos</a>
</div>

<div class="glass rounded-2xl border border-slate-800 overflow-hidden">
    <table class="min-w-full text-xs text-slate-300">
        <thead class="bg-slate-900/80 border-b border-slate-800 font-semibold text-slate-200">
            <tr>
                <th class="px-4 py-3 text-left">Asunto / ID</th>
                <th class="px-4 py-3 text-left">Solicitante</th>
                <th class="px-4 py-3 text-left">Estado</th>
                <th class="px-4 py-3 text-left">Última Act.</th>
                <th class="px-4 py-3 text-right">Acción</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-800/80">
            @forelse($tickets as $ticket)
            <tr class="hover:bg-slate-900/60 transition">
                <td class="px-4 py-3">
                    <div class="font-medium text-slate-100">{{ $ticket->subject }}</div>
                    <div class="text-[10px] text-emerald-400 font-mono">#{{ $ticket->number }}</div>
                </td>
                <td class="px-4 py-3">
                    @if($ticket->client)
                        {{ $ticket->client->first_name }} {{ $ticket->client->last_name }}
                        <div class="text-[10px] text-slate-500">Cliente</div>
                    @elseif($ticket->user)
                        {{ $ticket->user->name }}
                        <div class="text-[10px] text-amber-500">Staff (Interno)</div>
                    @else
                        <span class="text-slate-500">Desconocido</span>
                    @endif
                </td>
                <td class="px-4 py-3">
                    @php
                        $statusColors = [
                            'open' => 'bg-emerald-500/10 text-emerald-400 border-emerald-500/20',
                            'answered' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                            'closed' => 'bg-slate-700/30 text-slate-400 border-slate-600/30',
                        ];
                        $color = $statusColors[$ticket->status] ?? 'bg-slate-800 text-slate-300';
                    @endphp
                    <span class="px-2 py-0.5 rounded-full text-[10px] border {{ $color }}">
                        {{ ucfirst($ticket->status) }}
                    </span>
                </td>
                <td class="px-4 py-3">{{ $ticket->updated_at->diffForHumans() }}</td>
                <td class="px-4 py-3 text-right">
                    <a href="{{ route('admin.tickets.show', $ticket) }}" class="inline-flex items-center justify-center px-3 py-1.5 rounded-lg text-[11px] font-semibold bg-emerald-500 text-slate-950 hover:bg-emerald-400 transition">Responder</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-4 py-8 text-center text-slate-500">No hay tickets pendientes.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="p-4 border-t border-slate-800">
        {{ $tickets->links() }}
    </div>
</div>
@endsection