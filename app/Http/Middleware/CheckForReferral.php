<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class CheckForReferral
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Check for referral code in the request
        if($referralCode = $request->get('ref')) {

            // If we found a user with this referral code we should create a cookie for that
            if ($user = User::where('referral_code', $referralCode)->first()) {

                // In case no referral code cookie we should create new one
                // as we don't want to replace the old referral code
                if(!request()->cookie('referral_code')){
                    // Create a referral code token with 2 months expiry date
                    cookie()->queue('referral_code', $referralCode, 60*24*60);
                }

                // Get user referral Statistics
                $referralStatistics = $user->referralStatistics;

                // Add one to clicks
                $referralStatistics->clicks = $referralStatistics->clicks + 1;

                // Save
                $referralStatistics->save();
            }
        }

        return $next($request);
    }
}
