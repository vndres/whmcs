@extends('layouts.frontend')

@section('title', 'Ticket #' . $ticket->number)

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">

    {{-- Header del Ticket --}}
    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <a href="{{ route('tickets.index') }}" class="text-xs text-slate-400 hover:text-white transition flex items-center gap-1 mb-2">
                &larr; Volver
            </a>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-bold text-white">{{ $ticket->subject }}</h1>
                <span class="px-2 py-0.5 rounded text-[10px] font-mono bg-slate-800 text-slate-400 border border-slate-700">#{{ $ticket->number }}</span>
            </div>
        </div>
        
        <div class="flex gap-2">
            @if($ticket->status !== 'closed')
                <div class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-3 py-1 rounded-lg text-xs font-bold flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Abierto
                </div>
            @else
                <div class="bg-slate-800 text-slate-400 px-3 py-1 rounded-lg text-xs font-bold border border-slate-700">
                    Cerrado
                </div>
            @endif
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        
        {{-- COLUMNA IZQUIERDA: CONVERSACIÓN --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- CONTENEDOR DEL CHAT DINÁMICO --}}
            {{-- ID 'chat-container' es usado por el JS para actualizar el contenido --}}
            <div id="chat-container" class="space-y-4 max-h-[600px] overflow-y-auto pr-2">
                @include('client.tickets.partials.messages')
            </div>

            {{-- Indicador visual de actualización (opcional) --}}
            <div id="loading-indicator" class="hidden text-center text-[10px] text-slate-600 uppercase tracking-widest animate-pulse">
                Sincronizando chat...
            </div>

            @if($ticket->status !== 'closed')
                {{-- FORMULARIO DE RESPUESTA --}}
                <div class="mt-8 pt-6 border-t border-slate-800">
                    <h3 class="text-lg font-bold text-white mb-4">Responder</h3>
                    
                    <form action="{{ route('tickets.reply', $ticket->id) }}" method="POST" id="reply-form">
                        @csrf
                        <div class="relative">
                            <textarea name="message" id="message-input" rows="4" class="w-full bg-slate-900 border border-slate-700 rounded-xl p-4 text-slate-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 focus:outline-none transition" placeholder="Escribe tu respuesta aquí..." required></textarea>
                            <button type="submit" id="send-btn" class="absolute bottom-3 right-3 bg-emerald-600 hover:bg-emerald-500 text-white p-2 rounded-lg transition shadow-lg" title="Enviar Respuesta">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            </button>
                        </div>
                    </form>
                </div>
            @else
                <div class="p-4 bg-slate-800/50 border border-slate-700 rounded-xl text-center text-slate-400 text-sm">
                    Este ticket ha sido cerrado. Si necesitas más ayuda, por favor abre uno nuevo.
                </div>
            @endif

        </div>

        {{-- COLUMNA DERECHA: INFO LATERAL --}}
        <div class="lg:col-span-1">
            <div class="glass rounded-2xl border border-slate-800 p-6 sticky top-24 space-y-6">
                
                <div>
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Departamento</h4>
                    <p class="text-white font-medium">{{ $ticket->department }}</p>
                </div>

                <div>
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Prioridad</h4>
                    @if($ticket->priority == 'high')
                        <span class="text-rose-400 font-bold flex items-center gap-1">🔴 Alta</span>
                    @elseif($ticket->priority == 'medium')
                        <span class="text-amber-400 font-bold flex items-center gap-1">🟠 Media</span>
                    @else
                        <span class="text-emerald-400 font-bold flex items-center gap-1">🟢 Baja</span>
                    @endif
                </div>

                <div>
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Fecha de Creación</h4>
                    <p class="text-slate-300 text-sm">{{ $ticket->created_at->format('d/m/Y h:i A') }}</p>
                </div>

                <div class="pt-4 border-t border-slate-700">
                    {{-- Aquí podrías poner un botón real si implementas la lógica de cerrar --}}
                    <button disabled class="block w-full text-center py-2 border border-rose-500/30 text-rose-400/50 cursor-not-allowed rounded-lg text-xs transition">
                        Solicitar Cierre
                    </button>
                </div>

            </div>
        </div>

    </div>
</div>

{{-- SCRIPT PARA ACTUALIZACIÓN AUTOMÁTICA (POLLING) --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ticketId = "{{ $ticket->id }}";
        const chatContainer = document.getElementById('chat-container');
        let isScrolledToBottom = true;

        // Función para bajar el scroll al final
        function scrollToBottom() {
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }

        // Bajar scroll inmediatamente al cargar la página
        scrollToBottom();

        // Detectar si el usuario subió el scroll manualmente (para no molestarlo bajándolo)
        chatContainer.addEventListener('scroll', () => {
            const threshold = 100; // margen de píxeles
            const position = chatContainer.scrollTop + chatContainer.offsetHeight;
            const height = chatContainer.scrollHeight;
            // Si la posición está cerca del final, consideramos que está abajo
            isScrolledToBottom = position > height - threshold;
        });

        // POLLING: Ejecutar cada 4000ms (4 segundos)
        setInterval(() => {
            // Llamada AJAX a la ruta que devuelve solo los mensajes (partial)
            fetch(`/tickets/${ticketId}/messages`)
                .then(response => {
                    if (!response.ok) throw new Error('Error de red');
                    return response.text();
                })
                .then(html => {
                    // Si el servidor devuelve contenido, actualizamos el div
                    if(html.trim() !== "") {
                        // Guardamos la altura antigua para comparar si llegaron mensajes nuevos
                        const oldScrollHeight = chatContainer.scrollHeight;
                        
                        chatContainer.innerHTML = html;

                        // Solo bajamos el scroll si el usuario ya estaba abajo
                        // O si es la primera carga dinámica y hay diferencia de altura
                        if (isScrolledToBottom) {
                            scrollToBottom();
                        }
                    }
                })
                .catch(err => {
                    console.log('Sincronización en pausa (conexión)...');
                });
        }, 4000);

        // UX: Efecto de carga al enviar el formulario
        const form = document.getElementById('reply-form');
        if(form) {
            form.addEventListener('submit', function() {
                const btn = document.getElementById('send-btn');
                const textarea = document.getElementById('message-input');
                
                btn.disabled = true;
                btn.innerHTML = '<span class="animate-spin inline-block w-4 h-4 border-2 border-white border-t-transparent rounded-full"></span>';
                textarea.classList.add('opacity-50', 'cursor-not-allowed');
            });
        }
    });
</script>
@endsection