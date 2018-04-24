<?php

namespace App\Listeners;

use App\Events\ReferralAdded;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateReferrerAndReferralData
{
    /**
     * @var User
     */
    public $referrer;

    /**
     * @var User
     */
    public $referral;

    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     * @param ReferralAdded $referralAdded
     */
    public function handle(ReferralAdded $referralAdded)
    {
        // Get referrer from event
        $this->referrer = $referralAdded->referrer;

        // Get referral from event
        $this->referral = $referralAdded->referral;

        // Update referrer statistics
        $this->updateReferrerStatistics();

        // Add reward for referrer
        $this->addRewardForReferrer();

        // Add reward for referral
        $this->addRewardForReferral();
    }

    /**
     * Update referrer statistics
     *
     * @return void
     */
    protected function updateReferrerStatistics()
    {
        // Get user referral Statistics
        $referralStatistics = $this->referrer->referralStatistics;

        // Add one to referrals
        $referralStatistics->referrals = $referralStatistics->referrals + 1;

        // Save
        $referralStatistics->save();
    }

    /**
     * Add reward for referrer
     *
     * @return void
     */
    protected function addRewardForReferrer()
    {
        // Create book first class reward for referrer
        $this->referrer->rewards()->create([
            'amount' => 25,
            'required_action' => 'book_first_class',
            'status' => 'pending',
            'related_type' => 'referral',
            'related_id' => $this->referral->id
        ]);

        // Create create first class reward for referrer
        $this->referrer->rewards()->create([
            'amount' => 75,
            'required_action' => 'create_first_class',
            'status' => 'pending',
            'related_type' => 'referral',
            'related_id' => $this->referral->id
        ]);

        // Get user referral Statistics
        $referralStatistics = $this->referrer->referralStatistics;

        // Add rewards to pending
        $referralStatistics->pending = $referralStatistics->pending + 25 + 75;

        // Save
        $referralStatistics->save();
    }

    /**
     * Add reward for referral
     *
     * @return void
     */
    protected function addRewardForReferral()
    {
        // Create reward for referral
        $this->referral->rewards()->create([
            'amount' => 25,
            'status' => 'approved',
            'related_type' => 'referrer',
            'related_id' => $this->referrer->id
        ]);

        // Get user referral Statistics
        $referralStatistics = $this->referral->referralStatistics;

        // Add rewards to approved
        $referralStatistics->approved = $referralStatistics->approved + 25;

        // Save
        $referralStatistics->save();
    }
}
