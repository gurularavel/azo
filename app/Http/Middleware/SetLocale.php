<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->query('lang');
        $allowed = ['en', 'az', 'ru'];

        if ($locale && in_array($locale, $allowed, true)) {
            $request->session()->put('locale', $locale);
        }

        $selected = $request->session()->get('locale')
            ?? $request->user()?->locale
            ?? config('app.locale');

        if (!in_array($selected, $allowed, true)) {
            $selected = config('app.locale');
        }

        App::setLocale($selected);

        return $next($request);
    }
}
