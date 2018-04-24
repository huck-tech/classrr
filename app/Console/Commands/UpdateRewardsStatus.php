<?php

namespace App\Console\Commands;

use App\Booking;
use App\UserReward;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateRewardsStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:rewards-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update rewards status';

    /**
     * @var UserReward
     */
    protected $reward;

    /**
     * @var Booking
     */
    protected $booking;

    /**
     * Create a new command instance.
     *
     * @param UserReward $reward
     * @param Booking $booking
     */
    public function __construct(UserReward $reward, Booking $booking)
    {
        parent::__construct();
        $this->reward = $reward;
        $this->booking = $booking;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Change status of rewards with status equal used but are not actually used to approved
        UserReward::whereHas('bookings', function($query){
                $query->where('payment_status', 'created');
                $query->where('created_at', '<', Carbon::now());
            })
            ->with('bookings')
            ->chunk(100, function($rewards){

                foreach($rewards as $reward) {

                    // Loop through rewards bookings
                    foreach ($reward->bookings as $booking) {

                        // Deduct the used amount from the reward used amount
                        $reward->used_amount = $reward->used_amount - $booking->pivot->used_amount;
                    }

                    // Change status to approved
                    $reward->status = 'approved';

                    // Save reward
                    $reward->save();

                    // Get user referral statistics
                    $user = $reward->user;

                    // Get user referral statistics
                    $userReferralStatistics = $user->referralStatistics;

                    // Deduct discount used amount from used
                    $userReferralStatistics->used = $userReferralStatistics->used - $booking->pivot->used_amount;

                    // Add discount used amount to approved
                    $userReferralStatistics->approved = $userReferralStatistics->approved + $booking->pivot->used_amount;

                    // Save referral statistics
                    $userReferralStatistics->save();

                    // Detach all bookings
                    $reward->bookings()->detach();

                }
            });
    }
}
