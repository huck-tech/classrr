<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $fillable = ['user_email', 'paypal_email'];

    protected $dates = ['created_at', 'updated_at'];
}
