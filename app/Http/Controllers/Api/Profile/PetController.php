<?php

namespace App\Http\Controllers\Api\Profile;

use App\Income\Helper;
use App\Model\UserPet;
use App\Services\Crypto;
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
        return response()->json(Crypto::encrypt(Auth::user()->pets),200);
    }
    public function riding(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'id' => 'required|exists:user_pets,id',
            'pet_id' => 'required|numeric|exists:pets,id'
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
            $findPet = UserPet::where([['user_id',Auth::id()],['id',$request->id],['pet_id',$request->pet_id],['status', 0]]);
            if($findPet->exists())
            {
                $pet = $findPet->first()->load('pets')->pets;
                if($pet->level_required <= Auth::user()->level())
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
                            'message' => "Đã sử dụng thú cưỡi ".$pet->name." thành công !"
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
            return response()->json(Crypto::encrypt($response),200);
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
        return response()->json(Crypto::encrypt($response),200);
    }
    public function dropPet(Request $request)
    {
        $findPet = UserPet::where([['user_id',Auth::id()],['id',$request->id],['pet_id',$request->pet_id]]);
        if($findPet->exists())
        {
            $dropPet = $findPet->delete();
            if(isset($dropPet))
            {
                $this->updatePower();
                $response = [
                    'code' => 200,
                    'status' => 'success',
                    'message' => "Bạn đã thả thú cưỡi về với tự nhiên"
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
        return response()->json(Crypto::encrypt($response),200);
    }
}
