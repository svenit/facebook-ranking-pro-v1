<?php

namespace App\Http\Controllers\User\PVP;

use App\Model\Room;
use App\Model\Tracking;
use App\Model\FightRoom;
use Illuminate\Http\Request;
use App\Events\PvPJoinedRoom;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as RouteName;

class PvPController extends Controller
{
    public function __construct()
    {
        $this->middleware('prevent');
    }
    public function index()
    {
        return view('user.pvp.index');
    }
    public function createRoom(Request $request)
    {
        $this->validate($request,[
            'g-recaptcha-response' => 'required|recaptcha'
        ],[
            'g-recaptcha-response.required' => 'Bạn chưa xác nhập recaptcha',
            'g-recaptcha-response.recaptcha' => 'Captcha không hợp lệ'
        ]);
        if($this->config()->open_pvp == 1)
        {
            if(Auth::user()->pvp_times >= 1)
            {
                $checkRoom = Room::whereUserCreateId(Auth::id())->first();
                $checkFightRoom = FightRoom::whereUserChallenge(Auth::id())->first();
                if(empty($checkRoom) && empty($checkFightRoom))
                {
                    $room = new Room();
                    $room->user_create_id = Auth::id();
                    $room->name = uniqid().time();
                    $room->people = 0;
                    $room->save();

                    $fightRoom = new FightRoom();
                    $fightRoom->room_id = $room->id;
                    $fightRoom->user_challenge = Auth::id();
                    $fightRoom->user_challenge_hp = Auth::user()->power()['health_points'];
                    $fightRoom->user_challenge_energy = Auth::user()->character->default_energy;
                    $fightRoom->save();

                    if(isset($room,$fightRoom))
                    {
                        return redirect()->route('user.pvp.room',['id' => $room->name])->with([
                            'message' => 'Tạo phòng thành công',
                            'status' => 'success'
                        ]);
                    }
                }
                else
                {
                    return back()->with([
                        'status' => 'error',
                        'message' => 'Bạn đang ở trong 1 trận chiến khác'
                    ]);
                }
            }
            else
            {
                return back()->with([
                    'status' => 'error',
                    'message' => 'Bạn đã hết vé tham gia PVP, xin vui lòng mua thêm vé để tiếp tục'
                ]);
            }
        }
        else
        {
            return back()->with([
                'status' => 'warning',
                'message' => 'PVP chưa mở, mời bạn quay lại sau'
            ]);
        }
    }
    public function joinedRoom($room)
    {
        session_write_close();
        set_time_limit(60);
        
        $checkRoom = Room::whereName($room)->first();
        if(isset($checkRoom))
        {
            $findEnemy = FightRoom::where([['room_id',$checkRoom->id],['user_challenge',$checkRoom->user_create_id],['user_receive_challenge',null]])->first();
            if(Auth::id() == $checkRoom->user_create_id)
            {
                return redirect()->route('user.pvp.room',['id' => $checkRoom->name]);
            }
            else
            {
                if(isset($findEnemy))
                {
                    $checkSession = FightRoom::where([['room_id',$checkRoom->id],['user_challenge',Auth::id()]])->first();
                    if(isset($checkSession))
                    {
                        return redirect()->route('user.pvp.room',['id' => $checkRoom->name]);
                    }
                    else
                    {
                        if($checkRoom->people == 1 && $checkRoom->is_fighting == 0)
                        {
                            $joinMatch = FightRoom::create([
                                'room_id' => $checkRoom->id,
                                'user_challenge' => Auth::id(),
                                'user_challenge_hp' => Auth::user()->power()['health_points'],
                                'user_challenge_energy' => Auth::user()->character->default_energy
                            ]);
                            if(isset($joinMatch))
                            {
                                $data = [
                                    'room' => [
                                        'name' => $room,
                                        'id' => $checkRoom->id
                                    ],
                                    'enemy' => [
                                        'name' => Auth::user()->name,
                                        'id' => Auth::id()
                                    ],
                                    'broadcast-to' => $findEnemy->user_challenge
                                ];
                                event(new PvPJoinedRoom($data));
                                return redirect()->route('user.pvp.room',['id' => $checkRoom->name]);
                            }
                        }
                        else
                        {
                            return redirect()->route('user.pvp.index')->with([
                                'status' => 'error',
                                'message' => 'Đã đủ số người hoặc đang diễn ra trận chiến'
                            ]);
                        }
                    }
                }
                else
                {
                    return redirect()->route('user.pvp.index')->with([
                        'status' => 'error',
                        'message' => 'Không tìm thấy đối thủ'
                    ]);
                }
            }
        }
        else
        {
            return redirect()->route('user.pvp.index')->with([
                'status' => 'warning',
                'message' => 'Bạn đã bị kick hoặc không tìm thấy phòng này :('
            ]);
        }
    }
    public function room($room)
    {
        $checkRoom = Room::whereName($room)->first();
        $tracking = Tracking::where([['route',RouteName::route()->getName()],['user_id',Auth::id()]])->first();
        if(isset($checkRoom))
        {
            $checkSession = FightRoom::where([['room_id',$checkRoom->id],['user_challenge',Auth::id()]])->first();
            if(isset($checkSession))
            {
                $this->tracking(true);
                $comments = [
                    'Bỏ tay ra bạn <p>eeiiii..</p>', 
                    'Đánh thế cũng <p>đánh</p>', 
                    'Đm ví tao đâu :(', 
                    'Mẹ ơi con <p>muốn về nhà :(</p>',
                    'Ê có chap <p>mới rồi anh e</p>',
                    'Anh ơi thằng <p>kia nhìn đểu</p>',
                    'Đánh tay không <p>tao xem nào</p>',
                ];
                return view('user.pvp.fight',compact('room','checkRoom','checkSession', 'comments'));
            }
            else
            {
                if(isset($tracking))
                {
                    $this->removeTracking();
                }
                return redirect()->route('user.index')->with([
                    'status' => 'warning',
                    'message' => 'Bạn đã bị kick hoặc không tìm thấy phòng này :('
                ]);
            }
        }
        else
        {
            if(isset($tracking))
            {
                $this->removeTracking();
            }
            return redirect()->route('user.index')->with([
                'status' => 'warning',
                'message' => 'Bạn đã bị kick hoặc không tìm thấy phòng này :('
            ]);
        }
    }
}
