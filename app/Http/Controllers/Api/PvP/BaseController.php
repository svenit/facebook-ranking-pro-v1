<?php

namespace App\Http\Controllers\Api\PvP;

use App\Model\Room;
use App\Model\User;
use App\Model\Config;
use App\Model\FightRoom;
use App\Events\PvPExitMatch;
use App\Events\PvPKickEnemy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    protected $limitTimeStatus;
    protected $limitTime;
    protected $energyRecovery;
    protected $gameOver = [1,2];
    protected $parameter = 0;
    protected $percent = 1;
    protected $wasteEnergy = 5;

    public function __construct(Config $config)
    {
        $this->limitTimeStatus = $config->first()->limit_pvp_time_status == 1 ? true : false;
        $this->limitTime = $config->first()->limit_pvp_time ?? 0;
        $this->energyRecovery = 20;
    }
    public function exitMatch(Request $request)
    {
        $room = Room::where([['name',$request->room],['is_fighting',0]])->first();
        if(isset($room))
        {
            $countUser = FightRoom::where('room_id',$room->id)->count();
            if($room->people == 1 && $countUser == 1)
            {
                $deleteRoom = Room::findOrFail($room->id)->delete();
                if(isset($deleteRoom))
                {
                    $this->removeTracking();
                    $response = [
                        'code' => 200,
                        'msg' => 'Đã thoát',
                        'redirect' => ''
                    ];
                    return response()->json($response,200);
                }
            }
            else
            {
                $target = FightRoom::where([['user_challenge','!=',Auth::id()],['room_id',$room->id]])->first();
                if($room->user_create_id == Auth::id() && $countUser == 2)
                {
                    $updateMaster = Room::whereId($room->id)->update([
                        'user_create_id' => $target->user_challenge
                    ]);
                    $leaveRoom = FightRoom::where([['user_challenge',Auth::id()],['room_id',$room->id]])->first()->delete();
                    if(isset($leaveRoom,$target,$updateMaster))
                    {
                        $this->removeTracking();
                        $data = [
                            'room' => [
                                'name' => $room->name,
                                'id' => $room->id
                            ],
                            'data' => [
                                'message' => 'Đối thủ đã rời, bạn trở thành chủ phòng'
                            ],
                            'broadcast_to' => $target->user_challenge,
                            'is_master' => 1
                        ];
                        event(new PvPExitMatch($data));
                        $response = [
                            'code' => 200,
                            'msg' => 'Đã thoát',
                            'redirect' => ''
                        ];
                        return response()->json($response,200);
                    }
                }
                else
                {
                    $leaveRoom = FightRoom::where([['user_challenge',Auth::id()],['room_id',$room->id]])->first()->delete();
                    if(isset($leaveRoom))
                    {
                        $this->removeTracking();
                        $data = [
                            'room' => [
                                'name' => $room->name,
                                'id' => $room->id
                            ],
                            'data' => [
                                'message' => 'Đối thủ đã rời phòng'
                            ],
                            'broadcast_to' => $target->user_challenge,
                            'is_master' => 0
                        ];
                        event(new PvPExitMatch($data));
                        $response = [
                            'code' => 200,
                            'msg' => 'Đã thoát',
                            'redirect' => ''
                        ];
                        return response()->json($response,200);
                    }
                }
            }
        }
    }
    public function toggleReady(Request $request)
    {
        $room = Room::where([['name',$request->room],['people',2],['is_fighting',0]])->first();
        if(isset($room))
        {
            if(Auth::user()->energy >=  $this->wasteEnergy && Auth::user()->pvp_times > 0)
            {
                $toggleReady = FightRoom::where([['room_id',$room->id],['user_challenge',Auth::id()],['user_receive_challenge',null]])->update([
                    'is_ready' => $request->status == 1 ? 1 : 0,
                    'status' => null,
                    'turn' => 0
                ]);
                if(isset($toggleReady))
                {
                    return response()->json([
                        'status' => 'success',
                        'code' => 200,
                        'message' => $request->status == 1 ? 'Sẵn sàng' : 'Đã hủy'
                    ],200);
                }
                else
                {
                    return response()->json([
                        'status' => 'error',
                        'code' => 404,
                        'message' => 'Đã có lỗi xảy ra'
                    ],201);
                }
            }
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'Bạn không đủ sức khỏe hoặc lượt tham gia PVP'
            ],201);
        }
        else
        {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'Không tìm thấy phòng'
            ],201);
        }
    }
    public function pvpRestart($id,$win = null)
    {
        $enemy = FightRoom::where([['room_id',$id],['user_challenge','!=',Auth::id()]])->first();
        Room::whereId($id)->update([
            'is_fighting' => 0
        ]);
        FightRoom::where([['user_challenge',Auth::id()],['room_id',$id]])->update([
            'user_challenge_hp' => Auth::user()->power()['health_points'],
            'user_challenge_energy' => Auth::user()->character->default_energy,
            'turn' => 0,
            'user_receive_challenge' => null,
            'status' => $win ? 2 : null,
            'is_ready' => 0,
            'effected' => null
        ]);
        FightRoom::where([['user_challenge',$enemy->user_challenge],['room_id',$id]])->update([
            'user_challenge_hp' => User::findOrFail($enemy->user_challenge)->power()['health_points'],
            'user_challenge_energy' => User::findOrFail($enemy->user_challenge)->character->default_energy,
            'turn' => 0,
            'user_receive_challenge' => null,
            'status' => $win ? 1 : null,
            'is_ready' => 0,
            'effected' => null
        ]);
    }

    public function kickEnemy(Request $request)
    {
        $room = Room::where([['user_create_id',Auth::id()],['name', $request->room],['people',2],['is_fighting',0]]);
        if($room->exists())
        {
            $enemy = FightRoom::where([['room_id',$room->first()->id],['user_challenge','!=',Auth::id()]])->first();
            $data = [
                'room' => $room->first()->name,
                'broadcast-to' => $enemy->user_challenge
            ];
            $enemy->delete();
            event(new PvPKickEnemy($data));
            return response()->json([
                'status' => 'success',
                'code' => 200,
                'message' => 'Đã kick'
            ],200);
        }
        else
        {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'Không thể thực hiện hành động này'
            ],200);
        }
    }
}
