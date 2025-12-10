<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'type',
        'name',
        'slug',
        'description',
        'price_monthly',
        'price_yearly',
        'setup_fee',
        'is_recurring',
        'billing_cycles',
        'is_active',
        'server_id',
        'config',
    ];

    protected $casts = [
        'config' => 'array',
    ];
}
