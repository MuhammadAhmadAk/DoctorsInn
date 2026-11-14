<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('admin_user')) {
            return redirect()->route('admin.login')->with('warning', 'Please sign in to access the DoctorsInn Admin Portal.');
        }

        // Re-check the account so disabled or demoted staff lose access immediately.
        $email = session('admin_user.email');
        $user = $email ? \App\Models\User::where('email', $email)->first() : null;

        if (! $user || $user->is_active === false || ! in_array($user->role, array_keys(config('staff.roles', [])), true)) {
            session()->forget('admin_user');

            return redirect()->route('admin.login')->with('warning', 'Your staff account is no longer active.');
        }

        return $next($request);
    }
}
