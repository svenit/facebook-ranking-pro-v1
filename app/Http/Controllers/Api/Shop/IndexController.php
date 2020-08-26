<?php

namespace App\Http\Controllers\Api\Shop;

use App\Model\Gem;
use App\Model\Pet;
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

    public function gems()
    {
        $gems = Cache::rememberForever('gem.item', function () {
            return Gem::where('status', 1)->get();
        });
        return response()->json(Crypto::encrypt($gems), 200);
    }

    public function pet()
    {
        $pets = Cache::rememberForever('shop.pet', function () {
            return Pet::where('status',1)->get();
        });
        return response()->json(Crypto::encrypt($pets), 200);
    }

    public function skill()
    {
        $skills = Cache::rememberForever('shop.skill', function () {
            return Character::with('skills')->where([['id', '!=', env('NO_CHARACTER_ID')]])->get();
        });
        $formatSkills = [];
        foreach ($skills as $key => $skill) {
            $formatSkills[$skill->avatar] = $skill->skills;
        }
        return response()->json(Crypto::encrypt($formatSkills), 200);
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
