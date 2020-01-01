<?php

namespace App\Http\Controllers\User\Profile\Item;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ItemController extends Controller
{
    public function index()
    {
        return view('user.profile.item');
    }
}
