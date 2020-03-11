<?php

namespace App\Http\Controllers\Api\User;

use App\Model\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LocationController extends Controller
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
}
