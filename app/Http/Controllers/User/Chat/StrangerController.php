<?php

namespace App\Http\Controllers\User\Chat;

use App\Events\ExitChatRoom;
use App\Events\JoinChatRoom;
use App\Model\ChatRoom;
use App\Model\Tracking;
use Illuminate\Http\Request;
use App\Model\ChatConversation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as RouteName;

class StrangerController extends Controller
{
    public function __invoke()
    {
        $findRoom = ChatRoom::where('people',1)->first();
        $checkRoom = ChatConversation::where('user_id',Auth::id())->first();
        if(empty($checkRoom))
        {
            if(isset($findRoom))
            {
                ChatConversation::create([
                    'user_id' => Auth::id(),
                    'room_id' => $findRoom->id
                ]);
                event(new JoinChatRoom($findRoom->name));
                return redirect()->route('user.chat.stranger.room',['name' => $findRoom->name]);
            }
            else
            {
                $createRoom = ChatRoom::create([
                    'name' => uniqid().time(),
                    'people' => 0
                ]);
                ChatConversation::create([
                    'user_id' => Auth::id(),
                    'room_id' => $createRoom->id
                ]);
                if(isset($createRoom))
                {
                    return redirect()->route('user.chat.stranger.room',['name' => $createRoom->name]);
                }
            }
        }
        else
        {
            return redirect()->route('user.index')->with([
                'status' => 'error',
                'message' => 'Bạn đang ở trong 1 phòng khác'
            ]);
        }
    }
    public function chatRoom($name)
    {
        $room = ChatRoom::where([['name',$name],['people','<=',2]])->first();
        $tracking = Tracking::where([['route',RouteName::route()->getName()],['user_id',Auth::id()]])->first();
        if(isset($room))
        {
            if(empty($tracking))
            {
                $this->tracking(1);
            }
            $checkSession = ChatConversation::where([['user_id',Auth::id()],['room_id',$room->id]])->first();
            if(isset($checkSession))
            {
                return view('user.chat.stranger',compact('room'));
            }
        }
        else
        {
            if(isset($tracking))
            {
                $this->removeTracking();
            }
            return redirect()->route('user.index')->with([
                'status' => 'error',
                'message' => 'Không tìm thấy phòng này'
            ]);
        }
    }
    public function exit()
    {
        $coversation = ChatConversation::where('user_id',Auth::id())->first();
        if($coversation)
        {
            $room = ChatRoom::where('id',$coversation->room_id);
            if(isset($room))
            {
                if($room->first()->people == 1)
                {
                    $room->delete();
                }
                else
                {
                    Auth::user()->chat()->detach($coversation->room_id);
                    $room->decrement('people');
                    event(new ExitChatRoom($room->first()->name));
                }
                $this->removeTracking();
                return redirect()->route('user.index');
            }
            abort(404);
        }
        abort(404);
    }
}