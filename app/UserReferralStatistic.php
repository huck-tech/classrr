<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserReferralStatistic extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'clicks',
        'referrals',
        'earned',
        'approved',
        'used'
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
}
