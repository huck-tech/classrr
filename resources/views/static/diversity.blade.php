@extends('layout')

@section('title', 'Diversity at Global Education')
@section('meta_description', 'Classrr focus on bringing quality teaching &amp; learning experience to everyone in the world and promote diversity &amp; belonging.')

@section('additional_styles')
@endsection

@section('additional_javascript')
@endsection

@section('hero')
    <section id="hero">
        <div class="intro_title">
            <h3 class="animated fadeInDown">Education unites us</h3>
            <p class="animated fadeInDown">Minimizing preferences to embrace a better learning quality</p>
            {{--<a href="{{ route('register') }}" class="animated fadeInUp button_intro">Register</a> <a href="{{ route('login') }}" class="animated fadeInUp button_intro outline">Login Now</a>--}}
        </div>
    </section><!-- End hero -->

    <div id="position">
        <div class="container">
            <ul>
                <li><a href="{{ route('homepage') }}">Home</a></li>
                <li>Get Started</li>
            </ul>
        </div>
    </div><!-- Position -->
@endsection

@section('content')
    <div class="container margin_60">
        <div class="main_title">
            <h2>It's always impossible until <span>it's done</span></h2>
        </div>
        <hr>
		<div class="row add_bottom_30">
            <div class="col-md-12">
                <h3>Diversity</h3>
                <p>
                    If there's one thing traditional school has taught us, is that it is possible to learn anything with no prior information of who our teachers &amp; classmates are. 
					It takes time to understand people and to simplify it by associating their face &amp; personality with their gender, race, color, nationality, religion &amp; sexual orientation is a narrow-minded action. 
					Every class at Classrr starts with a quick &amp; positive introduction &amp; followed by learning of the topic's curriculum.
                </p>
                <hr>
                <h3>Belonging</h3>
                <p>
                    Hospitality is the key to any successful businesses &amp; transactions. Leaving a good impression is better than engaging yourself in an unpleasant situation. 
					Learners that come to Classrr want to experience a good learning experience, again &amp; again, wherever they go. It's everyone's responsibility to avoid doing harm to others. 
                </p>
            </div>
        </div><!-- End row -->
		<hr>
		<div class="main_title">
            <h2>Code of <span>Conduct</span></h2>
			<p>TL;DR—Learn Accordingly And Respect Other Learners.</p>
        </div>
        <hr>
		<div class="row add_bottom_30">
            <div class="col-md-12">
                <p>
                    Diversity in education is necessary because one have to learn about other cultures and how other people live. 
					That comes most effectively through interaction between actual people as opposed to just reading something in a book or watching a movie.
                </p>
				<p>
					<strong>We ask you to follow these Code of Conduct while communicating, teaching &amp; learning with other Classrr users, this includes your participation on our platforms, events &amp; gatherings. 
					Please note, these may change from time to time, so it's worth checking back regularly.<br /><br />
					Violations may result in temporary suspension or a permanent ban.
					</strong>
				</p>
                <hr>
                <ol>
					<li>Do not use any discriminatory language, including but not limited to any language regarding ethnicity, nationality, race, gender, religion, sexual preference or personal beliefs.</li>
					<li>Do not use extremely foul language, including but not limited to excessive profanity or language that is graphically sexual, grotesque, or violent.</li>
					<li>Do not make threats of real-world violence or other intended harm to other learners or our employees.</li>
					<li>Do not harass, stalk, or purposely do things to make someone else feel uncomfortable or threatened.</li>
					<li>Do not share personal information about yourself or other individuals.</li>
					<li>Do not engage in, request, arrange, or offer illegal activities or materials.</li>
					<li>Do not impersonate other individuals.</li>
					<li>Do not spam, be it in text, call or messaging platform.</li>
					<li>Do not exploit bugs or glitches: If you find a bug or a glitch in the platform that provides an unfair advantage, let us know about it instead of using the exploit for your own benefit.</li>
					<li>Do not share your account: your account is for your use and your use alone. Do not grant access to your account to anyone else, and do not access anyone else's account, even with their permission.</li>
				</ol>
				<p>
					<strong>These rules are neither final nor exhaustive - we reserve the right to suspend disruptive users even if their behaviour doesn’t fall under any of the above rules directly. Be nice, learn accordingly and respect others and yourself.
					</strong>
				</p>
            </div>
        </div><!-- End row -->
	</div>
	
@endsection