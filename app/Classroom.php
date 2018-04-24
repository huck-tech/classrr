<?php

namespace App;

use App\Skill;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Mockery\CountValidator\Exception;
use Sleimanx2\Plastic\Searchable;


class Classroom extends Model
{
    use Searchable;
    use PrettyDateTrait;
    use NullableTrait;

    const CANCELLATION = [
        '1' => 'Flexible',
        '2' => 'Moderate',
        '3' => 'Strict'
    ];
    
    // const PAYMENT_FEE = 0.05; // 5%

    protected $students = [];
    protected $time_open = [];

    protected $pretty_dates = ['enrollment_date'];

    //protected $nullable = ['level_id', 'duration_id'];

    protected $fillable = [
            'user_id',
            'category_id',
            'level_id',
            'title',
            'slug',
            'thumb_path',
            'description',
            'number_student',
            'country_id',
            'address_1',
            'address_2',
            'city',
            'state',
            'zip_code',
            'lat',
            'lng',
            'location_comments',
            'pricing',
            'base_price',
            'price_morning',
            'price_afternoon',
            'price_evening',
            'add_weekend_fee',
            'price_weekend',
            'duration_id',
            'enrollment_date',
            'schedule',
            'late_signup',
            'language',
            'cancellation_policy',
            'is_guaranteed',
            'is_international',
            'age_range',
            'associated_tutors',
            'rating_value',
            'rating_votes',
            'rules',
            'created_at',
            'updated_at',
    ];

    //TODO: Convert it to fillable
    // protected $guarded = ['created_at', 'updated_at', 'schedule_json', 'lecture',
        // 'base_price_fixed', 'base_price_flexible', 'remove_lecture', 'image', 'photos_ids', 'curriculum_later'];

    protected $casts = [
        'rules' => 'array',
        'schedule' => 'array',
        'level_id' => 'integer',
        'duration_id' => 'integer',
        'category_id' => 'integer',
        'avatar_id' => 'integer',
    ];

    protected $formatted_schedule;

    /**     
     * @var array
     **/
    protected $appends = ['start_date'];

    //public static $syncDocument = true; 

