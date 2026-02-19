<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;

class FeatureController extends Controller
{
    public function index()
    {
        $features = Feature::orderBy('sort_order')->orderBy('id')->get();
        return view('admin.features.index', compact('features'));
    }

    public function create()
    {
        return view('admin.features.form', ['feature' => new Feature()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:150',
            'description' => 'nullable|string|max:1000',
            'icon'        => 'required|string|max:80',
            'color'       => 'required|in:orange,blue,green,purple,red',
            'sort_order'  => 'nullable|integer|min:0',
            'is_active'   => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        Feature::create($data);

        return redirect()->route('admin.features.index')->with('status', 'Kart əlavə edildi.');
    }

    public function edit(Feature $feature)
    {
        return view('admin.features.form', compact('feature'));
    }

    public function update(Request $request, Feature $feature)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:150',
            'description' => 'nullable|string|max:1000',
            'icon'        => 'required|string|max:80',
            'color'       => 'required|in:orange,blue,green,purple,red',
            'sort_order'  => 'nullable|integer|min:0',
            'is_active'   => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $feature->update($data);

        return redirect()->route('admin.features.index')->with('status', 'Kart yeniləndi.');
    }

    public function destroy(Feature $feature)
    {
        $feature->delete();
        return redirect()->route('admin.features.index')->with('status', 'Kart silindi.');
    }
}
