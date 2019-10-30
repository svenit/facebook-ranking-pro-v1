<?php

namespace App\Http\Controllers\User\Top;

use App\Model\User;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TopController extends Controller
{
    private $cacheTime = 10;
    private $perPage = 10;

    public function power(Request $request)
    {
        $ranks = Cache::remember("top.power.$request->page", $this->cacheTime, function () {
            return User::orderByDesc('full_power')->paginate($this->perPage);
        });
        return view('user.top.power',compact('ranks'));
    }
    public function coin(Request $request)
    {
        $ranks = Cache::remember("top.coin.$request->page", $this->cacheTime, function () {
            return User::orderByDesc(DB::raw('coins + income_coins'))->paginate($this->perPage);
        });
        return view('user.top.coin',compact('ranks'));
    }
    public function gold(Request $request)
    {
        $ranks = Cache::remember("top.gold.$request->page", $this->cacheTime, function () {
            return User::orderByDesc('gold')->paginate($this->perPage);
        });
        return view('user.top.gold',compact('ranks'));
    }
    public function activities(Request $request)
    {
        $ranks = Cache::remember("top.coin.$request->page", $this->cacheTime, function () {
            return User::orderByDesc('coins')->paginate($this->perPage);
        });
        return view('user.top.activities',compact('ranks'));
    }
}
