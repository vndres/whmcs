<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registrar extends Model
{
    protected $fillable = ['name', 'type', 'config', 'is_active'];
    
    // Convertir el JSON de credenciales a Array automáticamente
    protected $casts = [
        'config' => 'array',
        'is_active' => 'boolean'
    ];
}