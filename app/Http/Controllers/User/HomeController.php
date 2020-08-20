<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $presenterTasks = config('game.presenterScripts');
        $presenterTask = $presenterTasks[rand(0, count($presenterTasks) - 1)];
        return view('user.index')->with([
            'presenterTask' => $presenterTask,
        ]);
    }
}
