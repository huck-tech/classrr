<?php

namespace App\Console;

use App\Console\Commands\AddMissingReferralData;
use App\Console\Commands\AddSkillPointExistingUser;
use App\Console\Commands\ApproveEarnedRewards;
use App\Console\Commands\ProfileSlug;
use App\Console\Commands\UpdateBookingStatus;
use App\Console\Commands\UpdateRewardsStatus;
use App\Console\Commands\UpdateUserSkill;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        AddMissingReferralData::class,
        UpdateRewardsStatus::class,
        UpdateBookingStatus::class,
        ApproveEarnedRewards::class,
        ProfileSlug::class,
        UpdateUserSkill::class,
        AddSkillPointExistingUser::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('update:booking-status')->hourly()->withoutOverlapping();
        $schedule->command('update:rewards-status')->hourly()->withoutOverlapping();
        $schedule->command('update:user-skill')->daily()->at('22:00')->withoutOverlapping();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
