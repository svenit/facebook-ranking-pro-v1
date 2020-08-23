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
            View::composer('user.theme.aside', function ($view) 
            {
                $cateGears = Cache::rememberForever('menuShop', function () {
                    return CateGear::all();
                }); 
                $characters = Cache::rememberForever('characters', function () {
                    return Character::where('id', '!=', env('NO_CHARACTER_ID'))->get();
                });
                $view->with([
                    'menuShop' => $cateGears,
                    'characters' => $characters
                ]);  
            });
        }
    }
}
