<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';

    protected $fillable = [
        'client_id',
        'product_id',
        'server_id',
        'status',
        'domain',
        'username',
        'password',
        'next_due_date',
        'activation_date',
        'cancellation_date',
        'config',
    ];

    protected $casts = [
        'next_due_date'      => 'date',
        'activation_date'    => 'date',
        'cancellation_date'  => 'date',
        'config'             => 'array',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function server()
    {
        return $this->belongsTo(Server::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'active'      => 'Activo',
            'suspended'   => 'Suspendido',
            'cancelled'   => 'Cancelado',
            'pending'     => 'Pendiente',
            default       => ucfirst($this->status ?? 'desconocido'),
        };
    }

    public function getStatusClassAttribute(): string
    {
        return match ($this->status) {
            'active'      => 'bg-emerald-500/15 text-emerald-300 border border-emerald-500/40',
            'suspended'   => 'bg-amber-500/15 text-amber-200 border border-amber-500/40',
            'cancelled'   => 'bg-slate-600/30 text-slate-200 border border-slate-500/50',
            'pending'     => 'bg-blue-500/15 text-blue-200 border border-blue-500/40',
            default       => 'bg-slate-700/40 text-slate-200 border border-slate-500/40',
        };
    }
}
