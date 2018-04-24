<?php

namespace App\Console\Commands;

use App\Booking;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateBookingStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:booking-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update booking status';

    /**
     * @var Booking
     */
    protected $booking;

    /**
     * Create a new command instance.
     *
     * @param Booking $booking
     */
    public function __construct(Booking $booking)
    {
        parent::__construct();
        $this->booking = $booking;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // If payment is in escrow and exceeded the start_date with less than 1 day
        // and class is not guaranteed change status to class_in_progress
        // or if payment is in escrow and exceeded the start_date with less than 7 days
        // and class is guaranteed change status to class_in_progress
        $this->booking
            ->where(function ($query){
                $query->where('payment_status', 'in escrow')
                    ->where('start_date', '<', Carbon::now())
                    ->where('start_date', '>', Carbon::now()->subDay())
                    ->whereHas('classroom', function($query){
                        $query->where('is_guaranteed', 0);
                    });
            })
            ->orWhere(function($query){
                $query->where('payment_status', 'in escrow')
                    ->where('start_date', '<', Carbon::now())
                    ->where('start_date', '>', Carbon::now()->subDays(7))
                    ->whereHas('classroom', function($query){
                        $query->where('is_guaranteed', 1);
                    });
            })
            ->update(['payment_status' => 'class_in_progress']);


        // If payment is in escrow or class_in_progress and exceeded the start_date with more than 1 day
        // and class is not guaranteed change status to completed
        // or if payment is in escrow or class_in_progress and exceeded the start_date with more than 7 days
        // and class is guaranteed change status to completed
        // Also update related reward if any
        $this->booking
            ->where(function ($query){
                $query->whereIn('payment_status', ['in escrow', 'class_in_progress'])
                    ->where('start_date', '<', Carbon::now()->subDay())
                    ->whereHas('classroom', function($query){
                        $query->where('is_guaranteed', 0);
                    });
            })
            ->orWhere(function($query){
                $query->whereIn('payment_status', ['in escrow', 'class_in_progress'])
                    ->where('start_date', '<', Carbon::now()->subDays(7))
                    ->whereHas('classroom', function($query){
                        $query->where('is_guaranteed', 1);
                    });
            })
            ->chunk(100, function ($bookings){

                // Loop through bookings and update it and related data
                foreach($bookings as $booking) {

                    // Update status to completed
                    $booking->update(['payment_status' => 'completed']);

                    // Get booking student in if condition to avoid missing students
                    if ($student = $booking->student) {

                        // If has referrer get it
                        if ($student->referrer_id && ($referrer = $student->referrer)) {

                            // Get referrer rewards
                            $reward = $referrer->rewards()
                                ->where('status', 'pending')
                                ->where('required_action', 'book_first_class')
                                ->where('related_type', 'referral')
                                ->where('related_id', $student->id)
                                ->first();

                            // If we found a related reward
                            if($reward) {
                                // Get related classroom
                                $classroom = $booking->classroom;

                                // Get class totals
                                $classTotals = $classroom->calcTotal($booking->day_time, $booking->start_date);

                                // Check if class is eligible for this reward
                                $eligibleForReward = $classroom->eligibleForReward($reward, $classTotals);

                                // If eligible we should use it
                                if ($eligibleForReward) {
                                    $reward->update(['status' => 'earned']);

                                    // Get user referral Statistics
                                    $referralStatistics = $referrer->referralStatistics;

                                    // Deduct reward amount from statistics pending
                                    $referralStatistics->pending = $referralStatistics->pending - $reward->amount;

                                    // Add reward amount to statistics earned
                                    $referralStatistics->earned = $referralStatistics->earned + $reward->amount;

                                    // Save
                                    $referralStatistics->save();
                                }
                            }
                        }
                    }

                    // Get booking tutor in if condition to avoid missing tutors
                    if ($tutor = $booking->tutor) {

                        // If has referrer get it
                        if ($tutor->referrer_id && ($referrer = $tutor->referrer)) {

                            // Get referrer rewards
                            $reward = $referrer->rewards()
                                ->where('status', 'pending')
                                ->where('required_action', 'create_first_class')
                                ->where('related_type', 'referral')
                                ->where('related_id', $tutor->id)
                                ->first();

                            // If we found a related reward
                            if($reward) {
                                // Get related classroom
                                $classroom = $booking->classroom;

                                // Calculate class totals
                                $classTotals = $classroom->calcTotal($booking->day_time, $booking->start_date);

                                // Check if class is eligible for this reward
                                $eligibleForReward = $classroom->eligibleForReward($reward, $classTotals);

                                // If eligible we should use it
                                if ($eligibleForReward) {
                                    $reward->update(['status' => 'earned']);

                                    // Get user referral Statistics
                                    $referralStatistics = $referrer->referralStatistics;

                                    // Deduct reward amount from statistics pending
                                    $referralStatistics->pending = $referralStatistics->pending - $reward->amount;

                                    // Add reward amount to statistics earned
                                    $referralStatistics->earned = $referralStatistics->earned + $reward->amount;

                                    // Save
                                    $referralStatistics->save();
                                }
                            }

                        }
                    }

                }
            });
    }
}
