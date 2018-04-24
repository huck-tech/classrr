<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
use App\Skill;
use App\SkillDistribution;
use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class AddDisciplineSkill
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
     * @param  UserLoggedIn  $event
     * @return void
     */
    public function handle(UserLoggedIn $event)
    {        
         $discipline = $this->discipline();
         $skills = $this->skills();        

         if($discipline) {
            $disciplineId = $discipline['id'];

            if(in_array($disciplineId, $skills['ids'])) {                             
                // Check if discipline skill hasn't reach max yet
                $originPoint = $skills['points'][$disciplineId];
                $maxPoint = $discipline['max'];

                if($originPoint < $maxPoint ) {
                    $hasBeenAdded = SkillDistribution::where('user_id', auth()->user()->id)
                                ->where('skill_id', $disciplineId)
                                ->whereDate('updated_at', Carbon::today())
                                ->first();
                                                
                    if(! $hasBeenAdded) {                        
                        $gainPoint = $originPoint + 1;
                        $this->addDisciplinePoint($gainPoint, $disciplineId);
                    }
                }
            } else {
                $this->addDisciplinePoint(1, $disciplineId);
            }


        }
    }

    /**
     * Add discipline point dayly after user logged in
     *
     * @return bool
     * @author 
     **/
    public function addDisciplinePoint($gainPoint, $skillId)
    {            
        $newData = [$skillId => ['amount_point' => $gainPoint]];
        $user    = User::where('id', auth()->user()->id)->first();
        $user->skills()->sync($newData, false);
        return true;        
    }

    /**
     * Get Skill of logged in user
     *
     * @return array
     * @author 
     **/
    public function skills()
    {
        $points = auth()->user()->skills->pluck('pivot.amount_point','id')->toArray();
        $ids    = auth()->user()->skills->pluck('id')->toArray();
        $max    = auth()->user()->skills->pluck('max_level','id')->toArray();

        return ['points' => $points, 'ids' => $ids, 'max' => $max];
    }

    /**
     * Get Skill Discipline
     *
     * @return null|array
     * @author 
     **/
    public function discipline()
    {
        $api = Skill::where('name','discipline')->first();
        $id  = $api->id?$api->id: null;
        $max = $api? $api->max_level: null;

        if($api) {
            return ['id' => $id, 'max' => $max];
        }
        return null;
    }
}
