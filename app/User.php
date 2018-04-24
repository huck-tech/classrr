<?php

namespace App;

use App\NullableTrait;
use App\PrettyDateTrait;
use App\Skill;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Sleimanx2\Plastic\Searchable;
use TCG\Voyager\Traits\VoyagerUser;

class User extends \TCG\Voyager\Models\User
{
    use Notifiable;
    use PrettyDateTrait;
    use NullableTrait;
    use Searchable;   
    // use VoyagerUser; 

    protected $pretty_dates = ['dob'];

    public static $syncDocument = false;
	
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'password_is_empty',
        'first_name', 'last_name', 'about_me', 'dob',
        'phone', 'address', 'city', 'zip_code', 'country_id',
        'avatar_id', 'gender', 'linkedin_id', 'google_id', 'facebook_id',
        'sign_in_count', 'current_sign_in_at', 'last_sign_in_at',
        'referral_code', 'referrer_id','profile_slug',
    ];

    protected $nullable = [
        'country_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    public function profile_avatar()
    {
        return $this->hasOne('App\Image', 'id', 'avatar_id');
    }

    public function classrooms()
    {
        return $this->hasMany('App\Classroom');
    }

    public function reviews()
    {
        return $this->hasManyThrough('App\Review', 'App\Classroom', 'user_id', 'object_id', 'id');
    }

    public function getAvatarPath()
    {
        if ($this->profile_avatar) {
            return asset('storage/' . $this->profile_avatar->path);
        } else {
            return asset('img/empty_avatar_256x256.png');
        }
    }

    public function pretty_name()
    {
        $result = ucfirst(strtolower($this->first_name));
        if ($this->last_name) {
            $result .= ' ' . ucfirst(strtolower($this->last_name));
        }
        return $result;
    }


    /**
     * Responsible for returning user full name or email if name is not given
     *
     * @return string
     */
    public function nameOrEmail(){

        return $this->pretty_name()?:substr($this->email, 0, strpos($this->email, '@'));
    }

//    public function setCountryIdAttribute($value)
//    {
//        if (empty($value)) {
//            $this->attributes['country_id'] = null;
//        } else {
//            $this->attributes['country_id'] = intval($value);
//        }
//    }

    // Set from format "May 1, 1999"
//    public function setDobAttribute($value)
//    {
//        if (empty($value)) {
//            $this->attributes['dob'] = null;
//        } else {
//            $this->attributes['dob'] = Carbon::createFromFormat(config('app.dateformat_php'), $value)->toDateString();
//        }
//    }


    /**
     * Define relation that gets all user booking
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'student_id');
    }

    /**
     * Define relation that gets all user activities
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function activities()
    {
        return $this->hasMany(UserActivity::class);
    }

    /**
     * Define relation that gets all user referral statistics
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function referralStatistics()
    {
        return $this->hasOne(UserReferralStatistic::class);
    }

    /**
     * Define relation that gets all user rewards
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rewards()
    {
        return $this->hasMany(UserReward::class);
    }

    /**
     * Define relation that get user referrer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id', 'id');
    }

    /**
     * Define relation that gets all user invitations
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invitations()
    {
        return $this->hasMany(UserInvitation::class);
    }

    /**
     * Create a unique referral code
     *
     * @return string random string for referral code
     */
    public static function createAUniqueReferralCode()
    {
        // Create random string of 6 character
        $randomString = str_random(6);

        // Check if this random string exist before
        // That may happen very rare but we must be sure
        if(User::where('referral_code', $randomString)->first()){
            $randomString = self::createAUniqueReferralCode();
        }

        return $randomString;

    }

    public function skills() 
    {
        return $this->belongsToMany(Skill::class, 'skill_distributions', 'user_id','skill_id')->withPivot(['amount_point','history_log'])->withTimestamps();;
    }   
}
