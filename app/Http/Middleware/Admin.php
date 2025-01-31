<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin
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
        if (!auth()->check()) {
            session(['url.intended' => $request->fullUrl()]);
            return redirect()->route('admin.login');
        }

        if (auth()->user()->role_id > 2) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
