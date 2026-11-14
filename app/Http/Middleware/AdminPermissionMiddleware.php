<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminPermissionMiddleware
{
    /**
     * Allow admins through, and staff only for granted sections.
     */
    public function handle(Request $request, Closure $next, string $permission)
    {
        $admin = session('admin_user');

        if (! $admin) {
            return redirect()->route('admin.login');
        }

        if (($admin['role_key'] ?? 'admin') === 'admin') {
            return $next($request);
        }

        $permissions = (array) ($admin['permissions'] ?? []);

        if (in_array($permission, $permissions, true)) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            abort(403);
        }

        return redirect()->route('admin.dashboard')
            ->with('error', 'Your staff account does not have access to that section.');
    }
}
