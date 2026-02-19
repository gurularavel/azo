<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->query('lang');
        $allowed = ['en', 'az', 'ru'];

        if ($locale && in_array($locale, $allowed, true)) {
            $request->session()->put('locale', $locale);
        }

        $siteDefault = $this->siteDefaultLocale();

        $selected = $request->session()->get('locale')
            ?? $request->user()?->locale
            ?? $siteDefault
            ?? config('app.locale');

        if (!in_array($selected, $allowed, true)) {
            $selected = $siteDefault ?? config('app.locale');
        }

        App::setLocale($selected);

        return $next($request);
    }

    private function siteDefaultLocale(): ?string
    {
        try {
            if (Schema::hasTable('site_settings')) {
                return \App\Models\SiteSetting::query()->value('default_locale');
            }
        } catch (Throwable) {
            // DB not ready
        }

        return null;
    }
}
