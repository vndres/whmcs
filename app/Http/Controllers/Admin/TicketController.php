<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    // Listar tickets en el panel admin
    public function index(Request $request)
    {
        $status = $request->get('status');

        $tickets = Ticket::with(['client', 'user']) // Cargamos cliente y usuario creador
            ->when($status, function ($q) use ($status) {
                return $q->where('status', $status);
            })
            // Ordenar: Prioridad a los abiertos, luego respondidos, al final cerrados
            ->orderByRaw("FIELD(status, 'open', 'answered', 'closed')")
            ->orderByDesc('updated_at')
            ->paginate(15);

        return view('admin.tickets.index', compact('tickets'));
    }

    // Ver detalle y conversar
    public function show(Ticket $ticket)
    {
        // Cargar mensajes y sus autores (usuario o cliente)
        $ticket->load(['messages.user', 'messages.client', 'client']);
        return view('admin.tickets.show', compact('ticket'));
    }

    // Responder ticket (Como Admin)
    public function reply(Request $request, Ticket $ticket)
    {
        $request->validate([
            'message' => 'required|string',
            'status'  => 'required|in:open,answered,closed'
        ]);

        // Crear el mensaje en la tabla 'ticket_messages'
        // IMPORTANTE: Al ser admin, llenamos 'user_id' y dejamos 'client_id' en NULL
        TicketMessage::create([
            'ticket_id'   => $ticket->id,
            'user_id'     => Auth::id(), 
            'client_id'   => null,       
            'message'     => $request->message,
            'is_internal' => false, // Opcional: podrías agregar un checkbox para notas internas
        ]);

        // Actualizar estado del ticket
        $ticket->update([
            'status' => $request->status,
            'updated_at' => now(), // Forzar actualización de fecha para que suba en la lista
        ]);

        return back()->with('success', 'Respuesta enviada correctamente.');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->messages()->delete();
        $ticket->delete();
        return redirect()->route('admin.tickets.index')->with('success', 'Ticket eliminado.');
    }
}