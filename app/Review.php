<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = ['user_id', 'type', 'rating', 'object_id', 'comment'];

    protected $dates = ['created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function avgScore($type, $object_id)
    {
        return Review::where([
                ['type', $type],
                ['object_id', $object_id]
            ])
            ->avg('rating');
    }
    public static function countFor($type, $object_id)
    {
        return Review::where([
                ['type', $type],
                ['object_id', $object_id]
            ])
            ->count();
    }
}
