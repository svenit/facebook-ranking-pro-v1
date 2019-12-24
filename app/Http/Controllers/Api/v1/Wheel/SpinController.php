<?php

namespace App\Http\Controllers\Api\v1\Wheel;

use App\Model\SpinWheel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SpinController extends Controller
{   
    public function __invoke(Request $request)
    {
        $hash = md5(substr(time(),0,-2));
        if($request->hash == $hash)
        {
            $data = explode('-',$request->data);
            if($data[0] == md5(strrev($hash)))
            {
                $findGif = SpinWheel::where([[DB::raw("md5(id)"),$data[1]],[DB::raw("md5(type)"),$data[2]],[DB::raw("md5(probability)"),$data[3]]])->first();
                if(isset($findGif))
                {
                    $receiveGif = DB::statement($findGif->query.Auth::id());
                    if($receiveGif)
                    {
                        $response = [
                            'code' => 200,
                            'status' => 'success',
                            'message' => "Chúc mừng bạn nhận được $findGif->result_text"
                        ];
                    }
                }
                else
                {
                    $response = [
                        'code' => 500,
                        'status' => 'error',
                        'message' => 'Không tìm thấy phần thưởng'
                    ];
                }
            }
            else
            {
                $response = [
                    'code' => 500,
                    'status' => 'error',
                    'message' => 'Không tìm thấy mã kết nối, vui lòng thử lại'
                ];
            }
        }
        else
        {
            $response = [
                'code' => 500,
                'status' => 'error',
                'message' => 'Không tìm thấy mã kết nối, vui lòng thử lại'
            ];
        }
        return response()->json($response); 
    }
}
