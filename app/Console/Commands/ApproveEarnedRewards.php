<?php

namespace App\Console\Commands;

use App\User;
use App\UserReward;
use Illuminate\Console\Command;

class ApproveEarnedRewards extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'approve:rewards {--user_id=} {--reward_id=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Approve earned rewards';

    /**
     * @var User
     */
    protected $user;

    /**
     * @var UserReward
     */
    protected $reward;

    /**
     * Create a new command instance.
     *
     * @param User $user
     * @param UserReward $reward
     */
    public function __construct(User $user, UserReward $reward)
    {
        parent::__construct();
        $this->user = $user;
        $this->reward = $reward;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // If reward id is given
        if($rewardId = $this->option('reward_id')){

            // Get reward
            if($reward = $this->reward->find($rewardId)){

                // Check status
                if($reward->status == 'earned'){

                    // Change status to approved
                    $reward->status = 'approved';

                    // Save reward
                    $reward->save();

                    // Get reward user
                    $user = $reward->user;

                    // Get user referral statistics
                    $userReferralStatistics = $user->referralStatistics;

                    // Deduct reward amount from earned
                    $userReferralStatistics->earned = $userReferralStatistics->earned - $reward->amount;

                    // Add reward amount to approved
                    $userReferralStatistics->approved = $userReferralStatistics->approved + $reward->amount;

                    // Save referral statistics
                    $userReferralStatistics->save();
                }
            }
        }
        // Else if user id is given
        elseif($userId = $this->option('user_id')){

            // Get user
            if($user = $this->user->find($userId)) {

                // Get earned user rewards
                $user->rewards()
                    ->where('status', 'earned')
                    ->chunk(100, function ($rewards) use($user){

                        // Loop through rewards and update it and related data
                        foreach($rewards as $reward) {

                            // Change status to approved
                            $reward->status = 'approved';

                            // Save reward
                            $reward->save();

                            // Get user referral statistics
                            $userReferralStatistics = $user->referralStatistics;

                            // Deduct reward amount from earned
                            $userReferralStatistics->earned = $userReferralStatistics->earned - $reward->amount;

                            // Add reward amount to approved
                            $userReferralStatistics->approved = $userReferralStatistics->approved + $reward->amount;

                            // Save referral statistics
                            $userReferralStatistics->save();
                        }
                    });

            }
        }

    }
}
