<?php

namespace App\Http\Controllers;

use App\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function calcTotal(Request $request)
    {
        // Get classroom or fail
        $classroom = Classroom::findOrFail($request->get('item_id'));

        // Get class totals
        $classTotals = $classroom->calcTotal($request->get('time'), $request->get('enrollment_date'));

        // Set discount to 0 as a default value
        $discount = 0;

        // Set has approved rewards to false
        $hasApprovedRewards =false;

        // Set has not eligible rewards to false
        $hasNotEligibleRewards = false;

        if($user = Auth::user()) {

            //Check if user have any approved reward
            $approvedRewards = $user->rewards()
                ->where('status', 'approved')
                ->get();

            // Set has approved rewards to true or false
            $hasApprovedRewards = count($approvedRewards) ? true : false;

            // If user have approved reward we should check if this class is eligible to any of them
            if ($hasApprovedRewards) {

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

                        // If discount is greater than max discount
                        // so we should set discount to max discount and break the loop
                        if ($discount > $maxDiscount) {

                            // Set discount to the max discount and
                            $discount = $maxDiscount;

                            // Break the loop as we can't add more discounts than max discount
                            break;
                        }

                    }else {
                        $hasNotEligibleRewards = true;
                    }
                }
            }
        }
        return view('classroom.prebook_result', [
            'item' => $classTotals,
            'discount' => $discount,
            'hasApprovedRewards' => $hasApprovedRewards,
            'hasNotEligibleRewards' => $hasNotEligibleRewards
        ]);
    }

}
