<?php

namespace App\Http\Controllers\User;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Income\Helper;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        return view('user.index')->with([
            'welcome' => Auth::user()->name ?? 'Khách',
        ]);
    }
}
