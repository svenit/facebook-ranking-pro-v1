<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Income\Helper;
use App\Model\CateGear;
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
            View::composer('*', function ($view) 
            {
                $cateGears = Cache::rememberForever('menuShop', function () use($view) {
                    return CateGear::all();
                });  
                $view->with('menuShop', $cateGears);  
            });
        }
        if(Schema::hasTable('notifications'))
        {
            View::composer('user.theme.*', function ($view) 
            {
                if(Auth::check())
                {
                    $view->with('notifications', [
                        'data' => Auth::user()->notifications,
                        'all' => Auth::user()->notifications->count(),
                        'read' => Auth::user()->readNotifications->count(),
                        'unread' => Auth::user()->unreadNotifications->count()
                    ]);
                }   
            });
        }
    }
}
