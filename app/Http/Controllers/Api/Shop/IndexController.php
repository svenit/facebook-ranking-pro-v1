<?php

namespace App\Http\Controllers\Api\Shop;

use App\Model\Item;
use App\Services\Crypto;
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
}
