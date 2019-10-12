<?php

namespace App\Http\Controllers\User\Top;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TopController extends Controller
{
    public function power()
    {
        $ranks = User::orderByDesc('full_power')->paginate(10);
        return view('user.top.power',compact('ranks'));
    }
}
