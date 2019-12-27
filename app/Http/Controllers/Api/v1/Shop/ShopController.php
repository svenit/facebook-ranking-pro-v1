<?php

namespace App\Http\Controllers\Api\v1\Shop;

use App\Model\Gear;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\UserGear;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    public function buyItem(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'id' => 'required|numeric|exists:gears,id'
        ]);
        if($validate->fails())
        {
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'Vật phẩm không tồn tại'
            ],200);
        }
        else
        {
            $item = Gear::whereId($request->id)->first();
            if(isset($item))
            {
                $checkItem = UserGear::where([['user_id',Auth::id()],['gear_id',$item->id]])->first();
                if(isset($checkItem))
                {
                    $response = [
                        'code' => 500,
                        'status' => 'error',
                        'message' => 'Bạn đã có vật phẩm này trong túi đồ rồi'
                    ];
                }
                else
                {
                    switch($item->price_type)
                    {
                        case 0:
                            if(Auth::user()->getCoins() >= $item->price)
                            {
                                Auth::user()->decrement('income_coins',$item->price);
                                Auth::user()->gears()->attach($item->id,[
                                    'status' => 0
                                ]);
                                $response = [
                                    'code' => 200,
                                    'status' => 'error',
                                    'message' => 'Mua vật phẩm thành công'
                                ];
                            }
                            else
                            {
                                $response = [
                                    'code' => 500,
                                    'status' => 'error',
                                    'message' => 'Bạn không đủ vàng'
                                ];
                            }
                        break;
                        case 1:
                            if(Auth::user()->gold >= $item->price)
                            {
                                Auth::user()->decrement('gold',$item->price);
                                Auth::user()->gears()->attach($item->id,[
                                    'status' => 0
                                ]);
                                $response = [
                                    'code' => 200,
                                    'status' => 'error',
                                    'message' => 'Mua vật phẩm thành công'
                                ];
                            }
                            else
                            {
                                $response = [
                                    'code' => 500,
                                    'status' => 'error',
                                    'message' => 'Bạn không đủ kim cương'
                                ];
                            }
                        break;
                    }
                }
            }
            else
            {
                $response = [
                    'code' => 500,
                    'status' => 'error',
                    'message' => 'Vật phẩm không tồn tại'
                ];
            }
            return response()->json($response,200);
        }
    }
}
