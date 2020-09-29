<?php

namespace App\Http\Controllers\Api;

use App\Model\User;
use App\Income\Helper;
use App\Services\Crypto;
use App\Services\RedisCache;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function userInfor($param)
    {
        $param = $param == 'profile' && Auth::check() ? Auth::id() : $param;
        $findUser = User::whereId($param)
            ->orWhere('id', $param)
            ->orWhere('provider_id', $param)
            ->orWhere('name', 'LIKE', "%$param%")
            ->first();

        if(isset($findUser))
        {
            $ttl = 60 * 24;
            $helper = new Helper($findUser->id);
            $user = $helper->user();
            $userPower = $helper->power();
            return RedisCache::remember("user-{$findUser->id}", $ttl, function () use($helper, $user, $userPower, $findUser){
                return response()->json(Crypto::encrypt([
                    'infor' => [
                        'uid' => $user->id,
                        'name' => $user->name,
                        'character' => [
                            'name' => $helper->character()->name,
                            'avatar' => $helper->character()->avatar
                        ],
                        'exp' => (int)$user->exp,
                        'coins' => $helper->coins(),
                        'gold' => $helper->gold(),
                        'pvp_points' => $user->pvp_points,
                        'fame' => $user->fame,
                        'provider_id' => $user->provider_id,
                        'energy' => $user->energy,
                        'isAdmin' => $user->isAdmin,
                        'config' => $user->config
                    ],
                    'rank' => [
                        'brand' => $helper->rank(),
                        'fame' => $helper->fameBrand(),
                        'pvp' => $helper->pvpBrand()
                    ],
                    'top' => [
                        'power' => $helper->getRank('full_power'),
                        'fame' => $helper->getRank('fame'),
                        'pvp' => $helper->getRank('pvp_points'),
                        'level' => $helper->getRank('exp'),
                    ],
                    'stats' => $this->isOwnerData($findUser->id, $helper->stats()),
                    'level' => $helper->nextLevel(),
                    'raw_power' => [
                        'hp' => $user['health_points'],
                        'strength' => $user['strength'],
                        'agility' => $user['agility'],
                        'intelligent' => $user['intelligent'],
                        'lucky' => $user['lucky'],
                        'energy' => $user->default_energy,
                        'armor_strength' => $user['armor_strength'],
                        'armor_intelligent' => $user['armor_intelligent'],
                    ],
                    'power' => [
                        'total' => $helper->fullPower($findUser->id),
                        'hp' => $userPower['health_points'],
                        'strength' => $userPower['strength'],
                        'agility' => $userPower['agility'],
                        'intelligent' => $userPower['intelligent'],
                        'lucky' => $userPower['lucky'],
                        'energy' => $helper->character()->default_energy,
                        'armor_strength' => $userPower['armor_strength'],
                        'armor_intelligent' => $userPower['armor_intelligent'],
                    ],
                    'pet' => $helper->usingPets()->first(),
                    'gears' => $helper->usingGears(),
                    'skills' => $this->isOwnerData($findUser->id, $helper->usingSkills())
                ]),200);
            });
        }
        return response()->json(Crypto::encrypt([
            'keyword' => $param,
            'code' => 404,
            'status' => 'error',
            'message' => 'Không tìm thấy người này',
            'time' => now(),
        ]),200);
    }

    public function isOwnerData($userId, $data)
    {
        return Auth::id() == $userId ? $data : [];
    }

    public function verifyToken(Request $request)
    {
        return $request->token == md5(hash('sha256',md5($this->encode(strrev(session('client_key').'..$!@{a-z0-9}-VYDEPTRAI&*@!LX&&$PHP?1+1'))))) ? 1 : 0;
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
