<?php

namespace App\Http\Controllers\User\PVP;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PvPController extends Controller
{
    public function index()
    {
        return view('user.pvp.index');
    }
}
