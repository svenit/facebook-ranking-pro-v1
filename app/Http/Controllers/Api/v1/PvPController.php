<?php

namespace App\Http\Controllers\Api\v1;

use App\Model\User;
use App\Income\Helper;
use App\Model\FightRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\v1\IndexController;

class PvPController extends Controller
{
    public function findEnemy(Request $request)
    {
        session_write_close();
        set_time_limit(60);
        $time = 0;
        $timeLimit = 20; 
        $findMatch = FightRoom::where('user_challenge',Auth::id())->first();
        if(isset($findMatch))
        {
            if(isset($findMatch->started_at,$findMatch->user_receive_challenge) && Carbon::parse($findMatch->started_at)->diffInMinutes() >= 5)
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
                while($time < $timeLimit && empty($findMatch->user_receive_challenge))
                {
                    sleep(1);
                    $time++;
                    $findEnemy = FightRoom::whereNull('user_receive_challenge')->where('user_challenge','!=',Auth::id())->get();
                    if(isset($findEnemy))
                    {
                        foreach($findEnemy as $key => $enemy)
                        {
                            $enemyPower = User::findOrFail($enemy->user_challenge);
                            if(Auth::user()->full_power >= $enemyPower->full_power || Auth::user()->full_power <= $enemyPower->full_power)
                            {
                                $time = 60;
                                if(FightRoom::where('user_receive_challenge',$enemyPower->id)->count() == 0)
                                {
                                    FightRoom::where('user_challenge',$enemyPower->id)
                                    ->update([
                                        'user_receive_challenge' => Auth::id(),
                                        'started_at' => now()
                                    ]);
                                    FightRoom::where('user_challenge',Auth::id())
                                        ->update([
                                            'user_receive_challenge' => $enemyPower->id,
                                            'started_at' => now()
                                        ]);
                                    break;
                                }
                                else
                                {
                                    $response = [
                                        'code' => 404,
                                        'status' => 'error',
                                        'message' => "Đối thủ đã trong 1 trận đấu khác",
                                    ];
                                    break;
                                }
                            }
                            else
                            {
                                $response = [
                                    'code' => 404,
                                    'status' => 'error',
                                    'message' => 'Không tìm thấy đối thủ nào'
                                ];
                                break;
                            }
                        }
                    }
                    else
                    {
                        break;
                    }
                }
                $getEnemy = FightRoom::where('user_challenge',Auth::id())->first();
                if(isset($getEnemy->user_receive_challenge))
                {
                    $enemy = new Helper($getEnemy->user_receive_challenge);
                    $you = new Helper(Auth::id());
                    if($getEnemy->turn == 0 && FightRoom::where('user_challenge',$getEnemy->user_receive_challenge)->first()->turn == 0)
                    {
                        switch(true)
                        {
                            case ($enemy->power()['lucky'] > $you->power()['lucky']):
                                $turn = 1; // 1 là đối thủ đi trước
                            break;
                            case ($enemy->power()['lucky'] < $you->power()['lucky']):
                                $turn = 0; // 0 là bạn đi trước
                            break;
                            default:
                                $turn = rand(0,1);
                            break;
                        }
                        if($turn == 1)
                        {
                            FightRoom::where('user_challenge',$getEnemy->user_receive_challenge)->update([
                                'turn' => 1,
                            ]);
                            FightRoom::where('user_challenge',Auth::id())->update([
                                'turn' => 0
                            ]);
                        }
                        else
                        {
                            FightRoom::where('user_challenge',Auth::id())->update([
                                'turn' => 1
                            ]);
                            FightRoom::where('user_challenge',$getEnemy->user_receive_challenge)->update([
                                'turn' => 0
                            ]);
                        }
                    }
                    else
                    {
                        $turn = $getEnemy->turn == 1 ? 0 : 1;
                    }
                    $userApi = new IndexController();
                    $response = [
                        'code' => 200,
                        'status' => 'success',
                        'message' => "Bạn đã ghép trận thành công với ".$userApi->userInfor($getEnemy->user_receive_challenge)->original['infor']['name'],
                        'enemy' => [
                            'basic' => $userApi->userInfor($getEnemy->user_receive_challenge),
                            'hp' => FightRoom::where('user_challenge',$getEnemy->user_receive_challenge)->first()->user_challenge_hp,
                        ],
                        'you' => [
                            'basic' => $userApi->userInfor(Auth::id()),
                            'hp' => $getEnemy->user_challenge_hp,
                            'turn' => $turn,
                        ],
                        
                    ];
                }
                else
                {
                    $response = [
                        'code' => 404,
                        'status' => 'error',
                        'message' => 'Không tìm thấy đối thủ nào'
                    ];
                }
            }
        }
        else
        {
            FightRoom::create([
                'user_challenge' => Auth::id(),
                'user_challenge_hp' => Auth::user()->health_points
            ]);
            $response = [
                'code' => 404,
                'status' => 'success',
                'message' => 'Bạn đã tham gia PvP, xin vui lòng đợi trong giây lát !'
            ];
        }
        return response()->json($response,200);
    }
    public function turnTimeOut()
    {
        $findMatch = FightRoom::where('user_challenge',Auth::id())->first();
        if(isset($findMatch))
        {
            if(isset($findMatch->started_at,$findMatch->user_receive_challenge) && Carbon::parse($findMatch->started_at)->diffInMinutes() >= 5)
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
                    ],
                    'you' => [
                        'basic' => $userApi->userInfor(Auth::id()),
                        'hp' => $you->first()->user_challenge_hp,
                        'turn' => 1
                    ],
                ];
                $you->update([
                    'turn' => 0
                ]);
                $enemy->update([
                    'turn' => 1
                ]);
                return response()->json($response,200);
            }
        }
        else
        {
            return response()->json([],200);
        }
    }
    public function listenAction()
    {
        session_write_close();
        set_time_limit(60);
        $time = 0;
        $timeLimit = 15; 
        $findMatch = FightRoom::where('user_challenge',Auth::id())->first();
        $you = FightRoom::where('user_challenge',Auth::id());
        $enemy = FightRoom::where('user_challenge',$findMatch->user_receive_challenge);
        $enemyTurn = $enemy->first()->turn;
        if(isset($findMatch))
        {
            if(isset($findMatch->started_at,$findMatch->user_receive_challenge) && Carbon::parse($findMatch->started_at)->diffInMinutes() >= 5)
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
                        $you->update([
                            'turn' => 1
                        ]);
                        $enemy->update([
                            'turn' => 0
                        ]);
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
                        ],
                        'you' => [
                            'basic' => $userApi->userInfor(Auth::id()),
                            'hp' => $you->first()->user_challenge_hp,
                            'turn' => 0
                        ],
                    ];
                }
            }
        }
        return response()->json($response,200);
    }
    public function hit()
    {
        $findMatch = FightRoom::where('user_challenge',Auth::id());
        if(isset($findMatch))
        {
            if(isset($findMatch->started_at,$findMatch->user_receive_challenge) && Carbon::parse($findMatch->started_at)->diffInMinutes() >= 5)
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
                $enemy = FightRoom::where('user_challenge',$findMatch->first()->user_receive_challenge);
                if($findMatch->first()->turn == 1)
                {
                    $findMatch->update([
                        'turn' => 0
                    ]);
                    $enemy->update([
                        'user_challenge_hp' => DB::raw('user_challenge_hp - 10'),
                        'turn' => 1
                    ]);
                    $userApi = new IndexController();
                    $response = [
                        'code' => 200,
                        'status' => 'success',
                        'message' => "OK",
                        'enemy' => [
                            'basic' => $userApi->userInfor($enemy->first()->user_challenge),
                            'hp' => $enemy->first()->user_challenge_hp,
                        ],
                        'you' => [
                            'basic' => $userApi->userInfor(Auth::id()),
                            'hp' => $findMatch->first()->user_challenge_hp,
                            'turn' => 1
                        ],
                    ];
                }
                else
                {
                    $response = [
                        'code' => 404,
                        'status' => 'info',
                        'message' => 'Xin vui lòng đợi đến lượt của bạn'
                    ];
                }
            }
        }
        else
        {
            $response = [
                'code' => 404,
                'status' => 'error',
                'message' => 'Không tìm thấy trận đấu này'
            ];
        }
        return response()->json($response,200);
    }
    public function exitMatch()
    {
        $findMatch = FightRoom::where('user_challenge',Auth::id());
        if(isset($findMatch))
        {
            $findMatch->delete();
            $response = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Thoát thành công'
            ];
        }
        return response()->json($response,200);
    }
}
