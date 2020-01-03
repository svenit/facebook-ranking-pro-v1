<?php

namespace App\Http\Controllers\User\RecoveryRoom;

use App\Model\RecoveryRoom;
use Illuminate\Http\Request;
use App\Model\UserRecoveryRoom;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RecoveryRoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('prevent')->only('join');
    }
    public function index()
    {
        $recoveries =  RecoveryRoom::all();
        $isJoined = Auth::user()->recoveryRoom->first();
        return view('user.recovery-room.index',compact('recoveries','isJoined'));
    }
    public function receive($id)
    {
        $room = RecoveryRoom::findOrFail($id);
        $userRoom = UserRecoveryRoom::where([['user_id',Auth::id()],['recovery_room_id',$room->id]]);
        if(isset($userRoom))
        {
            if(now() >= $userRoom->first()->end_at)
            {
                $receive = DB::statement($this->replaceStatement($room->query));
                if($receive)
                {
                    $userRoom->delete();
                    $this->removeTracking();
                    return redirect()->route('user.explore.recovery-room.index')->with([
                        'message' => 'Nhận phần thưởng thành công',
                        'status' => 'success'
                    ]);
                }
                else
                {
                    return redirect()->route('user.explore.recovery-room.index')->with([
                        'message' => 'Đã có lỗi xảy ra',
                        'status' => 'error'
                    ]);
                }
            }
            else
            {
                return redirect()->route('user.explore.recovery-room.index')->with([
                    'message' => 'Chưa đủ thời gian hồi phục không thể nhận',
                    'status' => 'error'
                ]);
            }
        }
        else
        {
            return redirect()->route('user.explore.recovery-room.index')->with([
                'message' => 'Không tìm thấy phòng này',
                'status' => 'error'
            ]);
        }
    }
    public function join($id)
    {
        $room = RecoveryRoom::findOrFail($id);
        $session = UserRecoveryRoom::where([['user_id',Auth::id()],['recovery_room_id',$room->id]])->first();
        if(isset($session))
        {
            return redirect()->route('user.explore.recovery-room.index');
        }
        else
        {
            Auth::user()->recoveryRoom()->attach($room->id,[
                'end_at' => now()->addMinutes($room->minutes)
            ]);
            $this->tracking(0);
            return redirect()->route('user.explore.recovery-room.index')->with([
                'message' => 'OK',
                'status' => 'success'
            ]);
        }
    }
    public function cancle($id)
    {
        $room = RecoveryRoom::findOrFail($id);
        $check = UserRecoveryRoom::where([['user_id',Auth::id()],['recovery_room_id',$room->id]]);
        if($check)
        {
            $check->delete();
            $this->removeTracking();
            return redirect()->route('user.explore.recovery-room.index')->with([
                'message' => 'Đã hủy',
                'status' => 'success'
            ]);
        }
        else
        {
            return redirect()->route('user.explore.recovery-room.index')->with([
                'message' => 'Đã có lỗi xảy ra',
                'status' => 'error'
            ]);
        }
    }
}

