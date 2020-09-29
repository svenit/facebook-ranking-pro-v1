<?php
namespace App\Http\Controllers\User\Shop;
use App\Model\Gem;
use App\Model\Pet;
use App\Model\Gear;
use App\Model\Item;
use App\Model\CateGear;
use App\Model\Character;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Services\RedisCache;

class ShopController extends Controller
{
    public function index($cate)
    {
        $equips = RedisCache::rememberForever("shop.$cate", function () use ($cate) {
            $allCates = CateGear::all();
            $gears = false;
            foreach($allCates as $cates)
            {
                if($cate == Str::slug($cates->name))
                {
                    $gears = Character::with('gears')->where('id','!=',0)->get();
                    foreach($gears as $i => $gear)
                    {
                        $gears[$i]->items = Gear::with('character','cates')->where([['status',1],['cate_gear_id',$cates->id],['character_id',$gear->id]])->get();
                    }
                    break;
                }
            }
            return $gears;
        });
        if($equips)
        {
            return view('user.shop.index',compact('equips'));
        }
        abort(404);
    }
    public function skill()
    {
        $skills = RedisCache::rememberForever('shop.skill', function () {
            return Character::with('skills')->where([['id','!=',0]])->get();
        });
        return view('user.shop.skill',compact('skills'));
    }
    public function pet()
    {
        $pets = RedisCache::rememberForever('shop.pet', function () {
            return Pet::where('status',1)->get();
        });
        return view('user.shop.pet',compact('pets'));
    }
    public function item()
    {
        $items = RedisCache::rememberForever('shop.item', function () {
            return Item::where('status', 1)->get();
        });
        return view('user.shop.item',compact('items'));
    }

    public function gem()
    {
        $gems = RedisCache::rememberForever('gem.item', function () {
            return Gem::where('status', 1)->get();
        });
        return view('user.shop.gem',compact('gems'));
    }
}