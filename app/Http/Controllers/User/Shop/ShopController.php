<?php

namespace App\Http\Controllers\User\Shop;

use App\Model\Gear;
use App\Model\CateGear;
use App\Model\Character;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
                $gears = Character::with('gears')->where('id','!=',0)->get();
                foreach($gears as $i => $gear)
                {
                    $gears[$i]->items = Gear::with('cates')->where([['cate_gear_id',$cates->id],['character_id',$gear->id]])->get();
                }
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
