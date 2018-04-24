<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class ProfileSlug extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:profileslug';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill column profile_slug which is null or empty in tables users ';

    /**
     * @var User
     */
    protected $user;

    /**
     * Create a new command instance.
     *
     * @return void
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
        $users = $this->user->whereNull('profile_slug')->orWhere('profile_slug', '')->get();

        if(count($users)) {
            $bar = $this->output->createProgressBar(count($users));
            foreach($users as $user) {                
                $fullname = $user->first_name. ' '. $user->last_name;
                $slug     = str_slug($fullname);

                $checkSlug = User::where('profile_slug', $slug)->first();

                if($checkSlug) {
                    $slug .= $user->id;
                }
                
                $user->profile_slug = $slug;
                $user->save();

                $bar->advance();
            }
            $this->line('Users table column profile_slug updated');
            $bar->finish();
        }
    }
}
