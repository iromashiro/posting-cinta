<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Ensure authenticated user has one of the allowed roles and is active.
     *
     * Usage in routes:
     *   Route::middleware(['role:admin'])->group(...)
     *   Route::middleware(['role:admin,puskesmas'])->group(...)
     */
    public function handle(Request $request, Closure $next, string $roles = '')
    {
        if (!Auth::check()) {
            abort(401, 'Unauthenticated');
        }

        $user = Auth::user();

        // Optional is_active guard if column exists
        if (property_exists($user, 'is_active') && method_exists($user, 'getAttribute') && !$user->getAttribute('is_active')) {
            abort(403, 'Account is inactive');
        }

        // If roles provided, validate
        if ($roles !== '') {
            $allowed = array_filter(array_map('trim', explode(',', $roles)));
            if (!empty($allowed) && !in_array($user->role ?? '', $allowed, true)) {
                abort(403, 'Forbidden');
            }
        }

        return $next($request);
    }
}
