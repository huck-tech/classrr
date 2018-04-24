@extends('layout')

@section('title', 'Our Partners and Contributors')
@section('meta_description', 'Classrr partners and Contributors')

@section('additional_styles')
@endsection

@section('additional_javascript')
@endsection

@section('hero')
    <section id="hero">
        <div class="intro_title">
            <h3 class="animated fadeInDown">Discover 3,840 classes around <a href="{{ route('coverage') }}">the globe</a></h3>
			<p class="animated fadeInDown">All the knowledge you need from Coding to Music, taught by our global community of teachers.</p>
			{{--<a href="#" class="animated fadeInUp button_intro">View Tours</a> <a href="#" class="animated fadeInUp button_intro outline">View Tickets</a>--}}
        </div>
    </section><!-- End hero -->

    <div id="position">
        <div class="container">
            <ul>
                <li><a href="{{ route('homepage') }}">Home</a></li>
                <li>Our partners</li>
            </ul>
        </div>
    </div><!-- Position -->
@endsection

@section('content')
    <div class="container margin_60">
	
		<!-- Contributors -->
		<div class="banner colored add_bottom_30">
            <h3>Our contributors</h3>
            <p>
                Our deepest appreciation to everyone's contribution for Classrr
            </p>
        </div>
		
		<div class="row">
				<div class="col-md-4">
					<div class="review_strip">
						<img src="{{ asset('img/people/igor.jpg') }}" alt="Igor" class="img-circle">
						<h4>Igor Nikitin</h4>
					</div>
				</div>

				<div class="col-md-4">
					<div class="review_strip">
						<img src="{{ asset('img/people/1.png') }}" alt="Blessy" class="img-circle">
						<h4>Blessy Dacanay</h4>
					</div>
				</div>
				
				<div class="col-md-4">
					<div class="review_strip">
						<img src="{{ asset('img/people/2.png') }}" alt="Sarah" class="img-circle">
						<h4>Sarah Pasion</h4>
					</div>
				</div>
				
				<div class="col-md-4">
					<div class="review_strip">
						<img src="{{ asset('img/people/3.png') }}" alt="Aynur" class="img-circle">
						<h4>Aynur Malikzade</h4>
					</div>
				</div>
				
				<div class="col-md-4">
					<div class="review_strip">
						<img src="{{ asset('img/people/4.png') }}" alt="Doubleton" class="img-circle">
						<h4><a href="https://twitter.com/Doubletonstudio" target="_blank">Doubleton</a></h4>
					</div>
				</div>
				
				<div class="col-md-4">
					<div class="review_strip">
						<img src="{{ asset('img/people/5.png') }}" alt="Michael" class="img-circle">
						<h4>Michael Paspa</h4>
					</div>
				</div>
			</div>
			<!-- End row -->
		
		<!-- Partners -->
        <div class="banner colored add_bottom_30">
            <h3>Our partners</h3>
            <p>
                Partners help bringing perks that can be enjoyed by Classrr teachers &amp; students
            </p>
        </div>
		{{--
        <div class="row">
            <div class="col-md-3 col-sm-6 text-center">
                <p>
                    <a href="#"><img src="img/bus.jpg" alt="Pic" class="img-responsive"></a>
                </p>
                <h4><span>Sightseen tour</span> booking</h4>
                <p>
                    Lorem ipsum dolor sit amet, vix erat audiam ei. Cum doctus civibus efficiantur in. Nec id tempor imperdiet deterruisset, doctus volumus explicari qui ex.
                </p>
            </div>
            <div class="col-md-3 col-sm-6 text-center">
                <p>
                    <a href="#"><img src="img/transfer.jpg" alt="Pic" class="img-responsive"></a>
                </p>
                <h4><span>Transfer</span> booking</h4>
                <p>
                    Lorem ipsum dolor sit amet, vix erat audiam ei. Cum doctus civibus efficiantur in. Nec id tempor imperdiet deterruisset, doctus volumus explicari qui ex.
                </p>
            </div>
            <div class="col-md-3 col-sm-6 text-center">
                <p>
                    <a href="#"><img src="img/guide.jpg" alt="Pic" class="img-responsive"></a>
                </p>
                <h4><span>Tour guide</span> booking</h4>
                <p>
                    Lorem ipsum dolor sit amet, vix erat audiam ei. Cum doctus civibus efficiantur in. Nec id tempor imperdiet deterruisset, doctus volumus explicari qui ex.
                </p>
            </div>
            <div class="col-md-3 col-sm-6 text-center">
                <p>
                    <a href="#"><img src="img/hotel.jpg" alt="Pic" class="img-responsive"></a>
                </p>
                <h4><span>Hotel</span> booking</h4>
                <p>
                    Lorem ipsum dolor sit amet, vix erat audiam ei. Cum doctus civibus efficiantur in. Nec id tempor imperdiet deterruisset, doctus volumus explicari qui ex.
                </p>
            </div>
        </div> End row --}}
    </div><!-- End container -->
@endsection