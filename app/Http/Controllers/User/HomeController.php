<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $presenterTasks = [
            'Chỉ có làm mới có ăn, cái loại không làm mà đòi ăn thì chỉ có ăn...',
            'Khảm ngọc bổ trợ sẽ giúp cho trang bị của bạn mạnh hơn',
            'Hoàn thành nhiệm vụ hàng ngày sẽ giúp bạn kiếm được nhiều vàng & kinh nghiệm hơn đấy',
            "Chào {$user->name}! Bạn đã chuẩn bị gì cho ngày hôm nay chưa?",
            "Class {$user->character->name} sẽ rất mạnh nếu bạn biết cách vận dụng sức mạnh đó ^^",
            "Nếu hết điểm sức khỏe, hãy tới cửa hàng để mua thức ăn hoặc đến phòng hồi phục nhé :*",
            "Để mình nói cho bạn một bí mật nhé! Chăm chỉ đi Dungeon sẽ giúp bạn mạnh hơn ^^",
            "Trong tất cả các class mình thấy {$user->character->name} là mạnh nhất đấy",
            "Nếu ai đó khiêu chiến bạn, hãy đấm chết m* nó đi 😡"
        ];
        $presenterTask = $presenterTasks[rand(0, count($presenterTasks) - 1)];
        return view('user.index')->with([
            'presenterTask' => $presenterTask,
        ]);
    }
}
