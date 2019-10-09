<?php

namespace App\Http\Middleware;

use Closure;
use App\User;
use Illuminate\Support\Facades\Auth;

class AdminAuth
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
        if(User::all()->count() == 0)
        {
            return $next($request);
        }
        else
        {
            if(Auth::check() && Auth::user()->isAdmin)
            {
                return $next($request);
            }
            return abort(404);
        }
    }
}
