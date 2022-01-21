<?php

namespace App\Http\Middleware;

use Closure;

class IsAdminOrSupervisor
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
        if(auth()->user()->isAdminOrSupervisor())
            return $next($request);

        return abort(401,'Usuario no autorizado');
    }
}
