<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Service;
use App\Models\Invoice;
use App\Models\Ticket;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

    protected $fillable = [
        'user_id',
        'uuid',
        'company_name',
        'first_name',
        'last_name',
        'email',
        'phone',
        'country',
        'state',
        'city',
        'address',
        'zip',
        'currency',
        'language',
        'is_active',
        'credit_balance',
    ];

    protected $casts = [
        'is_active'      => 'boolean',
        'credit_balance' => 'decimal:2',
    ];

    /**
     * Usuario asociado (login).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Servicios de hosting, dominios, etc.
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    /**
     * Facturas asociadas al cliente.
     */
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    /**
     * Tickets de soporte (si guardas client_id en tickets).
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Nombre completo cómodo para mostrar.
     */
    public function getFullNameAttribute()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }
}
