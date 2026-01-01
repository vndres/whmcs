<?php

namespace App\Services\Registrars;

use App\Models\Registrar;
use Illuminate\Support\Facades\Http;
use Exception;

class ResellerClubService implements RegistrarInterface
{
    protected $config;
    protected $baseUrl;

    public function __construct(Registrar $registrar)
    {
        $this->config = $registrar->config;
        
        // Definir URL base según modo pruebas o producción
        if (($this->config['test_mode'] ?? false) || ($this->config['environment'] ?? '') === 'test') {
            $this->baseUrl = 'https://test.httpapi.com/api/domains';
        } else {
            $this->baseUrl = 'https://httpapi.com/api/domains';
        }
    }

    /**
     * Registrar un nuevo dominio
     */
    public function registerDomain(string $domain, int $years, array $nameservers, array $contactDetails)
    {
        // Nota: En una implementación completa, aquí primero deberías crear 
        // el Customer y el Contact usando la API de ResellerClub.
        // Para este ejemplo, usamos los IDs por defecto de la configuración.

        $params = [
            'auth-userid' => $this->config['user_id'],
            'api-key'     => $this->config['api_key'],
            'domain-name' => $domain,
            'years'       => $years,
            'ns'          => $nameservers,
            'customer-id' => $this->config['default_customer_id'] ?? '0',
            'reg-contact-id' => $this->config['default_contact_id'] ?? '0',
            'admin-contact-id' => $this->config['default_contact_id'] ?? '0',
            'tech-contact-id' => $this->config['default_contact_id'] ?? '0',
            'billing-contact-id' => $this->config['default_contact_id'] ?? '0',
            'invoice-option' => 'NoInvoice',
        ];

        $url = "{$this->baseUrl}/register.json";

        $response = Http::get($url, $params);

        if ($response->failed()) {
            throw new Exception("Error HTTP ResellerClub: " . $response->status());
        }

        $data = $response->json();

        // ResellerClub devuelve status="error" si falla
        if (isset($data['status']) && strtolower($data['status']) === 'error') {
            throw new Exception("Error API: " . ($data['message'] ?? 'Desconocido'));
        }

        return $data;
    }

    /**
     * Verificar disponibilidad (ESTA ES LA QUE DABA ERROR)
     */
   /**
     * Verificar disponibilidad (CORREGIDO)
     */
    public function checkAvailability(string $domain): bool
    {
        // 1. LIMPIEZA CRÍTICA: Convertir a minúsculas y quitar espacios.
        // Esto soluciona el error de que "Hola.com" no coincida con "hola.com" de la API.
        $domain = strtolower(trim($domain));

        // Separar nombre y extensión
        $parts = explode('.', $domain, 2);
        
        if (count($parts) !== 2) {
            return false; 
        }

        $sld = $parts[0]; // nombre
        $tld = $parts[1]; // extension

        // 2. Construcción de URL
        // Usamos la base y reemplazamos para asegurar la ruta correcta
        $url = str_replace('/domains', '/domains/available.json', $this->baseUrl);

        try {
            // 3. Consultar API
            $response = Http::get($url, [
                'auth-userid' => $this->config['user_id'],
                'api-key'     => $this->config['api_key'],
                'domain-name' => $sld,
                'tlds'        => $tld
            ]);

            // DEBUG: Descomenta esto si sigue fallando para ver el error real en storage/logs/laravel.log
            // \Log::info('Respuesta Dominio '.$domain, $response->json());

            if ($response->failed()) {
                return false;
            }

            $data = $response->json();

            // 4. Verificación Robusta
            // Primero verificamos si existe la llave exacta del dominio
            if (isset($data[$domain])) {
                // Obtenemos el array interno
                $domainData = $data[$domain];
                
                // Verificamos el status. ResellerClub devuelve 'available' si está libre.
                if (isset($domainData['status']) && strtolower($domainData['status']) === 'available') {
                    return true;
                }
            }

            return false;

        } catch (Exception $e) {
            // Capturamos errores de conexión para que no rompa la web
            // \Log::error('Error CheckAvailability: ' . $e->getMessage());
            return false;
        }
    }

    public function renewDomain(string $domain, int $years)
    {
        // Lógica futura de renovación
        return true;
    }
}