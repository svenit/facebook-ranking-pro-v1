<?php

namespace App\Http\Controllers\Api\PvP;

use Carbon\Carbon;
use App\Model\Room;
use App\Model\FightRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\IndexController;
use App\Http\Controllers\Api\PvP\BaseController;

class TurnOutController extends BaseController
{
    public function __invoke(Request $request)
    {
        $findMatch = FightRoom::where('user_challenge',Auth::id())->first();
        $room = Room::whereName($request->room)->first();
        if(isset($room) && $room->is_fighting == 1 && $room->people == 2)
        {
            if(isset($findMatch))
            {
                if($this->limitTimeStatus && Carbon::parse($room->started_at)->diffInMinutes() >= $this->limitTime)
                {
                    $this->pvpRestart($room->id);
                    $response = [
                        'code' => 300,
                        'status' => 'warning',
                        'message' => 'Đã hết thời gian chiến đấu',
                    ];
                }
                elseif(collect($this->gameOver)->contains($findMatch->status))
                {
                    switch($findMatch->status)
                    {
                        case 1:
                            $response = [
                                'code' => 201,
                                'win' => false,
                                'status' => 'success',
                                'message' => 'Thua'
                            ];
                        break;
                        case 2:
                            $response = [
                                'code' => 201,
                                'win' => true,
                                'status' => 'success',
                                'message' => 'Thắng'
                            ];
                        break;
                        default;
                            $response = [
                                'code' => 300,
                                'status' => 'error',
                                'message' => 'Đã có lỗi xảy ra'
                            ];
                        break;
                    }
                }
                else
                {
                    $you = FightRoom::where('user_challenge',Auth::id());
                    $enemy = FightRoom::where('user_challenge',$findMatch->user_receive_challenge);
                    $userApi = new IndexController();
                    $you->update([
                        'turn' => 0
                    ]);
                    $enemy->update([
                        'turn' => 1
                    ]);
                    $response = [
                        'code' => 200,
                        'status' => 'success',
                        'message' => "Hết thời gian",
                        'enemy' => [
                            'basic' => $userApi->userInfor($enemy->first()->user_challenge),
                            'hp' => $enemy->first()->user_challenge_hp,
                            'energy' => $enemy->first()->user_challenge_energy,
                            'effected' => $enemy->first()->effected,
                            'buff' => $enemy->first()->buff,
                            'countdown' => $enemy->first()->countdown_skill
                        ],
                        'you' => [
                            'basic' => $userApi->userInfor(Auth::id()),
                            'hp' => $you->first()->user_challenge_hp,
                            'energy' => $you->first()->user_challenge_energy,
                            'turn' => 0,
                            'effected' => $you->first()->effected,
                            'buff' => $you->first()->buff,
                            'countdown' => $you->first()->countdown_skill
                        ],
                    ];
                }
            }
            else
            {
                $response = [
                    'code' => 404,
                    'status' => 'error',
                    'message' => 'Không tìm thấy trận'
                ];
            }
            return response()->json($response,200);
        }
        else
        {
            if($this->limitTimeStatus && Carbon::parse($room->started_at)->diffInMinutes() >= $this->limitTime)
            {
                $this->pvpRestart($room->id);
                $response = [
                    'code' => 300,
                    'status' => 'warning',
                    'message' => 'Đã hết thời gian chiến đấu',
                ];
            }
            else
            {
                $response = [
                    'code' => '404',
                    'status' => 'error',
                    'message' => 'Không tìm thấy phòng'
                ];
            }
            return response()->json($response,200);
        }
    }
}
