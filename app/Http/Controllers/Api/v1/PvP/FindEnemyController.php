<?php

namespace App\Http\Controllers\Api\v1\PvP;

use App\Http\Controllers\Api\v1\IndexController;
use App\Model\Room;
use App\Model\FightRoom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FindEnemyController extends Controller
{
    public function __invoke(Request $request)
    {
        $api = new IndexController();
        $room = Room::where([['name',$request->name],['user_create_id',$request->master],['people',2],['is_fighting',$request->is_fighting]])->first();
        if(isset($room))
        {
            $enemy = FightRoom::where([['room_id',$room->id],['user_challenge','!=',Auth::id()]])->first();
            $you = FightRoom::where([['room_id',$room->id],['user_challenge',Auth::id()]])->first();
            
            if($room->people == 2)
            {
                $fightRoom = FightRoom::where('room_id',$room->id);
                if($fightRoom->count() == 2 && isset($enemy,$you))
                {
                    return response()->json([
                        'you' => [
                            'basic' => $api->userInfor(Auth::id()),
                            'hp' => $you->user_challenge_hp,
                            'energy' => $you->user_challenge_energy,
                        ],
                        'enemy' => [
                            'basic' => $api->userInfor($enemy->user_challenge),
                            'hp' => $enemy->user_challenge_hp,
                            'energy' => $enemy->user_challenge_energy,
                        ],
                        'code' => 200,
                        'status' => 'success'
                    ],200);
                }
                else
                {
                    return response()->json([
                        'you' => [
                            'basic' => $api->userInfor(Auth::id()),
                            'hp' => $you->user_challenge_hp,
                            'energy' => $you->user_challenge_energy,
                        ],
                        'message' => 'Chưa có ai tham gia phòng',
                        'code' => 404,
                        'status' => 'error'
                    ],200);
                }
            }
            else
            {
                return response()->json([
                    'you' => [
                        'basic' => $api->userInfor(Auth::id()),
                        'hp' => $you->user_challenge_hp,
                        'energy' => $you->user_challenge_energy,
                    ],
                    'message' => 'Chưa có ai tham gia phòng',
                    'code' => 404,
                    'status' => 'error'
                ],200);
            }
        }
        else
        {
            return response()->json([
                'message' => 'Không tìm thấy phòng',
                'code' => 404,
                'status' => 'error'
            ],200);
        }
    }
}
