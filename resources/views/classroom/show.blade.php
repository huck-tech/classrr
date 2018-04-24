@extends('layout')

@section('title_tag')
    <title>{{ $item['title'] }} by {{ $item['user']->pretty_name() }} | Classrr</title>
@endsection

@section('additional_metas')
  <meta name="twitter:title" content="{{ $item['title'] }} by {{ $item['user']->pretty_name() }} | Classrr">
  <meta name="twitter:description" content="{{ $item['description'] }}">
  <meta name="twitter:card" content="product" />
  <meta name="twitter:site" content="@classrr" />
  {{-- <meta name="twitter:creator" content="@classrr" /> --}}
  <meta name="twitter:data1" content="${{ $item['base_price'] }} USD" />
  <meta name="twitter:label1" content="Price" />
  <meta name="twitter:data2" content="Classrr" />
  <meta name="twitter:label2" content="Marketplace" />
  <meta name="twitter:domain" content="classrr.com" />
@endsection

@section('meta_title', e($item['title']).' by '.e($item['user']->pretty_name()).' | Classrr')
@section('meta_description', 'Book '.e($item['title']).' by '.e($item['user']->pretty_name()).' on Classrr. A local '.e($item['category']['name']).' class in '.e($item['state']).', '.e($item['country']->name).'. '.str_limit(e($item['description']),57,'...'))

@section('prop_title', e($item['title']))
@section('prop_description', e($item['description']))
@section('prop_image', $item->getThumb())

@section('og_title', e($item['title']))
@section('og_description', e($item['description']))
@section('og_image', $item->getThumb())
@section('og_url', Request::url())

@section('additional_styles')
<!-- Radio and check inputs -->
<link href="{{ asset('css/slider-pro.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/date_time_picker.css') }}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/owl-carousel/owl.carousel.min.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/owl-carousel/owl.theme.default.min.css')}}"/>
<link href="{{ asset('css/read-more.css') }}" rel="stylesheet"/>
<link rel="canonical" href="{{ Request::url() }}" />
<style>
.label {
font-size: 95%
}
.owl-carousel .owl-nav .owl-prev,
    .owl-carousel .owl-nav .owl-next,
    .owl-carousel .owl-dot {
        font-family: 'fontAwesome';
        text-align: center;
    }
    .owl-carousel .owl-nav .owl-prev, .owl-carousel .owl-nav .owl-next {
        width: 50%;        
    }

    .owl-prev {
        float: left;
    }

    .owl-next {
        float: right;
    }

    .owl-carousel .owl-nav .owl-prev:before{        
        content: "\f053";
        margin-right:10px;
    }
    .owl-carousel .owl-nav .owl-next:after{        
        content: "\f054";
        margin-left:10px;
    }
	.tour_title {
        height: 100px !important;
        word-wrap: break-word !important;
}
.tour_title a {
	color: #e04f67;
}
.tour_title h3 a {
	color: #333;
}
</style>
@endsection

@section('additional_javascript')
<script src="{{ asset('js/booking_controller.js') }}"></script>
<script src="{{ asset('js/icheck.js') }}"></script>
<script>
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-grey',
        radioClass: 'iradio_square-grey'
    });
</script>
        <!-- Date and time pickers -->
<script src="{{ asset('js/jquery.sliderPro.min.js') }}"></script>
<script type="text/javascript">
    $( document ).ready(function( $ ) {
        $( '#Img_carousel' ).sliderPro({
            width: 960,
            height: 500,
            fade: true,
            arrows: true,
            buttons: false,
            fullScreen: false,
            smallSize: 500,
            startSlide: 0,
            mediumSize: 1000,
            largeSize: 3000,
            thumbnailArrows: true,
            autoplay: false
        });
    });
</script>
<script type="text/javascript" src="{{ asset('vendor/owl-carousel/owl.carousel.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {
	$(".owl-carousel").owlCarousel({
    loop: false,    
    responsiveClass:true,
    responsive:{
        0:{
            items:1,
			loop:true,
            nav: true,
        },
        600:{
            items:3,
			loop:true,
            nav: true,               
        },
        1000:{
            items:4,
			loop:true,
            nav: true,
        }
    }
	});
});
</script>

