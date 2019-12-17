<?php

namespace App\Observers;

use App\Model\FightRoom;

class FightRoomObserver
{
    /**
     * Handle the fight room "created" event.
     *
     * @param  \App\Model\FightRoom  $fightRoom
     * @return void
     */
    public function created(FightRoom $fightRoom)
    {
        $fightRoom->room()->increment('people');
    }

    /**
     * Handle the fight room "updated" event.
     *
     * @param  \App\Model\FightRoom  $fightRoom
     * @return void
     */
    public function updated(FightRoom $fightRoom)
    {
        //
    }

    /**
     * Handle the fight room "deleted" event.
     *
     * @param  \App\Model\FightRoom  $fightRoom
     * @return void
     */
    public function deleted(FightRoom $fightRoom)
    {
        $fightRoom->room()->decrement();
    }

    /**
     * Handle the fight room "restored" event.
     *
     * @param  \App\Model\FightRoom  $fightRoom
     * @return void
     */
    public function restored(FightRoom $fightRoom)
    {
        //
    }

    /**
     * Handle the fight room "force deleted" event.
     *
     * @param  \App\Model\FightRoom  $fightRoom
     * @return void
     */
    public function forceDeleted(FightRoom $fightRoom)
    {
        //
    }
}
