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
        if(isset($tracking) && $tracking->redirect == 1 && url()->current() != $tracking->path)
        {
            return redirect()->intended($tracking->path)->with([
                'status' => 'warning',
                'message' => 'Vui lòng bấm vào thoát trước khi bạn muốn thực hiện hành động'
            ]);
        }
        return $next($request);
    }
}
