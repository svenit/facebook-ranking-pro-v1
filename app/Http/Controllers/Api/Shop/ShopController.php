<?php

namespace App\Http\Controllers\Api\Shop;

use App\Model\Pet;
use App\Model\Gear;
use App\Model\Item;
use App\Model\Skill;
use App\Model\UserPet;
use App\Model\UserGear;
use App\Model\UserSkill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Model\UserItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    public function buyEquip(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'id' => 'required|numeric|exists:gears,id'
        ]);
        if($validate->fails())
        {
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'Trang bị không tồn tại'
            ],200);
        }
        else
        {
            $item = Gear::whereId($request->id)->first();
            if(isset($item))
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
                                'status' => 'success',
                                'message' => 'Mua trang bị thành công'
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
                                'status' => 'success',
                                'message' => 'Mua trang bị thành công'
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
            else
            {
                $response = [
                    'code' => 500,
                    'status' => 'error',
                    'message' => 'Trang bị không tồn tại'
                ];
            }
            return response()->json($response,200);
        }
    }
    public function buySkill(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'id' => 'required|numeric|exists:skills,id'
        ]);
        if($validate->fails())
        {
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'Kỹ năng không tồn tại'
            ],200);
        }
        else
        {
            $item = Skill::whereId($request->id)->first();
            if(isset($item))
            {
                $checkItem = UserSkill::where([['user_id',Auth::id()],['skill_id',$item->id]])->first();
                if(isset($checkItem))
                {
                    $response = [
                        'code' => 500,
                        'status' => 'error',
                        'message' => 'Bạn đã có kỹ năng này rồi'
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
                                Auth::user()->skills()->attach($item->id,[
                                    'status' => 0
                                ]);
                                $response = [
                                    'code' => 200,
                                    'status' => 'success',
                                    'message' => 'Mua kỹ năng thành công'
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
                                Auth::user()->skills()->attach($item->id,[
                                    'status' => 0
                                ]);
                                $response = [
                                    'code' => 200,
                                    'status' => 'success',
                                    'message' => 'Mua kỹ năng thành công'
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
                    'message' => 'Kỹ năng không tồn tại'
                ];
            }
            return response()->json($response,200);
        }
    }
    public function buyPet(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'id' => 'required|numeric|exists:pets,id'
        ]);
        if($validate->fails())
        {
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'Thú cưỡi không tồn tại'
            ],200);
        }
        else
        {
            $item = Pet::whereId($request->id)->first();
            if(isset($item))
            {
                switch($item->price_type)
                {
                    case 0:
                        if(Auth::user()->getCoins() >= $item->price)
                        {
                            Auth::user()->decrement('income_coins',$item->price);
                            Auth::user()->pets()->attach($item->id,[
                                'status' => 0
                            ]);
                            $response = [
                                'code' => 200,
                                'status' => 'success',
                                'message' => 'Mua thú cưỡi thành công'
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
                            Auth::user()->pets()->attach($item->id,[
                                'status' => 0
                            ]);
                            $response = [
                                'code' => 200,
                                'status' => 'success',
                                'message' => 'Mua thú cưỡi thành công'
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
            else
            {
                $response = [
                    'code' => 500,
                    'status' => 'error',
                    'message' => 'Thú cưỡi không tồn tại'
                ];
            }
            return response()->json($response,200);
        }
    }
    public function buyItem(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'id' => 'required|numeric|exists:items,id',
            'quantity' => 'required|numeric|min:1|max:9999'
        ]);
        if($validate->fails())
        {
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'Vật phẩm không tồn tại hoặc số lượng không chính xác'
            ],200);
        }
        else
        {
            $item = Item::whereId($request->id)->first();
            if(isset($item))
            {
                switch($item->price_type)
                {
                    case 0:
                        if(Auth::user()->getCoins() >= $item->price * $request->quantity)
                        {
                            Auth::user()->decrement('income_coins',$item->price);
                            $this->checkItem($request,$item);
                            $response = [
                                'code' => 200,
                                'status' => 'success',
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
                        if(Auth::user()->gold >= $item->price * $request->quantity)
                        {
                            Auth::user()->decrement('gold',$item->price * $request->quantity);
                            $this->checkItem($request,$item);
                            $response = [
                                'code' => 200,
                                'status' => 'success',
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
    public function checkItem($request,$item)
    {
        $checkItem = UserItem::where([['user_id',Auth::id()],['item_id',$request->id]])->first();
        if(isset($checkItem))
        {
            Auth::user()->items()->updateExistingPivot($request->id,[
                'quantity' => DB::raw("quantity + $request->quantity")
            ]);
        }
        else
        {
            Auth::user()->items()->attach($item->id,[
                'quantity' => $request->quantity
            ]);
        }
    }
}
