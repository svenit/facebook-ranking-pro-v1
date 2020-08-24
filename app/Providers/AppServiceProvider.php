<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Income\Helper;
use App\Model\CateGear;
use App\Model\Character;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        URL::forceScheme('https');
        Carbon::setLocale('vi');
        Schema::defaultStringLength(191);
        Validator::extend('recaptcha', 'App\Validators\ReCaptcha@validate');
        
        if(Schema::hasTable('cate_gears'))
        {
            View::composer(['user.theme.aside', 'app'], function ($view) 
            {
                $cateGears = Cache::rememberForever('menuShop', function () {
                    return CateGear::all();
                }); 
                $characters = Cache::rememberForever('characters', function () {
                    return Character::where('id', '!=', env('NO_CHARACTER_ID'))->get();
                });
                $user = Auth::user();
                $intro = [
                    "Xin chào {$user->name}! Chào mừng bạn đến với Solo Leveling Simulator! Mình là Andy, rất vui được làm người giới thiệu cho bạn.",
                    'Bạn có thể xem thông tin cá nhân của bạn bằng cách bấm vào đây',
                    'Đây là điểm hạng! Bạn có thể kiếm bằng cách vào đấu trường PVP và khiêu chiến các thợ săn khác',
                    'Thứ tiền tệ cơ bản nhất trong thế giới này là Vàng, bạn có thể kiếm được vàng bằng rất nhiều cách như đi Dungeon, Boss Thế Giới, Chợ Trời...!',
                    'Hmm! Kim cương ư? Nó là loại tiền tệ không chính thức trong thế giới này. Chỉ có những người giàu nhất mới có thể sở hữu nó thôi :(',
                    'Bạn đã bao giờ nghe đến rồng Karmish và đồng bọn của nó chưa? Bọn nó vẫn hay lởn vởn ở quanh đây lắm! Hãy tiêu diệt bọn chúng vào mỗi 20h hàng ngày nhé',
                    'Mastel - Bạn của tôi đã hi sinh trong sự kiện cánh cổng đỏ :( Hãy chiến đấu cùng ý chí của anh ấy nhé',
                    'Bạn bị bạn bè, đồng đội khinh thường? Bạn muốn cho trở thành chủ tịch và cái kết? Vào đây solo đi chứ còn chần chừ gì nữa :))',
                    'Vật phẩm, trang bị, kỹ năng, thú cưng đều có ở đây ^^',
                    'Hãy chuẩn bị nhu yếu phẩm một cách kĩ lưỡng trước khi bước vào Dungeon nhé? Vào đây mà mua sắm thôi',
                    'Hãy nhớ nhận nhiệm vụ hàng ngày vì bạn có thể nhận được rất nhiều kinh nghiệm, vàng, vật phẩm đấy...',
                    'Ui toàn mấy ông tay to hack game ở trong này thôi! Tôi tin một ngày bạn cũng sẽ nằm trong danh sách này ^^',
                    'Tập hợp bạn bè lại và lập cho riêng mình một bang hội nhỉ?',
                    'Nhiều tiền không biết làm gì? Hãy chứng minh độ giàu của bạn bằng cách vào đây',
                ];
                $view->with([
                    'menuShop' => $cateGears,
                    'characters' => $characters,
                    'intro' => $intro,
                ]);  
            });
        }
    }
}
