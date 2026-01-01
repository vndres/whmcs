<?php

namespace App\Models;

use App\Models\Client;
use App\Models\Ticket;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Campos que se pueden asignar en masa.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',      // admin, client, staff, etc.
        'locale',    // es, en
        'is_active', // 1 o 0
    ];

    /**
     * Campos que se ocultan en arrays / JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts de atributos nativos.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active'         => 'boolean',
    ];

    /**
     * Relaci¨®n 1:1 con Client.
     * clients.user_id -> users.id
     */
    public function client()
    {
        return $this->hasOne(Client::class, 'user_id');
    }

    /**
     * Tickets donde este user aparece como creador/cliente
     * (si en tu modelo Ticket usas user_id para el usuario que abre el ticket).
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'user_id');
    }
}
