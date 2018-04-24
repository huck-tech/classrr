<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Booking extends Model
{
    use PrettyDateTrait;

    //const PAYMENT_FEE = 0.05;
    const SERVICE_FEE = 0.20;
    
    protected $pretty_dates = ['start_date'];

    public $syncDocument = false;

    protected $fillable = [
        'uid',
        'student_id',
        'classroom_id',
        'tutor_id',
        'tutor_approved',
        'price',
        'student_fee',
        'tutor_commission',
        'gross_revenue',
        'day_time',
        'start_date',
        'payment_id',
        'payment_method',
        'payment_status',
        'payment_data',
        'currency_code',
        'student_reviewed_at',
        'student_review',
        'student_comment',
        'tutor_reviewed_at',
        'tutor_review',
        'tutor_comment',
        'payout_method',
        'payout_details',
        'pricing',
        'cancelled_reason',
        'tutor_report',
        'student_report',
    ];

    /**     
     * @var array
     **/
    protected $appends = ['begin_date'];

    public function classroom()
    {
        return $this->belongsTo('App\Classroom', 'classroom_id');
    }
    public function student()
    {
        return $this->belongsTo('App\User', 'student_id');
    }
    public function tutor()
    {
        return $this->belongsTo('App\User', 'tutor_id');
    }

    /**
     * Get all of the booking's messages.
     */
    public function message()
    {
        return $this->morphOne('App\Message', 'messageable');
    }
    
    public function getPriceWithFees() {
	    return $this->price * (1 - self::SERVICE_FEE);
    }

    /**
     * Check if current user already added report for this booking
     */
    public function isReportedByCurrentUser()
    {
        // Get current user id
        $userId = Auth::user()->id;

        // If current user id equal tutor id and tutor report is given return true
        if($this->tutor_id == $userId && $this->tutor_report){
            return true;
        }elseif($this->student_id == $userId && $this->student_report){
            return true;
        }

        return false;
    }

    /**
     * Define relation that gets booking used rewards
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function rewards()
    {
        return $this->belongsToMany(UserReward::class, 'booking_reward', 'booking_id', 'reward_id')
            ->withPivot(['used_amount']);
    }

    /**
     * Start Date
     *
     * @return void
     * @author 
     **/
    public function getBeginDateAttribute()
    {
        return Carbon::parse($this->start_date);
    }
}
