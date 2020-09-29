<?php

namespace App\Http\Controllers\Api\User;

use App\Model\User;
use App\Services\Crypto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{
    public function setLocation(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'lat' => 'required|numeric',
            'lng' => 'required|numeric'
        ]);
        if($validate->fails())
        {
            return $validate->errors()->first();
        }
        else
        {
            User::findOrFail(Auth::id())->update([
                'location' => $request->only(['lat', 'lng'])
            ]);
        }
    }

    public function all(Request $request)
    {
        $users = User::where([['name','LIKE', "%{$request->text}%"],['id','!=',Auth::id()]])
            ->orWhere('user_id',$request->text)
            ->orWhere('provider_id',$request->text)
            ->select(['id','name','user_id','full_power'])
            ->limit(20)
            ->get();
        return response()->json(Crypto::encrypt($users),200);
    }

    public function getAllFames()
    {
        $allFames = config('game.fame');
        return response()->json(Crypto::encrypt($allFames), 200);
    }
}
