<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Skill;
use App\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AddSocialSkill
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {        
        $skills = Skill::where('name', 'Social Media')->orWhere('name','Facebook')->get();
        $skillIds = $skills->pluck('id')->toArray();

        $user = User::where('id', $event->user->id)->with('skills')->first();
        $userSkillsIds = $user->skills->pluck('id')->toArray();

        $existSkills = count(array_intersect($skillIds, $userSkillsIds)) == 2? true: false;

        $fb = $user->facebook_id;
        $giveSkills = [];

        if($fb AND !$existSkills) {
            if(count($skills)) {
                foreach($skills as $skill) {
                    $giveSkills[$skill->id] = ['amount_point' => $skill->max_level];
                }
            }

            $user->skills()->sync($giveSkills, false);
            session()->flash('status', 'Social Media and Facebook skill has been added');
        }
    }
}
