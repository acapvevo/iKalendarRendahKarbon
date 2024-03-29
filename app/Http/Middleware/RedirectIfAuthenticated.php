<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if(in_array('resident', $guards, true) && Auth::guard('resident')->check()) {
            return redirect(route('resident.dashboard'));
        }
        if(in_array('community', $guards, true) && Auth::guard('community')->check()) {
            return redirect(route('community.dashboard'));
        }
        if(in_array('admin', $guards, true) && Auth::guard('admin')->check()) {
            return redirect(route('admin.dashboard'));
        }
        if(in_array('super_admin', $guards, true) && Auth::guard('super_admin')->check()) {
            return redirect(route('super_admin.dashboard'));
        }
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
