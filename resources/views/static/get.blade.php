@extends('layout')

@section('title', 'How it Works')
@section('meta_description', 'Get Started using Classrr is very simple, let students discover your classes now!')

@section('additional_styles')
@endsection

@section('additional_javascript')
@endsection

@section('hero')
    <section id="hero">
        <div class="intro_title">
            <h3 class="animated fadeInDown">@lang('page_quotes.getstarted_title')</h3>
            <p class="animated fadeInDown">@lang('page_quotes.getstarted_caption')</p>
            <a href="{{ route('register') }}" class="animated fadeInUp button_intro">@lang('get_started.cta_register')</a> <a href="{{ route('login') }}" class="animated fadeInUp button_intro outline">@lang('get_started.cta_login')</a>
        </div>
    </section><!-- End hero -->

    <div id="position">
        <div class="container">
            <ul>
                <li><a href="{{ route('homepage') }}">@lang('breadcrumb.home')</a></li>
                <li>@lang('breadcrumb.get_started')</li>
            </ul>
        </div>
    </div><!-- Position -->
@endsection

@section('content')
    <div class="container margin_60">
		<div class="main_title">
				<h2>@lang('get_started.tagline')</h2>
				<p>@lang('get_started.caption')</p>
			</div>

			<div class="row">
				<div class="col-md-6 wow fadeIn" data-wow-delay="0.1s">
					<div class="feature">
						<i class="icon_set_2_icon-105"></i>
						<h3>@lang('get_started.reason_title_1')</h3>
						<p>
							@lang('get_started.reason_caption_1')
						</p>
					</div>
				</div>
				<div class="col-md-6 wow fadeIn" data-wow-delay="0.2s">
					<div class="feature">
						<i class="icon_set_1_icon-18"></i>
						<h3>@lang('get_started.reason_title_2')</h3>
						<p>
							@lang('get_started.reason_caption_2')
						</p>
					</div>
				</div>
			</div>
			<!-- End row -->
			<div class="row">
				<div class="col-md-6 wow fadeIn" data-wow-delay="0.3s">
					<div class="feature">
						<i class="icon_set_1_icon-30"></i>
						<h3>@lang('get_started.reason_title_3')</h3>
						<p>
							@lang('get_started.reason_caption_3')
						</p>
					</div>
				</div>
				<div class="col-md-6 wow fadeIn" data-wow-delay="0.4s">
					<div class="feature">
						<i class="icon_set_1_icon-41"></i>
						<h3>@lang('get_started.reason_title_4')</h3>
						<p>
							@lang('get_started.reason_caption_4', [ 'link' => route('travel_deals')])	
						</p>
					</div>
				</div>
			</div>
			<!-- End row -->
			<div class="row">
				<div class="col-md-6 wow fadeIn" data-wow-delay="0.5s">
					<div class="feature">
						<i class="icon_set_1_icon-36"></i>
						<h3>@lang('get_started.reason_title_5')</h3>
						<p>
							@lang('get_started.reason_caption_5', [ 'link' => route('teachers_bonus')])	
						</p>
					</div>
				</div>
				<div class="col-md-6 wow fadeIn" data-wow-delay="0.6s">
					<div class="feature">
						<i class="icon_set_2_icon-108"></i>
						<h3>@lang('get_started.reason_title_6')</h3>
						<p>
							@lang('get_started.reason_caption_6')
						</p>
					</div>
				</div>
			</div>
			<!-- End row -->
			<hr>
		<div class="main_title">
			<h2><span>@lang('get_started.lead_title')</span></h2>
			<p>@lang('get_started.lead_caption')</p>
		</div>
		<p>
			@lang('get_started.lead_content')
		</p>
			<hr>
			<div class="row">
				<div class="col-md-12">
					<h3>@lang('get_started.lead_subtitle_1')</h3>
				</div>
			</div>
			<p>
				@lang('get_started.lead_subcontent_1')
            </p>
			<div class="row">
				<div class="col-md-12">
					<h3>@lang('get_started.lead_subtitle_2')</h3>
				</div>
			</div>
			<p>
				@lang('get_started.lead_subcontent_2')
			</p>
			<div class="banner">
                	<h4>@lang('get_started.cta_middle_title')</h4>
                		<p>@lang('get_started.cta_middle_caption').</p>
                		<a href="{{ url('register') }}" class="btn_1 white">@lang('get_started.cta_middle_button')</a>
			</div>
			<hr>
			<div class="main_title">
				<h2>@lang('get_started.card_title')</h2>
				<p>@lang('get_started.card_caption')</p>
			</div>
			<div class="row">
                  <div class="col-md-3 col-sm-3">
                  
                  <div class="box_style_2">
                    <img src="https://www.classrr.com/storage/images/d5fca0f801dab53ab1fd9b62008cda49.jpeg" style="width:80px;height:80px;" alt="Sophia Armstrong Classrr Top Performing Teachers" class="img-circle">
                    <h4>Sophia Armstrong</h4>
                        <a href="https://www.classrr.com/profile/sophia-armstrong">@lang('get_started.card_more')</a>    
                </div> 
                  
                  </div>
                  <div class="col-md-3 col-sm-3">
                  
                   <div class="box_style_2">
                   <img src="https://www.classrr.com/storage/images/e6a243afea4b50c79f5168a06ddb6fc7.jpeg" style="width:80px;height:80px;" alt="Keith Evans Classrr Top Performing Teachers" class="img-circle">
                    <h4>Keith Evans</h4>
                        <a href="https://www.classrr.com/profile/keith-evans">@lang('get_started.card_more')</a>    
                </div>
                  
                  </div>
				  <div class="col-md-3 col-sm-3">
                  
                   <div class="box_style_2">
                   <img src="https://www.classrr.com/storage/images/33fdf6f94cf30cda94c9cab65d6ca1dd.jpeg" style="width:80px;height:80px;" alt="Margaret East Classrr Top Performing Teachers" class="img-circle">
                    <h4>Margaret East</h4>
                        <a href="https://www.classrr.com/profile/margaret-east">@lang('get_started.card_more')</a>    
                </div>
                  
                  </div>
				  <div class="col-md-3 col-sm-3">
                  
                   <div class="box_style_2">
                   <img src="https://www.classrr.com/storage/images/817d40775316058f2f6ce27638921256.jpeg" style="width:80px;height:80px;" alt="Marley Ford Classrr Top Performing Teachers" class="img-circle">
                    <h4>Marley Ford</h4>
                        <a href="https://www.classrr.com/profile/marley-ford">@lang('get_started.card_more')</a>    
                </div>
                  
                  </div>
            </div><!-- End row-->
			<div class="banner colored">
				<h4>@lang('get_started.cta_bottom_title')</h4>
				<p>@lang('get_started.cta_bottom_caption')</p>
				<a href="{{ url('register') }}" class="btn_1 white">@lang('get_started.cta_bottom_button')</a>
          	</div>
	</div>
	
@endsection