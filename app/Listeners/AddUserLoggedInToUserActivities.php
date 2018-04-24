<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddUserLoggedInToUserActivities
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
     * @param UserLoggedIn $userLoggedIn
     */
    public function handle(UserLoggedIn $userLoggedIn)
    {
        // Get user from event
        $user = $userLoggedIn->user;

        // Create a new activity for login
        $user->activities()->create([
            'event' => 'logged_in',
            'ip_address' => request()->ip()
        ]);
    }
}
