<?php

namespace App\Http\Controllers;

use App\Category;
use App\Classroom;
use App\Booking;
use App\ClassroomDuration;
use App\ClassroomLevel;
use App\Country;
use App\Http\Requests\StoreClassroom;
use App\Image;
use App\Lecture;
use App\Mail\InviteTutor;
use App\Message;
use App\Review;
use App\Search;
use App\User;
use App\Verification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\Log;

class ClassroomController extends Controller
{
    public function show($id)
    {
        $classroom = Classroom::where([
            ['id', $id]
        ])->with('skills')->first();
        
        if (!$classroom) throw new HttpException(404, 'Not found.');

        $classroom->load('photos');
        $classroom->load('user');

        $reviews = Review::where([['type', 'classroom'],['is_active', 1], ['object_id', $id]])->get();
		$bookings = Booking::where([['classroom_id', $id]])->get();

        $classroom['rating_value'] = Review::avgScore('classroom', $id);
        $classroom['rating_votes'] = Review::countFor('classroom', $id);
		
		$time = $classroom->getTimeOpen()[0];
        $enrollment_date = $classroom->enrollment_date;
		$classTotals = $classroom->calcTotal($time, $enrollment_date);
		
		$totalPrice = $classTotals['total_price'];
		
		$relatedTeacher = Classroom::where([
            ['user_id', $classroom->user_id]
        ])->inRandomOrder()->take(8)->get(); 
		
		$relatedCategory = Classroom::where([
            ['category_id', $classroom->category_id]
        ])->inRandomOrder()->take(8)->get(); 
		
		$relatedCity = Classroom::where([
            ['city', $classroom->city]
        ])->inRandomOrder()->take(8)->get(); 

        $view_data = [
            'hours' => range(7, 23),
            'weekdays' => ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'],
            'categories' => Category::all()->pluck('name', 'id'),
            'enrollment_dates' => array_keys($classroom->getEnrollmentDates()),
            'time_open' => $classroom->getTimeOpen(),
            'levels' => ClassroomLevel::all()->pluck('title', 'id'),
            'countries' => Country::all()->pluck('name', 'id'),
            'durations' => ClassroomDuration::all()->pluck('title', 'id'),
            'item' => $classroom,
            'reviews' => $reviews,
			'totalPrice' => $totalPrice,
			'relatedTeacher' => $relatedTeacher,
			'relatedCategory' => $relatedCategory,
			'relatedCity' => $relatedCity,
            'bookings' => $bookings,
            'is_active' => $classroom['user']->is_active,
            'search_skill_url' => route('api.search.index'),
            'skills' => $classroom->skills,
        ];

        return view('classroom.show', $view_data);
    }

