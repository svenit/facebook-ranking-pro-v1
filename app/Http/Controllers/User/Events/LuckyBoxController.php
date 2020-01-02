<?php

namespace App\Http\Controllers\User\Events;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LuckyBoxController extends Controller
{
    public function index()
    {
        return view('user.events.lucky-box');
    }
}
