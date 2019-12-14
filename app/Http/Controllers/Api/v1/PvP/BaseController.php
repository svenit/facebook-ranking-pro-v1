<?php

namespace App\Http\Controllers\Api\v1\PvP;

use App\Model\Room;
use App\Model\Config;
use App\Model\FightRoom;
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

    public function __construct(Config $config)
    {
        $this->limitTimeStatus = $config->first()->limit_pvp_time_status == 1 ? true : false;
        $this->limitTime = $config->first()->limit_pvp_time ?? 0;
        $this->energyRecovery = 20;
    }
    public function exitMatch()
    {
        $findMatch = FightRoom::where('user_challenge',Auth::id());
        if(isset($findMatch) && empty($findMatch->first()->user_receive_challenge) || collect($this->gameOver)->contains($findMatch->first()->status))
        {
            $findMatch->delete();
            $this->removeTracking();
            $response = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Thoát trận thành công'
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
        return response()->json($response,200);
    }
    public function toggleReady(Request $request)
    {
        $room = Room::where([['name',$request->room],['people',2],['is_fighting',0]])->first();
        if(isset($room))
        {
            $toggleReady = FightRoom::where([['room_id',$room->id],['user_challenge',Auth::id()],['user_receive_challenge',null]])->update([
                'is_ready' => $request->status == 1 ? 1 : 0,
                'status' => null
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
        else
        {
            return response()->json([
                'status' => 'error',
                'code' => 404,
                'message' => 'Không tìm thấy phòng'
            ],201);
        }
    }
}
