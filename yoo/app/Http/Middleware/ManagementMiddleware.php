<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagementMiddleware
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
        // if (Auth::user()->management->management_role_id == 1) {
        //     return redirect()->route('management.index');
        // } else if (Auth::user()->management->management_role_id == 2) {
        //     return redirect()->route('management.shop', ['type' => 'publish', 'view' => 'grid']);
        // }
        // if (!Auth::check()) {
        //     return redirect()->route('login');
        // } elseif ( Auth::user()->management ) {
        //     return $next($request);
        // }




        // elseif ( Auth::user()->driver ) {
        //     Auth::logout();
        //     return redirect()->route('login');
        // } elseif ( Auth::user()->customer ) {
        //     Auth::logout();
        //     return redirect()->route('login');
        // } elseif ( Auth::user()->operator ) {
        //     return redirect()->route('operator.index');
        // }
    }
}
