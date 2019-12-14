<?php

namespace App\Providers;

use App\Income\Helper;
use App\Model\FightRoom;
use App\Observers\FightRoomObserver;
use App\Providers\FightRoomProvider;
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
        $this->app->bind(FightRoomProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        FightRoom::observe(FightRoomObserver::class);
        
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
    }
}
