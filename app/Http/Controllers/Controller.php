<?php

namespace App\Http\Controllers;

use App\Model\Config;
use App\Income\Helper;
use App\Model\Tracking;
use App\Services\RedisCache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function replaceStatement($string)
    {
        $replace = $string;
        $configs = [
            ':id' => Auth::id(),
            ':character_id' => Auth::user()->character->id
        ];
        foreach ($configs as $key => $config) {
            $replace = str_replace($key,$config,$replace);
        }
        return $replace;
    }
    public function tracking($redirect)
    {
        if (Auth::check()) {
            $tracking = Tracking::whereUserId(Auth::id())->first();
            if(empty($tracking)) {
                $createTracking = Tracking::updateOrCreate([
                    'user_id' => Auth::id()
                ],[
                    'user_id' => Auth::id(),
                    'path' => Request::path(),
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
            } else {
                if($tracking->path != Request::path()) {
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
    public function getTrackingHref()
    {
        return Tracking::whereUserId(Auth::id())->first()->path ?? '#';
    }
    public function updatePower()
    {
        $userId = Auth::id();
        $helper = new Helper($userId);
        $helper->updateFullPower();
        $this->clearMyCache();
    }
    public function clearMyCache()
    {
        $userId = Auth::id();
        $this->removeCache("user-{$userId}");
    }
    public function removeCache($key)
    {
        RedisCache::delete($key);
    }
    public function removeAllCache()
    {
        RedisCache::delete('*');
    }
    public function config()
    {
        $config = new Config();
        return $config->first();
    }
}
