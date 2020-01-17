<?php

namespace App\Http\Controllers\User\GiftCode;

use App\Model\GiftCode;
use App\Model\UserGiftCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GiftCodeController extends Controller
{
    public function submit(Request $request)
    {
        $this->validate($request,[
            'code' => 'required|exists:gift_codes,code',
            'g-recaptcha-response' => 'required|recaptcha'
        ],[
            'code.required' => 'Không được để trống',
            'code.exists' => 'Giftcode không tồn tại',
            'g-recaptcha-response.required' => 'Bạn chưa nhập captcha',
            'g-recaptcha-response.recaptcha' => 'Captcha không hợp lệ'
        ]);
        $giftcode = GiftCode::whereCode($request->code)->first();
        if(isset($giftcode))
        {
            $checkCode = UserGiftCode::where([['user_id',Auth::id()],['gift_code_id',$giftcode->id]])->first();
            if(empty($checkCode))
            {
                if($giftcode->expired_day >= now())
                {
                    $giftcodes = explode("^",$giftcode->query);
                    foreach($giftcodes as $code)
                    {
                        $exec = DB::statement($this->replaceStatement($code));
                    }
                    if($exec)
                    {
                        $this->updatePower();
                        $giftcode->user()->attach(Auth::id());
                        return redirect()->back()->with([
                            'status' => 'success',
                            'message' => 'Nhận phần thưởng thành công'
                        ]);
                    }
                }
                else
                {
                    return redirect()->back()->withErrors([
                        'error' => 'Giftcode đã hết hạn'
                    ]);
                }
            }
            else
            {
                return redirect()->back()->withErrors([
                    'error' => 'Bạn đã nhập giftcode này rồi'
                ]);
            }
        }
    }
}
