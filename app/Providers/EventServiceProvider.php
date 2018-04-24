<?php

namespace App\Providers;

use App\Events\MessageReplyCreated;
use App\Events\ReferralAdded;
use App\Events\UserLoggedIn;
use App\Events\UserLoggedOut;
use App\Events\UserRegistered;
use App\Listeners\AddDisciplineSkill;
use App\Listeners\AddSkillPointNewUser;
use App\Listeners\AddSocialSkill;
use App\Listeners\AddUserLoggedInToUserActivities;
use App\Listeners\AddUserLoggedOutToUserActivities;
use App\Listeners\AddUserRegisteredToUserActivities;
use App\Listeners\CreateNewLoginCookie;
use App\Listeners\SendEmailToReplyReceiverListener;
use App\Listeners\UpdateReferrerAndReferralData;
use App\Listeners\UpdateRelatedMessageListener;
use App\MessageReply;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        MessageReplyCreated::class => [
            UpdateRelatedMessageListener::class,
            SendEmailToReplyReceiverListener::class,
        ],
        UserRegistered::class=>[
            AddUserRegisteredToUserActivities::class,
            AddSkillPointNewUser::class,
            AddSocialSkill::class,
        ],
        UserLoggedIn::class => [
            CreateNewLoginCookie::class,
            AddUserLoggedInToUserActivities::class,
            AddDisciplineSkill::class,
        ],
        UserLoggedOut::class => [
            AddUserLoggedOutToUserActivities::class
        ],
        ReferralAdded::class => [
            UpdateReferrerAndReferralData::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // Fire message reply created event when a message reply is created
        MessageReply::created(function ($messageReply) {
            event(new MessageReplyCreated($messageReply));
        });
    }
}
