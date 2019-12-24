<?php

namespace App\Http\Controllers\Api\v1\Wheel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CheckController extends Controller
{
    private $price = 1000;

    public function __invoke(Request $request)
    {
        $hash = md5(substr(time(),0,-2));
        if($request->hash == $hash)
        {
            if(Auth::user()->getCoins() >= $this->price)
            {
                $paid = Auth::user()->decrement('income_coins',$this->price);
                if(isset($paid))
                {
                    return response()->json([
                        'code' => 200,
                        'status' => 'success',
                        'message' => 'OK'
                    ],200);
                }
            }
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'Bạn không đủ vàng'
            ]);
        }
        return response()->json([
            'code' => 500,
            'status' => 'error',
            'message' => 'Không tìm thấy mã kết nối, vui lòng thử lại'
        ]); 
    }
}
