<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SkillSuggestion extends Model
{
    protected $table = 'skill_suggestions';

    protected $fillable = [
		'user_id',
		'skill_name'		
	];
}
