<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Http\Requests\StoreReview;
use App\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(StoreReview $request)
    {
        $review = new Review();
        $review->fill($request->all());
        $review['user_id'] = Auth::user()->id;
        $review['type'] = 'classroom';
        $review->save();
        return back();
    }
}
