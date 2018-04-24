<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdminCategory extends Model
{
    
	/**	 
	 * @var string
	 **/
	protected  $table = 'admin_categories';
	
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'parent_id',
		'order',
		'name',
		'slug',
    ];
}
