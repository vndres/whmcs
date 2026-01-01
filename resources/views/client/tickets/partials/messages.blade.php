@foreach($ticket->messages as $msg)
    @php
        // Lógica para determinar quién envía
        $isMe = false;
        
        // Si estoy en panel CLIENTE:
        if(auth()->user()->client) {
            $isMe = !empty($msg->client_id); // Si tiene client_id, fui yo
        } 
        // Si estuviera en panel ADMIN (para futuro):
        else {
            $isMe = !empty($msg->user_id); // Si tiene user_id, fui yo (staff)
        }
    @endphp

    <div class="flex {{ $isMe ? 'justify-end' : 'justify-start' }} mb-4">
        <div class="max-w-[90%] {{ $isMe ? 'bg-emerald-500/10 border border-emerald-500/20 rounded-l-2xl rounded-tr-2xl' : 'bg-slate-800 border border-slate-700 rounded-r-2xl rounded-tl-2xl' }} p-5 relative group animate-fade-in">
            
            {{-- Cabecera --}}
            <div class="flex items-center justify-between gap-4 mb-2 text-xs">
                <span class="font-bold {{ $isMe ? 'text-emerald-400' : 'text-blue-400' }}">
                    {{ $isMe ? 'Tú' : ($msg->user ? 'Agente de Soporte' : 'Cliente') }}
                </span>
                <span class="text-slate-500 text-[10px]">
                    {{ $msg->created_at->format('d/m h:i A') }}
                </span>
            </div>

            {{-- Mensaje --}}
            <div class="prose prose-invert prose-sm text-slate-200 leading-relaxed break-words">
                {!! nl2br(e($msg->message)) !!}
            </div>
        </div>
    </div>
@endforeach

{{-- Si no hay mensajes --}}
@if($ticket->messages->count() == 0)
    <div class="text-center text-slate-500 py-10">
        <p>Aún no hay mensajes en esta conversación.</p>
    </div>
@endif