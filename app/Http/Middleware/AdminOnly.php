<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOnly
{
    /** Sections always accessible to any admin (no permission entry needed) */
    private const OPEN = ['dashboard', 'profile'];

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || !in_array($user->role, ['admin', 'superadmin'])) {
            abort(403);
        }

        // Eagerly load role so hasSection() and blade can use it without extra queries
        $user->loadMissing('roleModel');

        // Superadmin bypasses all section checks
        if ($user->role === 'superadmin') {
            return $next($request);
        }

        // Determine section from route name: admin.shops.index → shops
        $routeName = $request->route()?->getName() ?? '';
        $section   = explode('.', $routeName)[1] ?? null;

        if ($section && !in_array($section, self::OPEN)) {
            $permissions = $user->roleModel?->permissions ?? [];
            if (!in_array($section, $permissions)) {
                abort(403);
            }
        }

        return $next($request);
    }
}
