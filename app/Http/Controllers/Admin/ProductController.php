<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Server;
use App\Models\Addon;
use App\Models\Registrar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; // <--- IMPORTANTE: Necesario para generar el slug

class ProductController extends Controller
{
    protected function ensureAdmin()
    {
        if (Auth::user()->type !== 'admin') {
            abort(403, 'Acceso denegado');
        }
    }

    public function index()
    {
        $this->ensureAdmin();
        $products = Product::with(['server', 'registrar', 'addons'])
            ->orderBy('group_name')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $this->ensureAdmin();
        
        $servers    = Server::where('is_active', 1)->orderBy('name')->get();
        $registrars = Registrar::where('is_active', 1)->orderBy('name')->get();
        $addons     = Addon::where('is_active', 1)->orderBy('name')->get();

        return view('admin.products.create', compact('servers', 'registrars', 'addons'));
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'group_name'    => 'required|string|max:255',
            'description'   => 'nullable|string',
            'type'          => 'required|in:hosting,domain,website,vps,other',
            'price_monthly' => 'nullable|numeric|min:0',
            'price_annual'  => 'nullable|numeric|min:0',
            'setup_fee'     => 'nullable|numeric|min:0',
            'server_id'     => 'nullable|exists:servers,id',
            'registrar_id'  => 'nullable|exists:registrars,id',
            'is_active'     => 'boolean',
            'stock'         => 'nullable|integer',
            'config_raw'    => 'nullable|string',
            'addons'        => 'nullable|array',
            'addons.*'      => 'exists:addons,id',
        ]);

        // === CORRECCIÓN PRINCIPAL: GENERAR SLUG ===
        // Si no se envía un slug manual, lo creamos desde el nombre
        // Ejemplo: "Plan Básico" -> "plan-basico"
        $validated['slug'] = Str::slug($validated['name']); 

        // Procesar JSON de configuración
        $configRaw = $request->input('config_raw');
        if ($configRaw) {
            $decoded = json_decode($configRaw, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $validated['config'] = $decoded;
            }
        }
        unset($validated['config_raw']);

        $validated['is_active'] = $request->has('is_active');

        // Crear Producto
        $product = Product::create($validated);

        // Sincronizar Addons
        if ($request->has('addons')) {
            $product->addons()->sync($request->addons);
        }

        return redirect()->route('admin.products.index')->with('success', 'Producto creado correctamente.');
    }

    public function edit(Product $product)
    {
        $this->ensureAdmin();

        $servers    = Server::where('is_active', 1)->orderBy('name')->get();
        $registrars = Registrar::where('is_active', 1)->orderBy('name')->get();
        $addons     = Addon::where('is_active', 1)->orderBy('name')->get();

        $configRaw = $product->config 
            ? json_encode($product->config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) 
            : '';

        return view('admin.products.edit', compact('product', 'servers', 'registrars', 'addons', 'configRaw'));
    }

    public function update(Request $request, Product $product)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'group_name'    => 'required|string|max:255',
            'description'   => 'nullable|string',
            'type'          => 'required|in:hosting,domain,website,vps,other',
            'price_monthly' => 'nullable|numeric|min:0',
            'price_annual'  => 'nullable|numeric|min:0',
            'setup_fee'     => 'nullable|numeric|min:0',
            'server_id'     => 'nullable|exists:servers,id',
            'registrar_id'  => 'nullable|exists:registrars,id',
            'stock'         => 'nullable|integer',
            'config_raw'    => 'nullable|string',
            'addons'        => 'nullable|array',
            'addons.*'      => 'exists:addons,id',
        ]);

        // Si cambiamos el nombre, opcionalmente podríamos actualizar el slug, 
        // pero es mejor mantener el original para no romper enlaces SEO.
        // Si quisieras forzarlo: $validated['slug'] = Str::slug($validated['name']);

        // Procesar JSON
        $configRaw = $request->input('config_raw');
        if ($configRaw) {
            $decoded = json_decode($configRaw, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $validated['config'] = $decoded;
            } else {
                $validated['config'] = null; 
            }
        } else {
            $validated['config'] = null;
        }
        unset($validated['config_raw']);

        $validated['is_active'] = $request->has('is_active');

        $product->update($validated);

        // Actualizar Addons
        $product->addons()->sync($request->input('addons', []));

        return redirect()->route('admin.products.index')->with('success', 'Producto actualizado.');
    }

    public function destroy(Product $product)
    {
        $this->ensureAdmin();
        
        if ($product->services()->where('status', 'active')->exists()) {
            return back()->with('error', 'No puedes eliminar este producto porque hay servicios activos usándolo.');
        }

        $product->addons()->detach();
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Producto eliminado.');
    }
}