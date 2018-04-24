<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddSkillPointNewUser
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
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $user               = User::where('id', $event->user->id)->first();        
        $profileSlug        = str_slug($user->first_name. ' '. $user->last_name);
        $profileSlugId      = $profileSlug.$user->id;
        
        $user->skill_points = 50;
        
        if(User::where('profile_slug', $profileSlug)->first()) {
            $user->profile_slug = $profileSlugId;
        } else {
            $user->profile_slug = $profileSlug;
        }

        $user->save();
    }
}
