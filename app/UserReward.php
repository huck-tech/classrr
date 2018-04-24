<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReward extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'amount',
        'required_action',
        'status',
        'related_type',
        'related_id',
    ];

    /**
     * Define the relation that get the related user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::Class);
    }

    /**
     * Define relation that gets bookings that used this reward
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function bookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_reward', 'reward_id', 'booking_id')
            ->withPivot(['used_amount']);
    }
}
