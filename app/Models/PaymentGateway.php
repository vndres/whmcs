<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentGateway extends Model
{
    protected $table = 'payment_gateways';

    protected $fillable = [
        'name',
        'slug',
        'config',
        'test_mode',
        'is_active',
    ];

    protected $casts = [
        'config' => 'array',     // IMPORTANTE: Esto convierte el JSON de la DB en Array PHP
        'test_mode' => 'boolean',
        'is_active' => 'boolean',
    ];
}