<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Obtener un valor de configuración por su clave.
     * Uso: Setting::get('company_name', 'Valor por defecto');
     */
    public static function get($key, $default = null)
    {
        // Intentamos obtenerlo de caché para no consultar la BD en cada carga
        return Cache::rememberForever("setting_{$key}", function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Guardar o actualizar una configuración.
     * Uso: Setting::set('company_name', 'Nuevo Nombre');
     */
    public static function set($key, $value)
    {
        self::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget("setting_{$key}"); // Limpiar caché
    }
}