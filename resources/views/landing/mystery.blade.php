@extends('layout')

@section('title_tag')
<title>Get Paid Learning - Classrr Compass</title>
@endsection

@section('meta_description', 'Make extra money while also learning for free on any subject you ever want to learn only at Classrr')

@section('additional_styles')
@endsection

@section('additional_javascript')
@endsection

@section('hero')
    <section id="hero">
		<div class="intro_title animated fadeInDown">
			<h3 class="animated fadeInDown">Make learning your new job</h3>
			<p class="animated fadeInDown">Learn your most desired skills and knowledge for free, make extra money, wherever you are</p>
			</div>
			<!-- End bs-wizard -->
		</div>
		<!-- End intro-title -->
	</section>
	<!-- End Section hero_2 -->

    <div id="position">
        <div class="container">
            <ul>
                <li><a href="{{ route('homepage') }}">Home</a></li>
				<li><a href="{{ route('compass') }}">Compass</a></li>
                <li>Get Paid Learning</li>
            </ul>
        </div>
    </div><!-- Position -->
@endsection

@section('content')
    <div class="container margin_60">
        <div class="main_title">
            <h2><span>How</span> it works</h2>
			<p>Join 100,000+ mystery learners across all demographic and interest groups.</p>
        </div>
		<hr>
		<div class="row">
                  <div class="col-md-4">
                  
                  <div class="box_style_2">
				  <h2 class="plan-title">1</h2>
                    <i class="icon_set_1_icon-16"></i>
                    <h4>Attend <span>a class</span></h4>    
                </div> 
                  
                  </div><!-- End col-md-6-->
                  <div class="col-md-4">
                  
                   <div class="box_style_2">
				   <h2 class="plan-title">2</h2>
                    <i class="icon_set_1_icon-93"></i>
                    <h4><span>Complete</span> tasks &amp; give feedback</h4>  
                </div>
                  
                  </div><!-- End col-md-6-->
				  <div class="col-md-4">
                  
                   <div class="box_style_2">
				   <h2 class="plan-title">3</h2>
                    <i class="icon-money-2"></i>
                    <h4><span>Earn</span> $200 per class (or more).</h4>    
                </div>
                  
                  </div><!-- End col-md-6-->
                 </div><!-- End row-->
				 <p class="text-center nopadding">
				@unless (Auth::check())
				<a href="{{ url('register') }}" class="btn_1 medium">Sign up </a>
				@else
				<a href="https://classrr.typeform.com/to/PWMekj" class="btn_1 medium">Fill the form! </a>
				@endif
			</p>
		<hr>
		<div class="main_title">
            <p><strong>Share this with a friend!</strong></p>
        </div>
        <div class="text-center" id="shareIcons" style="font-size:20px"></div>
    </div><!-- End container -->
@endsection