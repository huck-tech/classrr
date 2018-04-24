@extends('layout')

@section('title', trans('home.page_title'))
@section('meta_title', trans('home.meta_title'))
@section('meta_description', trans('home.meta_description'))

@section('prop_title', trans('home.meta_title'))
@section('prop_description', trans('home.meta_description'))
@section('prop_image', asset('/img/features-intro-01.jpg'))

@section('og_title', trans('home.meta_title'))
@section('og_description', trans('home.meta_description'))
@section('og_image', asset('img/features-intro-01.jpg'))
@section('og_url', Request::url())

@section('additional_styles')
<link href="{{ asset('css/shop.css') }}" rel="stylesheet"/>
<link href="{{ asset('css/profile-skill.css') }}" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/owl-carousel/owl.carousel.min.css')}}"/>
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/owl-carousel/owl.theme.default.min.css')}}"/>
<style>

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
@if(auth()->check())
<script type="text/javascript">
    window.DataDEFAULT = {!! json_encode($data_default) !!};    
    $(document).ready(function() {                
        @if(auth()->user()->skill_points > 0)
            $('#modal-skill').modal();
        @endif           

        @if(session('status'))
        $.notify("{!! session('status') !!}");
        @endif
    });
</script>
<script type="text/javascript" src="{{ asset('js/profile/profile.js')}}"></script>
@endif
<script type="text/javascript" src="{{ asset('vendor/owl-carousel/owl.carousel.min.js') }}"></script>
<script type="text/javascript">
$(document).ready(function() {
	$(".owl-carousel").owlCarousel({
    loop: false,    
    responsiveClass:true,
    responsive:{
        0:{
            items:1,     
			loop: true,
            nav: true,
        },
        600:{
            items:3,   
			loop: true,
            nav: true,               
        },
        1000:{
            items:4,     
			loop: true,
            nav: true,
        }
    }
	});
});
</script>
@endsection