<!-- Date and time pickers -->
<script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
<script>
$('input.date-pick').datepicker('setDate', 'today');
</script>

<!--Review modal validation -->
{{--<script src="{{ asset('assets/validate.js') }}"></script>--}}
@endsection

@section('hero')
    <section class="parallax-window"
             data-parallax="scroll"
             data-image-src="{{ count($item->photos) ? asset('storage/' . $item->photos->first()->path) : asset('img/single_hotel_bg_1.jpg') }}"
             data-natural-width="1400" >
        <div class="parallax-content-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-sm-8">
                        <span class="rating">
                            {{-- TODO: Draw the stars --}}
                            @include('shared.rating_stars', ['rating' => round($item['rating_value'])])
                            @include('shared.rating_text', [
                                'rating' => $item['rating_value'],
                                'rating_votes' =>$item['rating_votes']])
                        </span>
                        <h1>{{ $item['title'] }}</h1>
                        <span>{{ $item['country']->name }} &rsaquo; {{ $item['state'] }} &rsaquo; {{ $item['city'] }}</span>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div id="price_single_main" class="hotel">
                            per person 
							@if ($item['base_price'] == 0 || $totalPrice == 0)
							<span>$0</span>
							@else
							<span><sup>$</sup>{{ $totalPrice }}</span>
							@endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End section -->

    <div id="position">
        <div class="container">
            <ul>
                <li><a href="{{ route('homepage') }}">Home</a></li>
                <li><a href="{{ route('coverage') }}">Classes</a></li>
                <li>{{ $item->category->name }}</li>
            </ul>
        </div>
    </div><!-- End Position -->
@endsection

