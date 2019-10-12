<?php

namespace App\Http\Controllers\User;

use App\Model\User;
use App\Income\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
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
