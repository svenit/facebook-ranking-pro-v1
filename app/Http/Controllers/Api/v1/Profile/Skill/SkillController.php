<?php

namespace App\Http\Controllers\Api\v1\Profile\Skill;

use App\Model\Skill;
use App\Model\UserSkill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Income\Helper;

class SkillController extends Controller
{
    private $maxSkill = 4;

    public function __construct()
    {
        return $this->middleware('prevent')->except(['__invoke']);
    }
    public function __invoke()
    {
        return response()->json(Auth::user()->skills->load('character'),200);
    }
    public function useSkill(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'id' => 'required|numeric|exists:skills,id'
        ]);
        if($validate->fails())
        {
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => 'Kĩ năng không tồn tại'
            ],200);
        }
        else
        {
            $recentSkills = UserSkill::where([['user_id',Auth::id()],['status',1]]);
            if($recentSkills->count() < $this->maxSkill)
            {
                $levelRequired = Skill::findOrFail($request->id)->required_level;
                if(Auth::user()->level() >= $levelRequired)
                {
                    Auth::user()->skills()->updateExistingPivot($request->id,[
                        'status' => 1
                    ],false);
                    $response = [
                        'code' => 200,
                        'status' => 'success',
                        'message' => "Trang bị kỹ năng thành công"
                    ];
                }
                else
                {
                    $response = [
                        'code' => 500,
                        'status' => 'error',
                        'message' => "Không đủ cấp độ yêu cầu"
                    ];
                }
            }
            else
            {
                $response = [
                    'code' => 500,
                    'status' => 'error',
                    'message' => "Bạn không thể sử dụng quá $this->maxSkill kỹ năng"
                ];
            }
            return response()->json($response,200);
        }
    }
    public function removeSkill(Request $request)
    {
        $removeSkill = Auth::user()->skills()->updateExistingPivot($request->id,[
            'status' => 0
        ],false);
        if(isset($removeSkill))
        {
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => "Đã gỡ kỹ năng"
            ],200);
        }
    }
    public function deleteSkill(Request $request)
    {
        Auth::user()->skills()->detach($request->id);
        return response()->json([
            'code' => 200,
            'status' => 'success',
            'message' => "Đã vứt bỏ kĩ năng :("
        ],200);
    }
}
