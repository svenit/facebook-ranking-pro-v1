<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Income\Helper;
use App\Model\CateGear;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
        if(Schema::hasTable('configs'))
        {
            View::composer('*', function ($view) 
            {
                if(Auth::check())
                {
                    $view->with('user', new Helper(Auth::id()));    
                }
            });
        }
        if(Schema::hasTable('cate_gears'))
        {
            View::composer('*', function ($view) 
            {
                $view->with('menuShop', CateGear::all());   
            });
        }
        if(Schema::hasTable('notifications'))
        {
            View::composer('*', function ($view) 
            {
                $view->with('notifications', [
                    'data' => Auth::user()->notifications,
                    'all' => Auth::user()->notifications->count(),
                    'unread' => Auth::user()->readNotifications->count(),
                    'unread' => Auth::user()->unreadNotifications->count()
                ]);   
            });
        }
    }
}
