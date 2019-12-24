<?php

namespace App\Http\Controllers\User\Chat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GlobalChatController extends Controller
{
    public function index()
    {
        return view('user.chat.global');
    }
}
