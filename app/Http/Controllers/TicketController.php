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
            $tickets = collect();
            return view('client.tickets.index', compact('user', 'client', 'tickets'));
        }

        $tickets = Ticket::withCount('messages')
            ->where('client_id', $client->id)
            ->orderByRaw("FIELD(status, 'open', 'answered', 'closed')") // Ordenar por importancia
            ->orderByDesc('updated_at')
            ->paginate(10);

        // CORRECCIÓN: Apuntamos a la carpeta 'client'
        return view('client.tickets.index', compact('user', 'client', 'tickets'));
    }

    /**
     * Formulario para crear un nuevo ticket.
     */
    public function create()
    {
        $user   = Auth::user();
        $client = $user->client;

        if (!$client) {
            return redirect()->route('profile.edit')->with('error', 'Completa tu perfil para crear tickets.');
        }

        // CORRECCIÓN: Apuntamos a la carpeta 'client'
        return view('client.tickets.create', compact('user', 'client'));
    }
/**
     * Responder a un ticket existente.
     */
    public function reply(Request $request, $id)
    {
        $user = Auth::user();
        $client = $user->client;
        
        $ticket = Ticket::find($id);

        if (!$client || !$ticket || $ticket->client_id != $client->id) {
            abort(404);
        }

        $request->validate(['message' => 'required|string']);

        // Crear mensaje
        $ticket->messages()->create([
            'client_id' => $client->id,
            'message' => $request->message,
            'is_internal' => false
        ]);

        // Actualizar estado del ticket
        $ticket->update(['status' => 'customer-reply', 'updated_at' => now()]);

        return back()->with('success', 'Respuesta enviada correctamente.');
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
            'message.required' => 'Debes escribir un mensaje detallado.',
        ]);

        // Generar numero de ticket (T00000X)
        $nextId = (Ticket::max('id') ?? 0) + 1;
        $number = 'T' . str_pad($nextId, 6, '0', STR_PAD_LEFT);

        $ticket = Ticket::create([
            'number'     => $number,
            'client_id'  => $client->id,
            'user_id'    => null, // Creado por cliente, no usuario admin
            'department' => $data['department'] ?: 'Soporte General',
            'subject'    => $data['subject'],
            'status'     => 'open',
            'priority'   => $data['priority'] ?: 'medium',
        ]);

        // Guardar el primer mensaje
        $ticket->messages()->create([
            'user_id'     => null,
            'client_id'   => $client->id,
            'message'     => $data['message'],
            'is_internal' => false,
        ]);

        // CORRECCIÓN REDIRECCIÓN: Pasamos el ID explícitamente para evitar errores
        return redirect()
            ->route('tickets.show', $ticket->id) 
            ->with('success', 'Ticket #'.$number.' creado correctamente.');
    }

    /**
     * Muestra el detalle o conversacion de un ticket.
     */
    public function show($id) // Recibimos ID para mejor control
    {
        $user   = Auth::user();
        $client = $user->client;

        // Buscar Ticket
        $ticket = Ticket::with(['messages.user', 'messages.client'])->find($id);

        // 1. Validar existencia
        if (!$ticket) {
            abort(404, 'Ticket no encontrado');
        }

        // 2. SEGURIDAD (CORRECCIÓN): Usamos != en vez de !==
        if (!$client || $ticket->client_id != $client->id) {
            abort(404);
        }

        // Ordenar mensajes cronológicamente
        $ticket->load(['messages' => function ($q) {
            $q->orderBy('created_at', 'asc');
        }]);

        // CORRECCIÓN: Apuntamos a la carpeta 'client'
        return view('client.tickets.show', compact('user', 'client', 'ticket'));
    }
    
    /**
     * AJAX: Obtener solo los mensajes (para recarga automática)
     */
    public function fetchMessages($id)
    {
        $user = auth()->user();
        $client = $user->client;
        
        // Buscamos el ticket
        $ticket = Ticket::find($id);

        // Seguridad básica
        if(!$ticket) return ''; 
        if($client && $ticket->client_id != $client->id) return ''; // Si es cliente y no es suyo

        // Cargar mensajes ordenados
        $ticket->load(['messages' => function ($q) {
            $q->orderBy('created_at', 'asc');
        }]);

        // Retornamos SOLO la vista parcial
        return view('client.tickets.partials.messages', compact('ticket'));
    }
}