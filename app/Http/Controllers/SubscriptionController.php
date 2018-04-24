<?php

namespace App\Http\Controllers;

use App\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        $email = $request->get('email');

        $query_bag = $request->get('query_bag');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return response()->json(false);

        Subscription::create([
            'email' => $email,
            'query' => $query_bag
        ]);

        Mail::send('emails.search_subscription', ['where' => $query_bag['where'] ?: 'N/A'], function ($m) use ($email) {

            $m->from('noreply@teachinclass.com');
            $m->to($email)->subject('Contact Form');

        });

        return response()->json(['status' => 'success']);
    }
}
