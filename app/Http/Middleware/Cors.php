<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(env('APP_PROTECTED_API'))
        {
            $token = hash('sha256',$this->encode(strrev(csrf_token().'VYDEPTRAI')));
            if($request->header('host') == env('APP_DOMAIN') && $request->header('pragma') == $token)
            {
                $newToken = str_random(50);
                Session::forget('_token');
                Session::put('_token',$newToken);
                return $next($request)->header('Authorization',$newToken)
                    ->header('Access-Control-Allow-Origin', env('APP_DOMAIN'))
                    ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
            }
            return response()->json([
                'status' => 'error',
                'code' => '403',
                'message' => 'Forbidden'
            ]);
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
