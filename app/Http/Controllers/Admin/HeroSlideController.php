<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class HeroSlideController extends Controller
{
    public function index()
    {
        $slides = HeroSlide::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('admin.hero-slides.index', [
            'slides' => $slides,
        ]);
    }

    public function create()
    {
        return view('admin.hero-slides.form', [
            'slide' => new HeroSlide(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request, true);
        $data = $this->prepareSlideData($data);

        HeroSlide::create($data);

        return redirect()->route('admin.hero-slides.index')->with('status', __('messages.slide_saved'));
    }

    public function edit(HeroSlide $slide)
    {
        return view('admin.hero-slides.form', [
            'slide' => $slide,
        ]);
    }

    public function update(Request $request, HeroSlide $slide)
    {
        $data = $this->validateData($request);
        $data = $this->prepareSlideData($data, $slide);

        $slide->update($data);

        return redirect()->route('admin.hero-slides.index')->with('status', __('messages.slide_saved'));
    }

    public function destroy(HeroSlide $slide)
    {
        $this->deleteSlideImage($slide);
        $slide->delete();

        return redirect()->route('admin.hero-slides.index')->with('status', __('messages.slide_deleted'));
    }

    public function order(Request $request)
    {
        $orderList = $request->input('order_list', '');
        $ids = array_values(array_filter(array_map('intval', explode(',', (string) $orderList))));

        foreach ($ids as $index => $id) {
            HeroSlide::query()->where('id', $id)->update(['sort_order' => $index + 1]);
        }

        return redirect()->route('admin.hero-slides.index')->with('status', __('messages.slide_order_saved'));
    }

    private function validateData(Request $request, bool $isCreate = false): array
    {
        $imageRule = $isCreate
            ? ['required_without:image_path', 'image', 'max:4096']
            : ['nullable', 'image', 'max:4096'];

        return $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'image_path' => ['nullable', 'string', 'max:255'],
            'image_file' => $imageRule,
            'button_text' => ['nullable', 'string', 'max:60'],
            'button_url' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }

    private function prepareSlideData(array $data, ?HeroSlide $slide = null): array
    {
        $imageFile = request()->file('image_file');
        if ($imageFile instanceof UploadedFile && $imageFile->isValid()) {
            if ($slide) {
                $this->deleteSlideImage($slide);
            }
            $data['image_path'] = $this->storeUploadedFile($imageFile, 'hero-slides');
        }

        $data['is_active'] = (bool) ($data['is_active'] ?? false);

        if (!$slide) {
            $data['sort_order'] = HeroSlide::query()->max('sort_order') + 1;
        }

        return $data;
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

    private function deleteSlideImage(HeroSlide $slide): void
    {
        if (!$slide->image_path) {
            return;
        }

        if (!str_starts_with($slide->image_path, 'http')) {
            Storage::disk('public')->delete($slide->image_path);
        }
    }
}