    public function listAll(Request $request)
    {

        /*
         /classroom/list?lvl_ids=1,3&cat_id=1&day_ids=1,7&time_ids=1,3&price=13;15&q=HA%20HA%20HA&where=Moscow,%20Russia&when=3&duration=2&sort_price=asc&sort_rating=desc
         */
        $builder = Classroom::search();
        $query = $request->all();

        // Query
        if ($request->has('q') || $request->has('where'))  {
            //$builder->must();
            if ($request->has('where')) $builder->must()->match('city_country', $request->get('where'));
            if ($request->has('q')) $builder->multiMatch(['title', 'description'], $request->get('q'));
        }

        // Filters
        if ($request->has('lvl_ids') || $request->has('cat_id') || $request->has('day_ids') || $request->has('time_ids')
            || $request->has('time_ids') || $request->has('duration') || $request->has('when'))
        {
            $builder->filter();

            if ($request->has('lvl_ids')) {
                $lvl_ids = array_map('intval', explode(',', $query['lvl_ids']));
                $builder->filter()->terms('level_id', $lvl_ids);
            }
            if ($request->has('duration')) {
                $builder->filter()->term('duration_id', intval($query['duration']));
            }
            if ($request->has('cat_id') and $request->get('cat_id') > 0) {
                $builder->filter()->term('category_id', intval($query['cat_id']));
            }
            if ($request->has('price')) {
                $price = array_map('intval', explode(';', $query['price']));
                if ($price[0] > 0 && $price[1] >= $price[0]) {
                    $builder->range('base_price', ['gte' => $price[0], 'lte' => $price[1]]);
                }
            }
        }

        // SortBy
        if ($request->has('sort_price')) {
            $builder->sortBy('base_price', ($query['sort_price'] === 'asc' ? 'asc' : 'desc'));
        }

        if ($request->has('sort_rating')) {
            $builder->sortBy('rating_value', ($query['sort_rating'] === 'asc' ? 'asc' : 'desc'));
        }

        $items = $builder->paginate(6);

        foreach($items as &$item) {
            $item['user'] = User::find($item['user_id']);
            // Get classroom
            $classroom = Classroom::find($item['id']);

            if($classroom) {
                // Get first time and enrollment date and use them to get clastotals
                $time = $classroom->getTimeOpen()[0];
                $enrollment_date = $classroom->enrollment_date;
                $classTotals = $classroom->calcTotal($time, $enrollment_date);

                $item['total_price'] = $classTotals['total_price'];

                // Set discount to 0 as a default value
                $item['discount'] = 0;

                // Set has approved rewards to false
                $item['hasApprovedRewards'] = false;

                // Set has not eligible rewards to false
                $item['hasNotEligibleRewards'] = false;

                if ($user = Auth::user()) {

                    //Check if user have any approved reward
                    $approvedRewards = $user->rewards()
                        ->where('status', 'approved')
                        ->get();

                    // Set has approved rewards to true or false
                    $item['hasApprovedRewards'] = count($approvedRewards) ? true : false;

                    // If user have approved reward we should check if this class is eligible to any of them
                    if ($item['hasApprovedRewards']) {

                        // If class price is between $80 to  $900 we should apply max discount of $300
                        if ($classTotals['total_price'] > 80 && $classTotals['total_price'] <= 900) {

                            // Max discount should be equal to the lowest of 300 or the class price
                            $maxDiscount = $classTotals['total_price'] < 300 ? $classTotals['total_price'] : 300;

                        } // Else if class price is greater than $900 we should apply max discount of $500
                        elseif ($classTotals['total_price'] > 900) {
                            $maxDiscount = 500;
                        }

                        // Loop through each reward
                        foreach ($approvedRewards as $reward) {

                            // Check if class is eligible for this reward
                            $eligibleForReward = $classroom->eligibleForReward($reward, $classTotals, $classroom);

                            // If eligible we should use it
                            if ($eligibleForReward) {

                                // Add to discount
                                $item['discount'] += $reward->amount - $reward->used_amount;

                                // If discount is greater than max discount
                                // so we should set discount to max discount and break the loop
                                if ($item['discount'] > $maxDiscount) {

                                    // Set discount to the max discount and
                                    $item['discount'] = $maxDiscount;

                                    // Break the loop as we can't add more discounts than max discount
                                    break;
                                }

                            } else {
                                $item['hasNotEligibleRewards'] = true;
                            }
                        }
                    }

                }
            }else{
                $item['total_price'] = 0;

                // Set discount to 0 as a default value
                $item['discount'] = 0;

                // Set has approved rewards to false
                $item['hasApprovedRewards'] = false;

                // Set has not eligible rewards to false
                $item['hasNotEligibleRewards'] = false;
            }
        }

        try {
            Search::create([
                'query' => substr($request->get('q'), 0, 255),
                'where' => substr($request->get('where'), 0, 255),
                'category_id' => $request->get('cat_id', 0),
                'duration' => $request->get('duration', 0),
                'when' => $request->get('when'),
                'is_result' => count($items) ? true : false,
                'ip_address' => $request->ip(),
                'user_agent' => substr($request->header('User-Agent'), 0, 255),
            ]);
        } catch (\Exception $e) {

        }

        if ($request->ajax()) {
            return view('search.results', ['items' => $items, 'query' => $request->get('q'), 'where' => $request->get('where'), 'category_id' => $request->get('cat_id'), 'when' => $request->get('when'), 'duration' => $request->get('duration')]);
        }
        $view_data = [
            'query' => $request->get('q'),
            'where' => $request->get('where'),
            'when' => $request->get('when'),
			'category_id' => $request->get('cat_id'),
            'duration' => $request->get('duration'),
            'items' => $items,
            'categories' => Category::all(),
            'levels' => ClassroomLevel::all(),
            'weekdays' => [
                'mon' => 'Monday',
                'tue' => 'Tuesday',
                'wed' => 'Wednesday',
                'thu' => 'Thursday',
                'fri' => 'Friday',
                'sat' => 'Saturday',
                'sun' => 'Sunday'],
            'class_time' => ['Morning', 'Afternoon', 'Evening'],
            'price_from' => 4,
            'price_to' => 60,

        ];
        return view('search.search', $view_data);
    }

