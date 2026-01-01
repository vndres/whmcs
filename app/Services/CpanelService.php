<?php

namespace App\Services;

use App\Models\Server;
use App\Models\Service;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CpanelService
{
    protected $server;

    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    /**
     * Crea una cuenta de hosting en el servidor WHM.
     */
    public function createAccount(Service $service)
    {
        // 1. Obtener la configuración del producto (para saber el Plan/Package de WHM)
        $productConfig = $service->product->config ?? [];
        $whmPackage = $productConfig['whm_package'] ?? null;

        if (!$whmPackage) {
            throw new \Exception('El producto no tiene asignado un paquete de WHM (whm_package).');
        }

        // 2. Preparar los datos para la API de WHM
        $payload = [
            'api.version' => 1,
            'username'    => $service->username,
            'domain'      => $service->domain,
            'password'    => $service->password, // Debe ser segura
            'plan'        => $whmPackage,
            'contactemail'=> $service->client->email,
        ];

        // 3. Enviar petición a WHM
        $response = $this->sendRequest('createacct', $payload);

        // 4. Verificar errores en la respuesta de WHM
        if (isset($response['metadata']['result']) && $response['metadata']['result'] === 0) {
            throw new \Exception('Error WHM: ' . $response['metadata']['reason']);
        }

        return $response;
    }

    /**
     * Suspender una cuenta (por falta de pago, etc).
     */
    public function suspendAccount(string $username, string $reason = 'Overdue Payment')
    {
        return $this->sendRequest('suspendacct', [
            'api.version' => 1,
            'user'        => $username,
            'reason'      => $reason
        ]);
    }

    /**
     * Reactivar una cuenta suspendida.
     */
    public function unsuspendAccount(string $username)
    {
        return $this->sendRequest('unsuspendacct', [
            'api.version' => 1,
            'user'        => $username
        ]);
    }

    /**
     * Método base para hacer la petición HTTP.
     */
    protected function sendRequest($function, $params)
    {
        $protocol = $this->server->use_ssl ? 'https' : 'http';
        $port     = $this->server->port; // Generalmente 2087
        $hostname = $this->server->ip_address; // O hostname si tienes DNS resuelto
        
        $url = "{$protocol}://{$hostname}:{$port}/json-api/{$function}";

        // Token de API de WHM (Bearer token)
        $token = $this->server->api_token;

        $response = Http::withHeaders([
            'Authorization' => "whm root:$token"
        ])->get($url, $params);

        if ($response->failed()) {
            Log::error("Error conectando a WHM ($function): " . $response->body());
            throw new \Exception("Error de conexión con el servidor: " . $response->status());
        }

        return $response->json();
    }
}