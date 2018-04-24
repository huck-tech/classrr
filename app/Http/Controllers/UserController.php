<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Classroom;
use App\Country;
use App\Http\Requests\StoreProfile;
use App\Image;
use App\Review;
use App\User;
use App\Verification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $current_user = Auth::user();
		
		$pending = Booking::where([
            ['tutor_id', $current_user->id],
			['payment_status', 'authorized']
        ])->count();
		
		$active = Booking::where([
            ['tutor_id', $current_user->id],
			['payment_status', 'in escrow']
        ])->count();
		
		$completed = Booking::where([
            ['tutor_id', $current_user->id],
			['payment_status', 'completed']
        ])->count();
		
		$payout = Booking::where([
            ['tutor_id', $current_user->id],
			['payment_status', 'completed']
        ])->sum('tutor_commission');

        $view_data = [
            'current_user' => $current_user->with('classrooms'),
            'classrooms' => Classroom::where('user_id', $current_user['id'])->paginate(10),
			'pending' => $pending,
			'active' => $active,
			'completed' => $completed,
			'payout' => $payout,
        ];
        return view('user.dashboard', $view_data);

    }
    public function listing()
    {
        $current_user = Auth::user();

        $view_data = [
            'current_user' => $current_user->with('classrooms'),
            'classrooms' => Classroom::where('user_id', $current_user['id'])->paginate(10),
        ];
        return view('user.listing', $view_data);

    }
    public function review($id) {
        $current_user = Auth::user();
        $review_user = User::findOrFail($id);

        $booking = Booking::where([
            ['student_id', $review_user->id],
            ['tutor_id', $current_user->id]
        ])->first();

        $verification_email = Verification::where([
            ['type', 'email'],
            ['user_id', $review_user->id],
            ['is_completed', true],
        ])->exists();

        $verification_phone = Verification::where([
            ['type', 'phone'],
            ['user_id', $review_user->id],
            ['is_completed', true],
        ])->exists();
		
		$bookings = Booking::where([
            ['student_id', $review_user->id],
			['tutor_id', $current_user->id]
        ])->get();

        if (!$booking) throw new HttpException(403, 'You are not authorized to view this page.');

        $documents = Image::where([
            ['user_id', $review_user->id],
            ['image_type', 'document']
        ])->get();

        $view_data = [
            'current_user' => $current_user,
            'review_user' => $review_user,
            'booking' => $booking,
            'documents' => $documents,
            'verification_email' => $verification_email,
            'verification_phone' => $verification_phone,
			'bookings' => $bookings
        ];

        return view('user.review', $view_data);
    }

    public function approve(Request $request)
    {
        $current_user = Auth::user();
        $review_user = User::findOrFail($request->get('student_id'));

        $booking = Booking::where([
            ['student_id', $review_user->id],
            ['tutor_id', $current_user->id]
        ])->first();

        if (!$booking) throw new HttpException(403, 'You are not authorized to view this page.');

        $booking['tutor_approved'] = true;
        $booking->save();

        return response()->json(true);
    }

    public function profile()
    {
        $current_user    = Auth::user();        
        $user            = User::where('id', $current_user->id)->with('skills')->first();
        $user_skills     = $user->getRelation('skills')->toArray();    
        $formated_skills = [];        
      
        if(count($user_skills) > 0) {
            foreach($user_skills as $skill) {
                $origin_point = $skill['pivot']['amount_point'];
                $max_level     = $skill['max_level'];
                $is_max       = $origin_point >= $max_level? true: false;

                $formated_skills[] = [
                    'id'     => $skill['id'], 
                    'name'         => $skill['name'],
                    'origin_point' => $origin_point,
                    'gain_point'   => 0,
                    'is_max'       => $is_max,
                    'max_level'    => $max_level,
                ];
            }
        }                   

        $data_default = [
            'remaining_point'     => $current_user->skill_points, 
            'search_url'          => route('api.search-suggestion-skills.index'),
            'suggestion_save_url' => route('api.search-suggestion-skills.store'),
            'formated_skills'     => $formated_skills,
            'skill_suggestion_url'=> route('api.skill-suggestions.store'),        
        ];
                
        $view_data = [
            'current_user' => $current_user,
            'countries'    => Country::all()->pluck('name', 'id'),            
            'data_default' => $data_default,
            'user_skills'  => $user_skills,
            'user'         => $user,
        ];

        return view('user.profile', $view_data);
    }

    public function account()
    {
        $current_user = Auth::user();

        $documents = Image::where([
            ['user_id', $current_user->id],
            ['image_type', 'document']
        ])->get();

        $verification_email = Verification::where([
            ['type', 'email'],
            ['user_id', $current_user->id],
        ])->first();

        $verification_phone = Verification::where([
            ['type', 'phone'],
            ['user_id', $current_user->id],
        ])->first();

        $view_data = [
            'current_user' => $current_user,
            'verification_email' => $verification_email,
            'verification_phone' => $verification_phone,
            'countries' => Country::all()->pluck('name', 'id'),
            'documents' => $documents
        ];

        return view('user.account', $view_data);
    }
    public function reviews()
    {
        $current_user = Auth::user();

        $view_data = [
            'current_user' => $current_user,
        ];

        $classrooms_ids = Classroom::where('user_id', $current_user['id'])->pluck('id');


        if ($classrooms_ids) {
            $view_data['reviews'] = Review::where('type', 'classroom')
                ->whereIn('object_id', $classrooms_ids)
                ->orderBy('created_at', 'desc')->get();
            $view_data['review_avg'] = $view_data['reviews']->avg('rating');
        }


        return view('user.reviews', $view_data);
    }

    public function studyplan()
    {
        $current_user = Auth::user();

        $classrooms = Classroom::where('user_id', $current_user['id'])->orderBy('id')->get();
        foreach($classrooms as &$classroom) {
            $classroom->loadStudents();
        }

        $bookings = Booking::where([
            ['student_id', $current_user->id],
			['payment_status', 'in escrow']
        ])->get();

        $view_data = [
            'current_user' => $current_user,
            'weekdays' => ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'],
            'classrooms' => $classrooms,
            'bookings' => $bookings
        ];
        return view('user.studyplan', $view_data);
    }

    public function transactions()
    {
        $current_user = Auth::user();

        $transactions = Booking::where('student_id', $current_user->id)->orWhere('tutor_id', $current_user->id)->get();

        $view_data = [
            'current_user' => $current_user,
            'transactions' => $transactions,
        ];
        return view('user.transactions', $view_data);
    }

    public function store(StoreProfile $request)
    {
        //if ($request->get('dob')) {
            //$dob = Carbon::createFromFormat(config('app.dateformat_php'), $request->get('dob'))->toDateString();
            //$request->merge(['dob' => $dob]);
        //}
        $current_user = Auth::user();
        $current_user->fill($request->all());
        //var_dump($current_user); die();
        $current_user->save();
        return redirect()->route('user_profile')->with('status', 'Profile updated!');
    }

    public function sendMessage(Request $request)
    {
        $student_id = $request->get('student_id');
        $message = $request->get('message');
        $student = User::find($student_id);
        $current_user = Auth::user();

        $transaction = Booking::where([
            ['student_id', $student_id],
            ['tutor_id', $current_user->id]
        ])->first();
		
		$classroom_name = Classroom::where([
			['user_id', $current_user->id],
			['id', $transaction->classroom_id]
		])->first();

        if (!$transaction) throw new HttpException(403, 'Not authorized.');

        Mail::send('emails.tutor_contact', [
            'message_txt' => $message,
            'student' => $student,
            'tutor' => $current_user,
            'classroom_name' => $classroom_name], function ($m) use ($student, $current_user) {

            $m->bcc('contact@classrr.com');
            $m->from('noreply@classrr.com', 'Classrr');
			$m->replyTo($current_user->email);
            $m->to($student->email)->subject('A New Message Regarding Your Booking');

        });

        $data = [
            'status' => true
        ];

        return response()->json($data);

    }
	
	public function hub()
    {
        $current_user = Auth::user();
		
		$checkEmail = Verification::where('type', '=', 'email')
                ->where('is_completed', '=', '1')
                ->where('user_id', '=', $current_user->id)
                ->first();
				
		$checkBooking = Booking::where([
            ['student_id', $current_user->id],
            ['payment_status', 'completed']
        ])->first();
				
		$view_data = [
            'checkEmail' => $checkEmail,
			'checkBooking' => $checkBooking,
        ];
        return view('user.hub', $view_data);
    }

    public function deactivate() {
        $current_user = Auth::user();
        User::where('id', $current_user->id)
            ->update(['is_active' => 0]);
        return redirect('/logout');
    }
}
