<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        $role = (string) ($user->role ?? '');
        $legacyRole = $role === 'hgadmin' ? 'clearance_admin' : $role;

        if ($roles === [] || in_array($role, $roles, true) || in_array($legacyRole, $roles, true)) {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }
}
