<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ClassroomDuration extends Model
{
    protected static function boot()
    {
        parent::boot();

        // Set global scope https://laravel.com/docs/5.3/eloquent#query-scopes
        static::addGlobalScope('is_active', function (Builder $builder) {
            $builder->where('is_active', true);
        });
    }

}
