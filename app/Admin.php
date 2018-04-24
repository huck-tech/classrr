<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use TCG\Voyager\Traits\VoyagerUser;

class Admin extends Authenticatable
{
	use VoyagerUser;
	/**	 
	 * @var string
	 **/
	protected  $table = 'admins';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
		'role_id',
		'email',
		'avatar',
		'fullname',
		'username',
		'password',
    ];
}
