<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    private array $locales = ['az', 'en', 'ru'];

    private function loadTranslations(): array
    {
        $all = [];
        foreach ($this->locales as $locale) {
            $path = resource_path("lang/{$locale}/messages.php");
            $all[$locale] = file_exists($path) ? require $path : [];
        }
        return $all;
    }

    public function index()
    {
        $translations = $this->loadTranslations();

        // Collect all unique keys across all locales
        $keys = collect($translations)
            ->flatMap(fn($t) => array_keys($t))
            ->unique()
            ->sort()
            ->values();

        return view('admin.translations.index', [
            'keys'         => $keys,
            'translations' => $translations,
            'locales'      => $this->locales,
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'translations'        => ['required', 'array'],
            'translations.*'      => ['array'],
            'translations.*.*'    => ['nullable', 'string'],
        ]);

        foreach ($this->locales as $locale) {
            $path    = resource_path("lang/{$locale}/messages.php");
            $current = file_exists($path) ? require $path : [];

            $incoming = $data['translations'][$locale] ?? [];

            foreach ($incoming as $key => $value) {
                $current[$key] = $value ?? '';
            }

            $this->writeTranslationFile($path, $current);
        }

        // Clear the config/translation cache so changes take effect immediately
        if (function_exists('opcache_reset')) {
            opcache_reset();
        }

        return redirect()->route('admin.translations.index')
            ->with('status', __('messages.translations_saved'));
    }

    private function writeTranslationFile(string $path, array $translations): void
    {
        $lines = ["<?php\n\nreturn [\n"];
        foreach ($translations as $key => $value) {
            $escapedKey   = str_replace("'", "\\'", $key);
            $escapedValue = str_replace("'", "\\'", $value);
            $lines[] = "    '{$escapedKey}' => '{$escapedValue}',\n";
        }
        $lines[] = "];\n";
        file_put_contents($path, implode('', $lines));
    }
}
