<?php

namespace App\Http\Controllers\User\Inventory;

use App\Model\User;
use App\Model\CateGear;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function index()
    {
        $cates = CateGear::all();
        return view('user.inventory.index',compact('cates'));
    }
}
