<?php

namespace App\Http\Controllers\Auth;

use App\Model\User;
use App\Model\Config;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Income\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    public function redirectToProvider()
    {
        if(!Auth::check())
        {
            return Socialite::driver('facebook')->redirect();
        }
        return back();
    }
    public function handleProviderCallback()
    {
        $callback = Socialite::driver('facebook')->user();
        $callback->expired = now()->addMinutes(5);
        
        Session::put('user_callback',$callback);
        $userAuthentication = User::whereProviderId($callback->id)->first();

        if(isset($userAuthentication))
        {
            Auth::loginUsingId($userAuthentication->id,TRUE);
            Auth::logoutOtherDevices('');
            return redirect()->route('user.index')->with([
                'status' => 'success',
                'message' => 'Đăng nhập thành công'
            ]);
        }
        return redirect()->route('oauth.show-confirm')->with([
            'status' => 'warning',
            'message' => 'Vui lòng xác thực tài khoản của bạn',
        ]);
    }
    public function showLoginForm()
    {
        if(Auth::check())
        {
            return redirect()->route('user.index');
        }
        return view('user.login');
    }
    public function showConfirm(Config $config)
    {
        if(Session::has('user_callback') && !Auth::check() && Session('user_callback')->expired > now())
        {
            return view('user.confirm')->with([
                'expired' => Carbon::parse(Session('user_callback')->expired)->diffInSeconds(),
                'config' => $config->first()
            ]);
        }
        return redirect()->route('oauth.index');
    }
    public function confirm(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'url' => 'required|url'
        ],[
            'token.required' => 'Bạn chưa nhập Token',
            'url.required' => 'Bạn chưa nhập URL',
            'url.url' => 'URL không đúng định dạng'
        ]);

        $userCallback = Session('user_callback');
        
        if(Session::has('user_callback') && $userCallback->expired > now())
        {
            if(Hash::check($userCallback->id, $request->token))
            {
                if(str_contains($request->url,'https://www.facebook.com/groups'))
                {
                    $getComment = explode('?comment_id=',$request->url);
                    if(isset($getComment[1]) && gettype((int)$getComment[1]) == 'integer')
                    {
                        $getComment = $getComment[1];
                        $helper = new Helper(User::first());
                        $endpoint = "https://graph.facebook.com/v4.0/$getComment?access_token=".$helper->config->access_token;
                        $api = json_decode($helper->requestRaw($endpoint),TRUE);

                        if(isset($api) && empty($api['error']))
                        {
                            if(Hash::check($userCallback->id, $api['message']) && $api['id'] == $getComment && $api['from']['name'] == $userCallback->name)
                            {
                                $userAuthentication = User::whereUserId($api['from']['id'])->first();
                                if(isset($userAuthentication))
                                {
                                    $userAuthentication->provider_id = $userCallback->id;
                                    $userAuthentication->save();

                                    Auth::loginUsingId($userAuthentication->id);
                                    Session::forget('user_callback');

                                    return back()->with([
                                        'status' => 'success',
                                        'message' => 'Xác thực tài khoản thành công'
                                    ]);
                                }
                                else
                                {
                                    return back()->withErrors([
                                        'Bạn không phải là thành viên của nhóm này hoặc chưa có dữ liệu về bạn'
                                    ]);
                                }
                            }
                            else
                            {
                                return back()->withErrors([
                                    'Token không trùng nhau'
                                ]);
                            }
                        }
                        else
                        {
                            return back()->withErrors([
                                'Lỗi server ! Xin lỗi đã làm ảnh hưởng đến quá trình trải nghiệm của bạn. 
                                Chúng tôi sẽ sửa chữa nhanh nhất có thể mời bạn quay lại sau'
                            ]);
                        }
                    }
                    else
                    {
                        return back()->withErrors([
                            'URL không đúng định dạng'
                        ]);
                    }
                }
                else
                {
                    return back()->withErrors([
                        'URL không đúng định dạng'
                    ]);
                }
            }
            else
            {
                return back()->withErrors([
                    'Token không hợp lệ'
                ]);
            }
        }
        return back();
    }
    public function logout()
    {
        Auth::logout();
        Session::forget('user_callback');
        return redirect()->route('oauth.index');
    }
}
