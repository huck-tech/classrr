@extends('layout')

@section('title_tag')
<title>Teachers Bonus - Classrr Compass</title>
@endsection

@section('meta_description', 'Show the world your way of teaching and claim this teachers bonus today! Only at Classrr')

@section('additional_styles')
@endsection

@section('additional_javascript')
@endsection

@section('hero')
    <section id="hero">
		<div class="intro_title animated fadeInDown">
			<h3>@lang('page_quotes.teaching_title')</h3><br />
			<div class="bs-wizard">
				<div class="col-md-3 col-sm-3 col-xs-3 bs-wizard-step complete">
					<div class="text-center bs-wizard-stepnum">5<sup>th</sup> Class</div>
					<div class="progress">
						<div class="progress-bar"></div>
					</div>
					<div class="bs-wizard-dot"></div>
					<div class="text-center bs-wizard-stepnum">$600</div>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3 bs-wizard-step complete">
					<div class="text-center bs-wizard-stepnum">6<sup>th</sup> Class</div>
					<div class="progress">
						<div class="progress-bar"></div>
					</div>
					<div class="bs-wizard-dot"></div>
					<div class="text-center bs-wizard-stepnum">$800</div>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3 bs-wizard-step complete">
					<div class="text-center bs-wizard-stepnum">7<sup>th</sup> Class</div>
					<div class="progress">
						<div class="progress-bar"></div>
					</div>
					<div class="bs-wizard-dot"></div>
					<div class="text-center bs-wizard-stepnum">$1,200</div>
				</div>
				<div class="col-md-3 col-sm-3 col-xs-3 bs-wizard-step complete">
					<div class="text-center bs-wizard-stepnum">8<sup>th</sup> Class</div>
					<div class="progress">
						<div class="progress-bar"></div>
					</div>
					<div class="bs-wizard-dot"></div>
					<div class="text-center bs-wizard-stepnum">$1,400</div>
				</div>
			</div>
			<!-- End bs-wizard -->
		</div>
		<!-- End intro-title -->
	</section>
	<!-- End Section hero_2 -->

    <div id="position">
        <div class="container">
            <ul>
                <li><a href="{{ route('homepage') }}">@lang('breadcrumb.home')</a></li>
				<li><a href="{{ route('compass') }}">@lang('breadcrumb.compass')</a></li>
                <li>@lang('breadcrumb.teaching')</li>
            </ul>
        </div>
    </div><!-- Position -->
@endsection

@section('content')
    <div class="container margin_60">
        <div class="main_title">
            <h2>@lang('teaching.tagline')</h2>
			<p>@lang('teaching.caption')</p>
        </div>
		<hr>
		<div class="row text-center plans">
				<div class="col-md-4 hidden-sm hidden-xs">
				</div>
				<div class="plan plan-tall col-md-4 col-sm-12 col-xs-12">
					<h2 class="plan-title">@lang('teaching.card_title')</h2>
					<p class="plan-price">@lang('teaching.card_price')</p>
					<ul class="plan-features">
						<li>@lang('teaching.bonus_top')</li>
						<li>@lang('teaching.bonus_1')</li>
						<li>@lang('teaching.bonus_2')</li>
						<li>@lang('teaching.bonus_3')</li>
						<li>@lang('teaching.bonus_4')</li>
						<li>@lang('teaching.bonus_5')</li>
						<li>@lang('teaching.bonus_6')</li>
						<li>@lang('teaching.bonus_7')</li>
						<li>@lang('teaching.bonus_8')</li>
					</ul>
					@if(!Auth::user())
					<p class=" col-md-8 col-md-offset-2 text-center">
						<a href="{{ url('register') }}" class=" btn_1 green">@lang('teaching.card_cta_register')</a>
					@elseif(Auth::user())
					<p class=" col-md-8 col-md-offset-2 text-center">
						<a href="{{ route('classroom_create') }}" class=" btn_1 green">@lang('teaching.card_cta_start')</a>
					@endif
					</p>
				</div>
				<!-- End col-md-4 -->
				<div class="col-md-4 hidden-sm hidden-xs">
				</div>
			</div>
			<!-- End row plans-->
        <hr>
		<div class="main_title">
            <p>@lang('teaching.feature_title')</p>
        </div>
		<div class="row">
                  <div class="col-md-4 col-sm-4">
                  
                  <div class="box_style_2">
                    <img src="https://www.classrr.com/storage/images/04dddcb04d3dd984357be3e23e1b3b41.jpeg" style="width:80px;height:80px;" alt="Vincent Canaro Classrr Top Performing Teachers" class="img-circle">
                    <h4>Vincent Canaro</h4>
                        <a href="https://www.classrr.com/profile/vincent-caro">@lang('teaching.feature_link')</a>    
                </div> 
                  
                  </div>
                  <div class="col-md-4 col-sm-4">
                  
                   <div class="box_style_2">
                   <img src="https://www.classrr.com/storage/images/04b583f1f1514e5c717c992d59c86e91.jpeg" style="width:80px;height:80px;" alt="Helena Castro Classrr Top Performing Teachers" class="img-circle">
                    <h4>Helena Castro</h4>
                        <a href="https://www.classrr.com/profile/helena-castro">@lang('teaching.feature_link')</a>    
                </div>
                  
                  </div>
				  <div class="col-md-4 col-sm-4">
                  
                   <div class="box_style_2">
                   <img src="https://www.classrr.com/storage/images/9d848d334255e8b03e5ed26c8202c5ab.jpeg" style="width:80px;height:80px;" alt="Stella Shaw Classrr Top Performing Teachers" class="img-circle">
                    <h4>Stella Shaw</h4>
                        <a href="https://www.classrr.com/profile/stella-shaw">@lang('teaching.feature_link')</a>    
                </div>
                  
                  </div>
                 </div><!-- End row-->
		<hr>
		<div class="main_title">
            <p>@lang('teaching.cta_social')</p>
        </div>
        <div class="text-center" id="shareIcons" style="font-size:20px"></div>
    </div><!-- End container -->
@endsection