@extends('layout')

@section('title', 'Global Teacher Program')

@section('prop_title', 'Global Teacher Program')
@section('prop_description', 'It is time for teacher to say goodbye to their 2nd job. Enter now, win $50 and we will bring students to your Classroom')
@section('prop_image', asset('/img/features-intro-01.jpg'))

@section('og_title', 'Global Teacher Program')
@section('og_description', 'It is time for teacher to say goodbye to their 2nd job. Enter now, win $50 and we will bring students to your Classroom')
@section('og_image', asset('img/features-intro-01.jpg'))
@section('og_url', Request::url())

@section('additional_metas')
<!-- Nofollow, Noindex -->
<meta name="robots" content="noindex, nofollow">
@endsection

@section('additional_styles')
@endsection

@section('additional_javascript')
@endsection

@section('hero')
    <section id="hero" class="login">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div id="login">
                        <div class="text-center"><h1>Global Teacher Program (March)</h1></div>
                        <hr>
                        <strong>OVERVIEW</strong><br>
                        Earn $100 for listing your classes to Teachinclass! Simply list 8 classes between 5-31 March 2017 with Initial Enrollment Date between 1-15 April 2017.<br>
                        <strong>ELIGIBILITY</strong><br>
                        If you are residing or currently living in United States, are 18 years or older at the time of entry, you are eligible to enter the Program.<br>
                        <strong>GUIDELINES</strong><br>
                        <ul>
                            <li>You may only create one account to participate.</li>
                            <li>You may only list classes that you teach on your own, private tuition classes is an exception.</li>
                            <li>Provide accurate information about you and your classroom.</li>
                            <li>Classes with similar topic will be counted as 1 class. (e.g Piano Beginner, Piano Advanced)</li>
                            <li>Teachinclass have the right to void the entry if there's any indication of violation.</li>
                            <li>Prizes is distributed between 10-15 April 2017.</li>
                        </ul>
                        <hr>
                        Share this to your friends
                        <div id="shareIcons"></div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div id="login">
                    @include('shared.flash')
                            <div class="text-center"><h1>Entry form</h1></div>
                            <hr>
                            <form action="/entry-submit" method="POST">
                            {{ csrf_field() }}
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input type="email" class=" form-control " name="user_email" id="user_email" placeholder="Email Address">
                                </div>
                                <div class="form-group">
                                    <label>PayPal Email</label>
                                    <input type="email" class=" form-control" name="paypal_email" id="paypal_email" placeholder="Where do we send the prize?">
                                </div>
                                <button type="submit" class="btn_full">Submit</button>
                            </form>
                            <div class="login-or"><hr class="hr-or"><span class="span-or">or</span></div>
                            <a href="{{ route('contest') }}" class="btn_full_outline">Go to Student Contest</a>
                        </div>
                </div>
            </div>
        </div>
    </section>
@endsection