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
        $search = $request->search;
        $ranks = User::orderByDesc('full_power')
        ->where('name','LIKE',"%{$search}%")
        ->orWhere('user_id',$search)
        ->orWhere('provider_id',$search)
        ->paginate($this->perPage);
        return view('user.top.power',compact('ranks'));
    }
    public function level(Request $request)
    {
        $search = $request->search;
        $ranks = User::orderByDesc('exp')
        ->where('name','LIKE',"%{$search}%")
        ->orWhere('user_id',$search)
        ->orWhere('provider_id',$search)
        ->paginate($this->perPage);
        return view('user.top.level',compact('ranks'));
    }
    public function pvp(Request $request)
    {
        $search = $request->search;
        $ranks = User::orderByDesc('pvp_points')
        ->where('name','LIKE',"%{$search}%")
        ->orWhere('user_id',$search)
        ->orWhere('provider_id',$search)
        ->paginate($this->perPage);
        return view('user.top.pvp',compact('ranks'));
    }
    public function coin(Request $request)
    {
        $search = $request->search;
        $ranks = User::orderByDesc(DB::raw('coins + income_coins'))
        ->where('name','LIKE',"%{$search}%")
        ->orWhere('user_id',$search)
        ->orWhere('provider_id',$search)
        ->paginate($this->perPage);
        return view('user.top.coin',compact('ranks'));
    }
    public function gold(Request $request)
    {
        $search = $request->search;
        $ranks = User::orderByDesc('gold')
        ->where('name','LIKE',"%{$search}%")
        ->orWhere('user_id',$search)
        ->orWhere('provider_id',$search)
        ->paginate($this->perPage);
        return view('user.top.gold',compact('ranks'));
    }
    public function activities(Request $request)
    {
        $search = $request->search;
        $ranks = User::orderByDesc('coins')
        ->where('name','LIKE',"%{$search}%")
        ->orWhere('user_id',$search)
        ->orWhere('provider_id',$search)
        ->paginate($this->perPage);
        return view('user.top.activities',compact('ranks'));
    }
}
