<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Model\User;
use App\Model\Config;
use Illuminate\Support\Str;
use App\Services\DiscordBot;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

        if(isset($userAuthentication))
        {
            if($userAuthentication->status)
            {
                Auth::loginUsingId($userAuthentication->id,TRUE);
                return redirect()->route('user.index')->with([
                    'status' => 'success',
                    'message' => 'Đăng nhập thành công'
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
        if(Session::has('user_callback') && Session('user_callback')->expired > now())
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
                if(Str::contains($request->url,'https://discord.com/channels'))
                {
                    if(preg_match_all('/\d+/m', $request->url, $matches) && isset($matches[0]))
                    {
                        $matches = $matches[0];
                        if(count($matches) == 3 && $matches[0] == env('DISCORD_SERVER_ID') && $matches[1] == env('DISCORD_CONFIRM_CHANNEL_ID'))
                        {
                            list($discordServer, $discordChannel, $discordMessage) = $matches;
                            $discordBot = new DiscordBot();
                            $message = $discordBot->getMessage($discordChannel, $discordMessage);
                            if(isset($message))
                            {
                                if(Hash::check($userCallback->id, $message->content))
                                {
                                    // $userAuthentication = new User();
                                    // $userAuthentication->provider_id = $userCallback->id;
                                    // $userAuthentication->discord_id = $message->author->id;
                                    // $userAuthentication->save();

                                    // Auth::loginUsingId($userAuthentication->id);
                                    // Session::forget('user_callback');
                                    $now = date('H:i:s d/m/Y');
                                    $discordBot->reactionMessage($discordChannel, $message->id, urlencode('✅'));
                                    $discordBot->sendMessage(env('DISCORD_VERIFIED_WEBHOOK'), [
                                        'content' => "<@{$message->author->id}>",
                                        'embeds' => [
                                            [
                                                'author' => [
                                                    'name' => $userCallback->name,
                                                    'url' => $userCallback->profileUrl,
                                                    'icon_url' => $userCallback->avatar
                                                ],
                                                "fields" => [
                                                    [
                                                        "name" => "Welcome :partying_face:",
                                                        "value" => "Chào mừng thợ săn **{$userCallback->name}** đến với Solo Level Simulator!"
                                                    ],
                                                    [
                                                        "name" => "Join Game :beers:",
                                                        "value" => env('APP_URL')
                                                    ]
                                                ],
                                                'thumbnail' => [
                                                    'url' => $userCallback->avatar
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
                                    return back()->with([
                                        'status' => 'success',
                                        'message' => 'Xác thực tài khoản thành công'
                                    ]);
                                }
                                else
                                {
                                    $message = 'Mã Token không chính xác! Hãy chắc rằng bạn đã nhập đúng mã Token!';
                                }
                            }
                        }
                        else
                        {
                            $message = 'URL không đúng định dạng';
                        }
                        
                    }
                    else
                    {
                        $message = 'URL không đúng định dạng';
                    }
                }
                else
                {
                    $message = 'URL không đúng định dạng';
                }
            }
            else
            {
                $message = 'Token không hợp lệ';
            }
            return back()->withErrors($message);
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
