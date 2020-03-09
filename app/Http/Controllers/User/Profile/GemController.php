<?php

namespace App\Http\Controllers\User\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GemController extends Controller
{
    public function index()
    {
        $gems = Auth::user()->gems;
        return view('user.profile.gem', compact('gems'));
    }
}
