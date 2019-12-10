<?php

namespace App\Http\Controllers\Api\v1\PvP;

use Carbon\Carbon;
use App\Model\FightRoom;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\v1\IndexController;
use App\Http\Controllers\Api\v1\PvP\BaseController;

class ListenActionController extends BaseController
{
    public function __invoke()
    {
        session_write_close();
        set_time_limit(60);
        $time = 0;
        $timeLimit = 15; 
        $findMatch = FightRoom::where('user_challenge',Auth::id())->first();
        $you = FightRoom::where('user_challenge',Auth::id());
        $enemy = FightRoom::where('user_challenge',$findMatch->user_receive_challenge);
        $enemyTurn = $enemy->first()->turn;
        if(isset($findMatch,$findMatch->first()->user_receive_challenge))
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
            else
            {
                while($time <= $timeLimit + 1 && $enemyTurn == 1)
                {
                    sleep(1);
                    $time++;
                    if($time == $timeLimit)
                    {
                        $hp = 0;
                        foreach(Auth::user()->usingSkills() as $key => $yourPassiveSkill)
                        {
                            if($yourPassiveSkill->passive == 1)
                            {
                                switch($yourPassiveSkill->type)
                                {
                                    case 'health_points':
                                        if($yourPassiveSkill->success_rate <= rand(0,100))
                                        {
                                            if($yourPassiveSkill->power_type == 0)
                                            {
                                                $hp = $yourPassiveSkill->power_value;
                                            }
                                            elseif($yourPassiveSkill->power_type == 1)
                                            {
                                                $hp = ($you->first()->user_challenge_hp * $yourPassiveSkill->power_value)/100;
                                            }
                                            else
                                            {
                                                $hp = 0;
                                            }
                                        }
                                    break;
                                    default:
                                        $hp = 0;
                                    break;
                                }
                            }
                        }
                        $you->update([
                            'turn' => 1,
                            'user_challenge_energy' => DB::raw("user_challenge_energy + ".$this->energyRecovery = $you->first()->user_challenge_energy + $this->energyRecovery > Auth::user()->character->default_energy ? Auth::user()->character->default_energy - $you->first()->user_challenge_energy : $this->energyRecovery),
                            'user_challenge_hp' => DB::raw("user_challenge_hp +".$hp = $you->first()->user_challenge_hp + $hp > Auth::user()->power()['health_points'] ? Auth::user()->power()['health_points'] - $you->first()->user_challenge_hp : $hp)
                        ]);
                        $enemy->update([
                            'turn' => 0
                        ]);
                    }
                    elseif(collect($this->gameOver)->contains(FightRoom::where('user_challenge',Auth::id())->first()->status))
                    {
                        switch(FightRoom::where('user_challenge',Auth::id())->first()->status)
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
                                    'code' => 201,
                                    'win' => false,
                                    'status' => 'error',
                                    'message' => 'Đã có lỗi xảy ra'
                                ];
                            break;
                        }
                        return response()->json($response,200);
                    }
                    else
                    {
                        $recallEnemy = FightRoom::where('user_challenge',$findMatch->user_receive_challenge);
                        if($recallEnemy->first()->turn == 0)
                        {
                            break;
                        }
                    }
                }
                $getEnemy = FightRoom::where('user_challenge',$findMatch->user_receive_challenge);
                if($getEnemy->first()->turn == 0)
                {
                    $you = FightRoom::where('user_challenge',Auth::id());
                    $enemy = FightRoom::where('user_challenge',$findMatch->user_receive_challenge);
                    $userApi = new IndexController();
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
                else
                {
                    $response = [
                        'code' => 404,
                        'status' => 'error',
                        'message' => 'Đã có lỗi xảy ra, xin vui lòng thử lại',
                    ];
                }
            }
        }
        else
        {
            $response = [
                'code' => 404,
                'status' => 'error',
                'message' => 'Đã có lỗi xảy ra xin vui lòng thử lại'
            ];
        }
        return response()->json($response,200);
    }
}
