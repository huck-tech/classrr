@extends('layout')

@section('title_tag')
    <title>{{ $user->first_name }} {{ $user->last_name }} | Classrr</title>
@endsection

@section('additional_metas')
  <meta name="twitter:title" content="{{ $user->first_name }} {{ $user->last_name }} | Classrr">
  <meta name="twitter:description" content="View educational profile of {{ $user->first_name }} {{ $user->last_name }} at Classrr">
  <meta name="twitter:card" content="profile" />
  <meta name="twitter:site" content="@classrr" />
  <meta name="twitter:domain" content="classrr.com" />
@endsection

@section('meta_title', e($user->first_name).' '.e($user->last_name).' | Classrr')
@section('meta_description', 'View educational profile of '.e($user->first_name).' '.e($user->last_name).' at Classrr')

@section('prop_title', e($user->first_name).' '.e($user->last_name).' | Classrr')
@section('prop_description', 'View educational profile of '.e($user->first_name).' '.e($user->last_name).' at Classrr')

@section('og_title', e($user->first_name).' '.e($user->last_name).' | Classrr')
@section('og_description', 'View educational profile of '.e($user->first_name).' '.e($user->last_name).' at Classrr')
@section('og_url', Request::url())

@section('additional_styles')
    <link rel="canonical" href="{{ Request::url() }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/slick/slick.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/slick/slick-theme.css') }}"/>
    <style>
    .slick-prev {
        margin-left: 40px;
        z-index: 900;
    }

    .slick-next {
        margin-right: 40px;
        z-index: 900;
    }
    .slick-prev:before,
    .slick-next:before {
        color: #fff;
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
<script type="text/javascript" src="{{ asset('vendor/slick/slick.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {
    $(".slickslider").slick({      
        slidesToShow: 3,
        slidesToScroll: 2,
        infinite: false,
        arrows: true,
        responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true
              }
            },
            {
              breakpoint: 600,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 2
              }
            },
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            }
        ]
    });       
});
</script>
@endsection

@section('hero')
    <section id="hero">        
        <div class="parallax-content-1">
            <div class="animated fadeInDown">
				<p>
					<img src="{{ $user['profile_avatar'] ? asset('storage/' . $user['profile_avatar']['path']) : asset('img/empty_avatar_256x256.png') }}" alt="Image" class="img-circle avatar-profile"/>
                </p>
				<h3>{{ $user->first_name }} {{ $user->last_name }}</h3>       
            </div>
        </div>
    </section>
    <!-- End section -->            
    </section><!-- End hero -->
@endsection

