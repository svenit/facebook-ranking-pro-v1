<?php

namespace App\Http\Controllers\User\Events;

use App\Model\SpinWheel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WheelController extends Controller
{
    public function index()
    {
        return view('user.events.wheel');
    }
}
