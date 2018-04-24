<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class AddMissingReferralData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:missing-referral-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add missing referral data for old users';

    /**
     * @var User
     */
    protected $user;

    /**
     * Create a new command instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get all users without referral code
        $users = $this->user->where('referral_code', '')
            ->get();

        // Loop through each user and create a referral code
        foreach($users as $user){
            $user->referral_code = $this->user->createAUniqueReferralCode();
            $user->save();
        }

        // Get all users without referral statistics
        $users = $this->user->doesntHave('referralStatistics')
            ->get();

        // Loop through each user and create a referral statistics
        foreach($users as $user){
            // Create a record in referral statistics with empty values
            $user->referralStatistics()->create([]);
        }
    }
}
