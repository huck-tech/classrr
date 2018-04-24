<?php

namespace App\Http\Controllers;

use App\Facades\Twilio;
use App\Verification;
use Carbon\Carbon;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Twilio\Rest\Api\V2010\Account\MessageInstance;

class VerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getEmailCode(Request $request)
    {
        $current_user = Auth::user();
        $email = $current_user->email;
        $verification_code = $this->generateRandomString();
        $verification = Verification::firstOrNew([
            'user_id' => $current_user['id'],
            'type' => 'email',
            'token' => $email
        ]);
        $verification['code'] = $verification_code;
        $verification['attempts'] = $verification['attempts'] + 1;
        $verification['sent_at'] = Carbon::now()->toDateTimeString();
        $verification->save();

        try {
            Mail::send('emails.verify_email', compact('verification_code', 'current_user'), function ($m) use ($current_user) {

                $m->from('noreply@classrr.com', 'Classrr');
                $m->to($current_user->email)->subject('Please Verify Your Email at Classrr');

            });
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Email gateway error. Try again later.' , 'details' => $e->getMessage()], 500);
        }

        return response()->json(['status' => 'success', 'message' => 'Email code has been sent. Follow instructions in email']);
    }

    public function verifyEmailCode($code)
    {
        $verification = Verification::where([
            ['code', $code],
            ['type', 'email']
        ])->first();

        if (!$verification) throw new BadRequestHttpException('Wrong request.');

        $verification->is_completed = true;
        $verification->completed_at = Carbon::now()->toDateTimeString();

        $verification->save();

        return redirect()->route('user_account')->with('status', 'Email verification is complete.');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSmsCode(Request $request)
    {
        // TODO: Validate phone
        $phone = $request->get('phone');
        $phone = '+' . preg_replace('/[^0-9]+/', '', $phone);

        $current_user = Auth::user();
        $verified_phone = Verification::where([
            ['type', '=', 'phone'],
            ['token', '=', $phone],
            ['is_completed', '=', true],
        ])->first();

        // Verifi
        if ($verified_phone && $verified_phone['user_id'] == $current_user['id']) {
            return response()->json(['status' => 'verified', 'message' => 'Phone number already verified.']);
        } elseif ($verified_phone && $verified_phone['user_id'] != $current_user['id']) {
            return response()->json(['status' => 'error', 'message' => 'This phone number already verified by someone else.'], 400);
        } else {
            $verification_code = rand(10000, 99999);
            $verification = Verification::firstOrNew([
                'user_id' => $current_user['id'],
                'type' => 'phone',
                'token' => $phone
            ]);
            $verification['code'] = $verification_code;
            $verification['attempts'] = $verification['attempts'] + 1;
            try{
                $sms_result = Twilio::sendSms($phone, 'CLASSRR Verification code: ' . $verification_code);
            } catch (\Exception $e) {
                return response()->json(['status' => 'error', 'message' => 'SMS gateway error. Try again later.', 'details' => $e->getMessage()], 500);
            }

            if ($sms_result instanceof MessageInstance) {
                $verification['sent_at'] = Carbon::now()->toDateTimeString();
                $verification->save();
                return response()->json(['status' => 'success', 'message' => 'SMS code has been sent.']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'SMS gateway error. Try again later.'], 500);
            }
        }
    }

    public function verifySmsCode(Request $request)
    {
        $phone = $request->get('phone');
        $phone = '+' . preg_replace('/[^0-9]+/', '', $phone);
        $code = $request->get('code');
        $current_user = Auth::user();

        $result = Verification::where([
            ['type', '=', 'phone'],
            ['token', '=', $phone],
            ['user_id', '=', $current_user['id']]
        ])->first();

        if ($result) {
            if (!$result['is_completed'] && $result['code'] == $code) {
                $result['is_completed'] = true;
                $result['completed_at'] = Carbon::now()->toDateTimeString();
                $result->save();
            } elseif (!$result['is_completed'] && $result['code'] != $code) {
                $result['attempts'] = $result['attempts'] + 1;
                $result->save();
                return response()->json(['status' => 'error', 'message' => 'Wrong Verification Code.']);
            }
            return response()->json(['status' => 'success', 'message' => 'Verification Successful.']);
        } else {

            return response()->json(['status' => 'error', 'message' => 'Wrong data.'], 400);
        }
    }

    private function generateRandomString($length = 16) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
