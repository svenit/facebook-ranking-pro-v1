<?php

namespace App\Http\Controllers\User\Guild;

use App\Model\Guild;
use App\Income\HandleFile;
use App\Model\GuildMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GuildController extends Controller
{
    use HandleFile;

    public function createForm()
    {
        if(empty(Auth::user()->guild))
        {
            return view('user.guild.create');
        }
        return redirect()->route('user.index');
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:guilds,name|between:3,30',
            'branch' => 'required|file|mimes:png,jpg,gif|max:5048',
            'g-recaptcha-response' => 'required|recaptcha'
        ]);

        if(empty(Auth::user()->guild))
        {
            $fee = 10;
            if(Auth::user()->gold >= $fee)
            {
                $file = HandleFile::upload('images/guild',$request->branch);
                if(isset($file))
                {
                    DB::transaction(function () use ($file, $fee, $request){
                        $subFee = Auth::user()->decrement('gold', $fee);
                        $createGuild = Guild::create([
                            'master_id' => Auth::id(),
                            'name' => $request->name,
                            'brand' => $file,
                            'noti_board' => null,
                            'level' => 1,
                            'resources' => 0
                        ]);
                        $createMember = GuildMember::create([
                            'guild_id' => $createGuild->id,
                            'member_id' => Auth::id(),
                            'resources' => 0
                        ]);
                    });
                    return redirect()->back()->with([
                        'message' => "Chúc mừng bạn đã tạo guild {$request->name} thành công",
                        'status' => 'success'
                    ]);
                }
                else
                {
                    return redirect()->back()->with([
                        'message' => 'Đã có lỗi trong quá trình tải file',
                        'status' => 'error'
                    ]);
                }
            }
            else
            {
                return redirect()->back()->with([
                    'message' => 'Bạn không đủ kim cương để tạo Guild',
                    'status' => 'error'
                ]);
            }
        }
        else
        {
            return redirect()->back()->with([
                'message' => 'Bạn đang ở trong 1 Guild khác',
                'status' => 'error'
            ]);
        }
    }
}