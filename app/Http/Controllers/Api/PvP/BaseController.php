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

    public function kickEnemy(Request $request)
    {
        $room = Room::where([['user_create_id',Auth::id()],['name', $request->room],['people',2],['is_fighting',0]]);
        if($room->exists())
        {
            $enemy = FightRoom::where([['room_id',$room->first()->id],['user_challenge','!=',Auth::id()]])->first();
            $enemy->delete();
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
