<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cookie;

class CreateNewLoginCookie
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
        // Create a new login token
        cookie()->queue('login', true,60*24*60);
    }
}
