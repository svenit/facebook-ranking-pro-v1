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
        if(Auth::check() && Auth::user()->character_id == env('NO_CHARACTER_ID')) {
            $characters = Character::avaiable();
            return view('user.character.choose')->with([
                'characters' => $characters
            ]);
        }
        abort(404);
    }
    public function set()
    {
        if(Auth::check() && Auth::user()->character_id == env('NO_CHARACTER_ID')) {
            $character = Character::where('id', '!=', env('NO_CHARACTER_ID'))->inRandomOrder()->first();
            $user = Auth::user();
            $user->character_id = $character->id;
            $user->strength = $character->strength;
            $user->intelligent = $character->intelligent;
            $user->agility = $character->agility;
            $user->lucky = $character->lucky;
            $user->health_points = $character->health_points;
            $user->armor_strength = $character->armor_strength;
            $user->armor_intelligent = $character->armor_intelligent;
            $user->stats = [
                'strength' => 0,
                'intelligent' => 0,
                'agility' => 0,
                'lucky' => 0,
                'health_points' => 0,
                'armor_strength' => 0,
                'armor_intelligent' => 0
            ];
            $user->config = [
                'canChatInGlobal' => true,
            ];
            $user->save();
            return redirect()->route('user.index')->with([
                'status' => '',
                'message' => "Chào mừng [ Player ] - Bạn đã thức tỉnh thành công E Rank - {$character->name}"
            ]);
        }
        abort(404);
    }
}