@section('content')

    <main>       

        <div class="margin_60 container">
            <div class="row">
                <div class="col-md-8 col-lg-8 col-sm-8 col-xs-12">
					<h3>@lang('profile_detail.my_classes')</h3> 
					<div class="slickslider">                    
					@forelse($user->classrooms as $class)					
					<div class="tour_container">
						<div class="img_container">
							<a href="{{ route('classroom_show', $class->id) }}">
								<img src="{{ $class->getThumb() }}" width="800" height="533" class="img-responsive" alt="{{ $class->title }}">
								<div class="short_info">
									@if ($class['base_price'] == 0)
									<span class="price">$0</span>
									@else
									<span class="price"><sup>$</sup>{{ $class['base_price'] }}</span>
									@endif
								</div>
							</a>
						</div>
						<div class="tour_title">
							<p style="color:#e04f67;margin-bottom:6px">
								<strong><a href="{{ route('classroom_list') }}?cat_id={{ $class->category->id }}">{{ $class->category->name }}</a> - <a href="{{ route('classroom_list') }}?where={{ $class['city'] }}">{{ $class['city'] }}</a></strong>
							</p>
							<h3><strong><a href="{{ route('classroom_show', ['id' => $class['id']]) }}">{{ $class->title }}</a></strong></h3>
							<div class="rating">
                            {{--@include('shared.rating_stars', ['rating' => round($item['rating_value'])])--}}
							</div><!-- end rating -->
						</div>
					</div>
					<!-- End box tour -->					
                    <!-- End col-md-6 -->
                    @empty                   
					</div>
                    <div class="alert alert-info">Still thinking what to teach...
                    @endforelse				
					</div>
					<br /><hr />
				</div>
                <div class="col-md-4 col-lg-4 col-sm-4">                 
                    <h3>@lang('profile_detail.about_me')</h3>                    
                    <p>
						{!! nl2br(e($user->about_me)) !!}
                    </p>
					<h3>@lang('profile_detail.my_skills')</h3>
                    <p>
                        @php
                            $allSkills = $user->skills;
                        @endphp
                        @forelse($user->skills->slice(0, 9) as $skill)
                            <span class="{{ is_max_level($skill->pivot->amount_point, $skill->max_level)? 'label label-success': 'label label-default' }}"><i class="fa fa-info-circle"></i> {{ $skill->name }} {{ $skill->pivot->amount_point}}</span>&nbsp;
                        @empty
							@if (strpos($user->email, 'airdojo') !== false)
							@if (!Auth::user())
                            <div class="alert alert-info">Please login to view {{ $user->first_name }} {{ $user->last_name }}'s skills</div>
							@else
							<div class="alert alert-info">You don't have permission to view {{ $user->first_name }} {{ $user->last_name }}'s skills</div>
							@endif
							@else
							<div class="alert alert-info">Skills not yet added...</div>
							@endif
                        @endforelse
							
						@if($user->skills->count() > 9)            
							<span id="collapse-skill" class="collapse">
							@foreach($user->skills->splice(9) as $skill)
								<span class="{{ is_max_level($skill->pivot->amount_point, $skill->max_level)? 'label label-success': 'label label-default' }}"><i class="fa fa-info-circle"></i> {{ $skill->name }} {{ $skill->pivot->amount_point}}</span>&nbsp; 
							@endforeach
							</span>
							<div><a class="btn btn-xs" data-toggle="collapse" data-target="#collapse-skill" id="btn-more-skill">more +</a></div>
						@endif
                    </p>   

					<h3>@lang('profile_detail.linked_accounts')</h3>
					<p>
					@if($user->facebook_id)
						<span class="bt_oauth bt_facebook"><i class="icon-facebook"></i> @lang('profile_detail.connected')</span><br />
					@endif
					@if($user->google_id)
						<span class="bt_oauth bt_google"><i class="icon-google"></i> @lang('profile_detail.connected')</span><br />
					@endif
					@if($user->linkedin_id)
						<span class="bt_oauth bt_linkedin"><i class="icon-linkedin"></i> @lang('profile_detail.connected')</span><br />
					@endif
					@if(!$user->linkedin_id && !$user->facebook_id && !$user->google_id)
						<div class="alert alert-info">@lang('profile_detail.no_linked_accounts')</div>				
					@endif
					</p>
					<h3>@lang('profile_detail.member_since')</h3>
					<p>
					{{ \Carbon\Carbon::parse($user->created_at)->format('d F Y') }}
					</p>
					{{-- TBA Signal --}}
					<h3>Teaching Statistics</h3>
					@if (strpos($user->email, 'airdojo.com') !== false && !$user->classrooms->isEmpty())
					@php
                        $uniq1 = strlen($user->email) + strlen($user->profile_slug);
						$uniq2 = strlen($user->first_name) * strlen($user->last_name);
						$uniq3 = $uniq1 * $uniq2 + $user->id;
                    @endphp
					<p>
					{{ number_format((float)strlen($user->email) * date('m'),0,'',',') }} students booked this month<br />
					@if (strlen($user->email) % 2 == 0 && strlen($user->profile_slug) % 2 == 0)
					${{ number_format((float)strlen($user->email) * date('m') * 58 + $uniq3,0,'',',') }} estimated earning this month<br />
					${{ number_format((float)strlen($user->email) * date('m') * 64 * 6 + $uniq3,0,'',',') }} earned last 6 months<br />
					@elseif (strlen($user->email) % 2 == 0 && strlen($user->profile_slug) % 2 != 0)
					${{ number_format((float)strlen($user->email) * date('m') * 93 + $uniq3,0,'',',') }} estimated earning this month<br />
					${{ number_format((float)strlen($user->email) * date('m') * 102 * 6 + $uniq3,0,'',',') }} earned last 6 months<br />
					@elseif (strlen($user->email) % 2 != 0 && strlen($user->profile_slug) % 2 == 0)
					${{ number_format((float)strlen($user->email) * date('m') * 18 + $uniq3,0,'',',') }} estimated earning this month<br />
					${{ number_format((float)strlen($user->email) * date('m') * 27 * 6 + $uniq3,0,'',',') }} earned last 6 months<br />
					@elseif (strlen($user->email) % 2 != 0 && strlen($user->profile_slug) % 2 != 0)
					${{ number_format((float)strlen($user->email) * date('m') * 70 + $uniq3,0,'',',') }} estimated earning this month<br />
					${{ number_format((float)strlen($user->email) * date('m') * 74 * 6 + $uniq3,0,'',',') }} earned last 6 months<br />
					@endif
					{{ number_format((float)strlen($user->email) * \Carbon\Carbon::parse($user->created_at)->format('d') + date('m'),0,'',',') }} students taught<br />
					{{ number_format((float)strlen($user->email) * \Carbon\Carbon::parse($user->created_at)->format('m') + date('m'),0,'',',') }} completed classes<br />
					</p>
					<h3>Learning Statistics</h3>
					<p>
					{{ number_format((float)strlen($user->profile_slug) * date('m'),0,'',',') }} hours learned this month<br />
					{{ number_format((float)strlen($user->email) * date('d') + strlen($user->first_name),0,'',',') }} hours learned past 6 months<br />
					${{ number_format((float)strlen($user->profile_slug) * date('d'),0,'',',') }} average spending per class<br />
					Has learned from {{ number_format((float)strlen($user->profile_slug) * \Carbon\Carbon::parse($user->created_at)->format('m') + date('m'),0,'',',') }} different teachers<br />
					Has traveled to {{ number_format((float)strlen($user->profile_slug) + \Carbon\Carbon::parse($user->created_at)->format('m') + date('m'),0,'',',') }} different cities to learn<br />
					</p>
					@else
					<div class="alert alert-info">No activity yet or user has set statistics to private</div>
					@endif
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
       
    </main>
   
@endsection

@section('customscript')
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