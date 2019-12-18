<?php

namespace App\Http\Controllers\Api\v1\PvP;

use App\Events\PvPHitEnemy;
use Carbon\Carbon;
use App\Model\Room;
use App\Model\User;
use App\Model\Skill;
use App\Model\FightRoom;
use App\Model\UserSkill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\v1\IndexController;
use App\Http\Controllers\Api\v1\PvP\BaseController;

class HitController extends BaseController
{
    public function __invoke(Request $request)
    {
        session_write_close();
        set_time_limit(60);

        $validate = Validator::make($request->all(), [
            'skill' => 'required|numeric|min:0|exists:skills,id',
            'room' => 'required|exists:rooms,name'
        ]);
        if($validate->fails())
        {
            return response()->json($validate->errors()->toArray(),200);
        }
        else
        {
            $room = Room::whereName($request->room)->first();
            if(isset($room) && $room->is_fighting == 1 && $room->people == 2)
            {
                $userApi = new IndexController();
                $findMatch = FightRoom::where('user_challenge',Auth::id());
                if(isset($findMatch,$findMatch->first()->user_receive_challenge))
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
                    else
                    {
                        $enemy = FightRoom::where('user_challenge',$findMatch->first()->user_receive_challenge);
                        if(FightRoom::where('user_challenge',Auth::id())->first()->turn == 1 && $enemy->first()->turn == 0)
                        {
                            $checkSkill = UserSkill::where([['user_id',Auth::id()],['skill_id',$request->skill],['status',1]])->first();
                            if(isset($checkSkill))
                            {
                                $skill = Skill::find($checkSkill->skill_id);
                                if($skill->passive == 0)
                                {
                                    if($findMatch->first()->user_challenge_energy >= $skill->energy)
                                    {
                                        $randomRate = rand(0,100);
                                        $getEnemyInfor = User::findOrFail($enemy->first()->user_challenge);

                                        $allAgility = Auth::user()->power()['agility'] + $getEnemyInfor->power()['agility'];
                                        $allLucky = Auth::user()->power()['lucky'] + $getEnemyInfor->power()['lucky'];

                                        if($randomRate <= $skill->success_rate && $randomRate <= (Auth::user()->power()['agility']/$allAgility) * 100)
                                        {
                                            /* Your skill */
                                            $destroy = 0;
                                            $effectTo = 0; 
                                            $yourUpdate = [
                                                'turn' => 0,
                                                'user_challenge_energy' => DB::raw("user_challenge_energy - $skill->energy")
                                            ];
                                            switch($skill->type)
                                            {
                                                case 'strength':
                                                    $destroy = $this->renderDestroy(Auth::user()->power()['strength'],$skill) - $getEnemyInfor->power()['armor_strength'] <= 0 ? 0 : $this->renderDestroy(Auth::user()->power()['strength'],$skill) - $getEnemyInfor->power()['armor_strength'];
                                                    $message = "[ $skill->name ] Bạn đã gây $destroy sát thương vật lí cho đối thủ";
                                                break;
                                                case 'intelligent':
                                                    $destroy = $this->renderDestroy(Auth::user()->power()['intelligent'],$skill) - $getEnemyInfor->power()['armor_intelligent'] <= 0 ? 0 : $this->renderDestroy(Auth::user()->power()['intelligent'],$skill) - $getEnemyInfor->power()['armor_intelligent'];
                                                    $message = "[ $skill->name ] Bạn đã gây $destroy sát thương phép thuật cho đối thủ";
                                                break;
                                                case 'crit':
                                                    $destroy = $this->renderDestroy(Auth::user()->power()['strength'],$skill) * 2;
                                                    $message = "[ $skill->name ] Bạn đã gây $destroy sát thương chí mạng cho đối thủ";
                                                break;
                                                case 'half-hp':
                                                    $destroy = (int)$enemy->first()->user_challenge_hp/2;
                                                    $message = "[ $skill->name ] Bạn đã gây $destroy sát thương tinh thần cho đối thủ";
                                                break;
                                                case 'health_points':
                                                    if($skill->power_type == $this->parameter)
                                                    {
                                                        $hp = (int)($findMatch->first()->user_challenge_hp + $skill->power_value) < Auth::user()->power()['health_points'] ? $skill->power_value : (int)(Auth::user()->power()['health_points'] - $findMatch->first()->user_challenge_hp);
                                                        $yourUpdate = [
                                                            'turn' => 0,
                                                            'user_challenge_hp' => DB::raw("user_challenge_hp + $hp"),
                                                            'user_challenge_energy' => DB::raw("user_challenge_energy - $skill->energy")
                                                        ];
                                                        $message = $hp > 0 ? "[ $skill->name ] Bạn đã được hồi $hp HP" : "[ $skill->name ] Bạn đã đầy máu không thể hồi thêm";
                                                    }
                                                    elseif($skill->power_type == $this->percent)
                                                    {
                                                        $renderHP = ($findMatch->first()->user_challenge_hp * $skill->power_value)/100;
                                                        $hp = (int)($findMatch->first()->user_challenge_hp + $renderHP) < Auth::user()->power()['health_points'] ? $renderHP : (int)(Auth::user()->power()['health_points'] - $findMatch->first()->user_challenge_hp);
                                                        $yourUpdate = [
                                                            'turn' => 0,
                                                            'user_challenge_hp' => DB::raw("user_challenge_hp + $hp"),
                                                            'user_challenge_energy' => DB::raw("user_challenge_energy - $skill->energy")
                                                        ];
                                                        $message = $hp > 0 ? "[ $skill->name ] Bạn đã được hồi $hp HP" : "[ $skill->name ] Bạn đã đầy máu không thể hồi thêm";
                                                    }
                                                    else
                                                    {
                                                        $yourUpdate = [
                                                            'turn' => 0,
                                                            'user_challenge_energy' => DB::raw("user_challenge_energy - $skill->energy")
                                                        ];
                                                        $message = "[ $skill->name ] Bạn đã được hồi 0 HP";
                                                    }
                                                    $effectTo = 1;
                                                break;
                                                default:
                                                    $destroy = 0;
                                                    $message = "[ $skill->name ] Bạn đã gây 0 sát thương cho đối thủ";
                                                break;
                                            }
                                            if($randomRate <= (Auth::user()->power()['lucky']/$allLucky) * 100)
                                            {
                                                if($effectTo == 0)
                                                {
                                                    $destroy *= 1.5;
                                                    $message = "[ $skill->name ] Bạn đã gây $destroy sát thương chí mạng cho đối thủ ( x1.5 )";
                                                }
                                            }
                                            /* Enemy passive skill */
                                            foreach($getEnemyInfor->usingSkills() as $key => $enemyPassiveSkill)
                                            {
                                                if($enemyPassiveSkill->passive == 1)
                                                {
                                                    switch($enemyPassiveSkill->type)
                                                    {
                                                        case 'armor_strength':
                                                            if($skill->type == 'strength')
                                                            {
                                                                $destroy = $this->renderPassive($destroy,$enemyPassiveSkill) < 0 ? 0 : $this->renderPassive($destroy,$enemyPassiveSkill);
                                                                $message = "[ $skill->name ] Đối thủ có kĩ năng bị động giảm sát thương vật lí ! Sát thương của bạn gây ra chỉ còn lại $destroy";
                                                            }
                                                        break;
                                                        case 'armor_intelligent':
                                                            if($skill->type == 'intelligent')
                                                            {
                                                                $destroy = $this->renderPassive($destroy,$enemyPassiveSkill) < 0 ? 0 : $this->renderPassive($destroy,$enemyPassiveSkill);
                                                                $message = "[ $skill->name ] Đối thủ có kĩ năng bị động giảm sát thương phép thuật ! Sát thương của bạn gây ra chỉ còn lại $destroy";
                                                            }
                                                        break;
                                                    }
                                                }
                                            }
                                            if($enemy->first()->user_challenge_hp - $destroy <= 0 || $enemy->first()->user_challenge_hp <= 0)
                                            {
                                                $exp = 250;
                                                $coins = 2000;
                                                $pvpPoints = 50;

                                                $youWin = Auth::user();

                                                $youWin->increment('exp',$exp);
                                                $youWin->increment('income_coins',$coins);
                                                $youWin->increment('pvp_points',$pvpPoints);

                                                if(isset($youWin))
                                                {
                                                    $this->pvpRestart($room->id,true);
                                                    $response = [
                                                        'code' => 201,
                                                        'win' => true,
                                                        'status' => 'success',
                                                        'message' => "Thắng ! Bạn nhận được $exp EXP,$coins Vàng, $pvpPoints Điểm hạng",
                                                    ];
                                                }
                                            }
                                            else
                                            {
                                                $enemyUpdate = [
                                                    'user_challenge_hp' => DB::raw("user_challenge_hp - $destroy"),
                                                    'turn' => 1
                                                ];
                                                if($findMatch->update($yourUpdate) && $enemy->update($enemyUpdate))
                                                {
                                                    $data = [
                                                        'room' => [
                                                            'name' => $room->name,
                                                            'id' => $room->id
                                                        ],
                                                        'enemy' => [
                                                            'name' => User::findOrFail($enemy->first()->user_challenge)->name,
                                                            'id' => $enemy->first()->user_challenge
                                                        ],
                                                        'data' => [
                                                            'message' => $effectTo == 0 ? "Đối thủ đã gây cho bạn $destroy sát thương" : 'Đối thủ dùng kĩ năng buff',
                                                            'effectTo' => $effectTo, 
                                                            'skillAnimation' => $skill->animation
                                                        ],
                                                        'broadcast-to' => $enemy->first()->user_challenge
                                                    ];
                                                    event(new PvPHitEnemy($data));
                                                    $response = [
                                                        'code' => 200,
                                                        'status' => 'success',
                                                        'message' => $message ?? "[ $skill->name ] Không biết",
                                                        'enemy' => [
                                                            'basic' => $userApi->userInfor($enemy->first()->user_challenge),
                                                            'hp' => $enemy->first()->user_challenge_hp,
                                                            'energy' => $enemy->first()->user_challenge_energy,
                                                        ],
                                                        'you' => [
                                                            'basic' => $userApi->userInfor(Auth::id()),
                                                            'hp' => $findMatch->first()->user_challenge_hp,
                                                            'energy' => $findMatch->first()->user_challenge_energy,
                                                            'turn' => 0,
                                                        ],
                                                    ];
                                                }
                                                else
                                                {
                                                    $response = [
                                                        'code' => 404,
                                                        'status' => 'error',
                                                        'message' => 'Đã có lỗi xảy ra xin vui lòng thử lại'
                                                    ];
                                                }
                                            }
                                        }
                                        else
                                        {
                                            $findMatch->update([
                                                'turn' => 0,
                                                'user_challenge_energy' => DB::raw("user_challenge_energy - $skill->energy")
                                            ]);
                                            $enemy->update([
                                                'turn' => 1
                                            ]);
                                            $response = [
                                                'code' => 200,
                                                'status' => 'success',
                                                'message' => "[ $skill->name ] Sử dụng kĩ năng thất bại",
                                                'enemy' => [
                                                    'basic' => $userApi->userInfor($enemy->first()->user_challenge),
                                                    'hp' => $enemy->first()->user_challenge_hp,
                                                    'energy' => $enemy->first()->user_challenge_energy,
                                                ],
                                                'you' => [
                                                    'basic' => $userApi->userInfor(Auth::id()),
                                                    'hp' => $findMatch->first()->user_challenge_hp,
                                                    'energy' => $findMatch->first()->user_challenge_energy,
                                                    'turn' => 0,
                                                ],
                                            ];
                                        }
                                    }
                                    else
                                    {
                                        $response = [
                                            'code' => 404,
                                            'status' => 'warning',
                                            'message' => 'Bạn không đủ MP để sử dụng kĩ năng này'
                                        ];
                                    }
                                }
                                else
                                {
                                    $response = [
                                        'code' => 404,
                                        'status' => 'warning',
                                        'message' => 'Bạn không thể sử dụng kĩ năng bị động'
                                    ];
                                }
                            }
                            else
                            {
                                $response = [
                                    'code' => 404,
                                    'status' => 'error',
                                    'message' => 'Không tìm thấy kĩ năng này'
                                ];
                            }
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
            }
            else
            {
                $response = [
                    'code' => 404,
                    'status' => 'error',
                    'message' => 'Không tìm thấy phòng này'
                ];
            }
            return response()->json($response,200);
        }
    }
    public function renderDestroy($power,$skill)
    {
        switch($skill->power_type)
        {
            case 0:
                return $power + $skill->power_value;
            break;
            case 1:
                return $power + (($power * $skill->power_value)/100);
            break;
            default:
                return 0;
            break;
        }
    }
    public function renderPassive($destroy,$skill)
    {
        $randomEnemyPassiveRate = rand(0,100);
        if($randomEnemyPassiveRate <= $skill->success_rate)
        {
            switch($skill->power_type)
            {
                case 0:
                    return $destroy - $skill->power_value;
                break;
                case 1:
                    return $destroy - ($destroy * $skill->power_value)/100;
                break;
                default:
                    return $destroy;
                break;
            }
        }
        else
        {
            return $destroy;
        }
    }
}
