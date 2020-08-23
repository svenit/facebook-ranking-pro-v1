<?php

namespace App\Http\Controllers\User;

use App\Model\CateGear;
use App\Model\Character;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $presenterTasks = config('game.presenterScripts');
        $presenterTask = $presenterTasks[rand(0, count($presenterTasks) - 1)];
        $cateGears = Cache::rememberForever('menuShop', function () {
            return CateGear::all();
        }); 
        $characters = Cache::rememberForever('characters', function () {
            return Character::where('id', '!=', env('NO_CHARACTER_ID'))->get();
        });
        return view('user.index')->with([
            'presenterTask' => $presenterTask,
            'menuShop' => $cateGears,
            'characters' => $characters
        ]);
    }
}
