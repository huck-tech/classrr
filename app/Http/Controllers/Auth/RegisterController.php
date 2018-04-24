<?php

namespace App\Http\Controllers\Auth;

use App\Events\ReferralAdded;
use App\Events\UserLoggedIn;
use App\Events\UserRegistered;
use App\User;
use Illuminate\Http\Request;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|min:2|max:30',
            'last_name' => 'required|max:30',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'referral_code' => User::createAUniqueReferralCode(),            
        ]);

    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return void
     */
    protected function registered(Request $request, $user)
    {
        // Create a record for registered user in referral statistics table
        // with no values as default equal 0
        $user->referralStatistics()->create([]);

        // Check if registered by referral
        $this->checkForReferrer($user);

        // Fire user registered event
        event(new UserRegistered($user));

        // Fire user logged in event as we login user after registering successfully
        event(new UserLoggedIn($user));
    }


    /**
     * Check if registered by referral
     *
     * @param $user
     * @return void
     */
    protected function checkForReferrer($user)
    {
        // If we have a referral code cookie and no active login cookie
        // so this is a valid referral code and should be added to this user
        if(request()->cookie('referral_code') && !request()->cookie('login')){

            // Get user of this referral code
            $referrer = User::where('referral_code', request()->cookie('referral_code'))->first();

            // If referrer found set user referrer id to his id
            if($referrer){

                // Update user referrer id
                $user->referrer_id = $referrer->id;

                // Save user
                $user->save();

                // Fire referral added event
                event(new ReferralAdded($referrer, $user));
            }

            // Remove referral code cookie as it should be used one time only
            cookie()->queue(cookie()->forget('referral_code'));
        }
    }
}
