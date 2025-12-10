<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Lista los tickets del cliente logeado.
     */
    public function index(Request $request)
    {
        $user   = Auth::user();
        $client = $user->client;

        if (!$client) {
            // Usuario sin perfil de cliente
            $tickets = collect(); // coleccion vacia (sin paginacion)
            return view('dashboard.tickets.index', compact('user', 'client', 'tickets'));
        }

        $tickets = Ticket::withCount('messages')
            ->where('client_id', $client->id)
            ->orderByRaw("FIELD(status, 'open', 'answered', 'closed')")
            ->orderByDesc('updated_at')
            ->paginate(10);

        return view('dashboard.tickets.index', compact('user', 'client', 'tickets'));
    }

    /**
     * Formulario para crear un nuevo ticket.
     */
    public function create()
    {
        $user   = Auth::user();
        $client = $user->client;

        if (!$client) {
            abort(403, 'Tu usuario no tiene un cliente asociado.');
        }

        return view('dashboard.tickets.create', compact('user', 'client'));
    }

    /**
     * Guarda el ticket nuevo en base de datos.
     */
    public function store(Request $request)
    {
        $user   = Auth::user();
        $client = $user->client;

        if (!$client) {
            abort(403, 'Tu usuario no tiene un cliente asociado.');
        }

        $data = $request->validate([
            'subject'    => ['required', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:100'],
            'priority'   => ['nullable', 'in:low,medium,high'],
            'message'    => ['required', 'string'],
        ], [
            'subject.required' => 'El asunto es obligatorio.',
            'message.required' => 'Debes escribir un mensaje.',
        ]);

        // Generar numero de ticket tipo T000001, T000002, etc.
        $nextId = (Ticket::max('id') ?? 0) + 1;
        $number = 'T' . str_pad($nextId, 6, '0', STR_PAD_LEFT);

        $ticket = Ticket::create([
            'number'     => $number,
            'client_id'  => $client->id,
            'user_id'    => null,
            'department' => $data['department'] ?: 'Soporte',
            'subject'    => $data['subject'],
            'status'     => 'open',
            'priority'   => $data['priority'] ?: 'medium',
        ]);

        // Primer mensaje del cliente
        $ticket->messages()->create([
            'user_id'     => null,
            'client_id'   => $client->id,
            'message'     => $data['message'],
            'is_internal' => false,
        ]);

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('status', 'Tu ticket se creo correctamente. Nuestro equipo lo revisara pronto.');
    }

    /**
     * Muestra el detalle o conversacion de un ticket.
     */
    public function show(Ticket $ticket)
    {
        $user   = Auth::user();
        $client = $user->client;

        // Seguridad: que el ticket sea del cliente logeado
        if (!$client || $ticket->client_id !== $client->id) {
            abort(404);
        }

        $ticket->load([
            'client',
            'messages' => function ($q) {
                $q->orderBy('created_at', 'asc');
            },
            'messages.user',
            'messages.client',
        ]);

        return view('dashboard.tickets.show', compact('user', 'client', 'ticket'));
    }
}
