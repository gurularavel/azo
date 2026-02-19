<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return view('admin.partners.index', ['partners' => $partners]);
    }

    public function create()
    {
        return view('admin.partners.form', ['partner' => new Partner()]);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request, true);
        $data = $this->prepareData($data);

        Partner::create($data);

        return redirect()->route('admin.partners.index')
            ->with('status', __('messages.partner_saved'));
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.form', ['partner' => $partner]);
    }

    public function update(Request $request, Partner $partner)
    {
        $data = $this->validateData($request);
        $data = $this->prepareData($data, $partner);

        $partner->update($data);

        return redirect()->route('admin.partners.index')
            ->with('status', __('messages.partner_saved'));
    }

    public function destroy(Partner $partner)
    {
        $this->deleteLogo($partner);
        $partner->delete();

        return redirect()->route('admin.partners.index')
            ->with('status', __('messages.partner_deleted'));
    }

    public function order(Request $request)
    {
        $ids = array_values(array_filter(
            array_map('intval', explode(',', (string) $request->input('order_list', '')))
        ));

        foreach ($ids as $index => $id) {
            Partner::query()->where('id', $id)->update(['sort_order' => $index + 1]);
        }

        return redirect()->route('admin.partners.index')
            ->with('status', __('messages.partner_order_saved'));
    }

    private function validateData(Request $request, bool $isCreate = false): array
    {
        $logoRule = $isCreate
            ? ['required_without:logo_path', 'image', 'max:2048']
            : ['nullable', 'image', 'max:2048'];

        return $request->validate([
            'name'        => ['required', 'string', 'max:120'],
            'logo_path'   => ['nullable', 'string', 'max:255'],
            'logo_file'   => $logoRule,
            'website_url' => ['nullable', 'url', 'max:255'],
            'is_active'   => ['nullable', 'boolean'],
        ]);
    }

    private function prepareData(array $data, ?Partner $partner = null): array
    {
        $file = request()->file('logo_file');
        if ($file instanceof UploadedFile && $file->isValid()) {
            if ($partner) {
                $this->deleteLogo($partner);
            }
            $data['logo_path'] = $this->storeFile($file, 'partners');
        }

        $data['is_active'] = (bool) ($data['is_active'] ?? false);

        if (!$partner) {
            $data['sort_order'] = Partner::query()->max('sort_order') + 1;
        }

        return $data;
    }

    private function storeFile(UploadedFile $file, string $dir): string
    {
        $stream = fopen($file->getPathname(), 'r');
        if (!$stream) {
            throw new \RuntimeException('Failed to open upload stream.');
        }
        $name = $dir . '/' . $file->hashName();
        Storage::disk('public')->put($name, $stream);
        if (is_resource($stream)) {
            fclose($stream);
        }
        return $name;
    }

    private function deleteLogo(Partner $partner): void
    {
        if ($partner->logo_path && !str_starts_with($partner->logo_path, 'http')) {
            Storage::disk('public')->delete($partner->logo_path);
        }
    }
}
