@extends('layout')

@section('title', 'Trust & Safety')

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
                <li>Tips</li>
            </ul>
        </div>
    </div><!-- Position -->
@endsection

@section('content')
    <div class="container margin_60">
        <div class="row add_bottom_30">
            <div class="col-md-4 text-center">
                <img src="{{ asset('img/bag.png') }}" alt="Tips">
            </div>
            <div class="col-md-7 col-md-offset-1">
                <h3>Tips for Teachers</h3>
                <p>
                    We want to help you teach your students to the best of your abilities. Please follow these guidelines to ensure a positive experience for everyone involved.
                </p>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <p>1. Use common sense when accepting student</p>
                        <ul class="list_ok">
                            <li>Utilize the messaging feature to ask potential students questions first.</li>
                            <li>Request the student to complete any missing profile information in order to better understand the student's learning goals and needs to avoid any confusion from either party.</li>
                            <li>You have the final say in who can join your class!</li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <p>2. Complete your listing</p>
                        <ul class="list_ok">
                            <li>A class with all the fields completed generally has more bookings than a class that doesn't provide much information.</li>
                            <li>Keep your listing upto date as much as possible.</li>
                            <li>Again, You have the final say in who can join your class!</li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <p>3. Confirmed a student? Congrats!</p>
                        <ul class="list_ok">
                            <li>Get in touch with your student to confirm their arrival time and mode of transport. Are you available to give a first-time pickup or offer travel advice to your place? Let them know!</li>
                            <li>Process their visa application if you provide the service.</li>
                            <li>Prepare a clean classroom and ready-to-use study materials.</li>
                        </ul>
                    </div>
                </div>
                <!-- End row  -->
                <hr>
                <h3>Student Tips</h3>
                <p>
                    We want to make your learning experience go as smoothly as possible in order to get the most out of course. Please follow these guidelines to ensure the best possible experience.
                </p>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <p>1. Use common sense.</p>
                        <ul class="list_ok">
                            <li>If a listing is missing data fields that are important to you (headshot, class images, or description etc.) consider booking another class that has more complete listings, or message the teacher to request additional information.</li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <p>2. Utilize our messaging system</p>
                        <ul class="list_ok">
                            <li>This feature allows you to contact the teacher before booking the class in order to ask questions, confirm availability, and educate yourself more about the specific details the course will provide.</li>
                        </ul>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <p>3. Booked a class? Congrats!</p>
                        <ul class="list_ok">
                            <li>Get in touch your teacher prior to arriving. Let them know your arrival time and the best means of contact.</li>
                            <li>Print out and pack your study plan. You can also find it saved in your dashboard when logged in to your Classrr account.</li>
                            <li>Keep your teacher informed of any changes or any materials you would like taught.</li>
                        </ul>
                    </div>
                </div>
                <!-- End row  -->
            </div>
        </div><!-- End row -->

    </div><!-- End container -->
@endsection