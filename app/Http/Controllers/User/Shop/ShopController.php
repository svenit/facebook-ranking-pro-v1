<?php

namespace App\Http\Controllers\User\Shop;

use App\Model\CateGear;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Gear;

class ShopController extends Controller
{
    public function index($cate)
    {
        $allCates = CateGear::all();
        $gears = [];
        $avaiableRows = false;
        foreach($allCates as $key => $cates)
        {
            if($cate == Str::slug($cates->name))
            {
                $avaiableRows = true;
                $gears = Gear::whereCateGearId($cates->id)->get();
                break;
            }
        }
        if($avaiableRows)
        {
            return view('user.shop.index',compact('gears'));
        }
        abort(404);
    }
}
