<?php

namespace App\Http\Controllers;

use App\Mail\InviteFriend;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ReferralsController extends Controller
{
    public function __construct()
    {
        // Make sure the user is authenticated using auth middleware
        $this->middleware('auth');
    }

    /**
     * Show the referrals
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Get current user
        $user = Auth::user();

        // Get available invitations
        $availableInvitations = 25 - $user->invitations()
                ->where('created_at', '>=', Carbon::now()->toDateString())
                ->count();

        // Get user referrals statistics
        $referralStatistics = $user->referralStatistics;

        // Return referrals view
        return view('user.referrals', compact('user', 'availableInvitations', 'referralStatistics'));
    }

    /**
     * Send invitations to user friends emails
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function inviteFriends(Request $request)
    {
        // Get email from request
        $emails = $request->get('emails', []);

        // Check if there're emails
        if(count($emails)){

            // Get current user
            $user = Auth::user();

            // Get available invitations
            $availableInvitations = 25 - $user->invitations()
                ->where('created_at', '>=', Carbon::now()->toDateString())
                ->count();

            // If invitation equal or less than zero so there're no more invitations available today
            if($availableInvitations <=0){
                // Redirect back to referral page with error
                return redirect()->back()
                    ->withErrors(['You do not have more available invitations for today.'])
                    ->withInput();
            }
            // Else if available invitations is less than emails count we should return error
            // and let user select only the available emails
            elseif($availableInvitations < count($emails)){
                // Redirect back to referral page with error
                return redirect()->back()
                    ->withErrors(['You only have '. $availableInvitations .' invitations left for today. Please select only '. $availableInvitations .' email'])
                    ->withInput();
            }

            // Loop through each
            foreach($emails as $email){

                // If email is valid send an email
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {

                    // Check if already registered
                    $alreadyRegisteredEmail = User::where('email', $email)->exists();

                    // Check if already invited by this user
                    $invitedBeforeByThisUser = $user->invitations()
                        ->where('email', $email)
                        ->exists();

                    // Create new invitation record
                    $user->invitations()->create([
                        'email' => $email
                    ]);

                    // If not already registered or invited send email
                    if(!$alreadyRegisteredEmail && !$invitedBeforeByThisUser){
                        // Send email
                        Mail::to($email)->send(new InviteFriend(Auth::user()));
                    }
                }
            }
        }

        // Redirect back to referral page
        return redirect(route('user_referrals'))->with('status', 'Invitations have been sent successfully');
    }
}
