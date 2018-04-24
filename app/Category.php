<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

	protected $fillable = [
		'slug',
		'name',
		'description',
		'icon',
		'is_active',
	];
}
