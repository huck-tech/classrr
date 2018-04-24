<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
use App\Events\UserLoggedOut;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddUserLoggedOutToUserActivities
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
     * @param UserLoggedOut $userLoggedOut
     */
    public function handle(UserLoggedOut $userLoggedOut)
    {
        // Get user from event
        $user = $userLoggedOut->user;

        // Create a new activity for logout
        $user->activities()->create([
            'event' => 'logged_out',
            'ip_address' => request()->ip()
        ]);
    }
}
