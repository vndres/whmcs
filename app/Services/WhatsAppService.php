<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = env('WHATSAPP_BOT_URL', 'http://127.0.0.1:3000');
    }

    /**
     * Obtener el estado actual y el código QR (si existe)
     * Retorna array: ['status' => 'READY|QR_READY...', 'qr_code' => 'string...']
     */
    public function getStatus()
    {
        try {
            $response = Http::timeout(5)->get("{$this->baseUrl}/status");
            
            if ($response->successful()) {
                return $response->json();
            }
            return ['status' => 'ERROR', 'qr_code' => null];

        } catch (\Exception $e) {
            return ['status' => 'SERVER_DOWN', 'qr_code' => null];
        }
    }

    /**
     * Cerrar la sesión actual de WhatsApp
     */
    public function logout()
    {
        try {
            $response = Http::timeout(20)->post("{$this->baseUrl}/logout");
            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Error logout WhatsApp: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Enviar mensaje de texto
     */
    public function send($phone, $message)
    {
        try {
            $phone = preg_replace('/[^0-9]/', '', $phone);
            $response = Http::timeout(10)->post("{$this->baseUrl}/send-message", [
                'number' => $phone,
                'message' => $message,
            ]);
            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Fallo WhatsApp Text: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Enviar Archivos
     */
    public function sendMedia($phone, $filePath, $caption = '')
    {
        try {
            $phone = preg_replace('/[^0-9]/', '', $phone);
            if (!file_exists($filePath)) {
                return false;
            }
            $response = Http::timeout(30)->post("{$this->baseUrl}/send-media", [
                'number' => $phone,
                'filePath' => $filePath, 
                'caption' => $caption,
            ]);
            return $response->successful();
        } catch (\Exception $e) {
            Log::error('Fallo WhatsApp Media: ' . $e->getMessage());
            return false;
        }
    }
}