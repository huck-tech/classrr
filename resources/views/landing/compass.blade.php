@extends('layout')

@section('title_tag')
<title>Compass by Classrr - Introduction</title>
@endsection

@section('meta_description', 'Compass by Classrr connects people through education way beyond the internet.')

@section('additional_styles')
@endsection

@section('additional_javascript')
@endsection

@section('hero')
    <section id="hero">
        <div class="intro_title">
            <h3 class="animated fadeInDown">Compass by Classrr</a></h3>
			<p class="animated fadeInDown">Whatever the direction is, we're here to help</p>
			{{--<a href="#" class="animated fadeInUp button_intro">View Tours</a> <a href="#" class="animated fadeInUp button_intro outline">View Tickets</a>--}}
        </div>
    </section><!-- End hero -->

    <div id="position">
        <div class="container">
            <ul>
                <li><a href="{{ route('homepage') }}">Home</a></li>
                <li>Compass</li>
            </ul>
        </div>
    </div><!-- Position -->
@endsection

@section('content')
    <div class="container margin_60">
        <div class="row">
				<div class="col-md-12">
					<h3>Compass FAQ</h3>
				</div>
			</div>
			<!-- end row -->

			<div class="row">

				<div class="col-md-4">
					<div class="question_box">
						<h3>What is Compass?</h3>
						<p>
							It's an initiative program to provide and promote education beyond the internet's reach.
						</p>
					</div>
				</div>

				<div class="col-md-4">
					<div class="question_box">
						<h3>How does it work?</h3>
						<p>
							Compass gives certain benefits to our visitors and users.
						</p>
					</div>
				</div>

				<div class="col-md-4">
					<div class="question_box">
						<h3>Can I participate?</h3>
						<p>
							Every Compass's program has its own terms and conditions as stated in the page, for more question or if you want to request a program you can contact our support <a href="mailto:contact@classrr.com">here</a>.
						</p>
					</div>
				</div>

			</div>
			<!-- end row -->
		<hr>
		<div class="main_title">
            <p><strong>Share this with a friend!</strong></p>
        </div>
        <div class="text-center" id="shareIcons" style="font-size:20px"></div>
    </div><!-- End container -->
@endsection