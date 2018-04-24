@extends('layout')

@section('title', 'XXXXXXXXXXXXX')

@section('additional_styles')
@endsection

@section('additional_javascript')
@endsection

@section('hero')
    <section id="hero">
        <div class="intro_title">
            <h3 class="animated fadeInDown">Fun Class. Happy Student</h3>
            <p class="animated fadeInDown">Book amazing courses from friendly tutors. Wherever you are.</p>
            {{--<a href="#" class="animated fadeInUp button_intro">View Tours</a> <a href="#" class="animated fadeInUp button_intro outline">View Tickets</a>--}}
        </div>
    </section><!-- End hero -->

    <div id="position">
        <div class="container">
            <ul>
                <li><a href="{{ route('homepage') }}">Home</a></li>
                <li>XXXXXXXXXXXX</li>
            </ul>
        </div>
    </div><!-- Position -->
@endsection

@section('content')
@endsection