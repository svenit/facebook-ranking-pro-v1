<?php

namespace App\Http\Controllers\User\Top;

use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class TopController extends Controller
{
    private $perPage = 10;

    public function power(Request $request)
    {
        $ranks = User::orderByDesc('full_power')->paginate($this->perPage);
        return view('user.top.power',compact('ranks'));
    }
    public function level(Request $request)
    {
        $ranks = User::orderByDesc('exp')->paginate($this->perPage);
        return view('user.top.level',compact('ranks'));
    }
    public function pvp(Request $request)
    {
        $ranks = User::orderByDesc('pvp_points')->paginate($this->perPage);
        return view('user.top.pvp',compact('ranks'));
    }
    public function coin(Request $request)
    {
        $ranks = User::orderByDesc(DB::raw('coins + income_coins'))->paginate($this->perPage);
        return view('user.top.coin',compact('ranks'));
    }
    public function gold(Request $request)
    {
        $ranks = User::orderByDesc('gold')->paginate($this->perPage);
        return view('user.top.gold',compact('ranks'));
    }
    public function activities(Request $request)
    {
        $ranks = User::orderByDesc('coins')->paginate($this->perPage);
        return view('user.top.activities',compact('ranks'));
    }
}
