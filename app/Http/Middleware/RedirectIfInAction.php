<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Tracking;
use Illuminate\Support\Facades\Auth;

class RedirectIfInAction
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
        $tracking = Tracking::whereUserId(Auth::id())->first();
        if(isset($tracking) && $tracking->redirect == 1 && $request->path() != $tracking->path)
        {
            return redirect($tracking->path)->with([
                'status' => 'warning',
                'message' => 'Vui lòng bấm vào thoát trước khi bạn muốn thực hiện hành động khác'
            ]);
        }
        return $next($request);
    }
}
