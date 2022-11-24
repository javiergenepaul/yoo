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
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if ($guard === 'operator') {
                    return redirect()->route('operator.index');
                } elseif ($guard === 'management') {
                    return redirect()->route('management.index');
                } elseif ($guard === 'shopadmin') {
                    return redirect()->route('shopadmin.shop', ['type' => 'publish', 'view' => 'grid']);
                }
            }
        }
        return $next($request);
    }
}
