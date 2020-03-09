<?php

namespace App\Http\Controllers\User\Profile;

use App\Model\CateGear;
use App\Http\Controllers\Controller;

class InventoryController extends Controller
{
    public function index()
    {
        $cates = CateGear::all();
        return view('user.profile.inventory',compact('cates'));
    }
}
