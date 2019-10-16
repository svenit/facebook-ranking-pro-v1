<?php

namespace App\Http\Controllers\Api\v1;

use App\Model\User;
use App\Model\FightRoom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\v1\IndexController;
use App\Income\Helper;

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
                                    'user_receive_challenge' => Auth::id() 
                                ]);
                                FightRoom::where('user_challenge',Auth::id())
                                    ->update([
                                        'user_receive_challenge' => $enemyPower->id
                                    ]);
                                $userApi = new IndexController();
                                $response = [
                                    'code' => 200,
                                    'status' => 'success',
                                    'message' => "Bạn đã ghép trận thành công với $enemyPower->name",
                                    'enemy' => $userApi->userInfor($enemyPower->id),
                                    'you' => $userApi->userInfor(Auth::id()),
                                    'enemy' => [
                                        'basic' => $userApi->userInfor($enemyPower->id),
                                        'hp' => FightRoom::where('user_challenge',$enemyPower->id)->first()->user_challenge_hp
                                    ],
                                    'you' => [
                                        'basic' => $userApi->userInfor(Auth::id()),
                                        'hp' => FightRoom::where('user_challenge',Auth::id())->first()->user_challenge_hp
                                    ],
                                ];
                                break;
                            }
                            else
                            {
                                $response = [
                                    'status' => 'error',
                                    'message' => "Đối thủ đã trong 1 trận đấu khác",
                                ];
                                break;
                            }
                        }
                        else
                        {
                            $response = [
                                'status' => 'error',
                                'message' => 'Không tìm thấy đối thủ nào'
                            ];
                            break;
                        }
                    }
                }
                else
                {
                    $userApi = new IndexController();
                    $response = [
                        'code' => 200,
                        'status' => 'success',
                        'message' => "Bạn đã ghép trận thành công với ".$userApi->userInfor($findMatch->user_receive_challenge)->original['infor']['name'],
                        'enemy' => $userApi->userInfor($findMatch->user_receive_challenge),
                        'you' => $userApi->userInfor(Auth::id())
                    ];
                }
            }
            $getEnemy = FightRoom::where('user_challenge',Auth::id())->first();
            if(isset($getEnemy->user_receive_challenge))
            {
                $enemy = new Helper($getEnemy->user_receive_challenge);
                $you = new Helper(Auth::id());
                switch(true)
                {
                    case ($enemy->power()['lucky'] > $you->power()['lucky']):
                        $turn = 1; // 1 là địch
                    break;
                    case ($enemy->power()['lucky'] < $you->power()['lucky']):
                        $turn = 0; // 0 là bạn
                    break;
                    default:
                        $random = rand(1,100);
                        while($random != 50)
                        {
                            $turn = $random < 50 ? 0 : 1;
                            $random = rand(1,100);
                        }
                    break;
                }
                if($turn == 1)
                {
                    $setTurn = FightRoom::where('user_challenge',$getEnemy->user_receive_challenge)->update([
                        'turn' => 1
                    ]);
                }
                else
                {
                    $setTurn = FightRoom::where('user_challenge',Auth::id())->update([
                        'turn' => 1
                    ]);
                }
                if(isset($setTurn))
                {
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
                            'turn' => $turn
                        ],
                    ];
                }
            }
            else
            {
                $response = [
                    'status' => 'error',
                    'message' => 'Không tìm thấy đối thủ nào'
                ];
            }
        }
        else
        {
            FightRoom::create([
                'user_challenge' => Auth::id(),
                'user_challenge_hp' => Auth::user()->health_points
            ]);
            $response = [
                'status' => 'error',
                'message' => 'Không tìm thấy đối thủ nào'
            ];
        }
        return response()->json($response,200);
    }
    public function turnTimeOut()
    {
        $findMatch = FightRoom::where('user_challenge',Auth::id())->first();
        if(isset($findMatch))
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
        $timeLimit = 20; 
        $findMatch = FightRoom::where('user_challenge',Auth::id())->first();
        $enemy = FightRoom::where('user_challenge',$findMatch->user_receive_challenge);
        $enemyTurn = $enemy->first()->turn;
        if(isset($findMatch))
        {
            while($time < $timeLimit && $enemyTurn == 1)
            {
                sleep(1);
                $time++;
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
                return response()->json($response,200);
            }
        }
    }
}
