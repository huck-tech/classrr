@extends('layout')

@section('title', 'Invite Your Friends')
@section('meta_description', 'Invite your friends to Classrr and earn learning credit when they learn or teach a class.')


@section('additional_styles')
<link href="{{ asset('css/timeline.css') }}" rel="stylesheet">
@endsection

@section('additional_javascript')
@endsection

@section('hero')
    <section id="hero">
        <div class="intro_title">
            <h3 class="animated fadeInDown">Give more, l<span>earn</span> more</a></h3>
			<p class="animated fadeInDown"><strong>Get up to $100 for every friends you invite.</strong></p>
			@unless (Auth::check())
			<a href="{{ route('login') }}" class="animated fadeInUp button_intro">Log in to invite friends</a><br /><br />
			<p class="animated fadeInDown"><strong>Don't have an account yet? <a href="{{ route('register') }}" class="animated fadeInUp">Sign up now</a>.
			</strong></p>
			@else
			<a href="{{ route('user_referrals') }}" class="animated fadeInUp button_intro">Start inviting your friends</a>
			@endif
        </div>
    </section><!-- End hero -->

    <div id="position">
        <div class="container">
            <ul>
                <li><a href="{{ route('homepage') }}">Home</a></li>
                <li>Referral Program</li>
            </ul>
        </div>
    </div><!-- Position -->
@endsection

@section('content')
    <div class="container margin_60">
        <div class="main_title">
			<h2>Get your education <span>covered</span> for many years to come!</h2><br />
            <span>
                Invite your friends to Classrr via Email, or share your referral code on your social media.<br />
				Your friend will get $25 free learning credit, you'll get $25 when they learn and $75 when they teach.<br />
				Your available learning credit automatically appears in a form of a discount.<br /><br />
				<a href="{{ route('referral_terms') }}">Referral Terms and Conditions</a>
			</span>
        </div>
		<hr>
    </div><!-- End container -->
@endsection