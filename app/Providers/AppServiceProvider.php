<?php

namespace App\Providers;

use App\Income\Helper;
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
        $this->app->singleton(HelperService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
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
