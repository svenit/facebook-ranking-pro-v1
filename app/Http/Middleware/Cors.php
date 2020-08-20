<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\Crypto;
use Illuminate\Support\Str;
use App\Services\DiscordBot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Cors
{
    protected $except = [
        'api/v1/wheel'
    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!session()->has('api_fails')) {
            session()->put('api_fails', 0);
        }
        if(in_array($request->path(), $this->except)) {
            return $next($request);
        }
        if(env('APP_PROTECTED_API'))
        {
            if(isset($request->bearer))
            {
                $token = md5(hash('sha256',md5($this->encode(strrev(session('client_key').'..$!@{a-z0-9}-VYDEPTRAI&*@!LX&&$PHP?1+1')))));
                if($request->_token == csrf_token() && $request->header('pragma') === $token)
                {
                    $newToken = uniqid(Str::random(40));
                    Session::forget('client_key');
                    Session::put('client_key', $newToken);
                    return $next($request)->header('Cookie', request()->header('Cookie'))
                        ->header('Token', Str::random(40))
                        ->header('Access-Control-Allow-Origin', url('/'))
                        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                        ->header('Access-Control-Allow-Name', $newToken);
                }
                $now = date('H:i:s d/m/Y');
                $discordBot = new DiscordBot();
                $user = Auth::user();
                session()->increment('api_fails');
                @$discordBot->sendMessage(env('DISCORD_LOG_WEBHOOK'), [
                    'content' => '@here',
                    'embeds' => [
                        [
                            'color' => 13303808,
                            'author' => [
                                'name' => 'Tracking System',
                            ],
                            "fields" => [
                                [
                                    "name" => "User's Information",
                                    "value" => "ID: {$user->id} \n Name: {$user->name}"
                                ],
                                [
                                    "name" => "Number of Failures",
                                    "value" => session()->get('api_fails', 0)
                                ],
                                [
                                    "name" => "IP Address",
                                    "value" => $request->ip()
                                ],
                                [
                                    "name" => "Current URL",
                                    "value" => url()->current()
                                ],
                                [
                                    "name" => "API's URL",
                                    "value" => url()->full()
                                ],
                                [
                                    "name" => "Request Payload",
                                    "value" => "Token: {$token} \n CSRF-Token: {$request->_token}"
                                ]
                            ],
                            'footer' => [
                                'text' => "Tin nhắn được tạo lúc: {$now}"
                            ]
                        ]
                    ],
                    'allowed_mentions' => [
                        'parse' => ['users']
                    ]
                ]);
                return response()->json([
                    'status' => 'error',
                    'code' => 500,
                    'message' => "Server Error"
                ]);
            }
            else
            {
                return response()->json([
                    'status' => 'error',
                    'code' => '403',
                    'message' => 'Bearer Token is required',
                ]);
            }
        }
        return $next($request);
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
