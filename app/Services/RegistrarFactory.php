<?php

namespace App\Services;

use App\Models\Registrar;
use App\Services\Registrars\GoDaddyService;
use App\Services\Registrars\ResellerClubService;
use Exception;

class RegistrarFactory
{
    public static function make(Registrar $registrar)
    {
        switch ($registrar->type) {
            case 'godaddy':
                return new GoDaddyService($registrar);
            case 'resellerclub':
                return new ResellerClubService($registrar);
            default:
                throw new Exception("Registrador no soportado: {$registrar->type}");
        }
    }
}