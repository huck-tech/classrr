@extends('layout')

@section('title', 'Social Student Contest')

@section('prop_title', 'Social Student Contest')
@section('prop_description', 'Learning is more fun when you are with a great teacher and fellow motivated classmates!')
@section('prop_image', asset('/img/features-intro-01.jpg'))

@section('og_title', 'Social Student Contest')
@section('og_description', 'Learning is more fun when you are with a great teacher and fellow motivated classmates!')
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
                        <div class="text-center"><h1>Social Student Contest (March)</h1></div>
                        <hr>
                        <strong>OVERVIEW</strong><br>
                        Chance of winning $500 total prize in Social Student Contest. Simply follow us on Instagram and Enter the Contest.<br>
                        <strong>RULES</strong><br>
                        No purchase or payment of any kind is necessary to enter or win this contest. A purchase will not increase your chances of winning.<br>
                        <strong>ELIGIBILITY</strong><br>
                        You have to be registered member of TeachInClass, are 18 years or older at the time of entry, you are eligible to enter the Contest.<br>
                        <strong>HOW TO ENTER</strong><br>
                        To enter the Contest, Follow us on Instagram <a href="https://www.instagram.com/teachinclass" target="_blank">@teachinclass</a>, share your most memorable story when learning with a teacher and mention @teachinclass in your post. All stories must be shared by 11:59 PM EST on March 31st.<br>
                        <strong>PRIZES</strong><br>
                        APPROXIMATE RETAIL VALUES (ARV): Maximum ARV of all prizes: $500. (3) gift cards of $100 value to Apple, Inc. Grand prize is one-time free coupon (worth up to $200) to book any classes in TeachInClass. If winner is unable to receive payment then prize will be forfeited, and an alternate winner may be selected in accordance with these Official Rules from among the remaining eligible entries for that prize. Prizes may not be transferred or assigned except by Sponsor.<br>
                        <strong>ODDS</strong><br>
                        Odds of winning depend on number of eligible entries received during the Contest.<br>
                        <strong>WINNER NOTIFICATION</strong><br>
                        Winner will be notified by email and/or mail and at the judges’ discretion. Winners must submit an Affidavit of Eligibility within 5 days of being informed of winning.<br>
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
                            <form action="/student-submit" method="POST">
                            {{ csrf_field() }}
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input type="email" class=" form-control " name="user_email" id="user_email" placeholder="Email Address">
                                </div>
                                <div class="form-group">
                                    <label>Instagram Username</label>
                                    <input type="text" class=" form-control" name="paypal_email" id="paypal_email" placeholder="Instagram Username">
                                </div>
                                <button type="submit" class="btn_full">Submit</button>
                            </form>
                            <div class="login-or"><hr class="hr-or"><span class="span-or">or</span></div>
                            <a href="{{ route('promo') }}" class="btn_full_outline">Go to Teacher Program</a>
                        </div>
                </div>
            </div>
        </div>
    </section>
@endsection