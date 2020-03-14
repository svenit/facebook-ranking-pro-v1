<?php

namespace App\Http\Controllers\Api\Wheel;

use Session;
use App\Model\SpinWheel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SpinController extends Controller
{   
    public function __invoke(Request $request)
    {
        if(Session::get('spinning'))
        {
            $hash = md5(substr(time(),0,-2));
            if($request->hash == $hash)
            {
                $data = explode('-',$request->data);
                if($data[0] == md5(strrev($hash)))
                {
                    $findGif = SpinWheel::where([[DB::raw("md5(id)"),$data[1]],[DB::raw("md5(type)"),$data[2]],[DB::raw("md5(probability)"),$data[3]]])->first();
                    if(isset($findGif->query))
                    {
                        $queries = explode("^",$findGif->query);
                        foreach($queries as $query)
                        {
                            $receiveGif = DB::statement($this->replaceStatement($query));
                        }
                        if($receiveGif)
                        {
                            Session::forget('spinning');
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
                            'code' => 200,
                            'status' => 'success',
                            'message' => 'Chúc bạn may mắn lần sau'
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
        }
        else
        {
            $log = " => ".now()." - ID : ".Auth::id()." - UID : ".Auth::user()->user_id . "\n";
            Storage::append('public/spin/'.date('d-m-Y').'.txt',$log);
            $response = [
                'code' => 500,
                'status' => 'error',
                'message' => 'Phát hiện nghi vấn hack, trường hợp của bạn đã được lưu vào lịch sử chúng tôi sẽ xem xét ra đưa ra quyết định khóa tài khoản !'
            ];
        }
        $this->clearMyCache();
        return response()->json($response); 
    }
}
