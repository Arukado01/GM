<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfNotActive
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
        if (auth()->user()->isFirstSession())
            return redirect()->route('admin.users.profile', ['flash_message' => true]);

        return $next($request);
    }
}
