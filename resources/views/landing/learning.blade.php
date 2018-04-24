@extends('layout')

@section('title_tag')
<title>Learn for Free - Classrr Compass</title>
@endsection

@section('meta_description', 'Learn for Free is part of our passion to educate the world beyond the internet. Learn how can you help!')

@section('additional_styles')
@endsection

@section('additional_javascript')
@endsection

@section('hero')
    <section id="hero">
        <div class="intro_title">
            <h3 class="animated fadeInDown">@lang('page_quotes.learning_title')</a></h3>
			<p class="animated fadeInDown">@lang('page_quotes.learning_caption')</strong></p>
			{{--<a href="#" class="animated fadeInUp button_intro">View Tours</a> <a href="#" class="animated fadeInUp button_intro outline">View Tickets</a>--}}
        </div>
    </section><!-- End hero -->

    <div id="position">
        <div class="container">
            <ul>
                <li><a href="{{ route('homepage') }}">@lang('breadcrumb.home')</a></li>
				<li><a href="{{ route('compass') }}">@lang('breadcrumb.compass')</a></li>
                <li>@lang('breadcrumb.learning')</li>
            </ul>
        </div>
    </div><!-- Position -->
@endsection

@section('content')
    <div class="container margin_60">
        <div class="main_title">
            <h2>@lang('learning.tagline')</h2>
			<p>
                @lang('learning.caption')
			</p>
        </div>
		<hr>
		<div class="row">
				<div class="col-md-4 col-sm-6">
					<img src="{{ asset('img/classrr-compass-learning.jpg') }}" alt="Classrr free learning" class="img-responsive styled">
				</div>
				<div class="col-md-7 col-md-offset-1 col-sm-6">
					@lang('learning.content')
					<a href="https://classrr.typeform.com/to/K25rn4" target="_blank"><img src="{{ asset('img/classrr-learning.jpg') }}" alt="Classrr free learning" class="img-responsive styled"></a>
				</div>
			</div>
			<!-- End row -->
        <hr>
		<div class="main_title">
            <p>@lang('learning.cta_social')</p>
        </div>
        <div class="text-center" id="shareIcons" style="font-size:20px"></div>
    </div><!-- End container -->
@endsection