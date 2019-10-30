<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Cache;

class HomeController extends Controller
{
    public function index()
    {
        return view('user.index')->with([
            'welcome' => Auth::user()->name ?? 'Khách',
        ]);
    }
}
