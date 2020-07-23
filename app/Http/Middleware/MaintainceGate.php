<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Config;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class MaintainceGate
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
        $config = new Config();
        $newToken = uniqid(Str::random(40));
        Session::forget('_token');
        Session::put('_token', $newToken);
        if(Auth::check() && Auth::user()->isAdmin)
        {
            return $next($request);
        }
        else
        {
            if($config->first()->maintaince == 1)
            {
                abort(503);
            }
            return $next($request);
        }
    }
}
