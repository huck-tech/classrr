@extends('user_layout')

@section('tab_content')


<div>
    <div class="row">
        <div class="col-lg-8 col-md-12">
            <div id="general_rating">{{ count($reviews) }} @lang('reviews.reviews')
                <div class="rating">
                    @include('shared.rating_stars', ['rating' => round($review_avg)])
                </div>
            </div><!-- End general_rating -->
            <hr>
            @foreach($reviews as $review)
                <div class="review_strip_single">
                    <img src="{{ $review['user']['avatar'] ?
                                asset($review['user']->getAvatarPath()) : 'https://api.adorable.io/avatars/68/airuser' . $review['user']['id']  }}" alt="{{ $review['user']->pretty_name() }}" class="avatar-sm">
                    <small> - {{ $review['created_at']->format('M j, Y H:i') }} -</small>
                    <h4>{{ $review['user']->pretty_name() }}</h4>
                    <p>
					@if($review['is_active'] == 0)
					<small></em>Pending Confirmation</em></small><br />		
					@endif
                        {!! nl2br(e($review['comment'])) !!}
                    </p>
                    <div class="rating">
                        @include('shared.rating_stars', ['rating' => $review['rating']])
                        <span style="margin-left: 10px;">{{ $review['rating'] }} of 10</span>
                    </div>
                </div><!-- End review strip -->
            @endforeach
        </div>
    </div>
</div>


@endsection