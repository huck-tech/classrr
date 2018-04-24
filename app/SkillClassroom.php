<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SkillClassroom extends Model
{
    protected $table = 'skill_classroom';

	protected $fillable = [
		'skill_id',
		'classroom_id',
		'detail',
		'amount_point',
		'related_booking_id',
	];
	
	public $timestamps = true;

}
