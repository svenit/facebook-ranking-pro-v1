<?php

namespace App\Http\Controllers\User\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Cache::rememberForever('user.profile.message.user-id-'.Auth::id(), function () {
            return Auth::user()->notifications()->paginate(10);
        });
        return view('user.profile.message',compact('messages'));
    }
    public function detail($id)
    {
        $message = Cache::rememberForever("user.profile.message.$id", function () use ($id) {
            return Auth::user()->notifications->find($id);
        });
        if(isset($message))
        {
            $message->markAsRead();
            $this->removeCache("user.profile.message.user-id-".Auth::id());
            return view('user.profile.detail-message',compact('message'));
        }
        abort(404);
    }
}
