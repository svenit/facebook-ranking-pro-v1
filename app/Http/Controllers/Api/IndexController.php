<?php

namespace App\Http\Controllers\Api;

use App\Model\User;
use App\Income\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Cache;

class IndexController extends Controller
{
    public function userInfor($param)
    {
        $param = $param == 'profile' && Auth::check() ? Auth::id() : $param;
        $findUser = User::whereId($param)
            ->orWhere('user_id',$param)
            ->orWhere('name','LIKE',"%$param%")
            ->first();

        if(isset($findUser))
        {
            $helper = new Helper($findUser->id);
            return response()->json([
                'infor' => [
                    'name' => $helper->user()->name,
                    'character' => [
                        'name' => $helper->character()->name,
                    ],
                    'exp' => (int)$helper->user()->exp,
                    'coins' => $helper->coins(),
                    'gold' => $helper->gold(),
                    'activities' => [
                        'posts' => (int)$findUser->posts,
                        'reactions' => (int)$findUser->reactions,
                        'comments' => (int)$findUser->comments,
                    ],
                    'facebook_id' => $findUser->user_id,
                    'active' => isset($findUser->provider_id) ? true : false,
                    'pvp_points' => $helper->user()->pvp_points
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
                'skills' => $helper->usingSkills()
            ],200);
        }
        return response()->json([
            'keyword' => $param,
            'code' => 404,
            'status' => 'error',
            'message' => 'Không tìm thấy người này',
            'time' => now(),
        ],200);
    }
}
