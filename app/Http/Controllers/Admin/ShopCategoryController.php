<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShopCategory;
use Illuminate\Http\Request;

class ShopCategoryController extends Controller
{
    public function index()
    {
        $categories = ShopCategory::query()
            ->withCount('shops')
            ->orderBy('name')
            ->get();

        return view('admin.shop-categories.index', [
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        return view('admin.shop-categories.form', [
            'category' => new ShopCategory(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        ShopCategory::create($data);

        return redirect()->route('admin.shop-categories.index')->with('status', __('messages.category_saved'));
    }

    public function edit(ShopCategory $category)
    {
        return view('admin.shop-categories.form', [
            'category' => $category,
        ]);
    }

    public function update(Request $request, ShopCategory $category)
    {
        $data = $this->validateData($request, $category->id);
        $category->update($data);

        return redirect()->route('admin.shop-categories.index')->with('status', __('messages.category_saved'));
    }

    public function destroy(ShopCategory $category)
    {
        $category->delete();

        return redirect()->route('admin.shop-categories.index')->with('status', __('messages.category_deleted'));
    }

    private function validateData(Request $request, ?int $categoryId = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120', 'unique:shop_categories,name'.($categoryId ? ','.$categoryId : '')],
        ]);
    }
}
