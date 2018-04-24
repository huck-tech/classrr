@extends('layout')

@section('title', 'Oops! Page not found')
@section('meta_description', 'You were never here, let&#39;s get you back to Classrr and meet with others.')

@section('additional_metas')
  <meta name="robots" content="noindex,nofollow">
@endsection

@section('hero')
    <section id="hero">
		<div class="intro_title error">
			<h1 class="animated fadeInDown">404</h1>
			<p class="animated fadeInDown">Let me show you the error of your way</p>
			<a href="{{ route('homepage') }}" class="animated fadeInUp button_intro">Back to home</a> <a href="{{ route('coverage') }}" class="animated fadeInUp button_intro outline">View all classes</a>
		</div>

	</section>
	<!-- End hero -->
@endsection

@section('content')
    <div class="container margin_60">

			<div class="banner colored add_bottom_30">
				<h3>Discover our Top Classes <strong>from $10</strong></h3>
				<p>
					Might as well check out our classes, there are thousands of them.
				</p>
				<a href="{{ route('coverage') }}" class="btn_1 white">Browse All</a>
			</div>
		</div>
		<!-- End container -->
@endsection