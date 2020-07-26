<?php

namespace App\Http\Controllers\Api\Shop;

use App\Model\Gem;
use App\Model\Pet;
use App\Model\Gear;
use App\Model\Item;
use App\Model\Skill;
use App\Model\UserGem;
use App\Model\UserPet;
use App\Model\UserGear;
use App\Model\UserItem;
use App\Model\UserSkill;
use App\Services\Crypto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
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
            return response()->json(Crypto::encrypt([
                'code' => 500,
                'status' => 'error',
                'message' => 'Trang bị không tồn tại'
            ]),200);
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
            return response()->json(Crypto::encrypt($response),200);
        }
    }
    public function buySkill(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'id' => 'required|numeric|exists:skills,id'
        ]);
        if($validate->fails())
        {
            return response()->json(Crypto::encrypt([
                'code' => 500,
                'status' => 'error',
                'message' => 'Kỹ năng không tồn tại'
            ]),200);
        }
        else
        {
            $item = Skill::findOrFail($request->id);
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
            return response()->json(Crypto::encrypt($response),200);
        }
    }
    public function buyPet(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'id' => 'required|numeric|exists:pets,id'
        ]);
        if($validate->fails())
        {
            return response()->json(Crypto::encrypt([
                'code' => 500,
                'status' => 'error',
                'message' => 'Thú cưỡi không tồn tại'
            ]),200);
        }
        else
        {
            $item = Pet::findOrFail($request->id);
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
            return response()->json(Crypto::encrypt($response),200);
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
            return response()->json(Crypto::encrypt([
                'code' => 500,
                'status' => 'error',
                'message' => 'Vật phẩm không tồn tại hoặc số lượng không chính xác'
            ]),200);
        }
        else
        {
            $item = Item::findOrFail($request->id);
            if(isset($item))
            {
                switch($item->price_type)
                {
                    case 0:
                        if(Auth::user()->getCoins() >= $item->price * $request->quantity)
                        {
                            Auth::user()->decrement('income_coins',$item->price * $request->quantity);
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
            return response()->json(Crypto::encrypt($response),200);
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
    public function buyGem(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'id' => 'required|exists:gems,id',
            'quantity' => 'required|between:0,10'
        ]);
        if($validate->fails())
        {
            return response()->json(Crypto::encrypt([
                'code' => 500,
                'message' => 'Lỗi',
                'status' => 'error'
            ]));
        }
        else
        {
            $item = Gem::findOrFail($request->id);
            switch($item->price_type)
            {
                case 0:
                    if(Auth::user()->getCoins() >= $item->price * $request->quantity)
                    {
                        DB::transaction(function () use($item, $request){
                            Auth::user()->decrement('income_coins',$item->price * $request->quantity);
                            for($i = 0; $i < $request->quantity; $i++)
                            {
                                UserGem::create([
                                    'user_id' => Auth::id(),
                                    'gem_id' => $item->id,
                                    'status' => 0
                                ]);
                            }
                        });
                        $response = [
                            'code' => 200,
                            'status' => 'success',
                            'message' => 'Mua ngọc bổ trợ thành công'
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
                        $response = [
                            'code' => 200,
                            'status' => 'success',
                            'message' => 'Mua ngọc bổ trợ thành công'
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
            return response()->json(Crypto::encrypt($response),200);
        }
    }
}
