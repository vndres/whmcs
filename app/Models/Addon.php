<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    protected $fillable = ['name', 'description', 'type', 'price', 'setup_fee', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relación: Un addon pertenece a muchos productos
    public function products()
    {
        return $this->belongsToMany(Product::class, 'addon_product');
    }
}