@section('content')
    


    <section class="container margin_60" id="app">
        @if(auth()->check())
            @include('user.modal-skill')
        @endif

        <div class="main_title">
            <h2>@lang('home.learn_today')</h2>
			<p>@lang('home.learn_today_caption')</p>
        </div>
		
		@if($nearby && count($nearby) > 4)
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-6">
				<h4><span class="text-left"><strong>
				Classes Near {{ $city }}
				</strong></span></h4>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6">
				<h4><p class="text-right"><strong><a href="{{ route('coverage') }}">@lang('home.see_all')</a></strong></p></h4>
			</div>
		</div>
        <div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
			<div class="owl-carousel">
			@foreach($nearby as $item)
            <div class="tour_container">
				<div class="img_container">
					<a href="{{ route('classroom_show', $item->id) }}">
					<img src="{{ $item->getThumb() }}" width="800" height="533" class="img-responsive" alt="{{ $item->title }}">
						<div class="short_info">
							@if ($item['base_price'] == 0)
							<span class="price">$0</span>
							@else
							<span class="price"><sup>$</sup>{{ $item['base_price'] }}</span>
							@endif
						</div>
					</a>
				</div>
				<div class="tour_title">
					<p style="color:#e04f67;margin-bottom:6px">
						<strong><a href="{{ route('classroom_list') }}?cat_id={{ $item->category->id }}">{{ $item->category->name }}</a> - <a href="{{ route('classroom_list') }}?where={{ $item['city'] }}">{{ $item['city'] }}</a></strong>
					</p>
					<h3><strong><a href="{{ route('classroom_show', ['id' => $item['id']]) }}">{{ $item->title }}</a></strong></h3>
					<div class="rating">
						{{--@include('shared.rating_stars', ['rating' => round($item['rating_value'])])--}}
					</div><!-- end rating -->
				</div>
			</div>
            @endforeach
			</div>
			</div>
        </div>
		<hr>
		@endif
		
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-6">
				<h4><span class="text-left"><strong>@lang('home.free_classes')</strong></span></h4>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6">
				<h4><p class="text-right"><strong><a href="{{ route('coverage') }}">@lang('home.see_all')</a></strong></p></h4>
			</div>
		</div>
        <div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
			<div class="owl-carousel">
			@foreach($freebies as $item)
            <div class="tour_container">
				<div class="img_container">
					<a href="{{ route('classroom_show', $item->id) }}">
					<img src="{{ $item->getThumb() }}" width="800" height="533" class="img-responsive" alt="{{ $item->title }}">
						<div class="short_info">
							@if ($item['base_price'] == 0)
							<span class="price">$0</span>
							@else
							<span class="price"><sup>$</sup>{{ $item['base_price'] }}</span>
							@endif
						</div>
					</a>
				</div>
				<div class="tour_title">
					<p style="color:#e04f67;margin-bottom:6px">
						<strong><a href="{{ route('classroom_list') }}?cat_id={{ $item->category->id }}">{{ $item->category->name }}</a> - <a href="{{ route('classroom_list') }}?where={{ $item['city'] }}">{{ $item['city'] }}</a></strong>
					</p>
					<h3><strong><a href="{{ route('classroom_show', ['id' => $item['id']]) }}">{{ $item->title }}</a></strong></h3>
					<div class="rating">
						{{--@include('shared.rating_stars', ['rating' => round($item['rating_value'])])--}}
					</div><!-- end rating -->
				</div>
			</div>
            @endforeach
			</div>
			</div>
        </div>
		<hr>

		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-6">
				<h4><span class="text-left"><strong>@lang('home.featured_classes')</strong></span></h4>
			</div>
			<div class="col-md-6 col-sm-6 col-xs-6">
				<h4><p class="text-right"><strong><a href="{{ route('coverage') }}">@lang('home.see_all')</a></strong></p></h4>
			</div>
		</div>
        <div class="row">
			<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
			<div class="owl-carousel">
			@foreach($featured as $item)
            <div class="tour_container">
				<div class="img_container">
					<a href="{{ route('classroom_show', $item->id) }}">
					<img src="{{ $item->getThumb() }}" width="800" height="533" class="img-responsive" alt="{{ $item->title }}">
						<div class="short_info">
							@if ($item['base_price'] == 0)
							<span class="price">$0</span>
							@else
							<span class="price"><sup>$</sup>{{ $item['base_price'] }}</span>
							@endif
						</div>
					</a>
				</div>
				<div class="tour_title">
					<p style="color:#e04f67;margin-bottom:6px">
						<strong><a href="{{ route('classroom_list') }}?cat_id={{ $item->category->id }}">{{ $item->category->name }}</a> - <a href="{{ route('classroom_list') }}?where={{ $item['city'] }}">{{ $item['city'] }}</a></strong>
					</p>
					<h3><strong><a href="{{ route('classroom_show', ['id' => $item['id']]) }}">{{ $item->title }}</a></strong></h3>
					<div class="rating">
						{{--@include('shared.rating_stars', ['rating' => round($item['rating_value'])])--}}
					</div><!-- end rating -->
				</div>
			</div>
            @endforeach
			</div>
			</div>
        </div><!-- End row -->
		<hr>
        <div class="main_title">
            <p><strong>@lang('home.support_freedom')</strong><br />
			<small><em>@lang('home.support_freedom_caption')</em></small></p>
        </div>
		<div class="row">
			<div class="col-md-4 col-sm-4 text-center">
				<h4 style="color:green"><i class="icon-trophy"></i>@lang('home.feature_1')</h4>
			</div>
			<div class="col-md-4 col-sm-4 text-center">
				<h4 style="color:green"><i class="icon-trophy"></i>@lang('home.feature_2')</h4>
			</div>
			<div class="col-md-4 col-sm-4 text-center">
				<h4 style="color:green"><i class="icon-trophy"></i>@lang('home.feature_3')</h4>
			</div>
		</div>
        <div class="text-center" id="shareIcons" style="font-size:20px"></div>
        {{--
        <p class="text-center nopadding"> <a href="{{ route('classroom_list') }}" class="btn_1 medium"><i class="icon-eye-7"></i>View more</a>
        </p>
        --}}
    </section><!-- End section -->

    <section class="white_bg">
        <div class="container margin_60">
            <div class="main_title">
                <h2>@lang('home.how_work')</h2>
                <p>@lang('home.how_work_caption')</p>
            </div>

            <div class="row how_it_works_home">
                <div class="item col-md-3 col-sm-3 text-center">
                    <i class="line-arrow square right hidden-xs"></i>
                    <p>
                        <i class="icon icon_set_1_icon-42 hidden-xs"></i>
                    </p>
                    <h4><span>1.</span> @lang('home.how_work_topic1')</h4>
                    <p>@lang('home.how_work_topic1_caption')</p>
                </div>

                <div class="item col-md-3 col-sm-3 text-center">
                    <i class="line-arrow square right hidden-xs"></i>
                    <p><i class="icon icon_set_1_icon-81 hidden-xs"></i></p>
                    <h4><span>2.</span> @lang('home.how_work_topic2')</h4>
                    <p>@lang('home.how_work_topic2_caption')</p>
                </div>

                <div class="item col-md-3 col-sm-3 text-center">
                    <i class="line-arrow square right hidden-xs"></i>
                    <p><i class="icon icon_set_1_icon-35 hidden-xs"></i></p>
                    <h4><span>3.</span> @lang('home.how_work_topic3')</h4>
                    <p>@lang('home.how_work_topic3_caption')</p>
                </div>

                <div class="item col-md-3 col-sm-3 text-center">
                    <p><i class="icon icon_set_1_icon-93 hidden-xs"></i></p>
                    <h4><span>4.</span> @lang('home.how_work_topic4')</h4>
                    <p>@lang('home.how_work_topic4_caption')</p>
                </div>

            </div><!-- End row -->
        </div><!-- End container -->
    </section><!-- End section -->

    <section class="promo_full">
        <div class="promo_full_wp magnific">
            <div>
                <h3>@lang('home.secure_title')</h3>
                <p>
                    <strong><mark>@lang('home.secure_caption')</mark></strong>
                </p>
                {{--<a href="{{ route('faq') }}" class="animated fadeInUp button_intro outline" target="_blank">Learn more</a>--}}
				<a href="https://www.youtube.com/watch?v=4IMo3dR337g" class="video"><i class="icon-play-circled2-1"></i></a>
            </div>
        </div>
    </section>

    <section class="margin_60 gray_bg">
        <div class="container">
            <div class="row">
                <div class="col-md-12 main_title">
                    <h2>@lang('home.benefit_title')</h2>
                    <p>@lang('home.benefit_caption')</p>
                </div>
            </div>
            
            <div class="row">
				<div class="col-md-4 col-sm-4 text-center">
					<h4><i class="icon_set_1_icon-76"></i>@lang('home.benefit_1')</h4>
					<p>
						@lang('home.benefit_1caption')
					</p>
				</div>
				<div class="col-md-4 col-sm-4 text-center">
					<h4><i class="icon_set_1_icon-76"></i>@lang('home.benefit_2')</h4>
					<p>
						@lang('home.benefit_2caption')
					</p>
				</div>
				<div class="col-md-4 col-sm-4 text-center">
					<h4><i class="icon_set_1_icon-76"></i>@lang('home.benefit_3')</h4>
					<p>
						@lang('home.benefit_3caption')
					</p>
				</div>
			</div>
				<!-- End row -->
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <h3>@lang('home.benefit_student_title')</h3>
                    <p>@lang('home.benefit_student_caption')</p>
                    <ul class="list_order">
                        <li><span>1</span>@lang('home.benefit_student_1')</li>
                        <li><span>2</span>@lang('home.benefit_student_2')</li>
                        <li><span>3</span>@lang('home.benefit_student_3')</li>
                        <li><span>4</span>@lang('home.benefit_student_4')</li>
                        <li><span>5</span>@lang('home.benefit_student_5')</li>
                    </ul>
                </div>
                <div class="col-md-6 col-sm-6">
                    <h3>@lang('home.benefit_teacher_title')</h3>
                    <p>@lang('home.benefit_teacher_caption')</p>
                    <ul class="list_order">
                        <li><span>1</span>@lang('home.benefit_teacher_1')</li>
                        <li><span>2</span>@lang('home.benefit_teacher_2')</li>
                        <li><span>3</span>@lang('home.benefit_teacher_3')</li>
                        <li><span>4</span>@lang('home.benefit_teacher_4')</li>
                        <li><span>5</span>@lang('home.benefit_teacher_5')</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
	
	<div class="white_bg">
			<div class="container margin_60">
				<div class="main_title">
					<h2>@lang('home.popular_topics')</h2>
					<p>
						@lang('home.popular_caption')
					</p>
				</div>
				<div class="row add_bottom_45">
					<div class="col-md-4 col-sm-4 other_tours">
						<ul>
							<li><a href="{{ route('classroom_list', ['q' => 'English']) }}"><i class="icon_set_1_icon-85"></i>English<span class="other_tours_price">$12</span></a>
							</li>
							<li><a href="{{ route('classroom_list', ['q' => 'Spanish']) }}"><i class="icon_set_1_icon-56"></i>Spanish<span class="other_tours_price">$15</span></a>
							</li>
							<li><a href="{{ route('classroom_list', ['q' => 'Photoshop']) }}"><i class="icon_set_1_icon-32"></i>Photoshop<span class="other_tours_price">$18</span></a>
							</li>
							<li><a href="{{ route('classroom_list', ['q' => 'Mandarin']) }}"><i class="icon_set_1_icon-73"></i>Mandarin<span class="other_tours_price">$16</span></a>
							</li>
							<li><a href="{{ route('classroom_list', ['q' => 'Yoga']) }}"><i class="icon_set_2_icon-117"></i>Yoga<span class="other_tours_price">$20</span></a>
							</li>
							<li><a href="{{ route('classroom_list', ['q' => 'Karate']) }}"><i class="icon_set_1_icon-29"></i>Karate<span class="other_tours_price">$16</span></a>
							</li>
						</ul>
					</div>
					<div class="col-md-4 col-sm-4 other_tours">
						<ul>
							<li><a href="{{ route('classroom_list', ['q' => 'Piano']) }}"><i class="icon_set_1_icon-81"></i>Piano<span class="other_tours_price">$18</span></a>
							</li>
							<li><a href="{{ route('classroom_list', ['q' => 'Guitar']) }}"><i class="icon_set_1_icon-82"></i>Guitar<span class="other_tours_price">$20</span></a>
							</li>
							<li><a href="{{ route('classroom_list', ['q' => 'Bass']) }}"><i class="icon_set_1_icon-97"></i>Bass<span class="other_tours_price">$14</span></a>
							</li>
							<li><a href="{{ route('classroom_list', ['q' => 'Drum']) }}"><i class="icon_set_2_icon-107"></i>Drum<span class="other_tours_price">$12</span></a>
							</li>
							<li><a href="{{ route('classroom_list', ['q' => 'Vocal']) }}"><i class="icon_set_1_icon-98"></i>Vocal<span class="other_tours_price">$15</span></a>
							</li>
							<li><a href="{{ route('classroom_list', ['q' => 'Trumpet']) }}"><i class="icon_set_1_icon-100"></i>Trumpet<span class="other_tours_price">$14</span></a>
							</li>
						</ul>
					</div>
					<div class="col-md-4 col-sm-4 other_tours">
						<ul>
							<li><a href="{{ route('classroom_list', ['q' => 'Math']) }}"><i class="icon_set_1_icon-11"></i>Math<span class="other_tours_price">$16</span></a>
							</li>
							<li><a href="{{ route('classroom_list', ['q' => 'Biology']) }}"><i class="icon_set_1_icon-68"></i>Biology<span class="other_tours_price">$18</span></a>
							</li>
							<li><a href="{{ route('classroom_list', ['q' => 'Statistics']) }}"><i class="icon_set_1_icon-92"></i>Statistics<span class="other_tours_price">$14</span></a>
							</li>
							<li><a href="{{ route('classroom_list', ['q' => 'Physics']) }}"><i class="icon_set_1_icon-17"></i>Physics<span class="other_tours_price">$16</span></a>
							</li>
							<li><a href="{{ route('classroom_list', ['q' => 'Chemistry']) }}"><i class="icon_set_1_icon-93"></i>Chemistry<span class="other_tours_price">$16</span></a>
							</li>
							<li><a href="{{ route('classroom_list', ['q' => 'Computer']) }}"><i class="icon_set_2_icon-116"></i>Computer<span class="other_tours_price">$17</span></a>
							</li>
						</ul>
					</div>
				</div>
				<!-- End row -->

				<div class="banner colored">
					<h3>@lang('home.cta_title')</h3>
					<p>
						@lang('home.cta_caption')
					</p>
					<a href="{{ route('get') }}" class="btn_1 white">@lang('home.cta_button')</a>
				</div>
			</div>
			<!-- End container -->
		</div>
		<!-- End white_bg -->

@endsection