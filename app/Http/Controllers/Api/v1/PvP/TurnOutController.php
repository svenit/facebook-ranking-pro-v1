<?php

namespace App\Http\Controllers\Api\v1\PvP;

use Carbon\Carbon;
use App\Model\FightRoom;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\v1\IndexController;
use App\Http\Controllers\Api\v1\PvP\BaseController;

class TurnOutController extends BaseController
{
    public function __invoke()
    {
        $findMatch = FightRoom::where('user_challenge',Auth::id())->first();
        if(isset($findMatch))
        {
            if(isset($findMatch->started_at,$findMatch->user_receive_challenge) && $this->limitTimeStatus && Carbon::parse($findMatch->started_at)->diffInMinutes() >= $this->limitTime)
            {
                FightRoom::whereIn('user_challenge',[Auth::id(),$findMatch->user_receive_challenge])->delete();
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
                    ],
                    'you' => [
                        'basic' => $userApi->userInfor(Auth::id()),
                        'hp' => $you->first()->user_challenge_hp,
                        'energy' => $you->first()->user_challenge_energy,
                        'turn' => 0,
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
}
