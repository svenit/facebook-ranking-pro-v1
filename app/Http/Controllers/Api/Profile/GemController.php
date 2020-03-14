<?php

namespace App\Http\Controllers\Api\Profile;

use App\Model\UserGem;
use App\Model\UserGearGem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GemController extends Controller
{
    public function __construct()
    {
        return $this->middleware('prevent.api')->except(['__invoke']);
    }

    public function __invoke()
    {
        $gems = Auth::user()->gems->where('pivot.status',0);

        return response()->json($gems, 200);
    }

    public function remove(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'id' => 'required|exists:gems,id',
            'user_gem_id' => 'required|exists:user_gems,id'
        ]);
        if($validate->fails())
        {
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'Ngọc bổ trợ không tồn tại'
            ]);
        }
        else
        {
            $userGem = UserGem::where([['user_id', Auth::id()],['id', $request->user_gem_id],['gem_id', $request->id],['status', 1]]);
            if($userGem->exists())
            {
                $userGearGem = UserGearGem::where('user_gem_id', $userGem->first()->id);
                if($userGearGem->exists())
                {
                    DB::transaction(function () use($userGem, $userGearGem){
                        $userGem->update([
                            'status' => 0
                        ]);
                        $userGearGem->delete();
                        $this->updatePower();
                    });
                    $response = [
                        'code' => 200,
                        'status' => 'success',
                        'message' => 'Đã tháo ngọc bổ trợ ra khỏi trang bị'
                    ];
                }
            }
            else
            {
                $response = [
                    'code' => 500,
                    'status' => 'error',
                    'message' => 'Ngọc bổ trợ không tồn tại'
                ];
            }
            return response()->json($response);
        }
    }
}
