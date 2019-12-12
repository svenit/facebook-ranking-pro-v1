<?php

namespace App\Http\Controllers\Api\v1\PvP;

use App\Model\Room;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ListRoomController extends Controller
{
    public function __invoke()
    {
        return response()->json([
            'rooms' => Room::all()
        ],200);
    }
}
