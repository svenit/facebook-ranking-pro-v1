<?php

namespace App\Http\Controllers\Api\v1\Pet;

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
        return $this->middleware('prevent')->except(['__invoke']);
    }
    public function __invoke()
    {
        return response()->json(Auth::user()->pets,200);
    }
    public function riding(Request $request)
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
            $findPet = UserPet::where([['user_id',Auth::id()],['pet_id',$request->id]])->first();
            if(isset($findPet) && $findPet->status == 0)
            {
                if($findPet->load('pets')->pets->level_required <= Auth::user()->level())
                {
                    UserPet::where([['user_id',Auth::id()],['status',1]])->update([
                        'status' => 0
                    ]);
                    Auth::user()->pets()->updateExistingPivot($request->id,[
                        'status' => 1
                    ],false);
                    $this->updatePower();
                    $response = [
                        'code' => 200,
                        'status' => 'success',
                        'message' => "Đã sử dụng thú cưỡi ".$findPet->load('pets')->pets->name." thành công !"
                    ];
                }
                else
                {
                    $response = [
                        'code' => 500,
                        'status' => 'success',
                        'message' => "Không đủ cấp độ"
                    ];
                }
            }
            else
            {
                $response = [
                    'code' => 500,
                    'status' => 'success',
                    'message' => "Thú cưỡi không tồn tại hoặc đã được trang bị"
                ];
            }
            return response()->json($response,200);
        }
    }
    public function petDown(Request $request)
    {
        $petDown = Auth::user()->pets()->updateExistingPivot($request->id,[
            'status' => 0
        ],false);
        if(isset($petDown))
        {
            $this->updatePower();
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => "Đã cho thú cưỡi nghỉ ngơi"
            ],200);
        }
    }
    public function dropPet(Request $request)
    {
        Auth::user()->pets()->detach($request->id);
        $this->updatePower();
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => "Thú cưỡi đã về với tự nhiên, cảm ơn tấm lòng tốt bụng của bạn"
        ],200);
    }
}
