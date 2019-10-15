<?php

namespace App\Http\Controllers\Api\v1;

use App\Model\User;
use App\Model\FightRoom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\v1\IndexController;

class PvPController extends Controller
{
    public function match()
    {

    }
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
                $userApi = new IndexController();
                $response = [
                    'code' => 200,
                    'status' => 'success',
                    'message' => "Bạn đã ghép trận thành công với ".$userApi->userInfor($getEnemy->user_receive_challenge)->original['infor']['name'],
                    'enemy' => $userApi->userInfor($getEnemy->user_receive_challenge),
                    'you' => $userApi->userInfor(Auth::id()),
                    'test' => $getEnemy
                ];
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
}
