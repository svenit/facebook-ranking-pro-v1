<?php

namespace App\Observers;

use App\Model\ChatConversation;

class ChatObserver
{
    /**
     * Handle the chat conversation "created" event.
     *
     * @param  \App\Model\ChatConversation  $chatConversation
     * @return void
     */
    public function created(ChatConversation $chatConversation)
    {
        $chatConversation->room()->increment('people');
    }

    /**
     * Handle the chat conversation "updated" event.
     *
     * @param  \App\Model\ChatConversation  $chatConversation
     * @return void
     */
    public function updated(ChatConversation $chatConversation)
    {
        //
    }

    /**
     * Handle the chat conversation "deleted" event.
     *
     * @param  \App\Model\ChatConversation  $chatConversation
     * @return void
     */
    public function deleted(ChatConversation $chatConversation)
    {
        $chatConversation->room()->decrement('people');
    }

    /**
     * Handle the chat conversation "restored" event.
     *
     * @param  \App\Model\ChatConversation  $chatConversation
     * @return void
     */
    public function restored(ChatConversation $chatConversation)
    {
        //
    }

    /**
     * Handle the chat conversation "force deleted" event.
     *
     * @param  \App\Model\ChatConversation  $chatConversation
     * @return void
     */
    public function forceDeleted(ChatConversation $chatConversation)
    {
        //
    }
}
