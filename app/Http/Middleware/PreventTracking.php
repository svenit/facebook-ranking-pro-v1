<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Tracking;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class PreventTracking
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
        $tracking = Tracking::where('user_id',Auth::id())->first();
        if($checkTracking->checkTracking() && Request::route()->getName() != $tracking->route)
        {
            return redirect()->back()->with([
                'message' => 'Bạn đang thực hiện một hành động khác',
                'status' => 'warning'
            ]);
        }
        return $next($request);
    }
}
