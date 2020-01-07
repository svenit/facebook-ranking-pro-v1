<?php

namespace App\Http\Controllers\User\Profile\Message;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Auth::user()->notifications()->paginate(10);
        return view('user.profile.message',compact('messages'));
    }
    public function detail($id)
    {
        $message = Auth::user()->notifications->find($id);
        if(isset($message))
        {
            $message->markAsRead();
            return view('user.profile.detail-message',compact('message'));
        }
        abort(404);
    }
}
