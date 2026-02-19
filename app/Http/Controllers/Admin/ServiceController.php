<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::query()->latest()->paginate(12);

        return view('admin.services.index', [
            'services' => $services,
        ]);
    }

    public function create()
    {
        return view('admin.services.form', [
            'service' => new Service(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data = $this->prepareServiceData($data);

        Service::create($data);

        return redirect()->route('admin.services.index')->with('status', __('messages.service_saved'));
    }

    public function edit(Service $service)
    {
        return view('admin.services.form', [
            'service' => $service,
        ]);
    }

    public function update(Request $request, Service $service)
    {
        $data = $this->validateData($request, $service);
        $data = $this->prepareServiceData($data, $service);

        $service->update($data);

        return redirect()->route('admin.services.index')->with('status', __('messages.service_saved'));
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')->with('status', __('messages.service_deleted'));
    }

    private function validateData(Request $request, ?Service $service = null): array
    {
        $serviceId = $service?->id;

        return $request->validate([
            'title'        => ['required', 'string', 'max:150'],
            'slug'         => ['nullable', 'string', 'max:180', 'unique:services,slug'.($serviceId ? ','.$serviceId : '')],
            'excerpt'      => ['nullable', 'string'],
            'body'         => ['nullable', 'string'],
            'image_path'   => ['nullable', 'string', 'max:255'],
            'image_file'   => ['nullable', 'image', 'max:4096'],
            'is_published' => ['nullable', 'boolean'],
            'show_on_home' => ['nullable', 'boolean'],
        ]);
    }

    private function prepareServiceData(array $data, ?Service $service = null): array
    {
        $imageFile = request()->file('image_file');
        if ($imageFile instanceof UploadedFile && $imageFile->isValid()) {
            $data['image_path'] = $this->storeUploadedFile($imageFile, 'services/images');
        }

        $slug = $data['slug'] ?? '';
        if (!$slug) {
            $slug = Service::generateSlug($data['title']);
        } else {
            $slug = Str::slug($slug);
        }

        $data['slug'] = $this->uniqueSlug($slug, $service?->id);
        $data['body']         = $data['body'] ?? '';
        $data['is_published'] = (bool) ($data['is_published'] ?? false);
        $data['show_on_home'] = (bool) ($data['show_on_home'] ?? false);
        $data['published_at'] = $data['is_published'] ? ($service?->published_at ?? now()) : null;

        return $data;
    }

    private function uniqueSlug(string $slug, ?int $serviceId = null): string
    {
        $baseSlug = $slug ?: 'service';
        $candidate = $baseSlug;
        $counter = 1;

        while (
            Service::query()
                ->where('slug', $candidate)
                ->when($serviceId, fn ($query) => $query->where('id', '!=', $serviceId))
                ->exists()
        ) {
            $counter++;
            $candidate = $baseSlug.'-'.$counter;
        }

        return $candidate;
    }

    private function storeUploadedFile(UploadedFile $file, string $directory): string
    {
        $path = $file->getPathname();
        $name = $file->hashName();

        $stream = fopen($path, 'r');
        if (!$stream) {
            throw new \RuntimeException('Failed to open upload stream.');
        }

        Storage::disk('public')->put(trim($directory.'/'.$name, '/'), $stream);

        if (is_resource($stream)) {
            fclose($stream);
        }

        return trim($directory.'/'.$name, '/');
    }
}
