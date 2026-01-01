<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppChannel
{
    /**
     * Enviar la notificación dada.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        // 1. Verificar si la notificación tiene el método 'toWhatsApp'
        if (!method_exists($notification, 'toWhatsApp')) {
            return;
        }

        // 2. Obtener los datos (mensaje y número) desde la Notificación
        $data = $notification->toWhatsApp($notifiable);
        
        $message = $data['message'] ?? '';
        // Intentamos obtener el número del array $data, si no, del modelo User ($notifiable)
        $phone = $data['number'] ?? $notifiable->phone; 

        // Si no hay número, no podemos enviar nada
        if (empty($phone)) {
            Log::warning("WhatsAppChannel: Se intentó enviar mensaje sin número de destino.", [
                'user_id' => $notifiable->id ?? 'N/A'
            ]);
            return;
        }

        // 3. Enviar la petición a tu Bot de Node.js (en el subdominio)
        try {
            // URL de tu bot en cPanel (asegúrate que coincida con tu subdominio real)
            $botUrl = 'https://bot.linea365apps.com/send-message';
            
            // Si estás probando en local sin HTTPS, usa: 'http://localhost:3000/send-message'
            
            $response = Http::post($botUrl, [
                'number' => $phone,
                'message' => $message,
            ]);

            if ($response->failed()) {
                Log::error('WhatsAppChannel Error: El bot respondió con error.', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
            } else {
                Log::info("WhatsApp enviado correctamente a {$phone}");
            }

        } catch (\Exception $e) {
            Log::error('WhatsAppChannel Exception: No se pudo conectar con el Bot de Node.js.', [
                'error' => $e->getMessage()
            ]);
        }
    }
}