<?php

namespace App\Http\Controllers\Api\PvP;

use Carbon\Carbon;
use App\Model\Room;
use App\Model\User;
use App\Income\Helper;
use App\Model\FightRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\IndexController;
use App\Http\Controllers\Api\PvP\BaseController;

class FindMatchController extends BaseController
{
    public function __invoke(Request $request)
    {
        session_write_close();
        set_time_limit(60);
        $time = 0;
        $timeLimit = 20; 
        $room = Room::where([['name',$request->room],['people',2]])->first();
        $userApi = new IndexController();
        if(isset($room))
        {
            $fightRoom = FightRoom::where('room_id',$room->id);
            if($fightRoom->count() == 2)
            {
                $enemy = FightRoom::where([['room_id',$room->id],['user_challenge','!=',Auth::id()]])->first();
                $you = FightRoom::where([['room_id',$room->id],['user_challenge',Auth::id()]])->first();
                
                if($room->is_fighting == 0 && $you->is_ready == 1)
                {
                    if(isset($room->started_at) && $room->is_fighting == 1 && $this->limitTimeStatus && Carbon::parse($room->started_at)->diffInMinutes() >= $this->limitTime)
                    {
                        $this->pvpRestart($room->id);
                        $response = [
                            'code' => 300,
                            'status' => 'warning',
                            'message' => 'Đã hết thời gian chiến đấu',
                        ];
                    }
                    elseif(collect($this->gameOver)->contains($you->status))
                    {
                        switch($you->status)
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
                                    'code' => 500,
                                    'status' => 'error',
                                    'message' => 'Đã có lỗi xảy ra'
                                ];
                            break;
                        }
                    }
                    else
                    {
                        while($time <= $timeLimit)
                        {
                            $enemyReady = FightRoom::where([['room_id',$room->id],['user_challenge',$enemy->user_challenge]]);
                            $youReady = FightRoom::where([['room_id',$room->id],['user_challenge',Auth::id()]]);
                            if($enemyReady->exists())
                            {
                                if($youReady->first()->is_ready == 0)
                                {
                                    return $response = [
                                        'code' => 404,
                                        'status' => 'error',
                                        'message' => 'Đã tạm dừng, vui lòng sẵn sàng để bắt đầu trận chiến'
                                    ];
                                    break;
                                }
                                elseif($enemyReady->first()->is_ready == 0)
                                {
                                    sleep(1);
                                    $time++;
                                    if($time == $timeLimit)
                                    {
                                        $youReady->update([
                                            'is_ready' => 0
                                        ]);
                                        return $response = [
                                            'code' => 404,
                                            'status' => 'error',
                                            'message' => 'Đối thủ vẫn chưa sẵn sàng'
                                        ];
                                        break;
                                    }
                                }
                                else
                                {
                                    $updateRoom = Room::where('id',$room->id)->update([
                                        'is_fighting' => 1,
                                        'started_at' => now()
                                    ]);
                                    $updateEnemy = FightRoom::where([['room_id',$room->id],['user_challenge',$enemy->user_challenge]])->update([
                                        'user_receive_challenge' => Auth::id(),
                                    ]);
                                    $updateYou = FightRoom::where([['room_id',$room->id],['user_challenge',Auth::id()]])->update([
                                        'user_receive_challenge' => $enemy->user_challenge,
                                    ]);
                                    if(isset($updateRoom,$updateEnemy,$updateYou))
                                    {
                                        Auth::user()->decrement('pvp_times');
                                        Auth::user()->decrement('energy',$this->wasteEnergy);
                                        $time = 60;
                                        break;
                                    }
                                }
                            }
                            else
                            {
                                return $response = [
                                    'code' => 500,
                                    'status' => 'error',
                                    'message' => 'Không tìm thấy đối thủ hoặc đối thủ đã thoát khỏi phòng'
                                ];
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
                                        $turn = 0; // 0 là đối thủ đi trước
                                    break;
                                    case ($enemy->power()['lucky'] < $you->power()['lucky']):
                                        $turn = 1; // 1 là bạn đi trước
                                    break;
                                    default:
                                        $turn = rand(0,1);
                                    break;
                                }
                                if($turn == 1)
                                {
                                    FightRoom::where('user_challenge',$getEnemy->user_receive_challenge)->update([
                                        'turn' => 0,
                                        'countdown_skill' => json_encode($this->getSkills($getEnemy->user_receive_challenge)),
                                        'check_status' => 0
                                    ]);
                                    FightRoom::where('user_challenge',Auth::id())->update([
                                        'turn' => 1,
                                        'countdown_skill' => json_encode($this->getSkills(Auth::id())),
                                        'check_status' => 0
                                    ]);
                                }
                                else
                                {
                                    FightRoom::where('user_challenge',Auth::id())->update([
                                        'turn' => 0,
                                        'countdown_skill' => json_encode($this->getSkills(Auth::id())),
                                        'check_status' => 0
                                    ]);
                                    FightRoom::where('user_challenge',$getEnemy->user_receive_challenge)->update([
                                        'turn' => 1,
                                        'countdown_skill' => json_encode($this->getSkills($getEnemy->user_receive_challenge)),
                                        'check_status' => 0
                                    ]);
                                }
                            }
                            else
                            {
                                $turn = $getEnemy->turn == 1 ? 1 : 0;
                            }
                            Room::findOrFail($room->id)->update([
                                'started_at' => now()
                            ]);
                            $enemy = FightRoom::where('user_challenge',$getEnemy->user_receive_challenge)->first();
                            return response()->json([
                                'code' => 200,
                                'status' => 'success',
                                'message' => "Bạn đã ghép trận thành công với ".$userApi->userInfor($getEnemy->user_receive_challenge)->original['infor']['name'],
                                'enemy' => [
                                    'basic' => $userApi->userInfor($getEnemy->user_receive_challenge),
                                    'hp' => $enemy->user_challenge_hp,
                                    'energy' => $enemy->user_challenge_energy,
                                    'effected' => $enemy->effected,
                                    'countdown' => $this->getSkills($getEnemy->user_receive_challenge)
                                ],
                                'you' => [
                                    'basic' => $userApi->userInfor(Auth::id()),
                                    'hp' => $getEnemy->user_challenge_hp,
                                    'energy' => $getEnemy->user_challenge_energy,
                                    'turn' => $turn,
                                    'effected' => $getEnemy->effected,
                                    'countdown' => $this->getSkills(Auth::id())
                                ],
                                'remaining' => ($this->limitTime * 60)
                            ]);
                        }
                        else
                        {
                            $response = [
                                'code' => 404,
                                'status' => 'error',
                                'message' => 'Không tìm thấy đối thủ nào'
                            ];
                        }
                        return response()->json($response,200);
                    }
                }
                else
                {
                    $response = [
                        'code' => 200,
                        'status' => 'success',
                        'message' => "Bạn đã ghép trận thành công với ".$userApi->userInfor($enemy->user_challenge)->original['infor']['name'],
                        'enemy' => [
                            'basic' => $userApi->userInfor($enemy->user_challenge),
                            'hp' => $enemy->user_challenge_hp,
                            'energy' => $enemy->user_challenge_energy,
                            'effected' => $enemy->effected,
                            'countdown' => $enemy->countdown_skill
                        ],
                        'you' => [
                            'basic' => $userApi->userInfor(Auth::id()),
                            'hp' => $you->user_challenge_hp,
                            'energy' => $you->user_challenge_energy,
                            'turn' => $you->turn,
                            'effected' => $you->effected,
                            'countdown' => $you->countdown_skill
                        ],
                        'remaining' => ($this->limitTime * 60) - Carbon::parse($room->started_at)->diffInSeconds()
                    ];
                }
                return response()->json($response,200);
            }
        }
    }

    public function getSkills($id)
    {
        $skills = [];
        foreach(User::findOrFail($id)->usingSkills() as $key => $skill)
        {
            $skills[$key] = $skill->only('id','countdown');
            $skills[$key]['countdown'] = 0;
        }
        return $skills;
    }
}
