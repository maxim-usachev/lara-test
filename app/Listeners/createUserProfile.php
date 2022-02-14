<?php

namespace App\Listeners;

use App\Events\userRegisteredEvent;
use App\Models\UserProfile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class createUserProfile
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  userRegisteredEvent  $event
     * @return void
     */
    public function handle(userRegisteredEvent $event)
    {
        UserProfile::createForNewUser($event->getUser()->id);
    }
}
