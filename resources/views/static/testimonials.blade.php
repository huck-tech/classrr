@extends('layout')

@section('title', 'Testimonials')

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
                <li>Testimonials</li>
            </ul>
        </div>
    </div><!-- Position -->
@endsection

@section('content')
    <div class="container margin_60">
        <div class="row">
            <div class="col-md-8" id="single_tour_desc">

                <div class="row">
                    <div class="col-md-3">
                        <h3>From teachers &amp; students </h3>
                        <a href="https://www.facebook.com/classrrcom" target="_blank" class="btn_1 add_bottom_30">Leave a testimonial</a>
                    </div>
                    <div class="col-md-9">
                        <div class="review_strip_single">
                            <img src="https://i.imgur.com/cSDZp8g.jpg" alt="Mable Winters" class="img-circle" style="width:80px;height:80px;">
                            <small> - 30 November 2017 -</small>
                            <h4>Mable Winters</h4>
                            <p>
                                "Amazing community and my students from Classrr are really wonderful and gifted!!! Looking forward to meet more learners out there."
                            </p>
                        </div>

                        <div class="review_strip_single">
                            <img src="https://i.imgur.com/ROmKY7N.jpg" alt="Sue Huggins" class="img-circle" style="width:80px;height:80px;">
                            <small> - 9 January 2018 -</small>
                            <h4>Sue Huggins</h4>
                            <p>
                                "can't wait for sdn to take place. let's see what's the future hold for all of us."
                            </p>
                        </div>
                    </div>
                </div>
            </div><!--End  single_tour_desc-->
        </div>
    </div>
@endsection