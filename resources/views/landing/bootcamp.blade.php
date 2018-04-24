@extends('layout')

@section('title_tag')
<title>Bootcamp - Classrr Compass</title>
@endsection

@section('meta_description', 'Join Classrr Bootcamp to prepare your future by learning and get rewarding job you want in no time')


@section('additional_styles')
@endsection

@section('additional_javascript')
@endsection

@section('hero')
    <section id="hero">
        <div class="intro_title">
            <h3 class="animated fadeInDown">@lang('page_quotes.bootcamp_title')</a></h3>
			<p class="animated fadeInDown">@lang('page_quotes.bootcamp_caption')</p>
			{{--<a href="#" class="animated fadeInUp button_intro">View Tours</a> <a href="#" class="animated fadeInUp button_intro outline">View Tickets</a>--}}
        </div>
    </section><!-- End hero -->

    <div id="position">
        <div class="container">
            <ul>
                <li><a href="{{ route('homepage') }}">@lang('breadcrumb.home')</a></li>
				<li><a href="{{ route('compass') }}">@lang('breadcrumb.compass')</a></li>
                <li>@lang('breadcrumb.bootcamp')</li>
            </ul>
        </div>
    </div><!-- Position -->
@endsection

@section('content')
    <div class="container margin_60">
		<div class="main_title">
            <h2>@lang('bootcamp.what_title')</h2>
			<p>@lang('bootcamp.what_caption')</p>
        </div>
		<div class="row">
				<div class="col-md-6 col-sm-6">
					<h4>@lang('bootcamp.what_title_1')</h4>
					<p>@lang('bootcamp.what_content_1')</p>
					<div class="general_icons">
						<ul>
							<li><i class="icon_set_1_icon-59"></i>Affordable</li>
							<li><i class="icon_set_1_icon-38"></i>Clear Direction</li>
							<li><i class="icon_set_1_icon-40"></i>ROI-Oriented</li>
						</ul>
					</div>
				</div>
				<div class="col-md-6 col-sm-6">
					<h4>@lang('bootcamp.what_title_2')</h4>
					<p>@lang('bootcamp.what_content_2')</p>
					<div class="general_icons">
						<ul>
							<li><i class="icon_set_1_icon-29"></i>Personalized</li>
							<li><i class="icon_set_1_icon-82"></i>Do What You Love</li>
							<li><i class="icon_set_1_icon-42"></i>Job-Oriented</li>
						</ul>
					</div>
				</div>
			</div>
		<hr>
        <div class="main_title">
            <h2>@lang('bootcamp.available_title') <span>{{ $city }}, {{ $country }}</span></h2>
        </div>
		<div class="row">
			<h3 class="text-center">Sushi Chefs (Itamae)</h3>
			<div class="col-md-6 col-sm-6 hidden-xs">
				<img src="https://i.imgur.com/Cbu57oy.jpg" alt="Sushi Chef" class="img-responsive laptop">
			</div>
			<div class="col-md-6 col-sm-6">
				<h3>@lang('bootcamp.key_information')</h3>
				<p>
				<strong>@lang('bootcamp.bootcamp_type'):</strong> apprenticeship &amp; on-the-job training<br />
				<strong>@lang('bootcamp.bootcamp_duration_cost'):</strong> 1-year bootcamp for an estimated $17,500 enrollment fee<br />
				<strong>@lang('bootcamp.bootcamp_roi'):</strong> In less than 6 months<br />
				<strong>@lang('bootcamp.bootcamp_detail'):</strong> Average sushi chefs salary offered by our partners is $43,250<br />
				<strong>@lang('bootcamp.bootcamp_entry'):</strong> 70%<br />
				<strong>@lang('bootcamp.bootcamp_skills'):</strong> <span class="label label-info">+max Entrepreneurship</span> <span class="label label-info">+max Cooking</span> <span class="label label-info">+max Baking</span> 
				<span class="label label-info">+max Cutlery</span> <span class="label label-info">+max Discipline</span> <span class="label label-info">+max Restaurant Management</span> 
				<span class="label label-info">+max Sushi</span> <span class="label label-info">+max Food Preparation</span> <span class="label label-info">+max Sushi Preparation</span> 
				<span class="label label-info">+max Consistency</span> <span class="label label-info">+max Customer Relation</span> <span class="label label-info">+max Customer Service</span> 
				<span class="label label-info">+max Grocery Shopping</span> <span class="label label-info">+max Patience</span> <span class="label label-info">+max Food Processing</span> 
				<span class="label label-info">+max Food Industry</span> <span class="label label-info">+max Sushi Art</span>
				</p>
				<ul class="list_order">
					<li><span>1</span>Request for Quotation</li>
					<li><span>2</span>Schedule an interview</li>
					<li><span>3</span>Start bootcamp experience</li>
					<li><span>4</span>Get your dream job</li>
				</ul>
				@unless (Auth::check())
				<a href="{{ route('register') }}" class="btn_1">@lang('bootcamp.bootcamp_register')</a>
				@else
				<a href="https://classrr.typeform.com/to/tyMqSh" class="btn_1">@lang('bootcamp.bootcamp_request_quote')</a>
				@endif
			</div>
		</div>
		<br />
		<hr>
		<div class="row">
				<div class="col-md-12">
					<h3>@lang('bootcamp.faq')</h3>
				</div>
			</div>
			<!-- end row -->

			<div class="row">

				<div class="col-md-4">
					<div class="question_box">
						<h3>@lang('bootcamp.faq_title_1')</h3>
						<p>
							@lang('bootcamp.faq_content_1')
						</p>
					</div>
				</div>

				<div class="col-md-4">
					<div class="question_box">
						<h3>@lang('bootcamp.faq_title_2')</h3>
						<p>
							@lang('bootcamp.faq_content_2', ['link' => 'https://www.classrr.com/sdn/'])
						</p>
					</div>
				</div>

				<div class="col-md-4">
					<div class="question_box">
						<h3>@lang('bootcamp.faq_title_3')</h3>
						<p>
							@lang('bootcamp.faq_content_3')
						</p>
					</div>
				</div>

			</div>
		<hr>
		<div class="main_title">
            <h2>@lang('bootcamp.testimony')</h2>
        </div>
		<div class="row">
				<div class="col-md-6">
					<div class="review_strip">
						<img src="https://www.classrr.com/storage/images/b3af54cf8ea422414067e04656672316.jpeg" style="width:80px;height:80px;" alt="Classrr Bootcamp Review 1" class="img-circle">
						<h4>Ned Dixon</h4>
						<p>
							"Amazing, wonderful experience, I can't say anything else but a huge thanks for my bootcamp teachers, there's no way I can do all of this by my own, the mistakes and everything, they are all very valuable."
						</p>
						<div class="rating">
							<i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class=" icon-star-empty"></i>
						</div>
					</div>
					<!-- End review strip -->
				</div>

				<div class="col-md-6">
					<div class="review_strip">
						<img src="https://www.classrr.com/storage/images/473920d401c398805f4e986e284ab4fc.jpeg" style="width:80px;height:80px;" alt="Classrr Bootcamp Review 2" class="img-circle">
						<h4>Amara Patel</h4>
						<p>
							"Confidence is the key and that's what I will always remember for my bootcamp experience."
						</p>
						<div class="rating">
							<i class="icon-star voted"><i class="icon-star voted"></i></i><i class="icon-star voted"></i><i class="icon-star voted"></i><i class=" icon-star-empty"></i>
						</div>
					</div>
					<!-- End review strip -->
				</div>
			</div>
			<!-- End row -->
		<hr>
		
		<div class="main_title">
            <p>@lang('bootcamp.cta_social')</p>
        </div>
        <div class="text-center" id="shareIcons" style="font-size:20px"></div>
    </div><!-- End container -->
@endsection