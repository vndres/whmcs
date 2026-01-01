<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\WhatsAppService; // Importamos tu servicio
use Illuminate\Support\Facades\Log;

class WhatsAppController extends Controller
{
    protected $whatsapp;

    // Inyectamos el servicio automáticamente
    public function __construct(WhatsAppService $whatsapp)
    {
        $this->whatsapp = $whatsapp;
    }

    /**
     * Muestra el panel de administración de WhatsApp
     * Aquí se ve el Estado y el Código QR
     */
    public function index()
    {
        // 1. Pedimos el estado actual al Bot de Node.js
        $data = $this->whatsapp->getStatus();

        // 2. Preparamos las variables para la vista
        // Si el bot está apagado, devolvemos valores por defecto para no romper la web
        $status = $data['status'] ?? 'ERROR';
        $qrCode = $data['qr_code'] ?? null;

        return view('admin.whatsapp.index', compact('status', 'qrCode'));
    }

    /**
     * Cierra la sesión de WhatsApp para poder escanear otro número
     */
    public function logout()
    {
        $success = $this->whatsapp->logout();

        if ($success) {
            return back()->with('success', 'Sesión cerrada correctamente. El sistema se está reiniciando para generar un nuevo QR.');
        }

        return back()->with('error', 'No se pudo cerrar la sesión. Verifica que el Bot esté encendido.');
    }

    /**
     * Envía un mensaje de prueba desde el panel
     */
    public function testMessage(Request $request)
    {
        $request->validate([
            'phone' => 'required|numeric',
            'message' => 'required|string'
        ]);

        $success = $this->whatsapp->send($request->phone, $request->message);

        if ($success) {
            return back()->with('success', '¡Mensaje de prueba enviado con éxito! 🚀');
        }

        return back()->with('error', 'Error al enviar. Revisa el log o el estado del bot.');
    }
}