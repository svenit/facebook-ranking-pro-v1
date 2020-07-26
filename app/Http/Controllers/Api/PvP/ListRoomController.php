<?php

namespace App\Http\Controllers\Api\PvP;

use App\Model\Room;
use App\Services\Crypto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ListRoomController extends Controller
{
    public function __invoke()
    {
        return response()->json(Crypto::encrypt([
            'rooms' => Room::all()
        ]),200);
    }
}