    public function create()
    {
		if (Auth::check()) {

            $classroom = new Classroom;
            $categories = Category::all()->pluck('name', 'id');
            $data_default = [ 
                'category_id' => $classroom->category_id,
                'skills'      => $classroom->skills,
                'duration_id' => $classroom->duration_id,
            ];
            $view_data = [
                'hours'                => range(7, 23),
                'weekdays'             => ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'],
                'categories'           => $categories,
                'levels'               => ClassroomLevel::all()->pluck('title', 'id'),
                'countries'            => Country::all()->pluck('name', 'id'),
                'durations'            => ClassroomDuration::all()->pluck('title', 'id'),
                'classroom'            => $classroom,
                'search_skill_url'     => route('api.search.index'),
                'skill_suggestion_url' => route('api.skill-suggestions.store'),
                'data_default'         => $data_default,
            ];
            
            $checkEmail = Verification::where('type', '=', 'email')
                ->where('is_completed', '=', '1')
                ->where('user_id', '=', Auth::user()->id)
                ->first();

            if (!$checkEmail) {
                $view_data['email_verified'] = false;
                return view('classroom.create', $view_data)
                    ->withErrors(['Please verify your email address first in order to be able to create a classroom by <a href="'. route('user_account') .'">clicking here</a>']);
            }

            return view('classroom.create', $view_data);
        }else{
			return redirect()->route('get');
		}
    }

    public function edit($id)
    {
        $current_user = Auth::user();

        $classroom = Classroom::with('skills')->findOrFail($id);
                
        if (!$classroom->isEmpty())return redirect()->route('classroom_show', ['id' => $classroom->id])->with('status', 'Sorry, you can\'t modify the class when there is an active booking in the class.');

        if (!Auth::check() || $classroom->user_id !== $current_user->id) throw new HttpException(403, 'You are not authorized to view this page.');

        $photos = DB::table('classroom_photos')->where('classroom_id', $classroom['id'])->orderBy('order')->get();
        //echo "<pre>";var_dump($classroom);die();
        $data_default = [ 
            'category_id' => $classroom->category_id,
            'skills'      => $classroom->skills,
            'duration_id' => $classroom->duration_id,
            'schedule'    => $classroom->schedule,
        ];

        $view_data = [
            'hours'                => range(7, 23),
            'weekdays'             => ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'],
            'categories'           => Category::all()->pluck('name', 'id'),
            'levels'               => ClassroomLevel::all()->pluck('title', 'id'),
            'countries'            => Country::all()->pluck('name', 'id'),
            'durations'            => ClassroomDuration::all()->pluck('title', 'id'),
            'photos'               => $photos,
            'classroom'            => $classroom,
            'search_skill_url'     => route('api.search.index'),
            'skill_suggestion_url' => route('api.skill-suggestions.store'),
            'data_default'         => $data_default,
        ];        

        return view('classroom.edit', $view_data);
    }

