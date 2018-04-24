<?php

namespace App;

use App\Skill;
use Illuminate\Database\Eloquent\Model;

class SkillDistribution extends Model
{
	protected $table = 'skill_distributions';

	protected $fillable = [
		'skill_id',
		'user_id',
		'details',
		'amount_point',
		'history_log',
	];

	public $timestamps = true;
	/**
	 * Relation many-to-one
	 *
	 * @return void
	 * @author 
	 **/
	public function skill()
	{
		return $this->belongsTo(Skill::class,'skill_id');
	}
}
