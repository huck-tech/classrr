<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Classroom;
use App\Paypal;
use App\UserReward;
use App\Verification;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;
use PayPal\Api\Amount;
use PayPal\Api\Authorization;
use PayPal\Api\Capture;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function book(Request $request)
    {
        // auth user
        $authUser = Auth::user();

        // Validate input
        $classroom_id = $request->get('item_id');
        $classroom = Classroom::findOrFail($classroom_id);
        $day_time = $request->get('time');
        $enrollment_date = $request->get('enrollment_date');
        $classTotals = $classroom->calcTotal($day_time, $enrollment_date);

		if ($authUser->id === $classroom->user_id) {
			return redirect()->back()->withErrors(['You can\'t book your own class']);
		}
		
		$checkEmail = Verification::where([
            ['type', '=', 'email'],
            ['is_completed', '=', '1'],
            ['user_id', '=', $authUser->id]
        ])->first();
		
		if (!$checkEmail) {
			return redirect()->route('user_account')->withErrors(['Please verify your email address first to book this class']);
		}
		
		$checkBooking = Booking::where([
            ['classroom_id', '=', $classroom_id],
			['payment_status', '=', 'authorized'],
            ['student_id', '=', $authUser->id]
        ])->orWhere([
            ['classroom_id', '=', $classroom_id],
			['payment_status', '=', 'in escrow'],
            ['student_id', '=', $authUser->id]
        ])->exists();
		
		if ($checkBooking) {
			return redirect()->back()->withErrors(['You have a booking in progress for this class']);
		}
		
		if ($classroom['base_price'] == 0) {

            $booking = Booking::create([
                'uid' => uniqid(),
                'student_id' => $authUser->id,
                'classroom_id' => $classroom_id,
                'tutor_id' => $classroom->user_id,
                'price' => 0,
                'student_fee' => 0,
                'tutor_commission' => 0,
                'gross_revenue' => 0,
                'day_time' => $day_time,
                'start_date' => $enrollment_date,
                'payment_method' => 'free',
                'payment_status' => 'authorized',
                'payment_id' => 'free'

            ]);

            // If no previous message so we should create new one
            $message = $booking->message()->create([
                'title' => 'Booking ' . $classroom->title,
                'sender_id' => $authUser->id,
                'receiver_id' => $classroom->user_id
            ]);


            // Create new reply with the contact message
            $message->replies()
                ->create([
                    'sender_id' => $authUser->id,
                    'text' => $authUser->nameOrEmail() . ' has requested to book a session in this class ' . $classroom->title
                ]);


            return redirect()->route('user_transactions')
                ->with('status', 'Thank you for requesting this booking, the teacher is already notified and you can start messaging by <a href="'. route('user_message', [$message->id]).'">clicking here</a>');
		}

        // Set discount to 0 as a default value
        $discount = 0;

        // Set used rewards to null as a default value
        $usedRewards = [];

        //Check if user have any approved reward
        $approvedRewards = $authUser->rewards()
            ->where('status', 'approved')
            ->get();

        // If user have approved reward we should check if this class is eligible to any of them
		if(count($approvedRewards)){

		    // If class price is between $80 to  $900 we should apply max discount of $300
            if($classTotals['total_price'] > 80 && $classTotals['total_price'] <= 900) {

                // Max discount should be equal to the lowest of 300 or the class price
                $maxDiscount = $classTotals['total_price'] < 300 ? $classTotals['total_price'] : 300;

            }
            // Else if class price is greater than $900 we should apply max discount of $500
            elseif($classTotals['total_price'] > 900) {
                $maxDiscount = 500;
            }

		    // Loop through each reward
		    foreach ($approvedRewards as $reward) {

		        // Check if class is eligible for this reward
                $eligibleForReward = $classroom->eligibleForReward($reward, $classTotals, $classroom);

                // If eligible we should use it
                if($eligibleForReward) {

                    // Add to discount
                    $discount += $reward->amount - $reward->used_amount;

                    // If discount still less than max discount so we used all the reward amount and no remainder
                    if ($discount < $maxDiscount) {

                        // Update reward status
                        $reward->status = 'used';

                        // Set used discount to reward amount
                        $reward->used_amount = $reward->amount;

                        // Save reward
                        $reward->save();

                        // Add reward to used rewards
                        $usedRewards[$reward->id] = ['used_amount' => $reward->amount];

                    }
                    // If discount is equal to max discount so we used all the reward amount and no remainder
                    elseif ($discount == $maxDiscount) {

                        // Update reward status
                        $reward->status = 'used';

                        // Set used discount to reward amount
                        $reward->used_amount = $reward->amount;

                        // Save reward
                        $reward->save();

                        // Add reward to used rewards
                        $usedRewards[$reward->id] = ['used_amount' => $reward->amount];

                        // Break the loop as we can't add more discounts than max discount
                        break;
                    }
                    // Else we will have a remainder so we should adjust reward amount
                    // and create new one with the remainder
                    else {

                        // Get remainder
                        $remainder = $discount - $maxDiscount;

                        // Update reward amount
                        $reward->used_amount = $reward->amount - $remainder;

                        // Save reward
                        $reward->save();

                        // Set discount to the max discount and
                        $discount = $maxDiscount;

                        // Add reward to used rewards
                        $usedRewards[$reward->id] = ['used_amount' => $reward->amount - $remainder];

                        // Break the loop as we can't add more discounts than max discount
                        break;
                    }
                }
            }

            // If we have discount so update referral statistics
            if($discount){

                // Get user referral statistics
                $userReferralStatistics = $authUser->referralStatistics;

                // Deduct reward amount from approved
                $userReferralStatistics->approved = $userReferralStatistics->approved - $discount;

                // Add reward amount to used
                $userReferralStatistics->used = $userReferralStatistics->used + $discount;

                // Save referral statistics
                $userReferralStatistics->save();

            }
        }

        $feePercentage = $classroom->getFeePercentage();

        $booking = Booking::create([
            'uid' => uniqid(),
            'student_id' => $authUser->id,
            'classroom_id' => $classroom_id,
            'tutor_id' => $classroom->user_id,
            'price' => $classTotals['total_price'],
            'student_fee' => $classTotals['total_price'] - $discount,
            'tutor_commission' => $classTotals['total_price'] * (1 - $feePercentage),
            'gross_revenue' => 0,
            'day_time' => $day_time,
            'start_date' => $enrollment_date
        ]);

        // If we have used rewards we should attach them to booking
        if(count($usedRewards)) {
            $booking->rewards()->attach($usedRewards);
        }

        // If class price equal discount so it will be fully paid through rewards
        if($classTotals['total_price'] == $discount){

            // Update booking payment data
            $booking->update([
                'payment_method' => 'credit',
                'payment_status' => 'authorized',
            ]);

            // If no previous message so we should create new one
            $message = $booking->message()->create([
                'title' => 'Booking ' . $classroom->title,
                'sender_id' => $authUser->id,
                'receiver_id' => $classroom->user_id
            ]);


            // Create new reply with the contact message
            $message->replies()
                ->create([
                    'sender_id' => $authUser->id,
                    'text' => $authUser->nameOrEmail() . ' has requested to book a session in this class ' . $classroom->title
                ]);


            return redirect()->route('user_transactions')
                ->with('status', 'Thank you for requesting this booking, the teacher is already notified and you can start messaging by <a href="'. route('user_message', [$message->id]).'">clicking here</a>');
        }


        // Pre-auth payment
        $paypal = new Paypal();
        $payment = $paypal->getPaymentForBooking($classroom, $classTotals, $booking, $discount);

        $request = clone $payment;

        try {
            $payment->create(app('paypal.api_context'));
        } catch (Exception $ex) {
            //TODO: Catch possible errors
            Log::error('Exception: Authorize a Payment - Authorized Payment',['message' => $ex->getMessage(), 'payment' => (array)$payment]);

            exit(1);
        }
        Log::info('Success: Authorize a Payment - Authorized Payment', (array)$payment);

        // Update booking payment data
        $booking->update([
            'payment_method' => 'paypal',
            'payment_status' => 'created',
            'payment_id' => $payment->getId()
        ]);

        return redirect($payment->getApprovalLink());
    }

    public function callback(Request $request)
    {
        echo view('shared.spin_loader');

        /*
         Response example:
            array(4) {
              ["success"]=>
              string(4) "true"
              ["paymentId"]=>
              string(28) "PAY-3WS98771HA141170RLCGLJOI"
              ["token"]=>
              string(20) "EC-2A704915A3570414E"
              ["PayerID"]=>
              string(13) "JM9CW3W59UK5N"
            }
         */
        $payment_id = $request->get('paymentId');

        if (!$payment_id) {

            // Get success status
            $success = $request->get('success');

            // Get booking id from request
            $bookingId = $request->get('booking_id');

            // If success failed and we have booking id we should check if a reward used and reset it's status
            if($success == 'false' && $bookingId) {

                // Get booking
                $booking = Booking::find($bookingId);

                // Update status
                $booking->payment_status = 'cancelled';

                // Save booking
                $booking->save();

                // If booking exists and a reward is used we should reset it's status
                if($booking && count($booking->rewards)) {

                    // Set discount to 0 as a default value
                    $discountUsed = 0;

                    foreach($booking->rewards as $reward) {

                        // Update reward status
                        $reward->status = 'approved';

                        // Update reward used amount
                        $reward->used_amount = $reward->used_amount - $reward->pivot->used_amount;

                        // Save reward
                        $reward->save();

                        // Add to discount used
                        $discountUsed += $reward->pivot->used_amount;
                    }

                    // Get user referral statistics
                    $userReferralStatistics = Auth::user()->referralStatistics;

                    // Deduct discount used amount from used
                    $userReferralStatistics->used = $userReferralStatistics->used - $discountUsed;

                    // Add discount used amount to approved
                    $userReferralStatistics->approved = $userReferralStatistics->approved + $discountUsed;

                    // Save referral statistics
                    $userReferralStatistics->save();

                    // Detach all rewards
                    $booking->rewards()->detach();
                }
            }

            return redirect()->route('homepage');
        }

        $booking = Booking::where('payment_id', $payment_id)->first();

        if (!$booking) {
            throw new Exception('Can`t find booking.');
        }

        if ($request->get('success') === 'true') {

            $classroom = Classroom::findOrFail($booking->classroom_id);
            $booking_arr = $classroom->calcTotal($booking->day_time, $booking->start_date);

            $payment = Payment::get($payment_id, app('paypal.api_context'));
            $execution = new PaymentExecution();
            $execution->setPayerId($request->get('PayerID'));
            $paypal = new Paypal();

            // Set discount to 0 as a default value
            $discount = 0;

            // Get used reward if booking used a reward
            if(count($booking->rewards)){

                foreach($booking->rewards as $reward) {
                    // Add discount to reward amount
                    $discount += $reward->pivot->used_amount;
                }
            }

            $transaction = $paypal->getTransaction($classroom, $booking_arr, $discount);
            $execution->addTransaction($transaction);

            try {
                $result = $payment->execute($execution, app('paypal.api_context'));
                Log::info("Executed Payment", (array)$result);

                try {
                    $payment = Payment::get($payment_id, app('paypal.api_context'));
                } catch (Exception $ex) {
                    Log::error("Get Payment", (array)$ex);
                    exit(1);
                }
            } catch (Exception $ex) {
                $booking->payment_status = 'cancelled';
                exit(1);
            }

            Log::info("Get Payment", (array)$payment);

            $transactions = $payment->getTransactions();
            $relatedResources = $transactions[0]->getRelatedResources();
            $authorization = $relatedResources[0]->getAuthorization();

            Log::info('Authorization', (array)$authorization);

            $booking->payment_data = $authorization->id;
            $booking->payment_status = 'authorized';

        } else {
            $booking->payment_status = 'cancelled';
        }

        $booking->save();

        // Get authenticated user
        $authUser = Auth::user();

        // If no previous message so we should create new one
        $message = $booking->message()->create([
            'title' => 'Booking ' . $classroom->title,
            'sender_id' => $authUser->id,
            'receiver_id' => $classroom->user_id
        ]);

        // Create new reply with the contact message
        $message->replies()
            ->create([
                'sender_id' => $authUser->id,
                'text' => $authUser->nameOrEmail() . ' has requested to book a session in this class ' . $classroom->title
            ]);

        // Get booking related message to show link for it to user
        $message = $booking->message;

        return redirect()->route('user_transactions')
            ->with('status', 'Thank you for payment for this booking, the teacher is already notified and you can start messaging by <a href="'. route('user_message', [$message->id]).'">clicking here</a>');
    }

    public function capture($id)
    {
        $booking = Booking::findOrFail($id);
        if (Auth::user()->id !== $booking->tutor_id || $booking->payment_status !== 'authorized') throw new AuthorizationException('Method not authorized.');
		
		if ($booking['price'] == 0 || $booking['payment_method'] == 'credit') {
			$booking->payment_status = 'in escrow';
			$booking->save();

            if ($message = $booking->message) {

                // Create new reply with the contact message
                $message->replies()
                    ->create([
                        'sender_id' => Auth::user()->id,
                        'text' => Auth::user()->nameOrEmail() . ' has approved your booking'
                    ]);
            }

			return redirect()->back()->with('status', 'Payment is approved.');
		}

        // Set discount to 0 as a default value
        $discount = 0;

        // Get used reward if booking used a reward
        if(count($booking->rewards)){

            foreach($booking->rewards as $reward) {
                // Add discount to reward amount
                $discount += $reward->pivot->used_amount;
            }
        }

        $authorization = Authorization::get($booking->payment_data, app('paypal.api_context'));
        try {
            $authId = $authorization->getId();

            $amt = new Amount();
            $amt->setCurrency("USD")
                ->setTotal($booking->price - $discount);

            ### Capture
            $capture = new Capture();
            $capture->setAmount($amt);

            // Perform a capture
            $getCapture = $authorization->capture($capture, app('paypal.api_context'));
        } catch (\Exception $ex) {
            // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
            Log::error("Capture Payment - Authorization", (array)$ex);
            exit(1);
        }

        Log::info("Capture Payment - Authorization", (array) $getCapture);
        $booking->payment_status = 'in escrow';
        $booking->save();

        if ($message = $booking->message) {

            // Create new reply with the contact message
            $message->replies()
                ->create([
                    'sender_id' => Auth::user()->id,
                    'text' => Auth::user()->nameOrEmail() . ' has approved your booking'
                ]);
        }


        return redirect()->back()->with('status', 'Payment has been approved.');
    }
	
	public function void(Request $request, $id)
    {
        // Validate inputs
        $this->validate($request, [
            'reason' => 'required|min:1|max:2500'
        ]);

        $booking = Booking::findOrFail($id);
        if (Auth::user()->id !== $booking->tutor_id || $booking->payment_status !== 'authorized') throw new AuthorizationException('Method not authorized.');

		if ($booking['price'] == 0) {
			$booking->payment_status = 'cancelled';
			$booking->cancelled_reason = $request->get('reason');
			$booking->save();

            if ($message = $booking->message) {
                $message->archived_by = Auth::user()->id;
                $message->archived_reason = 'booking_cancelled';
                $message->archived_at = Carbon::now();
                $message->save();

                // Create new reply with the contact message
                $message->replies()
                    ->create([
                        'sender_id' => Auth::user()->id,
                        'text' => Auth::user()->nameOrEmail() . ' is unable to accommodate class session at a schedule you requested'
                    ]);
            }

			return redirect()->back()->withErrors(['Booking is rejected']);
		}

		if($booking->payment_method == 'paypal') {
            $authorization = Authorization::get($booking->payment_data, app('paypal.api_context'));
            try {
                $authId = $authorization->getId();
                // Perform a void
                $getVoid = $authorization->void(app('paypal.api_context'));
            } catch (\Exception $ex) {
                // NOTE: PLEASE DO NOT USE RESULTPRINTER CLASS IN YOUR ORIGINAL CODE. FOR SAMPLE ONLY
                Log::error("Void Payment - Authorization", (array)$ex);
                exit(1);
            }

            Log::info("Void Payment - Authorization", (array)$getVoid);
        }

        $booking->payment_status = 'cancelled';
        $booking->save();

        // Get booking message and archive it
        if ($message = $booking->message) {
            $message->archived_by = Auth::user()->id;
            $message->archived_reason = 'booking_cancelled';
            $message->archived_at = Carbon::now();
            $message->save();

            if ($message = $booking->message) {

                // Create new reply with the contact message
                $message->replies()
                    ->create([
                        'sender_id' => Auth::user()->id,
                        'text' => Auth::user()->nameOrEmail() . ' is unable to accommodate class session at a schedule you requested'
                    ]);
            }
        }

        // If a reward is used we should reset it's status
        if(count($booking->rewards)) {

            // Set discount to 0 as a default value
            $discountUsed = 0;

            foreach ($booking->rewards as $reward) {

                // Update reward status
                $reward->status = 'approved';

                // Update reward used amount
                $reward->used_amount = $reward->used_amount - $reward->pivot->used_amount;

                // Save reward
                $reward->save();

                // Add to discount used
                $discountUsed += $reward->pivot->used_amount;

            }

            // Get reward user
            $student = $booking->student;

            // Get user referral statistics
            $userReferralStatistics = $student->referralStatistics;

            // Deduct reward amount from used
            $userReferralStatistics->used = $userReferralStatistics->used - $discountUsed;

            // Add reward amount to approved
            $userReferralStatistics->approved = $userReferralStatistics->approved + $discountUsed;

            // Save referral statistics
            $userReferralStatistics->save();

            $booking->rewards()->detach();
        }


        return redirect()->back()->withErrors(['Booking has been rejected. The payment is already voided.']);
    }
	
	public function cancel($id)
    {
        $booking = Booking::findOrFail($id);
        if (Auth::user()->id !== $booking->tutor_id && Auth::user()->id !== $booking->student_id) throw new AuthorizationException('Method not authorized.');

        if (Auth::user()->id === $booking->tutor_id && $booking->payment_status === 'in escrow') {
            $booking->payment_status = 'pending';
            $booking->save();

            if ($message = $booking->message) {

                // Create new reply with the contact message
                $message->replies()
                    ->create([
                        'sender_id' => Auth::user()->id,
                        'text' => Auth::user()->nameOrEmail() . ' has requested to cancel a booking with you'
                    ]);
            }


            return redirect()->back()->withErrors(['Waiting for student approval for the cancellation request']);
        } elseif (Auth::user()->id === $booking->student_id && $booking->payment_status === 'in escrow') {
            $booking->payment_status = 'disputed';
            $booking->save();

            if ($message = $booking->message) {

                // Create new reply with the contact message
                $message->replies()
                    ->create([
                        'sender_id' => Auth::user()->id,
                        'text' => Auth::user()->nameOrEmail() . ' has requested to cancel a booking with you'
                    ]);
            }

            return redirect()->back()->withErrors(['Waiting for teacher approval for the cancellation request']);
        } elseif ($booking->payment_status === 'pending' && Auth::user()->id === $booking->student_id) {
            Log::info("Cancel Booking - Authorization");
            $booking->payment_status = 'cancelled';
            $booking->save();

            if ($message = $booking->message) {
                $message->archived_by = Auth::user()->id;
                $message->archived_reason = 'booking_cancelled';
                $message->archived_at = Carbon::now();
                $message->save();

                // Create new reply with the contact message
                $message->replies()
                    ->create([
                        'sender_id' => Auth::user()->id,
                        'text' => Auth::user()->nameOrEmail() . ' has approved the cancellation request for this booking'
                    ]);
            }

            // If a reward is used we should reset it's status
            if(count($booking->rewards)) {

                // Set discount to 0 as a default value
                $discountUsed = 0;

                foreach ($booking->rewards as $reward) {

                    // Update reward status
                    $reward->status = 'approved';

                    // Update reward used amount
                    $reward->used_amount = $reward->used_amount - $reward->pivot->used_amount;

                    // Save reward
                    $reward->save();

                    // Add to discount used
                    $discountUsed += $reward->pivot->used_amount;

                }

                // Get reward user
                $student = $booking->student;

                // Get user referral statistics
                $userReferralStatistics = $student->referralStatistics;

                // Deduct reward amount from used
                $userReferralStatistics->used = $userReferralStatistics->used - $discountUsed;

                // Add reward amount to approved
                $userReferralStatistics->approved = $userReferralStatistics->approved + $discountUsed;

                // Save referral statistics
                $userReferralStatistics->save();

                $booking->rewards()->detach();
            }


            return redirect()->back()->withErrors(['Booking has been cancelled. Any payment will be refunded shortly.']);
        } elseif ($booking->payment_status === 'disputed' && Auth::user()->id === $booking->tutor_id) {
            Log::info("Cancel Booking - Authorization");
            $booking->payment_status = 'cancelled';
            $booking->save();

            if ($message = $booking->message) {
                $message->archived_by = Auth::user()->id;
                $message->archived_reason = 'booking_cancelled';
                $message->archived_at = Carbon::now();
                $message->save();

                // Create new reply with the contact message
                $message->replies()
                    ->create([
                        'sender_id' => Auth::user()->id,
                        'text' => Auth::user()->nameOrEmail() . ' has approved the cancellation request for this booking'
                    ]);
            }

            return redirect()->back()->withErrors(['Booking has been cancelled. Any payment will be refunded shortly.']);
        } else {
            throw new AuthorizationException('Method not authorized.');
        }
    }


    /**
     * Escalate the booking
     *
     * @param $id
     * @return $this
     * @throws AuthorizationException
     */
    public function escalate($id)
    {
        // Get booking or fail
        $booking = Booking::findOrFail($id);

        // Check authorization
        if (Auth::user()->id !== $booking->tutor_id && Auth::user()->id !== $booking->student_id) throw new AuthorizationException('Method not authorized.');

        if($booking->payment_status !== 'pending' &&  $booking->payment_status !== 'disputed'){
            return redirect()->back()->withErrors(['You must request to cancel the booking first']);
        }

        // Change booking status to escalated
        $booking->payment_status = 'escalated';
        $booking->save();

        // Get booking message and archive it
        $message = $booking->message;
        $message->archived_by = Auth::user()->id;
        $message->archived_reason = 'booking_escalated';
        $message->archived_at = Carbon::now();
        $message->save();

        // Redirect to messages
        return redirect('user/messages/' . $message->id)->withErrors(['Booking escalated. Please provide a reason to the disputed booking']);
    }

    /**
     * Report booking
     *
     * @param Request $request
     * @param $id
     * @return $this
     * @throws AuthorizationException
     */
    public function report(Request $request, $id)
    {
        // Validate inputs
        $this->validate($request, [
            'report' => 'required|min:1|max:2500'
        ]);

        // Get booking or fail
        $booking = Booking::findOrFail($id);


        // Check authorization
        if (Auth::user()->id !== $booking->tutor_id && Auth::user()->id !== $booking->student_id) throw new AuthorizationException('Method not authorized.');

        // Check if not escalated and redirect him with error
        if($booking->payment_status !== 'escalated'){
            return redirect()->back()->withErrors(['Booking must be escalated to provide a report']);
        }

        // If current user is the tutor save report to tutor report field
        if(Auth::user()->id === $booking->tutor_id){

            // Check if report already provided
            if($booking->tutor_report ){
                return redirect()->back()->withErrors(['You have provided the report already']);
            }else {
                $booking->tutor_report = $request->get('report');
            }
        }
        // Else if current user is the student save report to student report field
        elseif(Auth::user()->id === $booking->student_id){

            // Check if report already provided
            if($booking->student_report ){
                return redirect()->back()->withErrors(['You have provided the report already']);
            }else {
                $booking->student_report = $request->get('report');
            }
        }

        // Save changes
        $booking->save();

        // Redirect back to messages
        return redirect('user/messages/' . $booking->message->id)->withSuccess('Report sent successfully');
    }
}
