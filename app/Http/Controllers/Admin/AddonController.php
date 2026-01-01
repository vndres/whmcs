<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Addon;
use Illuminate\Http\Request;

class AddonController extends Controller
{
    public function index()
    {
        $addons = Addon::orderBy('name')->paginate(15);
        return view('admin.addons.index', compact('addons'));
    }

    public function create()
    {
        return view('admin.addons.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:recurring,onetime',
            'price' => 'required|numeric|min:0',
            'setup_fee' => 'nullable|numeric|min:0',
        ]);

        $data['is_active'] = $request->has('is_active');

        Addon::create($data);

        return redirect()->route('admin.addons.index')->with('success', 'Complemento creado exitosamente.');
    }

    public function edit(Addon $addon)
    {
        return view('admin.addons.edit', compact('addon'));
    }

    public function update(Request $request, Addon $addon)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:recurring,onetime',
            'price' => 'required|numeric|min:0',
            'setup_fee' => 'nullable|numeric|min:0',
        ]);

        $data['is_active'] = $request->has('is_active');

        $addon->update($data);

        return redirect()->route('admin.addons.index')->with('success', 'Complemento actualizado.');
    }

    public function destroy(Addon $addon)
    {
        $addon->delete();
        return redirect()->route('admin.addons.index')->with('success', 'Complemento eliminado.');
    }
}