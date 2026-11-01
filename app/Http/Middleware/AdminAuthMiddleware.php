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

        return $next($request);
    }
}
