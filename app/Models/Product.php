<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'type',           // hosting, domain, website, vps, other
        'group_name',     // <--- NUEVO: Para agrupar (Hosting, VPS, etc)
        'name',
        'slug',
        'description',
        'price_monthly',
        'price_yearly',
        'setup_fee',
        'is_recurring',
        'billing_cycles',
        'is_active',
        'stock',          // <--- Opcional si usas control de stock
        'server_id',      // Relaci車n con Servers (cPanel)
        'registrar_id',   // <--- NUEVO: Relaci車n con Registrars (GoDaddy/ResellerClub)
        'config',         // JSON con datos t谷cnicos
    ];

    protected $casts = [
        'config' => 'array',
        'is_active' => 'boolean',
        'is_recurring' => 'boolean',
        'price_monthly' => 'decimal:2',
        'price_yearly' => 'decimal:2',
        'setup_fee' => 'decimal:2',
    ];

    // ==========================================
    // RELACIONES (Esto es lo que faltaba)
    // ==========================================

    /**
     * Relaci車n: Un producto de hosting pertenece a un Servidor (cPanel/Plesk).
     */
    public function server()
    {
        return $this->belongsTo(Server::class);
    }

    /**
     * Relaci車n: Un producto de dominio pertenece a un Registrador (API).
     */
    public function registrar()
    {
        return $this->belongsTo(Registrar::class);
    }

    /**
     * Relaci車n: Un producto puede tener muchos Addons (Complementos).
     * Usamos la tabla pivote 'addon_product'.
     */
    public function addons()
    {
        return $this->belongsToMany(Addon::class, 'addon_product');
    }

    /**
     * Relaci車n: Un producto tiene muchos Servicios comprados por clientes.
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }
}