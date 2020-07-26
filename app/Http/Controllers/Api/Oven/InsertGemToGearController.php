<?php

namespace App\Http\Controllers\Api\Oven;

use App\Model\UserGem;
use App\Model\UserGear;
use App\Services\Crypto;
use App\Model\UserGearGem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InsertGemToGearController extends Controller
{
    public function insert(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'gear_id' => 'required|exists:gears,id',
            'user_gear_id' => 'required|exists:user_gears,id',
            'gem_id' => 'required|exists:gems,id'
        ]);
        if($validate->fails())
        {
            return response()->json(Crypto::encrypt([
                'code' => 500,
                'status' => 'error',
                'message' => 'Đã có lỗi xảy ra'
            ]));
        }
        else
        {
            $gem = UserGem::where([['gem_id', $request->gem_id],['user_id', Auth::id()],['status',0]]);
            $gear = UserGear::where([['id', $request->user_gear_id],['gear_id', $request->gear_id],['user_id', Auth::id(),['status',0]]]);
            $countGems = $gear->first()->load('gems')->gems->count();
            if($gem->exists() && $gear->exists())
            {
                $paid = 200;
                $maxGems = 3;
                if(Auth::user()->getCoins() >= $paid)
                {
                    if($countGems >= $maxGems)
                    {
                        $response = [
                            'code' => 500,
                            'status' => 'error',
                            'message' => "Bạn chỉ có thể khảm tối đa {$maxGems} viên ngọc bổ trợ cho mỗi trang bị"
                        ];
                    }
                    else
                    {
                        DB::transaction(function () use($gem, $gear, $request, $paid){
                            UserGearGem::create([
                                'user_gear_id' => $gear->first()->id,
                                'user_gem_id' => $gem->first()->id,
                                'gem_id' => $request->gem_id
                            ]);
                            Auth::user()->decrement('income_coins', $paid);
                            $gem->update([
                                'status' => 1
                            ]);
                        });
                        $response = [
                            'code' => 200,
                            'status' => 'success',
                            'message' => 'Chúc mừng bạn đã khảm ngọc bổ trợ thành công'
                        ];
                    }
                }
                else
                {
                    $response = [
                        'code' => 500,
                        'status' => 'error',
                        'message' => 'Bạn không đủ vàng'
                    ];
                }
            }
            else
            {
                $response = [
                    'code' => 500,
                    'status' => 'error',
                    'message' => 'Đã có lỗi xảy ra'
                ];
            }
            return response()->json(Crypto::encrypt($response),200);
        }
    }
}
