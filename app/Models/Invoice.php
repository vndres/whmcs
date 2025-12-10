<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';

    protected $fillable = [
        'number',
        'client_id',
        'issue_date',
        'due_date',
        'status',
        'currency',
        'subtotal',
        'tax_total',
        'total',
        'amount_paid',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date'   => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    // Etiquetas bonitas para el admin
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'unpaid'   => 'Pendiente de pago',
            'paid'     => 'Pagada',
            'overdue'  => 'Vencida',
            'cancelled'=> 'Cancelada',
            default    => ucfirst($this->status ?? 'desconocido'),
        };
    }

    public function getStatusClassAttribute(): string
    {
        return match ($this->status) {
            'unpaid'   => 'bg-amber-500/15 text-amber-300 border border-amber-500/40',
            'paid'     => 'bg-emerald-500/15 text-emerald-300 border border-emerald-500/40',
            'overdue'  => 'bg-red-500/15 text-red-300 border border-red-500/40',
            'cancelled'=> 'bg-slate-500/15 text-slate-300 border border-slate-500/40',
            default    => 'bg-slate-700/50 text-slate-300 border border-slate-600/60',
        };
    }
}
