<?php

namespace App\Http\Controllers\Api\Profile;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StatController extends Controller
{
    public function __construct()
    {
        return $this->middleware('prevent.api')->except(['__invoke']);
    }
    
    public function increment(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'stat' => [
                'required',
                Rule::in(['health_points', 'strength', 'intelligent', 'agility', 'lucky', 'armor_strength', 'armor_intelligent'])
            ],
            'point' => 'required|numeric|min:1|max:'.Auth::user()->availableStats()
        ]);
        if($validate->fails())
        {
            return response()->json([
                'code' => 500,
                'status' => 'error',
                'message' => $validate->errors()->first()
            ],200);
        }
        else
        {
            $stats = Auth::user()->stats();
            $stats[$request->stat] += $request->point;

            Auth::user()->update([
                'stats' => $stats,
                'stat_points' =>  DB::raw("stat_points - {$request->point}")
            ]);
            $this->updatePower();
            return response()->json([
                'code' => 200,
                'status' => 'success',
                'message' => 'Cộng điểm thuộc tính thành công'
            ],200);
        }
    }
}
