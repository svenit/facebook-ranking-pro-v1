<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Config;
use Illuminate\Support\Facades\Auth;

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
