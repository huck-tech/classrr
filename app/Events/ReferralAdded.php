<?php

namespace App\Events;

use App\User;
use Illuminate\Queue\SerializesModels;

class ReferralAdded
{
    use SerializesModels;

    /**
     * @var User
     */
    public $referrer;

    /**
     * @var User
     */
    public $referral;


    /**
     * Create a new event instance.
     *
     * @param User $referrer
     * @param User $referral
     */
    public function __construct(User $referrer, User $referral)
    {
        $this->referrer = $referrer;
        $this->referral = $referral;
    }
}
