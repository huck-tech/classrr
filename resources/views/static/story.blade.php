@extends('layout')

@section('title', 'Story')
@section('meta_description', 'Discover and Book Affordable Classes Online From Independent Teachers Around The World. Save Money and Learn on Classrr!')

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
                <li>Story</li>
            </ul>
        </div>
    </div><!-- Position -->
@endsection

@section('content')
    <div class="container margin_60">
        <div class="main_title">
            <h2>Stay hungry, stay curious... and learn</h2>
            <p>
                Education is another word for opportunity
            </p>
        </div>
        <hr>
        <div class="row add_bottom_30">
            <div class="col-md-4 text-center">
                <img src="img/bag.png" alt="Image">
            </div>
            <div class="col-md-7 col-md-offset-1">
                <h3>The story behind <span>Classrr</span></h3>
                <p>
                    This story begins way back in November 2015. I took a 3-month Mandarin language class in Shanghai. I flew all the way from Indonesia. My teachers were Yang and Weiwei, they created a fun and interesting learning experience that I will keep with me for the rest of my life. I was in my 20s, studying with the help of two amazing teachers was the best learning experience I have ever had as well as one of the best personal experiences.
                </p>
                <p>
                    No matter the difficulty of the content that they taught (and believe me Mandarin is not easy!) I managed to learn almost everything they both taught and had a working knowledge of basic Mandarin in just a short 3 months.
                </p>
                <p>
                    Unfortunately, shortly after our class ended. The school wasn't doing as well because the Chinese currency (the Yuan) reached a historic high point, this disuaded new international students from going to China as it was almost twice as expensive as just a few years before, so cuts at the school had to be made, and to my disbelief two of the greatest teachers I have ever had the pleasure of studying under were axed, they of course received a payout by the school, but it was no where near what our tuition fees were, of course the school has to pay for overheads, accreditation and of course make a profit, but it still seemed ludicrous to me. Yang and Weiwei then had no choice but to find another school to join and teach under, so again.....the cycle continues, but hopefully for no longer, Clasrr is designed to break this loop, to give teachers the opportunity and power to teach and make money by their own accord.
                </p>
                <p>
                    A problem that needed a solution, 2015
                </p>
            </div>
        </div><!-- End row -->

        <hr class="add_bottom_45">

        <div class="main_title">
            <h2><span>Tell us </span>your story!</h2>
            <p>
                Classrr began from listening to suggestions from people just like you, we'd love to hear from you too! Send your story to <a href="mailto:story@classrr.com">story@classrr.com</a>.
            </p>
        </div>

    </div><!-- End container -->
@endsection