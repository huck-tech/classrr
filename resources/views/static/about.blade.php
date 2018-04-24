@extends('layout')

@section('title', 'About Us')

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
                <li>About Us</li>
            </ul>
        </div>
    </div><!-- Position -->
@endsection

@section('content')
    <div class="container margin_60">
        <div class="main_title">
            <h2>Welcome, <span>lifelong learners</span></h2>
            <p>
                We believe that education is the foundation of our future.
            </p>
        </div>
        <hr>
        <div class="row add_bottom_30">
            <div class="col-md-4 text-center">
                <img src="img/bag.png" alt="Image">
            </div>
            <div class="col-md-7 col-md-offset-1">
                <h3>What is <span>Classrr</span>?</h3>
                <p>
                    Classrr is a marketplace for peer-to-peer education. We provide a viable alternative for teachers to start &amp; move along in their entrepreneurial journey, aswell as offering students the joy of learning anytime, anywhere. Classroom Marketplace, for short.
                </p>
                <p>
                    Why was this website created? Simple. In order to solve a persistent industry problem:
                </p>
                <p>
                    Currently, Education is lacking behind most other industries; restaurants, hotels even massage parlors can simply pop up anywhere in the world, however a classroom can not... until now. As a startup, teachers do not have as many options as other businesses, it is expensive to start up a classroom, it is also difficult to find students willing to enroll in your discipline.
                </p>
                <p>
                    Since the inception of Airbnb, many people now opt to rent out their room space to travelers from all around the world daily. So we thought that it is about time that teaching and learning also gains some benefit from technology, by removing the uncertainty of having an empty classroom.
                </p>
                <h4>How it works</h4>
                <p>
                    It's simple;<br>
                    1. Amazing teachers just like you are able to list your classrooms online and set a price.<br> 
                    2. Passionate students looking for a personal or professional learning experience can search through the listings for a classroom that suits their learning objectives as well as their schedule.<br>
                    3. When the student finds a suitable class, they can then book your classroom via credit card.<br> 
                    4. Contact information is then exchanged and then you can begin to prepare your class.<br>
                </p>
            </div>
        </div><!-- End row -->

    </div><!-- End container -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 nopadding features-intro-img">
                <div class="features-bg">
                    <div class="features-img">
                    </div>
                </div>
            </div>
            <div class="col-md-6 nopadding">
                <div class="features-content">
                    <h3>Join the community!</h3>
                    <p>
                        Start your class anytime, view our trending topics that other students are looking forward to, or simply browse through interesting classes provided by our amazing teachers, book a class whenever it suits you and enjoy learning topics that you love from people that love teaching it.
                    </p>
                    <p>
                        <a href="{{ route('register') }}" class=" btn_1 white">Sign up</a>
                    </p>
                </div>
            </div>
        </div>
    </div><!-- End container-fluid -->
@endsection