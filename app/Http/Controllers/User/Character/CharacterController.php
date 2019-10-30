<?php

namespace App\Http\Controllers\User\Character;

use App\Model\User;
use App\Model\Character;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CharacterRequest;

class CharacterController extends Controller
{
    public function choose()
    {
        if(Auth::check() && Auth::user()->character_id == 0)
        {
            $characters = Character::avaiable();
            return view('user.character.choose')->with([
                'characters' => $characters
            ]);
        }
        abort(404);
    }
    public function set($id)
    {
        if(Auth::check() && Auth::user()->character_id == 0)
        {
            $character = Character::findOrFail($id);
            $user = User::findOrFail(Auth::id());

            $user->character_id = $character->id;
            $user->strength = $character->strength;
            $user->intelligent = $character->intelligent;
            $user->agility = $character->agility;
            $user->lucky = $character->lucky;
            $user->health_points = $character->health_points;
            
            $user->save();
            return redirect()->route('user.index')->with([
                'status' => 'success',
                'message' => "Chúc mừng bạn đã chọn nhân vật $character->name thành công !"
            ]);
        }
        abort(404);
    }
}
