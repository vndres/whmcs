<?php

namespace App\Services\Registrars;

use App\Models\Registrar;
use Illuminate\Support\Facades\Http;
use Exception;

class GoDaddyService implements RegistrarInterface
{
    protected $config;
    protected $baseUrl;

    public function __construct(Registrar $registrar)
    {
        $this->config = $registrar->config;
        // Ojo: Usar api.ote-godaddy.com para pruebas (Test) y api.godaddy.com para producción
        $this->baseUrl = ($this->config['environment'] ?? 'production') === 'production'
            ? 'https://api.godaddy.com'
            : 'https://api.ote-godaddy.com';
    }

    public function registerDomain(string $domain, int $years, array $nameservers, array $contactDetails)
    {
        $url = "{$this->baseUrl}/v1/domains/purchase";

        // GoDaddy requiere una estructura específica de contacto.
        // Aquí simplificamos asumiendo que $contactDetails trae lo necesario.
        $body = [
            'domain' => $domain,
            'period' => $years,
            'renewAuto' => true,
            'nameServers' => $nameservers, // array de strings
            'consent' => [
                'agreementKeys' => ['DNRA'], // Esto varía según la API, simplificado
                'agreedBy' => $contactDetails['first_name'] . ' ' . $contactDetails['last_name'],
                'agreedAt' => now()->toIso8601String(),
            ],
            'contactAdmin' => $this->mapContact($contactDetails),
            'contactBilling' => $this->mapContact($contactDetails),
            'contactRegistrant' => $this->mapContact($contactDetails),
            'contactTech' => $this->mapContact($contactDetails),
        ];

        $response = Http::withHeaders([
            'Authorization' => 'sso-key ' . $this->config['api_key'] . ':' . $this->config['api_secret'],
            'Content-Type' => 'application/json',
        ])->post($url, $body);

        if ($response->failed()) {
            throw new Exception("GoDaddy Error: " . $response->body());
        }

        return $response->json();
    }

    public function renewDomain(string $domain, int $years)
    {
        // Lógica de renovación GoDaddy
    }

    public function checkAvailability(string $domain): bool
    {
        $url = "{$this->baseUrl}/v1/domains/available?domain={$domain}";
        $response = Http::withHeaders([
            'Authorization' => 'sso-key ' . $this->config['api_key'] . ':' . $this->config['api_secret'],
        ])->get($url);

        if ($response->successful()) {
            return $response->json()['available'] ?? false;
        }
        return false;
    }

    // Helper para mapear datos de tu tabla clients a formato GoDaddy
    private function mapContact($data)
    {
        return [
            'nameFirst' => $data['first_name'],
            'nameLast' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? '+1.5555555555', // Formato estricto requerido
            'addressMailing' => [
                'address1' => $data['address'] ?? 'Calle Desconocida 123',
                'city' => $data['city'] ?? 'Bogota',
                'state' => $data['state'] ?? 'Cundinamarca',
                'postalCode' => $data['zip'] ?? '110111',
                'country' => $data['country'] ?? 'CO',
            ]
        ];
    }
}