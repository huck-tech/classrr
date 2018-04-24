<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    protected $table = 'curriculum';
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        // Set global scope https://laravel.com/docs/5.3/eloquent#query-scopes
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('order');
        });
    }

    public function pretty_duration()
    {
        $pretty_duration_str = '';
        $hours = floor($this['duration'] / 60);
        if ($hours) {
            $pretty_duration_str = $hours . ' ' . trans_choice('hours', $hours) . ' ';
        }
        $minutes = $this['duration'] % 60;
        $pretty_duration_str .= sprintf('%02d', $minutes) . ' '  . trans_choice('mins', $minutes);
        return $pretty_duration_str;
    }

}
