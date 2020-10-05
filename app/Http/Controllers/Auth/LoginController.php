<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Model\User;
use App\Model\Config;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;
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
    public function __construct()
    {
        $this->middleware('guest')->except(['handleProviderCallback','logout']);
    }
    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function handleProviderCallback()
    {
        session_write_close();
        set_time_limit(60);

        $callback = Socialite::driver('facebook')->user();
        $callback->expired = now()->addMinutes(100);

        Session::put('user_callback',$callback);
        $userAuthentication = User::whereProviderId($callback->id)->first();

        if(isset($userAuthentication)) {
            if($userAuthentication->status) {
                Auth::loginUsingId($userAuthentication->id,TRUE);
                $user = Auth::user();
                return redirect()->route('user.index')->with([
                    'status' => 'success',
                    'message' => "Chào mừng [ {$user->name} ] đã quay trở lại!"
                ]);
            }
            return redirect()->route('oauth.index')->with([
                'status' => 'error',
                'message' => 'Tài khoản của bạn đã bị khóa'
            ]);
        }
        return redirect()->route('oauth.show-confirm')->with([
            'status' => 'warning',
            'message' => 'Vui lòng xác thực tài khoản của bạn',
        ]);
    }
    public function showLoginForm()
    {
        $content = $this->config()->introduce ?? '';
        return view('user.login', compact('content'));
    }
    public function showConfirm(Config $config)
    {
        if(Session::has('user_callback') && Session('user_callback')->expired > now() && !Auth::check())
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
        $validate = Validator::make($request->all(), [
            'token' => 'required',
            'name' => [
                'required',
                'between:6,50',
                Rule::notIn(config('blacklist.account_name')),
            ],
            'email' => 'required|email|unique:users,email',
        ],[
            'token.required' => 'Token lỗi',
            'name.required' => 'Tên không được để trống',
            'name.between' => 'Tên chỉ được trong khoảng 6-50 kí tự',
            'name.not_in' => 'Bạn không thể chọn tên này',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã tồn tại',
        ]);
        if ($validate->fails()) {
            return back()->with([
                'status' => 'error',
                'message' => $validate->errors()->first()
            ]);
        }
        $userCallback = Session('user_callback');
        if(Session::has('user_callback') && $userCallback->expired > now() && !Auth::check()) {
            if(Hash::check($userCallback->id, $request->token)) {
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->token = str_random(20);
                $user->provider_id = $userCallback->id;
                $user->character_id = env('NO_CHARACTER_ID');
                $user->status = 1;
                $user->save();
                Auth::login($user);
                return back()->with([
                    'status' => 'success',
                    'message' => 'Đăng ký tài khoản thành công'
                ]);
            }
        }
        return redirect()->route('oauth.index');
    }
    public function logout()
    {
        Auth::logout();
        Session::forget('user_callback');
        return redirect()->route('oauth.index');
    }
}
