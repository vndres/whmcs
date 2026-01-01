<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        // Obtenemos todas las settings y las convertimos en un array asociativo [key => value]
        // para acceder fácil en la vista: $settings['company_name']
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // Validamos solo lo esencial, el resto son strings opcionales
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_email' => 'required|email',
        ]);

        // Lista de claves permitidas para guardar
        $keys = [
            'company_name',
            'company_email',
            'company_address',
            'currency_symbol',
            'currency_code',
            'tax_rate',
            'enable_registrations',
            'maintenance_mode',
            // Agrega aquí más claves si creas más campos en la vista
        ];

        foreach ($keys as $key) {
            // Si es un checkbox y no viene en el request, asumimos '0' (falso)
            // Si es texto y viene null, guardamos string vacío
            $value = $request->input($key);

            // Manejo especial para checkboxes booleanos
            if (in_array($key, ['enable_registrations', 'maintenance_mode'])) {
                $value = $request->has($key) ? '1' : '0';
            }

            Setting::set($key, $value);
        }

        return redirect()->back()->with('success', 'Ajustes del sistema actualizados correctamente.');
    }
}