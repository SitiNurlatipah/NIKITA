<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminMiddleware
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
        if (isset(Auth::user()->peran_pengguna) && Auth::user()->peran_pengguna == '1'){
            return $next($request);
        } else {
            return abort(403);
        }
        return $next($request);
    }
}
