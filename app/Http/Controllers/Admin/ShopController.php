<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\ShopCategory;
use App\Models\ShopImage;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ShopController extends Controller
{
    public function index()
    {
        $categoryId = request()->integer('category_id');

        $shops = Shop::query()
            ->with(['category', 'city'])
            ->when($categoryId, fn ($query) => $query->where('shop_category_id', $categoryId))
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        $categories = ShopCategory::query()->orderBy('name')->get();

        return view('admin.shops.index', [
            'shops' => $shops,
            'categories' => $categories,
            'selectedCategoryId' => $categoryId,
        ]);
    }

    public function create()
    {
        return view('admin.shops.form', [
            'shop' => new Shop(),
            'categories' => ShopCategory::query()->orderBy('name')->get(),
            'cities' => City::query()->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $shop = Shop::create($data);

        $this->handleUploads($request, $shop);

        return redirect()->route('admin.shops.index')->with('status', __('messages.shop_saved'));
    }

    public function edit(Shop $shop)
    {
        $shop->load('images');

        return view('admin.shops.form', [
            'shop' => $shop,
            'categories' => ShopCategory::query()->orderBy('name')->get(),
            'cities' => City::query()->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Shop $shop)
    {
        $data = $this->validateData($request);
        $shop->update($data);
        $this->handleImageUpdates($request, $shop);
        $this->handleUploads($request, $shop);

        return redirect()->route('admin.shops.index')->with('status', __('messages.shop_saved'));
    }

    public function destroy(Shop $shop)
    {
        $shop->delete();

        return redirect()->route('admin.shops.index')->with('status', __('messages.shop_deleted'));
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'shop_category_id' => ['nullable', 'integer', 'exists:shop_categories,id'],
            'city_id' => ['required', 'integer', 'exists:cities,id'],
            'logo_path' => ['nullable', 'string', 'max:255'],
            'header_image_path' => ['nullable', 'string', 'max:255'],
            'logo_file' => ['nullable', 'image', 'max:2048'],
            'header_image_file' => ['nullable', 'image', 'max:4096'],
            'gallery_files.*' => ['nullable', 'image', 'max:4096'],
            'delete_images' => ['nullable', 'array'],
            'delete_images.*' => ['integer', 'exists:shop_images,id'],
            'image_order' => ['nullable', 'array'],
            'image_order.*' => ['integer', 'min:0'],
            'delete_images_list' => ['nullable', 'string'],
            'image_order_list' => ['nullable', 'string'],
            'discount_percent' => ['required', 'integer', 'min:0', 'max:100'],
            'description' => ['nullable', 'string'],
            'map_embed'   => ['nullable', 'string', 'max:5000'],
        ]);
    }

    private function handleImageUpdates(Request $request, Shop $shop): void
    {
        $deleteIds = collect($request->input('delete_images', []))
            ->map(fn ($value) => (int) $value)
            ->filter(fn ($value) => $value > 0)
            ->values();

        $deleteList = $request->input('delete_images_list');
        if (is_string($deleteList) && $deleteList !== '') {
            $deleteIds = $deleteIds->merge(
                collect(explode(',', $deleteList))
                    ->map(fn ($value) => (int) $value)
                    ->filter(fn ($value) => $value > 0)
            )->unique()->values();
        }

        if ($deleteIds->isNotEmpty()) {
            $images = ShopImage::query()
                ->where('shop_id', $shop->id)
                ->whereIn('id', $deleteIds)
                ->get();

            foreach ($images as $image) {
                Storage::disk('public')->delete($image->path);
                $image->delete();
            }
        }

        $orderList = $request->input('image_order_list');
        $orderedIds = [];
        if (is_string($orderList) && $orderList !== '') {
            $orderedIds = array_values(array_filter(array_map('intval', explode(',', $orderList))));
        }

        if (!$orderedIds) {
            $orderInput = $request->input('image_order', []);
            if (is_array($orderInput)) {
                foreach ($orderInput as $id => $order) {
                    $imageId = (int) $id;
                    if ($imageId < 1) {
                        continue;
                    }
                    ShopImage::query()
                        ->where('shop_id', $shop->id)
                        ->where('id', $imageId)
                        ->update(['sort_order' => max(0, (int) $order)]);
                }
            }
        } else {
            foreach ($orderedIds as $index => $imageId) {
                ShopImage::query()
                    ->where('shop_id', $shop->id)
                    ->where('id', $imageId)
                    ->update(['sort_order' => $index + 1]);
            }
        }
    }

    private function handleUploads(Request $request, Shop $shop): void
    {
        $logoFile = $request->file('logo_file');
        if ($logoFile instanceof UploadedFile && $this->isUsableUpload($logoFile)) {
            try {
                $this->logUploadInfo('logo_file', $logoFile);
                $path = $this->storeUploadedFile($logoFile, 'shops/logos');
                $shop->update(['logo_path' => $path]);
            } catch (\Throwable $e) {
                $this->logUploadException('logo_file', $logoFile, $e);
                throw $e;
            }
        } elseif ($logoFile) {
            $this->logUploadIssue('logo_file', $logoFile);
        }

        $headerFile = $request->file('header_image_file');
        if ($headerFile instanceof UploadedFile && $this->isUsableUpload($headerFile)) {
            try {
                $this->logUploadInfo('header_image_file', $headerFile);
                $path = $this->storeUploadedFile($headerFile, 'shops/headers');
                $shop->update(['header_image_path' => $path]);
            } catch (\Throwable $e) {
                $this->logUploadException('header_image_file', $headerFile, $e);
                throw $e;
            }
        } elseif ($headerFile) {
            $this->logUploadIssue('header_image_file', $headerFile);
        }

        $galleryFiles = $request->file('gallery_files', []);
        $nextOrder = (int) ShopImage::query()
            ->where('shop_id', $shop->id)
            ->max('sort_order');
        foreach ($galleryFiles as $file) {
            if (!$file instanceof UploadedFile || !$this->isUsableUpload($file)) {
                if ($file) {
                    $this->logUploadIssue('gallery_files', $file);
                }
                continue;
            }
            try {
                $this->logUploadInfo('gallery_files', $file);
                $path = $this->storeUploadedFile($file, 'shops/gallery');
                $nextOrder++;
                ShopImage::create([
                    'shop_id' => $shop->id,
                    'path' => $path,
                    'sort_order' => $nextOrder,
                ]);
            } catch (\Throwable $e) {
                $this->logUploadException('gallery_files', $file, $e);
                throw $e;
            }
        }
    }

    private function isUsableUpload(?UploadedFile $file): bool
    {
        if (!$file || !$file->isValid() || $file->getError() !== UPLOAD_ERR_OK) {
            return false;
        }

        $path = $file->getPathname();

        return is_string($path)
            && $path !== ''
            && $file->getSize() > 0
            && file_exists($path);
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

    private function logUploadIssue(string $field, UploadedFile $file): void
    {
        Log::warning('Shop upload rejected', [
            'field' => $field,
            'error' => $file->getError(),
            'error_message' => $file->getErrorMessage(),
            'original_name' => $file->getClientOriginalName(),
            'mime' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'path' => $file->getPathname(),
            'is_valid' => $file->isValid(),
        ]);
    }

    private function logUploadInfo(string $field, UploadedFile $file): void
    {
        Log::info('Shop upload attempt', [
            'field' => $field,
            'error' => $file->getError(),
            'error_message' => $file->getErrorMessage(),
            'original_name' => $file->getClientOriginalName(),
            'mime' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'path' => $file->getPathname(),
            'is_valid' => $file->isValid(),
        ]);
    }

    private function logUploadException(string $field, UploadedFile $file, \Throwable $e): void
    {
        Log::error('Shop upload failed', [
            'field' => $field,
            'error' => $file->getError(),
            'error_message' => $file->getErrorMessage(),
            'original_name' => $file->getClientOriginalName(),
            'mime' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'path' => $file->getPathname(),
            'is_valid' => $file->isValid(),
            'exception' => $e->getMessage(),
        ]);
    }
}
