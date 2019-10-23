<?php

namespace App\Http\Controllers\Api\v1;

use App\Model\User;
use App\Income\Helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
                        'avatar' => $helper->character()->avatar
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
                    'vip' => $findUser->isVip == 1 ? true : false
                ],
                'rank' => [
                    'power' => $helper->rankPower(),
                    'rich' => $helper->rankCoin()
                ],
                'level' => $helper->nextLevel(),
                'power' => [
                    'total' => $helper->fullPower($findUser->id),
                    'hp' => $helper->power()['health_points'],
                    'strength' => $helper->power()['strength'],
                    'agility' => $helper->power()['agility'],
                    'intelligent' => $helper->power()['intelligent'],
                    'lucky' => $helper->power()['lucky'],
                ],
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
