<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SiteSettingController extends Controller
{
    public function edit()
    {
        $settings = SiteSetting::query()->first();

        if (!$settings) {
            $settings = SiteSetting::query()->create([
                'site_name' => 'QR Endirim',
            ]);
        }

        return view('admin.site-settings.edit', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'site_name'                => ['required', 'string', 'max:255'],
            'default_locale'           => ['nullable', 'string', 'in:az,en,ru'],
            'hero_title'               => ['nullable', 'string', 'max:255'],
            'hero_subtitle'            => ['nullable', 'string', 'max:2000'],
            'hero_primary_text'        => ['nullable', 'string', 'max:255'],
            'hero_primary_url'         => ['nullable', 'string', 'max:255'],
            'hero_secondary_text'      => ['nullable', 'string', 'max:255'],
            'hero_secondary_url'       => ['nullable', 'string', 'max:255'],
            'hero_image'               => ['nullable', 'string', 'max:255'],
            'hero_image_file'          => ['nullable', 'image', 'max:4096'],
            'hero_stat_users_value'    => ['nullable', 'string', 'max:50'],
            'hero_stat_users_label'    => ['nullable', 'string', 'max:100'],
            'hero_stat_partners_value' => ['nullable', 'string', 'max:50'],
            'hero_stat_partners_label' => ['nullable', 'string', 'max:100'],
            'hero_stat_savings_value'  => ['nullable', 'string', 'max:50'],
            'hero_stat_savings_label'  => ['nullable', 'string', 'max:100'],
            'contact_email'            => ['nullable', 'email', 'max:255'],
            'contact_phone'            => ['nullable', 'string', 'max:255'],
            'facebook_url'             => ['nullable', 'url', 'max:255'],
            'instagram_url'            => ['nullable', 'url', 'max:255'],
            'youtube_url'              => ['nullable', 'url', 'max:255'],
            'footer_text'              => ['nullable', 'string', 'max:2000'],
            'terms_content'            => ['nullable', 'string'],
            'privacy_content'          => ['nullable', 'string'],
            'services_hero_title'      => ['nullable', 'string', 'max:255'],
            'services_hero_subtitle'   => ['nullable', 'string', 'max:2000'],
        ]);

        $settings = SiteSetting::query()->first();

        if (!$settings) {
            $settings = SiteSetting::query()->create([
                'site_name' => 'QR Endirim',
            ]);
        }

        $file = $request->file('hero_image_file');
        if ($file instanceof UploadedFile && $file->isValid()) {
            if ($settings->hero_image && !str_starts_with($settings->hero_image, 'http')) {
                Storage::disk('public')->delete($settings->hero_image);
            }
            $stream = fopen($file->getPathname(), 'r');
            $name = 'hero-images/' . $file->hashName();
            Storage::disk('public')->put($name, $stream);
            if (is_resource($stream)) fclose($stream);
            $data['hero_image'] = $name;
        }

        unset($data['hero_image_file']);
        $settings->update($data);

        return redirect()
            ->route('admin.site-settings.edit')
            ->with('status', __('messages.site_settings') . ' ' . __('messages.profile_updated'));
    }
}
