<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Server extends Model
{
    protected $table = 'servers';

    protected $fillable = [
        'name',
        'hostname',
        'ip_address',
        'port',
        'type',
        'api_token',
        'use_ssl',
        'is_active',
    ];
}
