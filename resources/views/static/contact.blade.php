@extends('layout')

@section('title', 'Contact us')

@section('additional_styles')
@endsection

@section('additional_javascript')
<script src="{{ asset('php/validate.js') }}"></script>
<script src="{{ asset('js/infobox.js') }}"></script>
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
                <li>Contact us</li>
            </ul>
        </div>
    </div><!-- Position -->
@endsection

@section('content')
    <div class="container margin_60">
        <div class="row">
            <div class="col-md-8 col-sm-8">
                <div class="form_title">
                    <h3><strong><i class="icon-pencil"></i></strong>Fill the form below</h3>
                    <p>
                        Our support team will get back to you within 24 hours.
                    </p>
                </div>
                <div class="step">

                    <div id="message-contact"></div>
                    <form method="post" action="{{ asset('php/contact.php') }}" id="contactform">
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" class="form-control" id="name_contact" name="name_contact" placeholder="Enter Name">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" class="form-control" id="lastname_contact" name="lastname_contact" placeholder="Enter Last Name">
                                </div>
                            </div>
                        </div>
                        <!-- End row -->
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" id="email_contact" name="email_contact" class="form-control" placeholder="Enter Email">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Message</label>
                                    <textarea rows="5" id="message_contact" name="message_contact" class="form-control" placeholder="Write your message" style="height:200px;"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Human verification</label>
                                <input type="text" id="verify_contact" name="verify_contact" class=" form-control add_bottom_30" placeholder="Are you human? 3 + 1 =">
                                <input type="submit" value="Submit" class="btn_1" id="submit-contact">
                            </div>
                        </div>
                    </form>
                </div>
            </div><!-- End col-md-8 -->

            <div class="col-md-4 col-sm-4">
                <div class="box_style_1">
                    <span class="tape"></span>
                    <h4>Help center <span><i class="icon-help pull-right"></i></span></h4>
                    <ul id="contact-info">
                        <li>General Inquiries: <a href="mailto:contact@classrr.com">contact@classrr.com</a></li>
                        <li>Technical Support: <a href="mailto:help@classrr.com">help@classrr.com</a></li>
						<li>Transaction Support: <a href="mailto:dispute@classrr.com">dispute@classrr.com</a></li>
                    </ul>
                </div>
				<!--
                <div class="box_style_4">
                    <i class="icon_set_1_icon-57"></i>
                    <h4>Customer <span>Concierge?</span></h4>
                    <a href="tel://004542344599" class="phone">+45 423 445 99</a>
                    <small>Monday to Friday 9.00am - 7.30pm</small>
                </div>
				-->
            </div><!-- End col-md-4 -->
        </div><!-- End row -->
    </div><!-- End container -->
@endsection