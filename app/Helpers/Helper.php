<?php

use Illuminate\Database\Eloquent\Collection;


if (! function_exists('is_max_level')) {
    /**
     * Check whether skill is on max level.
     *
     * Usage:
     * {{ is_max_level($skill->pivot->amount_point, $skill->max_level)? 'Yes': 'No' }}
     * 
     * @param integer ID of skill     
     * @param integer Origin Point of Skill
     * 
     * @return bool
     */
    function is_max_level($point, $maxLevel)
    {                
     	return $point >= $maxLevel? true: false;      
             
    }
}