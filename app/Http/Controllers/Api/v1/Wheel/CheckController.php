<?php

namespace App\Http\Controllers\Api\v1\Wheel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CheckController extends Controller
{
    private $price = 1000;

    public function __invoke()
    {
        if( Auth::user()->getCoins() >= $this->price)
        {
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'OK'
            ],200);
        }
        return response()->json([
            'code' => 500,
            'status' => 'error',
            'message' => 'Bạn không đủ vàng'
        ]);
    }
}
