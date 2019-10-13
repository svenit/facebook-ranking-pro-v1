<?php

namespace App\Http\Controllers\User\Top;

use App\Model\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TopController extends Controller
{
    public function power()
    {
        $ranks = User::orderByDesc('full_power')->paginate(10);
        return view('user.top.power',compact('ranks'));
    }
    public function coin()
    {
        $ranks = User::orderByDesc(DB::raw('coins + income_coins'))->paginate(10);
        return view('user.top.coin',compact('ranks'));
    }
    public function gold()
    {
        $ranks = User::orderByDesc('gold')->paginate(10);
        return view('user.top.gold',compact('ranks'));
    }
    public function activities()
    {
        $ranks = User::orderByDesc('coins')->paginate(10);
        return view('user.top.activities',compact('ranks'));
    }
}
