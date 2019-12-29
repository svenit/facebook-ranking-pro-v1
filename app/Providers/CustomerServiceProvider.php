<?php

namespace App\Providers;

use App\Model\ChatConversation;
use App\Model\FightRoom;
use App\Observers\ChatObserver;
use App\Observers\FightRoomObserver;
use Illuminate\Support\ServiceProvider;

class CustomerServiceProvider extends ServiceProvider
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
        ChatConversation::observe(ChatObserver::class);
    }
}
