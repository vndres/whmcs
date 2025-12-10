<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    protected function ensureAdmin()
    {
        $user = Auth::user();
        if (!$user || $user->type !== 'admin') {
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }
    }

    public function index()
    {
        $this->ensureAdmin();

        $products = Product::orderByDesc('id')->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $this->ensureAdmin();

        $servers = Server::where('is_active', 1)->orderBy('name')->get();

        return view('admin.products.create', compact('servers'));
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'type'           => 'required|string|max:50',
            'name'           => 'required|string|max:190',
            'slug'           => 'nullable|string|max:190',
            'description'    => 'nullable|string',
            'price_monthly'  => 'nullable|numeric|min:0',
            'price_yearly'   => 'nullable|numeric|min:0',
            'setup_fee'      => 'nullable|numeric|min:0',
            'is_recurring'   => 'nullable|boolean',
            'billing_cycles' => 'nullable|integer|min:0',
            'is_active'      => 'nullable|boolean',
            'server_id'      => 'nullable|integer|exists:servers,id',
        ]);

        // Slug
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_recurring'] = $request->boolean('is_recurring');
        $validated['is_active']    = $request->boolean('is_active');

        Product::create($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Producto creado correctamente.');
    }

    public function edit(Product $product)
    {
        $this->ensureAdmin();

        $servers = Server::where('is_active', 1)->orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'servers'));
    }

    public function update(Request $request, Product $product)
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'type'           => 'required|string|max:50',
            'name'           => 'required|string|max:190',
            'slug'           => 'nullable|string|max:190',
            'description'    => 'nullable|string',
            'price_monthly'  => 'nullable|numeric|min:0',
            'price_yearly'   => 'nullable|numeric|min:0',
            'setup_fee'      => 'nullable|numeric|min:0',
            'is_recurring'   => 'nullable|boolean',
            'billing_cycles' => 'nullable|integer|min:0',
            'is_active'      => 'nullable|boolean',
            'server_id'      => 'nullable|integer|exists:servers,id',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $validated['is_recurring'] = $request->boolean('is_recurring');
        $validated['is_active']    = $request->boolean('is_active');

        $product->update($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $product)
    {
        $this->ensureAdmin();

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Producto eliminado correctamente.');
    }
}
