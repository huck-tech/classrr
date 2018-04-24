@extends('layout')

@section('title_tag')
<title>Travel for Free - Classrr Compass</title>
@endsection

@section('meta_description', 'Sign up now and enjoy traveling the world. Travel, teach, learn &amp; connect with learners from all over the world.')


@section('additional_styles')
<link href="{{ asset('css/timeline.css') }}" rel="stylesheet">
@endsection

@section('additional_javascript')
@endsection

@section('hero')
    <section id="hero">
        <div class="intro_title">
            <h3 class="animated fadeInDown">@lang('page_quotes.travel_title')</a></h3>
			<p class="animated fadeInDown">@lang('page_quotes.travel_caption')</strong></p>
			{{--<a href="#" class="animated fadeInUp button_intro">View Tours</a> <a href="#" class="animated fadeInUp button_intro outline">View Tickets</a>--}}
        </div>
    </section><!-- End hero -->

    <div id="position">
        <div class="container">
            <ul>
                <li><a href="{{ route('homepage') }}">@lang('breadcrumb.home')</a></li>
				<li><a href="{{ route('compass') }}">@lang('breadcrumb.compass')</a></li>
                <li>@lang('breadcrumb.travel')</li>
            </ul>
        </div>
    </div><!-- Position -->
@endsection

@section('content')
    <div class="container margin_60">
        <div class="main_title">
            <h2>@lang('travel.tagline')</h2>
            <p>
                @lang('travel.caption')<br /><br />
				<small>@lang('travel.note', [ 'link' => route('referral_program') ])</small>
            </p>
        </div>
        <hr>
        <ul class="cbp_tmtimeline">
				<li>
					<time class="cbp_tmtime" datetime="2017"><span>July - Dec</span> <span>2017</span>
					</time>
					<div class="cbp_tmicon timeline_icon_test"></div>
					<div class="cbp_tmicon timeline_icon_test"></div>
					<div class="cbp_tmlabel">
						<h4>@lang('travel.timeline_title_1')</h4>
						<p>@lang('travel.timeline_content_1')</p>
					</div>
				</li>
				<li>
					<time class="cbp_tmtime" datetime="2018"><span>Jan</span> <span>2018</span>
					</time>
					<div class="cbp_tmicon timeline_icon_break"></div>
					<div class="cbp_tmlabel">
						<h4>@lang('travel.timeline_title_2')</h4>
						<p>@lang('travel.timeline_content_2')</p>
					</div>
				</li>
				<li>
					<time class="cbp_tmtime" datetime="2018"><span>Feb - Jun</span> <span>2018</span>
					</time>
					<div class="cbp_tmicon timeline_icon_point"></div>
					<div class="cbp_tmlabel">
						<h4>@lang('travel.timeline_title_3')</h4>
						<p>@lang('travel.timeline_content_3')</p>
					</div>
				</li>
				<li>
					<time class="cbp_tmtime" datetime="2018"><span>Jul - Dec</span> <span>2018</span>
					</time>
					<div class="cbp_tmicon timeline_icon_doc"></div>
					<div class="cbp_tmlabel">
						<h4>@lang('travel.timeline_title_4')</h4>
						<p>@lang('travel.timeline_content_4')</p>
					</div>
				</li>
			</ul>
		<hr>
		<div class="main_title">
            <h2>@lang('travel.card_title')</h2>
            <p>
                @lang('travel.card_caption')
            </p>
        </div>
		<div class="row">
                  <div class="col-md-3 col-sm-3">
                  
                  <div class="box_style_2">
                    <img src="https://www.classrr.com/storage/images/df3ebaa65fadbb7b6a49a5babd06089e.jpeg" style="width:80px;height:80px;" alt="Marcelo Fisher Classrr Top Performing Teachers" class="img-circle">
                    <h4>Marcelo Fisher
					<br /><small>@lang('travel.card_now') India</small></h4>
                        <a href="https://www.classrr.com/profile/marcelo-fisher">@lang('travel.card_link')</a>    
                </div> 
                  
                  </div>
                  <div class="col-md-3 col-sm-3">
                  
                   <div class="box_style_2">
                   <img src="https://www.classrr.com/storage/images/42ac809aaa8dacedc922254d28e0f666.jpeg" style="width:80px;height:80px;" alt="Giada Rivera Classrr Top Performing Teachers" class="img-circle">
                    <h4>Giada Rivera
					<br /><small>@lang('travel.card_now') Singapore</small></h4>
                        <a href="https://www.classrr.com/profile/giada-rivera">@lang('travel.card_link')</a>    
                </div>
                  
                  </div>
				  <div class="col-md-3 col-sm-3">
                  
                   <div class="box_style_2">
                   <img src="https://www.classrr.com/storage/images/a9044327e7940c1ef17472b8573afbd4.jpeg" style="width:80px;height:80px;" alt="Martha Torres Classrr Top Performing Teachers" class="img-circle">
                    <h4>Martha Torres
					<br /><small>@lang('travel.card_now') Shanghai</small></h4>
                        <a href="https://www.classrr.com/profile/martha-torres">@lang('travel.card_link')</a>    
                </div>
                  
                  </div>
				  <div class="col-md-3 col-sm-3">
                  
                   <div class="box_style_2">
                   <img src="https://www.classrr.com/storage/images/eb16fde8a6a87061005d8e50e9360dbf.jpeg" style="width:80px;height:80px;" alt="Livia Lewis Classrr Top Performing Teachers" class="img-circle">
                    <h4>Livia Lewis
					<br /><small>@lang('travel.card_now') Indonesia</small></h4>
                        <a href="https://www.classrr.com/profile/livia-lewis">@lang('travel.card_link')</a>    
                </div>
                  
                  </div>
            </div><!-- End row-->
			<p class="text-center nopadding">
				@unless (Auth::check())
				<a href="{{ url('register') }}" class="btn_1 medium"><i class="icon-eye-7"></i>@lang('travel.card_more') (156) </a>
				@else
				<a href="{{ route('coverage') }}" class="btn_1 medium"><i class="icon-eye-7"></i>@lang('travel.card_more') (156) </a>
				@endif
			</p>
        <hr>
		<div class="main_title">
            <p>@lang('travel.cta_social')</p>
        </div>
        <div class="text-center" id="shareIcons" style="font-size:20px"></div>
    </div><!-- End container -->
@endsection