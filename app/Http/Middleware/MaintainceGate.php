<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Config;

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
        if($config->first()->maintaince == 1)
        {
            abort(503,'Server đang bảo trì :(');
        }
        return $next($request);
    }
}
