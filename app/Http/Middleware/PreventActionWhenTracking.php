<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\Crypto;
use App\Http\Controllers\Controller;

class PreventActionWhenTracking
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
        $checkTracking = new Controller;
        if($checkTracking->checkTracking())
        {
            return response()->json(Crypto::encrypt([
                'code' => 500,
                'status' => 'error',
                'message' => 'Không thể thực hiện hành động trong lúc này'
            ]));
        }
        return $next($request);
    }
}