    protected static function boot()
    {
        parent::boot();

        // Set global scope https://laravel.com/docs/5.3/eloquent#query-scopes
        static::addGlobalScope('created_at', function (Builder $builder) {
            $builder->orderBy('created_at', 'desc');
        });
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function level()
    {
        return $this->belongsTo('App\ClassroomLevel', 'level_id');
    }

    public function duration()
    {
        return $this->belongsTo('App\ClassroomDuration', 'duration_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function country()
    {
        return $this->belongsTo('App\Country');
    }

    public function booking()
    {
        return $this->hasOne('App\Booking');
    }

    public function photos()
    {
        return $this->belongsToMany('App\Image', 'classroom_photos', 'classroom_id', 'image_id');
    }

    public function curriculum()
    {
        return $this->hasMany('App\Lecture');
    }

    /**
     * Get all of the classroom's messages.
     */
    public function messages()
    {
        return $this->morphMany('App\Message', 'messageable');
    }

    public function seTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug(substr($value, 0, 80));
    }

    public function getFormattedSchedule()
    {
        if (!isset($this['schedule'])) return null;

        if (isset($this->formatted_schedule) and $this->formatted_schedule) return $this->formatted_schedule;

        // $this['schedule'][$weekday] - is plain array of hours like [7,8,9,13,14,19,20,21]
        // we need to split it to array like ['morning' => ['from' => 7, 'to' = 10], <...>]
        // in view it would be "Morning from 7:00 to 10:00"
        // Morning is 7 <= HOUR <= 12
        // Afternoon is 13 <= HOUR <= 17
        // Evening is 18 <= HOUR
        $this->formatted_schedule = [];
        foreach ($this['schedule'] as $weekday => $hours) {
            $result = [];
            $size = count($hours);
            for ($i = 0; $i < $size; $i++)  {
                if (7 <= $hours[$i] and $hours[$i] <= 12) {
                    $result['morning']['from'] = $hours[$i];
                    $result['morning']['to'] = $hours[$i] + 1;
                    for ($j = $i + 1; $j < $size and $hours[$j] == $hours[$i] + 1; $j++) {
                        $i = $j;
                        $result['morning']['to'] = $hours[$j] + 1;
                    }
                } elseif (13 <= $hours[$i] and $hours[$i] <= 17) {
                    $result['afternoon']['from'] = $hours[$i];
                    $result['afternoon']['to'] = $hours[$i] + 1;
                    for ($j = $i + 1; $j < $size and $hours[$j] == $hours[$i] + 1; $j++) {
                        $i = $j;
                        $result['afternoon']['to'] = $hours[$j] + 1;
                    }

                } else {
                    $result['evening']['from'] = $hours[$i];
                    $result['evening']['to'] = $hours[$i] + 1;
                    for ($j = $i + 1; $j < $size and $hours[$j] == $hours[$i] + 1; $j++) {
                        $i = $j;
                        $result['evening']['to'] = $hours[$j] + 1;
                    }
                }
            }
            $this->formatted_schedule[$weekday] = $result;
        }
        return $this->formatted_schedule;
    }


    public function getEnrollmentDates()
    {
        if (!isset($this['enrollment_date'])) return null;
        $ed = Carbon::createFromFormat(config('app.dateformat_php'), $this['enrollment_date']);
        $enrollment_dates = [];

        // Class will run within 1 year since enrollment date
        // If class duration is 1 Month => then class will run 12 times
        // If class duration is 3 Month => then class will run 4 times
        $enrollments_per_year = round(360 / $this->duration->days);
        for ($i = 0; $i < $enrollments_per_year; $i++) {
            $enrollment_dates[$ed->toDateString()] = $ed->year . '-' . sprintf('%02d', $ed->month);
            $ed->addDays($this->duration->days);
        }

        return $enrollment_dates;
    }

    public function getCurrentEnrollmentDate()
    {
        return $this['duration']['title'];
    }
    public function getFinalPrice()
    {
        return 1;
    }

    public function getTimeOpen()
    {
        if ($this->time_open) return $this->time_open;
        $formatted_schedule = $this->getFormattedSchedule();
        $time_open = [];
        foreach ($formatted_schedule as $weekday) {
            $time_open = array_merge($time_open, array_keys($weekday));
            //if (count($time_open) == 3) break; // break if $time_open have all: morning, afternoon and evening
        }
        $this->time_open = array_values(array_unique($time_open));
        // We need to get values because otherwise it turns into an json object for some damn reason
        return $this->time_open;
    }

    public function isOpenAt($day_time)
    {
        $time_open = $this->getTimeOpen();
        return (array_search($day_time, $time_open) !== false);
    }

    public function buildDocument()
    {
        $formatted_schedule = $this->getFormattedSchedule();
        $weekdays_open = array_keys($formatted_schedule);
        $time_open = $this->getTimeOpen();
		$rating_value = $this->getReviewValue();
		$rating_votes = $this->getReviewVotes();

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'category_id' => $this->category_id,
            'level_id' => $this->level_id,
            'duration_id' => $this->duration_id,
            'base_price' => $this->base_price,
            'rating_value' => (float)$rating_value,
			'rating_votes' => $rating_votes,
            'thumb_path' => $this->thumb_path,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
			'state' => $this->state,
            'city' => $this->city,
			'lat' => $this->lat,
			'lng' => $this->lng,
            'country_name' => $this->country->name,
            'city_country' => $this->city . ', ' . $this->state . ', ' . $this->country->name,
            'weekdays_open' => $weekdays_open,
            'time_open' => $time_open,
            'enrollment_date' => $this->enrollment_date,
            'is_active' => true
        ];
        ///classroom/list?lvl_ids=1,3&cat_id=1&day_ids=1,7&time_ids=1,3&price=13;15&q=HA%20HA%20HA&where=Moscow,%20Russia&when=3&duration=2&sort_price=asc&sort_rating=desc

    }

    public function calcTotal($time, $enrollment_date)
    {
        $result = [];
        $enrollment_dates = $this->getEnrollmentDates();
        $schedule = $this->getFormattedSchedule();
        $total_duration = $this->duration->days;
        $time_open = $this->getTimeOpen();
        if (!in_array($time, $time_open)) { throw new Exception('Wrong schedule time.'); }
        //if (!isset($enrollment_dates[$enrollment_date])) { throw new Exception('Wrong enrollment date.'); }

        $current_day = Carbon::parse($enrollment_date);
        $weekdays = [
            1 => 'mon',
            2 => 'tue',
            3 => 'wed',
            4 => 'thu',
            5 => 'fri',
            6 => 'sat',
            7 => 'sun',
        ];

        if ($this->pricing === 'fixed') {
            $total_hours = 0;
            $total_days = 0;
            $base_price = $this->base_price;
            for ($i = 0; $i < $total_duration; $i++) {
                $wd = $weekdays[$current_day->dayOfWeek+1];
                // If there is a class in current day
                if (isset($schedule[$wd][$time])) {
                    $total_hours += $schedule[$wd][$time]['to'] - $schedule[$wd][$time]['from'];
                    $total_days++;
                }
                $current_day->addDay();
            }
            $result = [
                'pricing' => $this->pricing,
                'total_hours' => $total_hours,
                'total_days' => $total_days,
                'base_price' => $base_price,
                'total_price' => $total_hours * $base_price
            ];
        } else {
            $weekend_hours = 0;
            $total_hours = 0;
            $total_days = 0;
            $total_price = 0;
            $price_key = 'price_' . $time;
            $base_price = $this->base_price + $this[$price_key];
            for ($i = 0; $i < $total_duration; $i++) {
                $wd = $weekdays[$current_day->dayOfWeek+1];
                // If there is a class in current day
                if (isset($schedule[$wd][$time])) {
                    $hours = $schedule[$wd][$time]['to'] - $schedule[$wd][$time]['from'];
                    $total_hours += $hours;
                    if ($this->add_weekend_fee and $this->price_weekend > 0 and in_array($wd, ['sat', 'sun'])) {
                        $total_price += $hours * ($base_price + $this['price_weekend']);
                        $weekend_hours += $hours;
                    } else {
                        $total_price += $hours * $base_price;
                    }
                    $total_days++;
                }
                $current_day->addDay();
            }
            $result = [
                'pricing' => $this->pricing,
                'total_hours' => $total_hours,
                'total_days' => $total_days,
                'base_price' => $base_price,
                'total_price' => $total_price,
                'weekend_hours' => $weekend_hours,
                'weekend_fee' => $this->price_weekend,
            ];
        }

        if (App::environment('local', 'development')) {
//            $result['total_price'] = '1';
        }
        
        /*
		if (self::PAYMENT_FEE) {
            $result['price_before'] = $result['total_price'];
			$result['total_price'] = $result['total_price'] + $result['total_price'] * self::PAYMENT_FEE;
			$result['fee'] = self::PAYMENT_FEE;
		}
        */

        return $result;
    }

    public function loadStudents()
    {
        $bookings = Booking::where([
            ['classroom_id', $this->id],
			['payment_status', 'in escrow']
        ])->with('student')->get();

        foreach($bookings as $booking) {
            $this->students[$booking->day_time][] = $booking;
        }
    }

    public function getStudents($day_time)
    {
        if (isset($this->students[$day_time]) && $this->students[$day_time]) {
            return $this->students[$day_time];
        } else {
            return [];
        }
    }

    public function isEmpty()
    {
        $bookings = Booking::where([
            ['classroom_id', $this->id],
			['payment_status', 'in escrow']
        ])->exists();

        return !$bookings;
    }
    
    public function getThumb()
    {
	    if (!$this->thumb_path) return asset('img/tour_box_2.jpg');
	    
	    return asset('storage/' . $this->thumb_path);
    }
	
	public function getReviewValue()
    {
	    $this->rating_value = Review::avgScore('classroom', $this->id);
	    
	    return $this->rating_value;
    }
	
	public function getReviewVotes()
    {
	    $this->rating_votes = Review::countFor('classroom', $this->id);
	    
	    return $this->rating_votes;
    }

    /**
     * Get tutor fee percentage
     *
     * @return float
     */
    public function getFeePercentage()
    {
        $user = Auth::user();

        $bookedWithThisTeacherBefore = $user->bookings()
            ->where('tutor_id', $this->user_id)
            ->where('payment_status', 'completed')
            ->exists();

        if($bookedWithThisTeacherBefore){
            return 0.10; // 10%
        }

        return 0.20; // 20%
    }

    /**
     * Check if this class is eligible for this reward
     *
     * @param $reward
     * @param $booking
     * @param null $classroom
     * @return bool
     */
    public function eligibleForReward($reward, $booking, $classroom = null)
    {
        if($classroom) {
            // Check if reward is coming from referrer and this is his classroom
            if ($reward->related_type == 'referrer' && $classroom->user_id == $reward->related_id) {
                return false;
            }
        }

        // If total hours less than 8 return false
        if ($booking['total_hours'] < 8) {
            return false;
        }

        // If total classes less than 4  return false
        if ($booking['total_days'] < 4) {
            return false;
        }

        // If total price less than 80  return false
        if ($booking['total_price'] < 80) {
            return false;
        }

        // If number of students less than 4 return false
        if ($this->number_student < 4) {
            return false;
        }

        return true;
    }

    /**
     * Responsible for getting the class total price
     *
     */
    public function getTotalPrice()
    {
        $schedule = $this->getFormattedSchedule();
        $total_duration = $this->duration->days;
        $time = $this->getTimeOpen()[0];
        $enrollment_date = $this->enrollment_date;
        $current_day = Carbon::parse($enrollment_date);
        $weekdays = [
            1 => 'mon',
            2 => 'tue',
            3 => 'wed',
            4 => 'thu',
            5 => 'fri',
            6 => 'sat',
            7 => 'sun',
        ];

        if ($this->pricing === 'fixed') {
            $total_hours = 0;
            $base_price = $this->base_price;
            for ($i = 0; $i < $total_duration; $i++) {
                $wd = $weekdays[$current_day->dayOfWeek+1];
                // If there is a class in current day
                if (isset($schedule[$wd][$time])) {
                    $total_hours += $schedule[$wd][$time]['to'] - $schedule[$wd][$time]['from'];
                }
                $current_day->addDay();
            }

            $total_price = $total_hours * $base_price;

        } else {
            $total_price = 0;
            $price_key = 'price_' . $time;
            $base_price = $this->base_price + $this[$price_key];
            for ($i = 0; $i < $total_duration; $i++) {
                $wd = $weekdays[$current_day->dayOfWeek+1];
                // If there is a class in current day
                if (isset($schedule[$wd][$time])) {
                    $hours = $schedule[$wd][$time]['to'] - $schedule[$wd][$time]['from'];
                    if ($this->add_weekend_fee and $this->price_weekend > 0 and in_array($wd, ['sat', 'sun'])) {
                        $total_price += $hours * ($base_price + $this['price_weekend']);
                    } else {
                        $total_price += $hours * $base_price;
                    }
                }
                $current_day->addDay();
            }
        }

        return $total_price;
    }

    public function skills() 
    {
        return $this->belongsToMany(Skill::class, 'skill_classroom', 'classroom_id','skill_id')->withPivot('amount_point');
    }

    /**
     * Start Date
     *
     * @return void
     * @author 
     **/
    public function getStartDateAttribute()
    {
        return Carbon::parse($this->enrollment_date);
    }

	/*
    public static function dontSyncDocument()
    {
        static::$syncDocument = false;            
    }
	*/
}
