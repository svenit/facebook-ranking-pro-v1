<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $presenterTasks = config('game.presenterScripts');
        $presenterTask = $presenterTasks[rand(0, count($presenterTasks) - 1)];
        return view('user.index')->with([
            'presenterTask' => $presenterTask
        ]);
    }
}
