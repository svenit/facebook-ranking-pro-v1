<?php

namespace App\Http\Controllers\User\Top;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TopRichestController extends Controller
{
    public function power()
    {
        return view('user.top.power');
    }
}
