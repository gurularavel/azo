<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::query()
            ->withCount('shops')
            ->orderBy('name')
            ->get();

        return view('admin.cities.index', [
            'cities' => $cities,
        ]);
    }

    public function create()
    {
        return view('admin.cities.form', [
            'city' => new City(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        City::create($data);

        return redirect()->route('admin.cities.index')->with('status', __('messages.city_saved'));
    }

    public function edit(City $city)
    {
        return view('admin.cities.form', [
            'city' => $city,
        ]);
    }

    public function update(Request $request, City $city)
    {
        $data = $this->validateData($request, $city->id);
        $city->update($data);

        return redirect()->route('admin.cities.index')->with('status', __('messages.city_saved'));
    }

    public function toggle(City $city)
    {
        $city->update([
            'is_active' => !$city->is_active,
        ]);

        return redirect()->route('admin.cities.index')->with('status', __('messages.city_saved'));
    }

    public function destroy(City $city)
    {
        $city->delete();

        return redirect()->route('admin.cities.index')->with('status', __('messages.city_deleted'));
    }

    private function validateData(Request $request, ?int $cityId = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120', 'unique:cities,name'.($cityId ? ','.$cityId : '')],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }
}
