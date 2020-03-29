<?php

namespace App\Http\Controllers\Api\PvP;

use Carbon\Carbon;
use App\Model\Room;
use App\Model\User;
use App\Model\Skill;
use App\Model\FightRoom;
use App\Model\UserSkill;
use App\Events\PvPHitEnemy;
use App\Model\FightRoomLog;
use App\Constants\SkillType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\IndexController;
use App\Http\Controllers\Api\PvP\BaseController;

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
                                $noCountDown = false;
                                $checkCountDown = $findMatch->first()->countdown_skill[$request->skill];
                                if(isset($checkCountDown) && $checkCountDown == 0)
                                {
                                    $skill = Skill::findOrFail($checkSkill->skill_id);
                                    if($skill->passive == 0)
                                    {
                                        if($findMatch->first()->user_challenge_energy >= $skill->energy)
                                        {
                                            $checkCountDown = Skill::findOrFail($checkSkill->skill_id)->countdown;
                                            $findMatch->update([
                                                "countdown_skill->{$request->skill}" => $checkCountDown
                                            ]);
                                            
                                            /* Enemy buff */
                                            $enemyBuffStatus = [
                                                'agility' => 0,
                                                'lucky' => 0,
                                                'armor_strength' => 0,
                                                'armor_intelligent' => 0
                                            ];
                                            $enemyBuffs = $enemy->first()->buff;
                                            if(isset($enemyBuffs))
                                            {
                                                foreach($enemyBuffs as $key => $enemyBuff)
                                                {
                                                    if($enemyBuff > 0)
                                                    {
                                                        switch($key)
                                                        {
                                                            case SkillType::INCREAGILITY:
                                                                $enemyBuffStatus['agility'] += $enemyBuffs[$key."-value"];
                                                                $enemyBuffs[$key] = --$enemyBuff;
                                                            break;
                                                        }
                                                    }
                                                }
                                                $enemy->update([
                                                    'buff' => json_encode($enemyBuffs)
                                                ]);
                                            }

                                            $randomRate = rand(0,100);
                                            $getEnemyInfor = User::findOrFail($enemy->first()->user_challenge);

                                            $allAgility = Auth::user()->power()['agility'] + $getEnemyInfor->power()['agility'] + $enemyBuffStatus['agility'];
                                            $allLucky = Auth::user()->power()['lucky'] + $getEnemyInfor->power()['lucky'] + $enemyBuffStatus['lucky'];

                                            if($randomRate <= $skill->success_rate && $randomRate <= (Auth::user()->power()['agility']/$allAgility) * 100)
                                            {
                                                /* Your skill */
                                                $destroy = 0;
                                                $effectTo = 0; 
                                                $yourUpdate = [
                                                    'turn' => 0,
                                                    'user_challenge_energy' => DB::raw("user_challenge_energy - $skill->energy")
                                                ];
                                                $yourTurn = 0;
                                                $yourBuff = $findMatch->first()->buff ?? [];

                                                $enemyTurn = 1;
                                                $enemyUpdate = [];
                                                $enemyEffected = $enemy->first()->effected ?? [];

                                                switch($skill->type)
                                                {
                                                    case SkillType::ATTACK_STRENGTH:
                                                        $yourStrength = Auth::user()->power()['strength'];
                                                        $countDamage = $this->renderDestroy($yourStrength,$skill);
                                                        $enemyStrengthArmor = $getEnemyInfor->power()['armor_strength'];
                                                        $destroy = $this->calculateDamage($countDamage, $enemyStrengthArmor) - $enemyBuffStatus['armor_strength'];
                                                        $messageToMe = "[ $skill->name ] Bạn đã gây $destroy sát thương vật lí cho đối thủ";
                                                        $messageToEnemy = "[ $skill->name ] Đối thủ đã gây $destroy sát thương vật lí cho bạn";
                                                    break;
                                                    case SkillType::ATTACK_INTELLIGENT:
                                                        $yourStrength = Auth::user()->power()['intelligent'];
                                                        $countDamage = $this->renderDestroy($yourStrength,$skill);
                                                        $enemyStrengthArmor = $getEnemyInfor->power()['armor_intelligent'];
                                                        $destroy = $this->calculateDamage($countDamage, $enemyStrengthArmor) - $enemyBuffStatus['armor_intelligent'];
                                                        $messageToMe = "[ $skill->name ] Bạn đã gây $destroy sát thương phép thuật cho đối thủ";
                                                        $messageToEnemy = "[ $skill->name ] Đối thủ đã gây $destroy sát thương phép thuật cho bạn";
                                                    break;
                                                    case SkillType::ATTACK_CRIT:
                                                        $destroy = ($this->renderDestroy(Auth::user()->power()['strength'],$skill) * 2);
                                                        $messageToMe = "[ $skill->name ] Bạn đã gây $destroy sát thương chí mạng cho đối thủ";
                                                        $messageToEnemy = "[ $skill->name ] Đối thủ đã gây $destroy sát thương chí mạng cho bạn";
                                                    break;
                                                    case SkillType::ATTACK_HALF_HP:
                                                        $destroy = (int)$enemy->first()->user_challenge_hp/2;
                                                        $messageToMe = "[ $skill->name ] Bạn đã gây $destroy sát thương tinh thần cho đối thủ";
                                                        $messageToEnemy = "[ $skill->name ] Đối thủ đã gây $destroy sát thương tinh thần cho bạn";
                                                    break;
                                                    case SkillType::HEALTH_HP:
                                                        if($skill->power_type == $this->parameter)
                                                        {
                                                            $hp = (int)($findMatch->first()->user_challenge_hp + $skill->power_value) < Auth::user()->power()['health_points'] ? $skill->power_value : (int)(Auth::user()->power()['health_points'] - $findMatch->first()->user_challenge_hp);
                                                            $yourUpdate = [
                                                                'turn' => 0,
                                                                'user_challenge_hp' => DB::raw("user_challenge_hp + $hp"),
                                                                'user_challenge_energy' => DB::raw("user_challenge_energy - $skill->energy")
                                                            ];
                                                            $messageToMe = $hp > 0 ? "[ $skill->name ] Bạn đã được hồi $hp HP" : "[ $skill->name ] Bạn đã đầy máu không thể hồi thêm";
                                                            $messageToEnemy = $hp > 0 ? "[ $skill->name ] Đối thủ đã được hồi $hp HP" : "[ $skill->name ] Đối thủ đã đầy máu không thể hồi thêm";
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
                                                            $messageToMe = $hp > 0 ? "[ $skill->name ] Bạn đã được hồi $hp HP" : "[ $skill->name ] Bạn đã đầy máu không thể hồi thêm";
                                                            $messageToEnemy = $hp > 0 ? "[ $skill->name ] Đối thủ đã được hồi $hp HP" : "[ $skill->name ] Đối thủ đã đầy máu không thể hồi thêm";
                                                        }
                                                        else
                                                        {
                                                            $yourUpdate = [
                                                                'turn' => 0,
                                                                'user_challenge_energy' => DB::raw("user_challenge_energy - $skill->energy")
                                                            ];
                                                            $messageToMe = "[ $skill->name ] Bạn đã được hồi 0 HP";
                                                            $messageToEnemy = "[ $skill->name ] Đối thủ đã được hồi 0 HP";
                                                        }
                                                        $effectTo = 1;
                                                    break;
                                                    case SkillType::STUN:
                                                        $yourStrength = Auth::user()->power()['strength'];
                                                        $countDamage = $this->renderDestroy($yourStrength,$skill);
                                                        $enemyStrengthArmor = $getEnemyInfor->power()['armor_strength'];
                                                        $destroy = $this->calculateDamage($countDamage, $enemyStrengthArmor) - $enemyBuffStatus['armor_strength'];
                                                        $rate = rand(0,100);
                                                        if($skill->effect_rate >= $rate)
                                                        {
                                                            $yourUpdate['turn'] = 1;
                                                            $yourTurn = 1;
                                                            $enemyTurn = 0;
                                                            $enemyEffected[$skill->type] = $skill->effect_turn;
                                                            $messageToMe = "[ $skill->name ] Bạn đã gây $destroy sát thương cho đối thủ, đối thụ dính hiệu ứng choáng trong $skill->effect_turn lượt";
                                                            $messageToEnemy = "[ $skill->name ] Đối thủ đã gây $destroy sát thương cho bạn, bạn bị dính hiệu ứng choáng trong $skill->effect_turn lượt";
                                                        }
                                                        else
                                                        {
                                                            $messageToMe = "[ $skill->name ] Bạn đã gây $destroy sát thương cho đối thủ";
                                                            $messageToEnemy = "[ $skill->name ] Đối thủ đã gây $destroy sát thương cho bạn";
                                                        }
                                                    break;
                                                    case SkillType::FREEZE:
                                                        $yourStrength = Auth::user()->power()['intelligent'];
                                                        $countDamage = $this->renderDestroy($yourStrength,$skill);
                                                        $enemyStrengthArmor = $getEnemyInfor->power()['armor_intelligent'];
                                                        $destroy = $this->calculateDamage($countDamage, $enemyStrengthArmor) - $enemyBuffStatus['armor_intelligent'];
                                                        $rate = rand(0,100);
                                                        if($skill->effect_rate >= $rate)
                                                        {
                                                            $yourUpdate['turn'] = 1;
                                                            $yourTurn = 1;
                                                            $enemyTurn = 0;
                                                            $enemyEffected[$skill->type] = $skill->effect_turn;
                                                            $messageToMe = "[ $skill->name ] Bạn đã gây $destroy sát thương cho đối thủ, đối thụ dính hiệu ứng đóng băng trong $skill->effect_turn lượt";
                                                            $messageToEnemy = "[ $skill->name ] Đối thủ đã gây $destroy sát thương cho bạn, bạn bị thụ dính hiệu ứng đóng băng trong $skill->effect_turn lượt";
                                                        }
                                                        else
                                                        {
                                                            $messageToMe = "[ $skill->name ] Bạn đã gây $destroy sát thương cho đối thủ";
                                                            $messageToEnemy = "[ $skill->name ] Đối thủ đã gây $destroy sát thương cho bạn";
                                                        }
                                                    break;
                                                    case SkillType::INCREAGILITY:
                                                        $yourStrength = Auth::user()->power()['strength'];
                                                        $countDamage = $this->renderDestroy($yourStrength,$skill);
                                                        $enemyStrengthArmor = $getEnemyInfor->power()['armor_strength'];
                                                        $destroy = $this->calculateDamage($countDamage, $enemyStrengthArmor) - $enemyBuffStatus['armor_strength'];
                                                        $rate = rand(0,100);
                                                        if($skill->effect_rate >= $rate)
                                                        {
                                                            $yourBuff[$skill->type] = $skill->effect_turn;
                                                            $yourBuff[$skill->type."-type"] = $skill->effect_value['type'];
                                                            $yourBuff[$skill->type."-value"] = $skill->effect_value['value'];
                                                            $yourUpdate['buff'] = json_encode($yourBuff);
                                                            $effectType = $skill->effect_value['type'] == 1 ? '%' : '';
                                                            $messageToMe = "[ $skill->name ] Bạn đã gây $destroy sát thương cho đối thủ, Hiệu ứng kích hoạt - Bạn được tăng {$skill->effect_value['value']}{$effectType} nhanh nhẹn trong {$skill->effect_turn} lượt";
                                                            $messageToEnemy = "[ $skill->name ] Đối thủ đã gây $destroy sát thương cho bạn, Hiệu ứng kích hoạt - Đối thủ được tăng {$skill->effect_value['value']}{$effectType} nhanh nhẹn trong {$skill->effect_turn} lượt";
                                                        }
                                                        else
                                                        {
                                                            $messageToMe = "[ $skill->name ] Bạn đã gây $destroy sát thương cho đối thủ";
                                                            $messageToEnemy = "[ $skill->name ] Đối thủ đã gây $destroy sát thương cho bạn";
                                                        }
                                                    break;
                                                    default:
                                                        $destroy = 0;
                                                    break;
                                                }
                                                if($randomRate <= (Auth::user()->power()['lucky']/$allLucky) * 100)
                                                {
                                                    if($effectTo == 0)
                                                    {
                                                        $destroy *= 1.5;
                                                        $messageToMe .= " - Hiệu ứng chí mạng kích hoạt tổng sát thương $destroy ";
                                                        $messageToEnemy .= " - Hiệu ứng chí mạng kích hoạt tổng sát thương $destroy ";
                                                    }
                                                }
                                                /* Enemy passive skill */
                                                foreach($getEnemyInfor->usingSkills() as $key => $enemyPassiveSkill)
                                                {
                                                    if($enemyPassiveSkill->passive == 1 && $enemyPassiveSkill->success_rate >= $randomRate)
                                                    {
                                                        switch($enemyPassiveSkill->type)
                                                        {
                                                            case SkillType::ARMOR_STRENGTH:
                                                                if($skill->type == 'strength')
                                                                {
                                                                    $destroy = $this->renderPassive($destroy,$enemyPassiveSkill) < 0 ? 0 : $this->renderPassive($destroy,$enemyPassiveSkill);
                                                                    $messageToMe .= " - Đối thủ có kĩ năng bị động giảm sát thương vật lí ! Sát thương của bạn gây ra chỉ còn lại $destroy";
                                                                    $messageToEnemy .= " - Bạn có kĩ năng bị động giảm sát thương vật lí ! Sát thương nhận được chỉ còn lại $destroy";
                                                                }
                                                            break;
                                                            case SkillType::ARMOR_INTELLIGENT:
                                                                if($skill->type == 'intelligent')
                                                                {
                                                                    $destroy = $this->renderPassive($destroy,$enemyPassiveSkill) < 0 ? 0 : $this->renderPassive($destroy,$enemyPassiveSkill);
                                                                    $messageToMe .= " - Đối thủ có kĩ năng bị động giảm sát thương phép thuật ! Sát thương của bạn gây ra chỉ còn lại $destroy";
                                                                    $messageToMe .= " - Bạn có kĩ năng bị động giảm sát thương phép thuật ! Sát thương nhận được chỉ còn lại $destroy";
                                                                }
                                                            break;
                                                        }
                                                    }
                                                }
                                                if($enemy->first()->user_challenge_hp - $destroy <= 0 || $enemy->first()->user_challenge_hp <= 0)
                                                {
                                                    $rewards = [
                                                        'exp' => 100,
                                                        'coins' => 1000,
                                                        'pvp_points' => 5
                                                    ];

                                                    DB::transaction(function () use ($enemy, $room, $rewards){
                                                        $youWin = Auth::user();
                                                        $enemyLose = User::findOrFail($enemy->first()->user_challenge);
        
                                                        $youWin->increment('exp',$rewards['exp']);
                                                        $youWin->increment('income_coins',$rewards['coins']);
                                                        $youWin->increment('pvp_points',$rewards['pvp_points']);
        
                                                        $enemyLose->decrement('income_coins',$rewards['coins']);
                                                        $enemyLose->decrement('pvp_points',$rewards['pvp_points']);
        
                                                        FightRoomLog::create([
                                                            'user_win_id' => Auth::id(),
                                                            'user_lose_id' => $enemy->first()->user_challenge
                                                        ]);
        
                                                        if(isset($youWin))
                                                        {
                                                            $this->pvpRestart($room->id,true);
                                                        }
                                                    });
                                                    $response = [
                                                        'code' => 201,
                                                        'win' => true,
                                                        'status' => 'success',
                                                        'message' => "Thắng ! Bạn nhận được {$rewards['exp']} EXP,{$rewards['coins']} Vàng, {$rewards['pvp_points']} Điểm hạng",
                                                    ];
                                                }
                                                else
                                                {
                                                    $enemyUpdate = [
                                                        'user_challenge_hp' => DB::raw("user_challenge_hp - $destroy"),
                                                        'turn' => $enemyTurn,
                                                        'effected' => json_encode($enemyEffected)
                                                    ];
                                                    if($findMatch->update($yourUpdate) && $enemy->update($enemyUpdate))
                                                    {
                                                        $data = [
                                                            'hit' => true,
                                                            'room' => [
                                                                'name' => $room->name,
                                                                'id' => $room->id
                                                            ],
                                                            'enemy' => [
                                                                'name' => User::findOrFail($enemy->first()->user_challenge)->name,
                                                                'id' => $enemy->first()->user_challenge
                                                            ],
                                                            'data' => [
                                                                'message' => $effectTo == 0 ? $messageToEnemy : 'Đối thủ dùng kĩ năng lên bản thân',
                                                                'effectTo' => $effectTo, 
                                                                'skillAnimation' => $skill->animation,
                                                                'damage' => $destroy,
                                                                'effected' => $enemy->first()->effected,
                                                                'buff' => $enemy->first()->buff
                                                            ],
                                                            'broadcast-to' => $enemy->first()->user_challenge
                                                        ];
                                                        $response = [
                                                            'code' => 200,
                                                            'status' => 'success',
                                                            'message' => $messageToMe ?? "[ $skill->name ] Không biết",
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
                                                                'hp' => $findMatch->first()->user_challenge_hp,
                                                                'energy' => $findMatch->first()->user_challenge_energy,
                                                                'turn' => $yourTurn,
                                                                'damage' => $destroy,
                                                                'effected' => $findMatch->first()->effected,
                                                                'buff' => $findMatch->first()->buff,
                                                                'countdown' => $findMatch->first()->countdown_skill
                                                            ],
                                                            'data' => $data
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
                                                $data = [
                                                    'hit' => false,
                                                    'room' => [
                                                        'name' => $room->name,
                                                        'id' => $room->id
                                                    ],
                                                    'data' => [
                                                        'message' => "[ $skill->name ] Đối thủ sử dụng kĩ năng thất bại",
                                                    ],
                                                    'enemy' => [
                                                        'name' => User::findOrFail($enemy->first()->user_challenge)->name,
                                                        'id' => $enemy->first()->user_challenge
                                                    ],
                                                    'broadcast-to' => $enemy->first()->user_challenge
                                                ];
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
                                                        'effected' => $enemy->first()->effected,
                                                        'buff' => $enemy->first()->buff,
                                                        'countdown' => $enemy->first()->countdown_skill,
                                                        'buff_status' => $enemyBuffStatus
                                                    ],
                                                    'you' => [
                                                        'basic' => $userApi->userInfor(Auth::id()),
                                                        'hp' => $findMatch->first()->user_challenge_hp,
                                                        'energy' => $findMatch->first()->user_challenge_energy,
                                                        'turn' => 0,
                                                        'damage' => 0,
                                                        'effected' => $findMatch->first()->effected,
                                                        'buff' => $findMatch->first()->buff,
                                                        'countdown' => $findMatch->first()->countdown_skill,
                                                    ],
                                                    'data' => $data
                                                ];
                                            }
                                        }
                                        else
                                        {
                                            $response = [
                                                'code' => 202,
                                                'status' => 'warning',
                                                'message' => 'Bạn không đủ MP để sử dụng kĩ năng này'
                                            ];
                                        }
                                    }
                                    else
                                    {
                                        $response = [
                                            'code' => 202,
                                            'status' => 'warning',
                                            'message' => 'Bạn không thể sử dụng kĩ năng bị động'
                                        ];
                                    }
                                }
                                else
                                {
                                    $response = [
                                        'code' => 202,
                                        'status' => 'error',
                                        'message' => 'Vui lòng đợi hồi chiêu'
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

    public function calculateDamage($effect1, $effect2)
    {
        return $effect1 - $effect2 <= 0 ? 0 : $effect1 - $effect2;
    }
}
