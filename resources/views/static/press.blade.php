@extends('layout')

@section('title', 'Press')
@section('meta_description', 'Classrr press coverage')

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
                <li>Press</li>
            </ul>
        </div>
    </div><!-- Position -->
@endsection

@section('content')
    <div class="container margin_60">
        <div class="main_title">
            <h2>Press Room</h2>
			<small>We appreciate your coverage on Classrr</small>
			<hr>
            <p>
                <a href="mailto:press@classrr.com">Media contact</a> | 
				<a href="https://www.classrr.com/support/wp-content/uploads/2018/02/Classrr-Logo.zip">Download Media Kit</a>
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