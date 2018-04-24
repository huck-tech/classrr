@extends('layout')

@section('title', 'Team')

@section('additional_styles')
@endsection

@section('additional_javascript')
@endsection

@section('hero')
    <section id="hero">
        <div class="intro_title">
            <h3 class="animated fadeInDown">Fun Classes. Happy Students</h3>
            <p class="animated fadeInDown">Discover &amp; book creative courses provided by independent teachers near you</p>
            {{--<a href="#" class="animated fadeInUp button_intro">View Tours</a> <a href="#" class="animated fadeInUp button_intro outline">View Tickets</a>--}}
        </div>
    </section><!-- End hero -->

    <div id="position">
        <div class="container">
            <ul>
                <li><a href="{{ route('homepage') }}">Home</a></li>
                <li>Team</li>
            </ul>
        </div>
    </div><!-- Position -->
@endsection

@section('content')
    <div class="container margin_60">
        <div class="main_title">
            <h2>Meet <span>the team </span></h2>
            <p>
                Entrepreneur at Heart
            </p>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="review_strip">
                    <img src="img/rifqi.jpg" alt="Image" class="img-circle">
                    <h4>Rifqi</h4>
                    <p>
                        "Rifqi is a serial entrepreneur and businessman. He has been responsible for all business-related at Classrr including customer acquistion and investor relations."
                    </p>
                </div><!-- End review strip -->
            </div>

            <div class="col-md-6">
                <div class="review_strip">
                    <img src="img/arief.jpg" alt="Image" class="img-circle">
                    <h4>Arief</h4>
                    <p>
                        "Arief is a marketing expert and oversees Classrr development. Arief's primary responsibility is driving the company vision and assembling a passionate team to realize that vision."
                    </p>
                </div><!-- End review strip -->
            </div>
        </div><!-- End row -->

        <div class="row">
            <div class="col-md-6">
                <div class="review_strip">
                    <img src="img/igor.jpg" alt="Image" class="img-circle">
                    <h4>Igor</h4>
                    <p>
                        "Igor is an experienced full stack developer with 8 years of experience. Igor in charge in developing &amp; maintenenance of Classrr platform. "
                    </p>
                </div><!-- End review strip -->
            </div>

            <div class="col-md-6">
                <div class="review_strip">
                    <img src="img/rob.jpg" alt="Image" class="img-circle">
                    <h4>Rob</h4>
                    <p>
                        "Rob is an SEO Expert &amp; Social Media Analyst. His objective is to manage Classrr Community and help user understand the benefits of using our platform."
                    </p>
                </div><!-- End review strip -->
            </div>
        </div><!-- End row -->
    </div><!-- End container -->
@endsection