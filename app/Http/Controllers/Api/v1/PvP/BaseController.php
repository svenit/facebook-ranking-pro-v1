<?php

namespace App\Http\Controllers\Api\v1\PvP;

use App\Model\Config;
use App\Model\FightRoom;
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
}
