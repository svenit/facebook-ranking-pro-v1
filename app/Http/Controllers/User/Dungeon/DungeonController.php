<?php

namespace App\Http\Controllers\User\Dungeon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DungeonController extends Controller
{
    public function __construct()
    {
        $this->middleware('prevent');
    }
    public function index()
    {
        return view('user.dungeon.index');
    }

    public function join($gate)
    {
        $accept = ['e', 'd', 'c', 'b', 'a'];
        if(in_array($gate, $accept))
        {
            return 1;
        }
    }
}
