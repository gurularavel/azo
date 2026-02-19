<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::query()
            ->published()
            ->latest('published_at')
            ->paginate(9);

        return view('services.index', [
            'services' => $services,
        ]);
    }

    public function show(Service $service)
    {
        if (!$service->is_published) {
            abort(404);
        }

        return view('services.show', [
            'service' => $service,
        ]);
    }
}
