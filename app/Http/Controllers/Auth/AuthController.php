<?php

namespace App\Http\Controllers\Auth;

use App\Events\ReferralAdded;
use App\Events\UserLoggedIn;
use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Skill;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Socialite;


/**
 * Class AuthController
 * @package App\Http\Controllers\Auth
 */
class AuthController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }


    /**
     * @param $provider string
     * @return bool|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handleProviderCallback($provider)
    {
        if(auth()->user()) {
            return $this->linkSocialMedia($provider);
        }

        $external_user = Socialite::driver($provider)->user();
        $user = User::where('email', $external_user->email)->first();

        if ($user) {
            // User with email is already exists
            if (!isset($user[$provider . '_id']) || empty($user[$provider . '_id'])) {
                $user[$provider . '_id'] = $external_user->id;
            }
            $user['sign_in_count'] = $user['sign_in_count'] + 1;
            $user['last_sign_in_at'] = $user['current_sign_in_at'];
            $user['current_sign_in_at']= Carbon::now()->toDateTimeString();
            $user->save();

        } else {
            // New user, create it
            $create = [];
            $name = explode(' ', $external_user->name);
            $create['first_name'] = $name[0];
            if (isset($name[1])) {
                $create['last_name'] = $name[1];
            }
            if (isset($external_user->user['gender']) &&
                in_array($external_user->user['gender'], ['male', 'female'])) {
                $create['gender'] = strtolower($external_user->user['gender']);
            }
            $create['email'] = $external_user->email;
            $create[$provider . '_id'] = $external_user->id;
            $create['avatar'] = $external_user->avatar;

            $create['sign_in_count'] = 1;
            $now = Carbon::now()->toDateTimeString();
            $create['current_sign_in_at'] = $now;
            $create['last_sign_in_at'] = $now;

            // Set some random password (password can't be null)
            // OAuth User can set password later in settings
            $create['password_is_empty'] = true;
            $create['password'] = bcrypt('salt' . rand() . uniqid());

            $create['referral_code'] = User::createAUniqueReferralCode();

            $user = User::create($create);

            // Create a record for registered user in referral statistics table
            // with no values as default equal 0
            $user->referralStatistics()->create([]);

            // Check if registered by referral
            $this->checkForReferrer($user);

            // Fire user registered event
            event(new UserRegistered($user));

        }

        // Now we can login user and redirect to homepage
        Auth::login($user);

        // Fire user logged in event as we login user after registering successfully
        event(new UserLoggedIn($user));

        return redirect()->intended('/');

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

    /**
     * undocumented function
     *
     * @return void
     * @author 
     **/
    public function linkSocialMedia($provider)
    {
        $external_user = Socialite::driver($provider)->user();
        $user = User::where('email', auth()->user()->email)->first();

        try{
            if ($user) {
                // User with email is already exists
                if (!isset($user[$provider . '_id']) || empty($user[$provider . '_id'])) {
                    $user[$provider . '_id'] = $external_user->id;
                }

                $store = $user->save();

                if($store) {
                    $skills = Skill::where('name', 'Social Media')->orWhere('name','Facebook')->get();
                    $giveSkills = [];
                    
                    if(count($skills)) {
                        foreach($skills as $skill) {
                            $giveSkills[$skill->id] = ['amount_point' => $skill->max_level];
                        }
                    }
                    $user->skills()->sync($giveSkills, false);                    
                }
            }
        } catch(\Exception $e) {
            return redirect()->route('user_profile');
        }
        session()->flash('status', 'Social Media and Facebook skill has been added');
        return redirect()->route('user_profile');
    }
}
