@extends('layout')

@section('title_tag')
<title>Rent Your Classroom - Classrr Compass</title>
@endsection

@section('meta_description', 'Looking for another way to earn money from your empty room situation? Rent your classroom and bring education to your property for free.')

@section('additional_styles')
@endsection

@section('additional_javascript')
@endsection

@section('hero')
    <section id="hero">
        <div class="intro_title">
            <h3 class="animated fadeInDown">@lang('page_quotes.classroom_title')</a></h3>
			<p class="animated fadeInDown">@lang('page_quotes.classroom_caption')</strong></p>
			<a href="https://classrr.typeform.com/to/zEWcvS" target="_blank" class="animated fadeInUp button_intro">@lang('classroom.cta_top')</a>
        </div>
    </section><!-- End hero -->

    <div id="position">
        <div class="container">
            <ul>
                <li><a href="{{ route('homepage') }}">@lang('breadcrumb.home')</a></li>
				<li><a href="{{ route('compass') }}">@lang('breadcrumb.compass')</a></li>
                <li>@lang('breadcrumb.classroom')</li>
            </ul>
        </div>
    </div><!-- Position -->
@endsection

@section('content')
    <div class="container margin_60">
        <div class="main_title">
            <h2>@lang('classroom.tagline')</h2>
			<p>
                @lang('classroom.caption')
			</p>
        </div>
		<hr>
		<div class="row">
				<div class="col-md-8">
					<h3>@lang('classroom.title_1')</h3>
					<h5>@lang('classroom.caption_1')</h5>
					<p>
						@lang('classroom.caption_1_content')
					</p>
					<h5>@lang('classroom.caption_2')</h5>
					<p>
						@lang('classroom.caption_2_content')
					</p>
					<h5>@lang('classroom.caption_3')</h5>
					<p>
						@lang('classroom.caption_3_content')
					</p>
				</div>
				<div class="col-md-4">
					<h3>@lang('classroom.title_2')</h3>
					<p>
						@lang('classroom.title_2_caption')
					</p>
					<p>
						<img src="{{ asset('img/lang_en.png') }}" width="40" height="26" alt="Image" data-retina="true"> <img src="{{ asset('img/lang_fr.png') }}" width="40" height="26" alt="Image" data-retina="true">
						<img src="{{ asset('img/lang_de.png') }}" width="40" height="26" alt="Image" data-retina="true"> <img src="{{ asset('img/lang_es.png') }}" width="40" height="26" alt="Image" data-retina="true"> @lang('classroom.title_2_more')
					</p>
					<h3><i class=""></i>@lang('classroom.all_to_do')</h3>
					<ul class="list_ok">
						<li>@lang('classroom.list_ok_1', ['link' => 'https://classrr.typeform.com/to/zEWcvS'])</li>
						<li>@lang('classroom.list_ok_2')</li>
					</ul>
				</div>
		</div>
		<!-- end row -->
        <hr>
		<div class="main_title">
            <p>@lang('classroom.cta_social')</p>
        </div>
        <div class="text-center" id="shareIcons" style="font-size:20px"></div>
    </div><!-- End container -->
@endsection