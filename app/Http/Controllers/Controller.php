<?php

namespace App\Http\Controllers;

use App\Model\Tracking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function tracking($redirect)
    {
        if(Auth::check())
        {
            $tracking = Tracking::whereUserId(Auth::id())->first();
            if(empty($tracking))
            {
                $createTracking = Tracking::updateOrCreate([
                    'user_id' => Auth::id()
                ],[
                    'user_id' => Auth::id(),
                    'path' => url()->current(),
                    'route' => Request::route()->getName() ?? '',
                    'redirect' => $redirect == 1 ? true : false
                ]);
                if(empty($createTracking))
                {
                    return redirect()->route('user.index')->with([
                        'status' => 'error',
                        'message' => 'Đã có lỗi xảy ra'
                    ]);
                }
            }
            else
            {
                if($tracking->path != url()->current())
                {
                    return redirect()->route('user.index')->with([
                        'status' => 'error',
                        'message' => 'Không thể thực hiện 2 hành động song song'
                    ]);
                }
            }
        }
    }
    public function removeTracking()
    {
        Tracking::whereUserId(Auth::id())->delete();
    }
    public function checkTracking()
    {
        return Tracking::whereUserId(Auth::id())->first() ? true : false;
    }
}