    public function store(StoreClassroom $request)
    {
        $current_user = Auth::user();

        if ($request->get('id')) {
            $classroom = Classroom::findOrFail($request->get('id'));
            if ($classroom->user_id !== $current_user->id) throw new HttpException(403, 'You are not authorized to view this page.');
        } else {
            $classroom = new Classroom;
        }

        $classroom->user_id = $current_user->id;
        $classroom->fill($request->all());

        switch($request->get('pricing')) {
            case 'fixed':
                $classroom['base_price'] = $request->get('base_price_fixed');
                break;
            case 'flexible':
                $classroom['base_price'] = $request->get('base_price_flexible');
                break;
        }

        $classroom['schedule'] = json_decode($request->get('schedule_json'), true);

		$classroom->slug = str_slug($classroom->title);
        $storeClassroom = $classroom->save();

        if (!empty($classroom['associated_tutors'])) {
            $raw_emails = explode(', ', $classroom['associated_tutors']);
            $emails = [];
            foreach ($raw_emails as $raw_email) {
                $raw_email = trim($raw_email);
                if(filter_var($raw_email, FILTER_VALIDATE_EMAIL)) $emails[] = $raw_email;
            }
            // Send invations
            try {
	            Mail::to($emails)->send(new InviteTutor($classroom))->from('noreply@classrr.com', 'Classrr');
            } catch (\Exception $e) {
	            Log::error('Exception: Can\'t send emails: ', $emails);
            }
        }

        $curriculum = $request->get('lecture');
        $later = $request->get('curriculum_later');

        if (is_array($curriculum) && !$later) {
            foreach($curriculum as $id => $lecture) {
                if (substr($id, 0, 3) === 'new') {
                    Lecture::create([
                        'classroom_id' => $classroom['id'],
                        'order' => $lecture['order'],
                        'title' => $lecture['title'],
                        'description' => $lecture['description'],
                        'duration' => (int)$lecture['duration'],
                    ]);
                } elseif (is_numeric($id)) {
                    $old = Lecture::find($id);
                    if ($old) {
                        $old->fill([
                            'classroom_id' => $classroom['id'],
                            'order' => $lecture['order'],
                            'title' => $lecture['title'],
                            'description' => $lecture['description'],
                            'duration' => (int)$lecture['duration'],
                        ])->save();
                    }
                }
            }
        }

        $remove_lecture = $request->get('remove_lecture');
        if (is_array($remove_lecture) && $remove_lecture) {
            Lecture::where('classroom_id', $classroom['id'])
                ->whereIn('id', $remove_lecture)
                ->delete();
        }

        DB::table('classroom_photos')->where('classroom_id', $classroom['id'])->delete();
        $order = 0;
        $photos_ids = $request->get('photos_ids');

        if (is_array($photos_ids) && $photos_ids) {
            $first_thumb = Image::find($photos_ids[0]);
            $classroom->thumb_path = 'images/600x400_' . $first_thumb->name;
            $classroom->save();

            foreach($photos_ids as $image_id) {
                DB::table('classroom_photos')
                    ->insert(['classroom_id' => $classroom['id'], 'image_id' => (int)$image_id, 'order' => $order++]);
            }
        }

        // Storing the skill into pivot table classroom skill     
        $formSkills = $request->input('skills');
        $inputSkills = [];

        if($formSkills != '') {
            $inputSkills = explode(',', $formSkills);
        }
        $skills = [];
        $gainedPoint = 1;

        if(count($inputSkills) > 0) {
            foreach($inputSkills as $itemSkill) {
                $skills[ $itemSkill ] = ['detail' => 'Student will get '. $gainedPoint. ' point(s) after finishing this class', 'amount_point' => $gainedPoint];
            }

        }
        
        $storeSkills = Classroom::where('id', $classroom['id'])->firstOrFail();
        $storeSkills->skills()->sync($skills, true);

        return redirect()->route('classroom_show', ['id' => $classroom->id])->with('status', 'Congratulations on the creation of your class. Now let&apos;s give it some more love by sharing it to the world.');
    }

    /**
     * Resposible for contacting classroom.
     *
     * @param Request $request
     * @param $classroomId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     * @internal param $roomId
     */
    public function contactClassroom(Request $request, $classroomId)
    {
        // Validate inputs
        $this->validate($request, [
            'message' => 'required|min:1|max:2500'
        ]);

        // Get current user
        $currentUserId = Auth::user()->id;

        $checkEmail = Verification::where('type', '=', 'email')
            ->where('is_completed', '=', '1')
            ->where('user_id', '=', $currentUserId)
            ->first();

        if (!$checkEmail) {
            return redirect()->route('user_account')
                ->withErrors(['Please verify your email address first in order to be able to contact a teacher']);
        }

        // Get classroom
        $classroom = Classroom::find($classroomId);

        if($currentUserId == $classroom->user_id){

            // Redirect to user messages
            return redirect(route('classroom_show', [$classroom->id]))
                ->withErrors(['You cannot contact a classroom where you are the teacher']);
        }

        // Check if this user already contacting this classroom
        $message = Message::where(function($query) use($currentUserId, $classroom) {

                $query->where(function ($query) use ($currentUserId, $classroom) {
                    $query->where('sender_id', $currentUserId)
                        ->where('receiver_id', $classroom->user_id);
                })
                ->orWhere(function ($query) use ($currentUserId, $classroom) {
                    $query->where('sender_id', $classroom->user_id)
                        ->where('receiver_id', $currentUserId);
                });
            })
            ->where('messageable_id', $classroomId)
            ->where('messageable_type', 'classroom')
            ->first();


        // If no previous message so we should create new one
        if(!$message) {
            $message = $classroom->messages()->create([
                'title' => $classroom->title,
                'sender_id' => $currentUserId,
                'receiver_id' => $classroom->user_id
            ]);
        }

        if($message->archived_at){
            // Redirect to user messages
            return redirect(route('user_message', ['message_id' => $message->id]))
                ->withErrors(['Sorry, this message has been archived and you cannot send or receive messages anymore!']);
        }

        // Create new reply with the contact message
        $message->replies()
            ->create([
                'sender_id' => $currentUserId,
                'text' => $request->get('message')
            ]);

        // Redirect to user messages
        return redirect(route('user_message', ['message_id' => $message->id]));
    }
}
