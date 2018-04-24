<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
use App\Events\UserRegistered;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddUserRegisteredToUserActivities
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
     * @param UserRegistered $userRegistered
     * @internal param UserLoggedIn $userLoggedIn
     */
    public function handle(UserRegistered $userRegistered)
    {
        // Get user from event
        $user = $userRegistered->user;

        // Update user referrer id
        if($user->referrer_id){

            // Create a new activity for referral register
            $user->activities()->create([
                'event' => 'referral_register',
                'ip_address' => request()->ip()
            ]);
        }else{
            // Create a new activity for normal register
            $user->activities()->create([
                'event' => 'normal_register',
                'ip_address' => request()->ip()
            ]);
        }

    }
}
