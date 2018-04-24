<?php

namespace App\Console\Commands;

use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AddSkillPointExistingUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:setpoint {user? : ID of user} {--point=15}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to set default point for existing users';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $userId = $this->argument('user');
        $point  = $this->option('point') > 0? $this->option('point'): 15;

        if($userId) {
            $user = User::where('id', $userId)->first();
            $userName = $user->first_name. ' ' . $user->last_name;
            $user->skill_points = $point;
            $user->save();
            $this->line("add {$point} points only to user {$userName}");
        } else {
            $users = User::where('skill_points', 0)->whereDate('created_at', '<', Carbon::now())->get();
            if($users) {
                foreach($users as $user) {
                    $userName = $user->first_name. ' ' . $user->last_name;
                    $user->skill_points = $point;
                    $user->save();
                    $this->line("add {$point} points to user {$userName}");
                }   
            }
        }
    }
}
