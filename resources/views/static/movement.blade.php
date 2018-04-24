@extends('layout')

@section('title', 'Global Movement')
@section('meta_description', ' The concept of Classrr is fairly new in this industry so it is not really surprising that many do not get it right away. This is our Global Movement')

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
                <li>Global Movement</li>
            </ul>
        </div>
    </div><!-- Position -->
@endsection

@section('content')
    <div class="container margin_60">
        <div class="main_title">
            <h2>Welcome, <span>lifelong learners</span></h2>
            <p>
                Are you here looking for an answer? The bigger picture is...
            </p>
        </div>
        <hr>
        <div class="row add_bottom_30">
            <div class="col-md-4 text-center">
                <img src="img/bag.png" alt="Image">
            </div>
            <div class="col-md-7 col-md-offset-1">
                <h3>Why should I use <span>Classrr</span>?</h3>
                <p>
                	Classrr is a new concept we are bringing to the teaching industry, in this article we will be showing you what it is that we are doing differently and how it can benefit you.
            	</p>
            	<p>
            		Traditional education relies on two main concepts; Having a school or institution for which to teach at, as well as reputation for the school and it's staff for the school to attract new students, in this form education seems quite rigid; you will always need a place, and a teacher.
            	</p>
            	<p>
            		Technology has tried to improve education with things like video classes and online Tutoring, but this never really caught on, how will Classrr be any different? While it is true that despite great leaps forward in technology schools 50 years ago and schools today are still run in very much the same way, but... that's about to change.
            	</p>
            	<p>
            		Classrr is all about giving teachers greater freedom, to be able to do things they love and to be paid fairly for it, we are trying to give teachers the ability to work freelance like in many other professions, a great photographer rarely works for an institution other than their own, so why should teacher be any different?
            	</p>
            	<p>
            		Unfortunately though unlike photographers if a teacher wants to go freelance it is much more difficult, photographers simply go to locations and take beautiful pictures for their clients, a teacher is not the same, a teacher needs a classroom, and renting a space for this is costly and difficult, not to mention finding students, this is where Classrr comes in.
            	</p>
            	<p>
            		We are trying to take the difficulty out of teaching, and let teachers focus on what they do best; teaching, the way we do this is by instead of having to look for students to join your class, we have students to come to you, all you need to do is post the details about your proposed class, the planned class date and place and we do the rest!
            	</p>
            	<p>
            		Classrr has the potential to be very profitable for teachers and quite affordable for students as well, of course you can set your own prices and maximum class size, but let's see how much you can make using a typical class as an example:
            	</p>
            	<p>
            		(1) Assuming rent for the class is $1,000 a month (classes for rent you can find on our website being listed, or find on your own accord)<br>
            		(2) You can then set your own class times, let's say you want morning classes 9am to 12pm Monday to Friday, so 15 hours a week.<br>
            		(3) And you think your class is worth about $15 per hour per student, fair for the student and for the teacher.<br>
            		(4) Now your classroom isn't too big, you can't have 100 students, but you think 6 is a good size, not too many not too few; just right, teaching 6 students for one month only doing 15 hours a week gives you a total $5,400, substract the rent and you have made $4,400 of course you still need to pay for any overheads, transportation and personal costs, but the more you work, the more you make!
            	</p>
            	<p>
            		And that's all there is to it, we take a small percentage, much less than what a school would take, and we put the money back into improving our platform, ensuring that there is always a steady stream of eager students waiting to join.
            	</p>
            	<p>
            		Our vision is not just to have our teachers as a nameless, faceless entity, but as someone special to us, as the quality of your classes increase, so does your reputation, as does the number of students interested in taking your classes. A great teacher like yourself can travel anywhere in the world and with a few clicks of a button set up a classroom, start teaching and getting paid in no time!
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