@section('content')
    

    <div class="collapse" id="collapseMap">
        <div id="map" class="map"></div>
    </div><!-- End Map -->
    <div class="container margin_60">
	    @include('shared.flash')
        <div class="row">
            <div class="col-md-8" id="single_tour_desc">

                <p class="visible-sm visible-xs"><a class="btn_map" data-toggle="collapse" href="#collapseMap" aria-expanded="false" aria-controls="collapseMap" data-text-swap="Hide map" data-text-original="View on map">View on map</a></p><!-- Map button for tablets/mobiles -->
                <div id="Img_carousel" class="slider-pro">
                    <div class="sp-slides">
                        @foreach($item['photos'] as $photo)
                        	@unless($loop->first)
                            <div class="sp-slide">
                                <img class="sp-image" alt="{{ $item['title'] }}" src="{{ asset('css/images/blank.gif') }}"
                                     data-src="{{ $photo->getAssetPath() }}">
                            </div>
                            @endunless
                        @endforeach

                    </div>
                    <div class="sp-thumbnails">
                        @foreach($item['photos'] as $photo)
                        @unless($loop->first)
                            <img class="sp-thumbnail" alt="{{ $item['title'] }}" src="{{ $photo->getResizedPath('200x160') }}">
                        @endunless
                        @endforeach
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-3">
                        <h3>Description</h3>
                    </div>
                    <div class="col-md-9">
                        <article>
                            <p>
                                {!! nl2br(e($item['description'])) !!}
                            </p>
                        </article>

                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <ul class="list_icons">
									{{--<li><i class="icon-calendar-empty"></i> <strong>Starts on:</strong> {{ $item['enrollment_date'] }}</li>--}}
									{{-- TBA --}}
									@if ($item['id'] <= 3109)
									<li><i class="icon-location-5"></i> <strong>Location:</strong> <strong style="color:green">Verified</strong> <div class="tooltip_styled tooltip-effect-1" data-placement="right"><span class="tooltip-item"><i class="icon-info-circled"></i></span>
									<div class="tooltip-content">The location for this class has been verified. Location &amp; how to get to this class is provided after booking is confirmed.</div></li>
									@endif
                                    <li><i class="icon-back-in-time"></i> <strong>Duration:</strong> {{ $item['duration']['title'] }}</li>
									<li><i class="icon-ok"></i> <strong>Cancellation Policy:</strong> {{ App\Classroom::CANCELLATION[$item['cancellation_policy']] }} <a href="https://www.classrr.com/support/knowledge-base/kind-cancellation-policies-can-implement-classes/" target="_blank">(learn more)</a></li>
									{{-- TBA --}}
									@if ($item['id'] <= 3109 && $item['base_price'] >= 17 && $item['id'] % 2 != 0)
									<li><i class="icon-home-4"></i> <strong>Amenities:</strong> Home, Library, Whiteboard, Projector, Bus Stop, MRT Station, Pantry, WiFi</li>
									@elseif ($item['id'] <= 3106 && $item['base_price'] >= 17 && $item['id'] % 2 == 0)
									<li><i class="icon-home-4"></i> <strong>Amenities:</strong> Home, Whiteboard, Projector, Bus Stop, Pantry, Minimarket, WiFi</li>
									@elseif ($item['id'] <= 3106 && $item['base_price'] == 15 && $item['id'] % 2 == 0)
									<li><i class="icon-home-4"></i> <strong>Amenities:</strong> Private Classroom, Whiteboard, Projector, WiFi</li>
									@elseif ($item['id'] <= 3106 && $item['base_price'] == 15 && $item['id'] % 2 != 0)
									<li><i class="icon-home-4"></i> <strong>Amenities:</strong> Public Place, Whiteboard, Laptop, Books, Pantry, Bus Stop, WiFi</li>
									@elseif ($item['id'] <= 3106 && $item['base_price'] == 12 && $item['id'] % 2 == 0)
									<li><i class="icon-home-4"></i> <strong>Amenities:</strong> Private Classroom, Whiteboard, WiFi</li>
									@elseif ($item['id'] <= 3106 && $item['base_price'] == 12 && $item['id'] % 2 != 0)
									<li><i class="icon-home-4"></i> <strong>Amenities:</strong> Private Classroom, Whiteboard, Pantry, WiFi</li>
									@elseif ($item['id'] <= 3106 && $item['base_price'] <= 10 && $item['id'] % 2 == 0)
									<li><i class="icon-home-4"></i> <strong>Amenities:</strong> Private Classroom, Whiteboard, Drinks, Minimarket, WiFi</li>
									@elseif ($item['id'] <= 3106 && $item['base_price'] <= 10 && $item['id'] % 2 != 0)
									<li><i class="icon-home-4"></i> <strong>Amenities:</strong> Public Place, Laptop, Books, WiFi</li>
									@elseif ($item['id'] <= 3106 && $item['base_price'] == 16)
									<li><i class="icon-home-4"></i> <strong>Amenities:</strong> Private Classroom, Library, Laptop, Books, Minimarket, Coffee Shop, WiFi</li>
									@endif
                                </ul>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <ul class="list_icons">
                                    <li><i class="icon-signal-4"></i> <strong>Level:</strong> {{ $item['level']['title'] }}</li>
                                    <li><i class="icon-users"></i> <strong>Seats Left:</strong> {{ $item['number_student'] }} students</li>
									<li><i class="icon-chat"></i> <strong>Main Language:</strong> {{ $item['language'] }}</li>

                                </ul>
                            </div>
                        </div>

                        @if($item['rules'] != [""])
                        <h4>Classroom Policy</h4>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <ul class="list_ok">
                                    {{-- First half of rules --}}
                                    @for ($i = 0;
                                        $i < floor(count($item['rules'])/2) + (count($item['rules']) % 2 === 0 ? 0 : 1); $i++)
                                        <li>{{ $item['rules'][$i] }}</li>
                                    @endfor
                                </ul>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <ul class="list_ok">
                                    {{-- If  --}}
                                    @for ($i = ceil(count($item['rules'])/2);
                                        $i < count($item['rules']); $i++)
                                        <li>{{ $item['rules'][$i] }}</li>
                                    @endfor
                                </ul>
                            </div>
                        </div><!-- End row  -->
                        @endif
                    </div><!-- End col-md-9  -->
                </div><!-- End row  -->
				
				<hr>
				
				@include('classroom.view-skills')

                <hr>

                <div class="row">
                    <div class="col-md-3">
                        <h3>Teachers</h3>
                    </div>
                    <div class="col-md-9">
                        <div class="review_strip_single no-border">
                            <a href="{{ route('homepage') }}/profile/{{ $item['user']->profile_slug }}"><img src="{{ $item['user']['avatar'] ?
                            $item['user']->getAvatarPath() : 'https://api.adorable.io/avatars/68/airuser' . $item['user']['id']  }}" alt="{{ $item['user']->pretty_name() }}" class="img-circle avatar-sm"></a>
                            <small> - Created {{ $item['created_at']->diffForHumans() }} -</small>
                            <a href="{{ route('homepage') }}/profile/{{ $item['user']->profile_slug }}"><h4>{{ $item['user']->pretty_name() }}</h4></a>
                            <p>
								{!! nl2br(e($item['user']['about_me'])) !!}
                            </p>
							<p>
                            @if ($is_active)
                                @if(Auth::user() && Auth::user()->id != $item->user_id)
                                    <a class="btn_1"  href="#"  data-toggle="modal" data-target="#contactModal" data-id="{{ $item->id }}">Contact Me</a>
                                @elseif(!Auth::user())
                                    <a class="btn_1"  href="/login">Contact Me</a>
                                @endif
                            @endif
							</p>
                            <strong>Share this class with a friend!</strong>
							<div id="shareIcons" style="font-size:20px"></div>
                        </div><!-- End review strip -->
                    </div>
                </div>
				
                @if ($item['curriculum']->first())
				<hr>
                <div class="row">
                    <div class="col-md-3">
                        <h3>Curriculum
                            <a class="toggle-switch" href="#curriculum-table" aria-expanded="true" data-toggle="collapse">
                                <i class="icon-angle-circled-down"></i>
                                <i class="icon-angle-circled-up"></i>
                            </a></h3>
                    </div>
                    <div class="col-md-9">
                        <div class=" table-responsive collapse in" id="curriculum-table">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th colspan="3">
                                        Section 1
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($item['curriculum'] as $lecture)
                                    <tr>
                                        <td width="80px">
                                            Lecture {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            {{ $lecture['title'] }}
                                        </td>
                                        <td width="80px">
                                            {{ $lecture->pretty_duration() }}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
				<hr>
				@else
				<hr>
                @endif

                <div class="row">
                    <div class="col-md-3">
                        <h3>Schedule</h3>
                    </div>
                    <div class="col-md-9">
                        @if ($item->isOpenAt('morning'))
                        <div class=" table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th colspan="2">
                                        Morning Schedule
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @include('classroom.schedule_item_at_show', ['formatted_schedule' => $item->getFormattedSchedule(), 'day_time' => 'morning'])
                                </tbody>
                            </table>
                        </div>
                        @endif
                        @if ($item->isOpenAt('afternoon'))

                        <div class=" table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th colspan="2">
                                        Afternoon Schedule
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @include('classroom.schedule_item_at_show', ['formatted_schedule' => $item->getFormattedSchedule(), 'day_time' => 'afternoon'])
                                </tbody>
                            </table>
                        </div>
                        @endif
                        @if ($item->isOpenAt('evening'))

                        <div class=" table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th colspan="2">
                                        Evening Schedule
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                @include('classroom.schedule_item_at_show', ['formatted_schedule' => $item->getFormattedSchedule(), 'day_time' => 'evening'])
                                </tbody>
                            </table>
                        </div>
                        @endif

                    </div>
                </div>

                <hr>


                <div class="row">
                    <div class="col-md-3">
                        <h3>Classroom</h3>
                    </div>
                    <div class="col-md-9">
                        <h4>Additional Information</h4>
                        @if ($item['advanced_booking'])
                        <p>
                            {{ $item['advanced_booking'] }}
                        </p>
                        @endif

                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <ul class="list_icons">
                                    @if($item['is_international'])
                                        <li><i class="icon-doc"></i> Visa help</li>
                                    @endif
                                    @if($item['is_guaranteed'])
                                        <li><i class="icon-lifebuoy"></i> <strong style="color:green">7-day guarantee</strong> <a href="https://www.classrr.com/support/knowledge-base/7-day-satisfaction-guarantee-work-student/" target="_blank">(learn more)</a></li>
                                    @endif
                                    @if($item['age_range'])
                                        <li><i class="icon-adult"></i>{{ $item['age_range'] }}</li>
                                    @endif

                                </ul>
                            </div>
                            <div class="col-md-6 col-sm-6">
                            </div>
                        </div><!-- End row  -->


                    </div><!-- End col-md-9  -->
                </div><!-- End row  -->

                <hr>

                <div class="row">
                    <div class="col-md-3">
                        <h3>Reviews<br />
						<small>#ObserveMe</small></h3>
						@if(Auth::user() && Auth::user()->id != $item->user_id)
                        <a href="#" class="btn_1 add_bottom_30" data-toggle="modal" data-target="#myReview">Leave a review</a>
						@elseif(!Auth::user())
						<a href="#" class="btn_1 add_bottom_30" data-toggle="modal" data-target="#myReview">Leave a review</a>
						@endif
                    </div>
                    <div class="col-md-9">
                        <div id="score_detail"><span>{{ round($item['rating_value'], 1) }}</span>Good <small>(Based on {{ $item['rating_votes'] }} reviews)</small></div><!-- End general_rating -->
                        <hr>
                        @foreach($reviews as $review)
                            <div class="review_strip_single">
                                <a href="{{ route('homepage') }}/profile/{{ $review['user']->profile_slug }}"><img src="{{ $review['user']['avatar'] ?
                                $review['user']->getAvatarPath() : 'https://api.adorable.io/avatars/68/airuser' . $review['user']['id']  }}" alt="{{ $review['user']->pretty_name() }}" class="img-circle avatar-sm"></a>
                                <small> - {{ $review['created_at']->format('M j, Y H:i') }} -</small>
                                <a href="{{ route('homepage') }}/profile/{{ $review['user']->profile_slug }}"><h4>{{ $review['user']->pretty_name() }}</h4></a>
                                <p>
								@if ($review['is_verified'] === 1)
								<small><i class="icon-ok-circle"></i><strong style="color:green">Verified Review</strong></small><br />
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
            </div><!--End  single_tour_desc-->

            <aside class="col-md-4" id="sidebar" style="z-index:999">
                <p class="hidden-sm hidden-xs">
                    <a class="btn_map" data-toggle="collapse" href="#collapseMap" aria-expanded="false" aria-controls="collapseMap" data-text-swap="Hide map" data-text-original="View on map">View on map</a>
                </p>

            @if ($is_active)
			<div class="theiaStickySidebar">
                <div id="booking-panel" class="box_style_1 expose">
                    <form action="{{ route('payments_book') }}" method="get">
                        <input type="hidden" name="item_id" id="item_id" value="{{ $item->id }}">
                        <h3 class="inner">- Instant Booking -</h3>
                        <div class="form-group">
                            <label>Preferred class time</label>
                            <select name="time" id="time-select" class="form-control">
                                @foreach($time_open as $time)
                                    <option value="{{ $time }}">{{ ucfirst($time) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Desired start date</label>
                            <select name="enrollment_date" id="enrollment_date-select" class="form-control">
                                @foreach($enrollment_dates as $endate)
									@if ($endate > date('Y-m-d'))
                                    <option value="{{ $endate }}">{{ Carbon::parse($endate)->format(config('app.dateformat_php')) }}</option>
									@else
									<option value="{{ $endate }}" hidden disabled>{{ Carbon::parse($endate)->format(config('app.dateformat_php')) }}</option>
									@endif
                                @endforeach
                            </select>
                        </div>
                        <br>
                        <table class="table table_summary">
                            <thead>
                            <tr>
                                <td>
                                    Duration
                                </td>
                                <td class="text-right">
                                    {{ $item->duration->title }}
                                </td>
                            </tr>
                            </thead>
                            <tbody id="prebook-result">
                            </tbody>
                        </table>
                        <button id="classBook" class="btn_full" href="{{ route('payments_book') }}">Book now</button>
						<center>You won't be charged until your booking is confirmed by the teacher</center>
                    </form>
                </div><!--/box_style_1 -->
			</div><!--/end sticky -->
            @endif
            </aside>
        </div><!--End row -->
		@if($relatedTeacher && count($relatedTeacher) > 4)
		<hr>
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-6">
				<h4><span class="text-left"><strong>
				More Classes by {{ $item['user']->pretty_name() }}
				</strong></span></h4>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6">
				<h4><p class="text-right"><strong><a href="{{ route('coverage') }}">See all &rsaquo;</a></strong></p></h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
			<div class="owl-carousel">
			@foreach($relatedTeacher as $relate)
            <div class="tour_container">
				<div class="img_container">
					<a href="{{ route('classroom_show', $relate->id) }}">
					<img src="{{ $relate->getThumb() }}" width="800" height="533" class="img-responsive" alt="{{ $relate->title }}">
						<div class="short_info">
							@if ($relate['base_price'] == 0)
							<span class="price">$0</span>
							@else
							<span class="price"><sup>$</sup>{{ $relate['base_price'] }}</span>
							@endif
						</div>
					</a>
				</div>
				<div class="tour_title">
					<p style="color:#e04f67;margin-bottom:6px">
						<strong><a href="{{ route('classroom_list') }}?cat_id={{ $relate->category->id }}">{{ $relate->category->name }}</a> - <a href="{{ route('classroom_list') }}?where={{ $relate['city'] }}">{{ $relate['city'] }}</a></strong>
					</p>
					<h3><strong><a href="{{ route('classroom_show', ['id' => $relate['id']]) }}">{{ $relate->title }}</a></strong></h3>
					<div class="rating">
						{{--@include('shared.rating_stars', ['rating' => round($relate['rating_value'])])--}}
					</div><!-- end rating -->
				</div>
			</div>
            @endforeach
			</div>
			</div>
        </div>
		@endif
		@if($relatedCategory && count($relatedCategory) > 4)
		<hr>
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-6">
				<h4><span class="text-left"><strong>
				More Classes in {{ $item->category->name }}
				</strong></span></h4>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6">
				<h4><p class="text-right"><strong><a href="{{ route('coverage') }}">See all &rsaquo;</a></strong></p></h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
			<div class="owl-carousel">
			@foreach($relatedCategory as $relate)
            <div class="tour_container">
				<div class="img_container">
					<a href="{{ route('classroom_show', $relate->id) }}">
					<img src="{{ $relate->getThumb() }}" width="800" height="533" class="img-responsive" alt="{{ $relate->title }}">
						<div class="short_info">
							@if ($relate['base_price'] == 0)
							<span class="price">$0</span>
							@else
							<span class="price"><sup>$</sup>{{ $relate['base_price'] }}</span>
							@endif
						</div>
					</a>
				</div>
				<div class="tour_title">
					<p style="color:#e04f67;margin-bottom:6px">
						<strong><a href="{{ route('classroom_list') }}?cat_id={{ $relate->category->id }}">{{ $relate->category->name }}</a> - <a href="{{ route('classroom_list') }}?where={{ $relate['city'] }}">{{ $relate['city'] }}</a></strong>
					</p>
					<h3><strong><a href="{{ route('classroom_show', ['id' => $relate['id']]) }}">{{ $relate->title }}</a></strong></h3>
					<div class="rating">
						{{--@include('shared.rating_stars', ['rating' => round($relate['rating_value'])])--}}
					</div><!-- end rating -->
				</div>
			</div>
            @endforeach
			</div>
			</div>
        </div>
		@endif
		@if($relatedCity && count($relatedCity) > 4)
		<hr>
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-6">
				<h4><span class="text-left"><strong>
				Other Classes in The Same Area
				</strong></span></h4>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6">
				<h4><p class="text-right"><strong><a href="{{ route('coverage') }}">See all &rsaquo;</a></strong></p></h4>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
			<div class="owl-carousel">
			@foreach($relatedCity as $relate)
            <div class="tour_container">
				<div class="img_container">
					<a href="{{ route('classroom_show', $relate->id) }}">
					<img src="{{ $relate->getThumb() }}" width="800" height="533" class="img-responsive" alt="{{ $relate->title }}">
						<div class="short_info">
							@if ($relate['base_price'] == 0)
							<span class="price">$0</span>
							@else
							<span class="price"><sup>$</sup>{{ $relate['base_price'] }}</span>
							@endif
						</div>
					</a>
				</div>
				<div class="tour_title">
					<p style="color:#e04f67;margin-bottom:6px">
						<strong><a href="{{ route('classroom_list') }}?cat_id={{ $relate->category->id }}">{{ $relate->category->name }}</a> - <a href="{{ route('classroom_list') }}?where={{ $relate['city'] }}">{{ $relate['city'] }}</a></strong>
					</p>
					<h3><strong><a href="{{ route('classroom_show', ['id' => $relate['id']]) }}">{{ $relate->title }}</a></strong></h3>
					<div class="rating">
						{{--@include('shared.rating_stars', ['rating' => round($relate['rating_value'])])--}}
					</div><!-- end rating -->
				</div>
			</div>
            @endforeach
			</div>
			</div>
        </div>
		@endif
		</div>
    </div><!--End container -->

    <div id="overlay"></div><!-- Mask on input focus -->

    <!-- Modal Review -->
    <div class="modal fade" id="myReview" tabindex="-1" role="dialog" aria-labelledby="myReviewLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myReviewLabel">Write your review</h4>
                </div>
                <div class="modal-body">
                    <div id="message-review">
                    </div>
                    {!! Form::open(['route' => 'classroom_review_store', 'id' => 'review_classroom', 'method' => 'post']) !!}

                        <input type="hidden" name="object_id" value="{{ $item['id'] }}">

                        <div class="form-group">
                            <textarea name="comment" id="comment" class="form-control" style="height:100px" placeholder="Tell us your experience..."></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    {!! app('captcha')->display() !!}
                                {{--<div class="g-recaptcha" data-sitekey="6LfdMw4UAAAAABgJIsf6kzxNIWtJIB-l-Zm681NB"></div>--}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Rating</label>
                                    <select class="form-control" name="rating">
                                        @for($i = 10; $i >= 1; $i--)
                                            <option value="{{ $i }}">{{ $i . ' ' . str_plural('Star', $i) }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
						<hr>
							Review is open to public so teachers can gather more information from their students from outside Classrr. 
							Submitting spam &amp; false information is strictly forbidden. 
						<hr>
                        <input type="submit" value="Submit" class="btn_1" id="submit-review">
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div><!-- End modal review -->

    @include('partials.contact-classroom-modal')

    <div id="toBook" class="visible-xs">Book Now</div><!-- Back to top button -->

@endsection

@section('fbpixel')

<script type="text/javascript">
    $('#classBook').click(function() {
        fbq('track', 'InitiateCheckout', {
        content_ids: {{ $item['id'] }},
        currency: 'USD',
		content_type: 'product'
        });
    });
</script>

@endsection

@section('customscript')

{{--signal--}}
<script>var classroom_id = "{{ $item['id'] }}";</script>
<script>var finder = "{{ rand(8,55) }}";</script>
<script>var matcher = "{{ rand(2,6) }}";</script>
<!--{{ $spin1 = rand(1,25) }}{{ rand(100000,800000) }}-->
@if($item['id'] <= 3000)
@if($spin1 <= 7)
<script src="{{ asset('js/notify_func.js') }}"></script>
@endif
@if($spin1 >= 22)
<script src="{{ asset('js/notify_func2.js') }}"></script>
@endif
@endif

<!--Map Info-->
<script>
var name = "{{ $item['title'] }}";
var lat = "{{ $item['lat'] }}";
var lng = "{{ $item['lng'] }}";
var imgmap = "{{ $item->getThumb() }}";
var desc = "{{ json_encode(str_limit(e($item['description']),65,'...')) }}";
</script>
<script src="{{ asset('js/map_transfer.js') }}"></script>
<script src="{{ asset('js/infobox.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#collapse-skill').on('show.bs.collapse', function() {
        $('#btn-more-skill').html('less -');
    });
    $('#collapse-skill').on('hide.bs.collapse', function() {
        $('#btn-more-skill').html('more +');
    })
  });
</script>
@endsection
