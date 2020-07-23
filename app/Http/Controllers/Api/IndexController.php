<?php

namespace App\Http\Controllers\Api;

use App\Model\User;
use App\Income\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class IndexController extends Controller
{
    public function userInfor($param)
    {
        $param = $param == 'profile' && Auth::check() ? Auth::id() : $param;
        $findUser = User::whereId($param)
            ->orWhere('user_id', $param)
            ->orWhere('provider_id', $param)
            ->orWhere('name', 'LIKE', "%$param%")
            ->first();

        if(isset($findUser))
        {
            $ttl = 60 * 24;
            $helper = new Helper($findUser->id);
            return Cache::remember("user-{$findUser->id}", $ttl, function () use($helper, $findUser){
                return response()->json([
                    'infor' => [
                        'name' => $helper->user()->name,
                        'character' => [
                            'name' => $helper->character()->name,
                        ],
                        'exp' => (int)$helper->user()->exp,
                        'coins' => $helper->coins(),
                        'gold' => $helper->gold(),
                        'pvp_points' => $helper->user()->pvp_points,
                        'provider_id' => $helper->user()->provider_id
                    ],
                    'rank' => [
                        'power' => $helper->rankPower()
                    ],
                    'stats' => Auth::id() == $findUser->id ? $helper->stats() : [],
                    'level' => $helper->nextLevel(),
                    'power' => [
                        'total' => $helper->fullPower($findUser->id),
                        'hp' => $helper->power()['health_points'],
                        'strength' => $helper->power()['strength'],
                        'agility' => $helper->power()['agility'],
                        'intelligent' => $helper->power()['intelligent'],
                        'lucky' => $helper->power()['lucky'],
                        'energy' => $helper->character()->default_energy,
                        'armor_strength' => $helper->power()['armor_strength'],
                        'armor_intelligent' => $helper->power()['armor_intelligent'],
                    ],
                    'pet' => $helper->usingPets()->first(),
                    'gears' => $helper->usingGears(),
                    'skills' => Auth::id() == $findUser->id ? $helper->usingSkills() : []
                ],200);                
            });
        }
        return response()->json([
            'keyword' => $param,
            'code' => 404,
            'status' => 'error',
            'message' => 'Không tìm thấy người này',
            'time' => now(),
        ],200);
    }

    public function verifyToken(Request $request) 
    {
        return $request->token == md5(hash('sha256',md5($this->encode(strrev(csrf_token().'..$!@{a-z0-9}-VYDEPTRAI&*@!LX&&$PHP?1+1'))))) ? 1 : 0;
    }

    public function encode($message)
    {
        $message = str_replace(1,"^",$message);
        $message = str_replace(2,"+",$message);
        $message = str_replace(3,"#",$message);
        $message = str_replace(4,"*",$message);
        $message = str_replace(5,"<",$message);
        $message = str_replace(6,"%",$message);
        $message = str_replace(7,"!",$message);
        $message = str_replace(8,"_",$message);
        $message = str_replace(9,"=",$message);
        return $message;
    }
}
