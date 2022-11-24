<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperatorMiddleware
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
        if (!Auth::check()) {
            return redirect()->route('login');
        } elseif ( Auth::user()->operator ) {
            return $next($request);
        } elseif ( Auth::user()->driver ) {
            Auth::logout();
            return redirect()->route('login');
        } elseif ( Auth::user()->customer ) {
            Auth::logout();
            return redirect()->route('login');
        } elseif ( Auth::user()->management ) {
            return redirect()->route('management.index');
        } elseif ( Auth::user()->operator ) {
            return $next($request);
        }
    }
}
