<?php

namespace App\Providers;

use App\Model\FightRoom;
use App\Observers\FightRoomObserver;
use Illuminate\Support\ServiceProvider;

class FightRoomProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        FightRoom::observe(FightRoomObserver::class);
    }
}
