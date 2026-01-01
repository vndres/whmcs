<?php

namespace App\Services\Registrars;

interface RegistrarInterface
{
    /**
     * Registrar un nuevo dominio.
     * Retorna array con éxito o lanza excepción.
     */
    public function registerDomain(string $domain, int $years, array $nameservers, array $contactDetails);

    /**
     * Renovar un dominio.
     */
    public function renewDomain(string $domain, int $years);
    
    /**
     * Verificar disponibilidad.
     */
    public function checkAvailability(string $domain): bool;
}