<?php

namespace App\Http\Controllers\Api\Profile;

use App\Income\Helper;
use App\Model\UserPet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PetController extends Controller
{
    public function __construct()
    {
        return $this->middleware('prevent.api')->except(['__invoke']);
    }
    public function __invoke()
    {
        return response()->json(Auth::user()->pets,200);
    }
    public function riding(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'pet_id' => 'required|numeric|exists:pets,id'
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
            $findPet = UserPet::where([['user_id',Auth::id()],['id',$request->id],['pet_id',$request->pet_id]]);
            if(isset($findPet) && $findPet->first()->status == 0)
            {
                if($findPet->first()->load('pets')->pets->level_required <= Auth::user()->level())
                {
                    UserPet::where([['user_id',Auth::id()],['status',1]])->update([
                        'status' => 0
                    ]);
                    $ridingPet = $findPet->update([
                        'status' => 1
                    ]);
                    if(isset($ridingPet))
                    {
                        $this->updatePower();
                        $response = [
                            'code' => 200,
                            'status' => 'success',
                            'message' => "Đã sử dụng thú cưỡi ".$findPet->first()->load('pets')->pets->name." thành công !"
                        ];
                    }
                    else
                    {
                        $response = [
                            'code' => 500,
                            'status' => 'error',
                            'message' => "Đã có lỗi xảy ra"
                        ];
                    }
                }
                else
                {
                    $response = [
                        'code' => 500,
                        'status' => 'error',
                        'message' => "Không đủ cấp độ"
                    ];
                }
            }
            else
            {
                $response = [
                    'code' => 500,
                    'status' => 'error',
                    'message' => "Thú cưỡi không tồn tại hoặc đã được trang bị"
                ];
            }
            return response()->json($response,200);
        }
    }
    public function petDown(Request $request)
    {
        $findPet = UserPet::where([['user_id',Auth::id()],['id',$request->id],['pet_id',$request->pet_id]]);
        if(isset($findPet))
        {
            $petDown = $findPet->update([
                'status' => 0
            ]);
            if(isset($petDown))
            {
                $this->updatePower();
                $response = [
                    'code' => 200,
                    'status' => 'success',
                    'message' => "Đã cho thú cưỡi nghỉ ngơi"
                ];
            }
            else
            {
                $response = [
                    'code' => 500,
                    'status' => 'error',
                    'message' => "Đã có lỗi xảy ra"
                ];
            }
        }
        else
        {
            $response = [
                'code' => 500,
                'status' => 'error',
                'message' => "Thú cưỡi không tồn tại"
            ];
        }
        return response()->json($response,200);
    }
    public function dropPet(Request $request)
    {
        $findPet = UserPet::where([['user_id',Auth::id()],['id',$request->id],['pet_id',$request->pet_id]]);
        if(isset($findPet))
        {
            $dropPet = $findPet->delete();
            if(isset($dropPet))
            {
                $this->updatePower();
                $response = [
                    'code' => 200,
                    'status' => 'success',
                    'message' => "Thú cưỡi đã về với tự nhiên, cảm ơn tấm lòng tốt bụng của bạn"
                ];
            }
            else
            {
                $response = [
                    'code' => 500,
                    'status' => 'error',
                    'message' => "Đã có lỗi xảy ra"
                ];
            }
        }
        else
        {
            $response = [
                'code' => 500,
                'status' => 'error',
                'message' => "Thú cưỡi không tồn tại"
            ];
        }
        return response()->json($response,200);
    }
}
