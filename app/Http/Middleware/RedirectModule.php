<?php

namespace App\Http\Middleware;

use App\Models\Redirect;
use Illuminate\Support\Facades\Cache;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RedirectModule
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        
        $redirects = Cache::remember('active_redirects', now()->addMinutes(30), function () {
            return Redirect::where('active', 1)->get();
        });

        $path = request()->path();
        if ($path !== '/' && $path[0] !== '/') {
            $path = '/' . $path;
        }

        foreach ($redirects as $redirect) {
            $regex = str_replace('*', '.*', $redirect->from);

            if (preg_match("#^{$regex}$#", $path)) {
                return redirect($redirect->to, $redirect->code);
            }
        }

        return $next($request);
    }
}
