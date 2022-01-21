<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIsNotClient
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!auth()->user()->isClient())
            return redirect()->route('admin.dashboard');
        return $next($request);
    }
}
