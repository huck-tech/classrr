<?php

namespace App;

use App\Category;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $table = 'skills';

    protected $fillable = [
		'skill_name',
		'skill_icon',
		'skill_slug',
		'description',
		'category_id',
		'category_id',
		'max_level',
	];

	public $timestamps = true;

	/**
	 * Many-to-one
	 *
	 * @return void
	 * @author 
	 **/
	public function category()
	{
		return $this->belongsTo(Category::class, 'category_id');
	}
}
