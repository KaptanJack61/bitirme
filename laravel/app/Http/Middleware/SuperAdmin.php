<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class SuperAdmin
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
        if (Auth::guard('yonetim')->check() && Auth::guard('yonetim')->user()->admin)
        {
            return $next($request);
        }

        return redirect()->route('yetkisiz.erisim');
    }
}
