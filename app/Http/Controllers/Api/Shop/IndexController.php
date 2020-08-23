<?php

namespace App\Http\Controllers\Api\Shop;

use App\Model\Gear;
use App\Model\Item;
use App\Model\CateGear;
use App\Model\Character;
use App\Services\Crypto;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class IndexController extends Controller
{
    public function item()
    {
        $items = Cache::rememberForever('shop.item', function () {
            return Item::where('status', 1)->get();
        });
        return response()->json(Crypto::encrypt($items), 200);
    }

    public function equipment($cate) {
        $equips = Cache::rememberForever("shop.$cate", function () use ($cate) {
            $allCates = CateGear::all();
            $characterGears = [];
            foreach($allCates as $cates)
            {
                if($cate == Str::slug($cates->name))
                {
                    $gears = Character::with('gears')->where('id','!=',0)->get();
                    foreach($gears as $i => $gear)
                    {
                        $characterGears[$gear->avatar] = Gear::with('character', 'cates')->where([['status', 1],['cate_gear_id', $cates->id],['character_id', $gear->id]])->get();
                    }
                    break;
                }
            }
            return $characterGears;            
        });
        if(empty($equips)) {
            abort(404);
        }
        return response()->json(Crypto::encrypt($equips), 200); 
    }
}
