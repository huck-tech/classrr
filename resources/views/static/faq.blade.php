@extends('layout')

@section('title', 'FAQ')

@section('additional_styles')
@endsection

@section('additional_javascript')
    <script src="js/theia-sticky-sidebar.js"></script>
    <script>
        jQuery('#sidebar').theiaStickySidebar({
            additionalMarginTop: 80
        });
    </script>
    <script>
        $(function() {
            'use strict';
            $('#faq_box a[href*=#]:not([href=#])').click(function() {
                if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
                    var target = $(this.hash);
                    target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
                    if (target.length) {
                        $('html,body').animate({
                            scrollTop: target.offset().top - 120
                        }, 500);
                        return false;
                    }
                }
            });
        });
    </script>
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
                <li>Frequently Asked Questions</li>
            </ul>
        </div>
    </div><!-- Position -->
@endsection


@section('content')
    <div  class="container margin_60">
        <div class="row">
            <aside class="col-lg-3 col-md-3"  id="sidebar">
                <div class="theiaStickySidebar">
                    <div class="box_style_cat"  id="faq_box">
                        <ul id="cat_nav">
                            <li><a href="#general" class="active"><i class="icon_set_1_icon-95"></i>General FAQ's</a></li>
                            <li><a href="#teacher"><i class="icon_set_1_icon-95"></i>Teacher Questions</a></li>
                            <li><a href="#student"><i class="icon_set_1_icon-95"></i>Student Questions</a></li>
                            <li><a href="#classroom"><i class="icon_set_1_icon-95"></i>Classroom Rental Questions</a></li>
                        </ul>
                    </div>
                    <div class="box_style_2">
                        <i class="icon_set_1_icon-57"></i>
                        <h4>Ask a New <span>Question</span></h4>
                        <a href="mailto:contact@classrr.com" class="phone">Email Us</a>
                        <!-- <small>Monday to Friday 9.00am - 7.30pm</small> -->
                    </div>
                </div><!--End sticky -->
            </aside><!--End aside -->
            <div class="col-lg-9 col-md-9" id="faq">
                <h3 class="nomargin_top">General FAQ's</h3>

                <div class="panel-group" id="general">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#general" href="#collapseOne_general">What is the purpose of Classrr?<i class="indicator icon-minus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseOne_general" class="panel-collapse collapse in">
                            <div class="panel-body">
                                The purpose of Classrr is the ability to provide students who are passionate about learning with teachers who are equally passionate about teaching in order to create the best learning experience possible. Teachers can subtitute their income by working for themselves and students can learn from the best without paying a premium price for it!
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#general" href="#collapseTwo_general">Why would I use Classrr?<i class="indicator icon-plus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseTwo_general" class="panel-collapse collapse">
                            <div class="panel-body">
                                In the Teaching industry students only have 3 choices; Buying video courses, hiring an online tutor and paying per hour, or going to a school. As we all know video courses pitfall is that you cannot ask questions, online tutors cannot provide that sense that you are in a learning environment, and going to school can be very expensive as well as being at times that are inconvenient for you. Classrr has none of these pitfalls, we just provide teachers who want to teach with students who want to learn, each class is limited to a maximum of 6 students, so these are nothing like University lecturers where you are sitting in the backrow unable to answer questions. By using Classrr you are not only supporting our educational growth, but are revolutionising the Education system.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#general" href="#collapseThree_general">Does it cost anything to sign up?<i class="indicator icon-plus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseThree_general" class="panel-collapse collapse">
                            <div class="panel-body">
                                There is no cost for signing up, you only pay when you book your class!
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#general" href="#collapseFour_general">How do I find a class?<i class="indicator icon-plus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseFour_general" class="panel-collapse collapse">
                            <div class="panel-body">
                                it's very simple! in just three clicks you can find exactly what you are looking for Simply: (1) enter your city &amp; desired topic (2) find a listing, and (3) book your class securely using your credit card or PayPal.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#general" href="#collapseFive_general">Is Classrr international?<i class="indicator icon-plus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseFive_general" class="panel-collapse collapse">
                            <div class="panel-body">
                                Yes, classes are available in many countries all over the world.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#general" href="#collapseSix_general">What is Classrr 7-days satisfaction guarantee?<i class="indicator icon-plus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseSix_general" class="panel-collapse collapse">
                            <div class="panel-body">
                                The guarantee is simply to provide the best experience for our Classrr community. Teachers can opt-in to provide the class with a simple satisfaction guarantee where the payment you made for the class will be securely held in our escrow system and released after 7 days assuming that no problems have arisen. This gives our students a peace of mind when enrolling in new classes.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#general" href="#collapseSeven_general">Is it necessary for students and teachers to follow the class rules?<i class="indicator icon-plus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseSeven_general" class="panel-collapse collapse">
                            <div class="panel-body">
                                A good class starts from being in an orderly environment, it is a students responsibility if, for whatever reason are unable to attend class, to contact the teacher or other students to inform them of your absense, it is up to the teacher how they choose to move forward, as a teacher is responsible for all students in their course in and out of the classroom.
                            </div>
                        </div>
                    </div>
                </div><!-- End panel-group -->

                <h3>Teacher Questions</h3>

                <div class="panel-group" id="teacher">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#teacher" href="#collapseOne_teacher">How can I get a class started?<i class="indicator icon-plus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseOne_teacher" class="panel-collapse collapse">
                            <div class="panel-body">
                                If you have planned a class schedule, then you are already 90% of the way there! let students find you and earn some extra cash along the way. Simply start by selecting the 'Start your class' link on the top right of the page.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#teacher" href="#collapseTen_teacher">Do I need any teaching experience to teach?<i class="indicator icon-plus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseTen_teacher" class="panel-collapse collapse">
                            <div class="panel-body">
                                You don't need any formal teaching experience to teach with us. At Classrr we believe that real-world knowledge, passion and expertise is just as valuable as any certificate. If you do have a lot of teaching experience, of course we welcome you as well. Our business model is designed to bring the best the teachers and providing them with a platform to be able to find (or be found by) equally motivated students.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#teacher" href="#collapseTwo_teacher">Are there any fees?<i class="indicator icon-plus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseTwo_teacher" class="panel-collapse collapse">
                            <div class="panel-body">
                                Listing classes with Classrr is completely free of charge. Students will be charged a 3-5% processing fee based on the total amount of the package purchased at the time of checkout, this fee will be taken by PayPal or your chosen payment processor, this way our beloved teachers won't be underpaid. The teacher receives the amount they set based on their base price and class duration, minus 20% service fee for any first time students in any of your classes and sliding down to 10% for every returning students. This way we can cover employee expenses, technical costs &amp; maintenance and promotional campaigns so that teacher can focus on what really matters.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#teacher" href="#collapseThree_teacher">How do I receive my money?<i class="indicator icon-plus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseThree_teacher" class="panel-collapse collapse">
                            <div class="panel-body">
                                Your students will first send payment to Classrr at the time of booking via credit card or PayPal. We will then send you that money via your choice of check or whatever method is most convenient for you as soon as the student's first class has started.<br /><br />
								To keep Classrr as a fun, secure &amp; professional community, for your first class payout, you'll be required to verify your identity securely via our website &amp; your payment may be paid separately each week; For example, 1-month class with total value of $1,000 will be paid $250 every week.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#teacher" href="#collapseFour_teacher">Do I have to provide visa support for overseas student?<i class="indicator icon-plus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseFour_teacher" class="panel-collapse collapse">
                            <div class="panel-body">
                                This is entirely upto you. It may take extra effort on your part to provide your students with visa support, different countries have different rules regarding this situation, if you are familiar with the process in your country then it is possible to use this as a method in order to potentially attract overseas students which usually prefer a longer study duration.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#teacher" href="#collapseFive_teacher">Do I need a classroom in order to teach?<i class="indicator icon-plus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseFive_teacher" class="panel-collapse collapse">
                            <div class="panel-body">
                                It is not a strict requirement, however it is recommended that you have a classroom with a clearly outlined curriculum and course plan. We understand that is may be difficult to first get a classroom and then find students, instead you can list your current address as your classroom address and change it later on when your student quota is met.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#teacher" href="#collapseNine_teacher">How do I find a classroom?<i class="indicator icon-plus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseNine_teacher" class="panel-collapse collapse">
                            <div class="panel-body">
                                When you’re deciding where to teach your class, think about places you often go to; existing relationships with business owners and employees can help a lot. Also use the following suggestions in order to help you decide where would be the best location to set up a classroom.
                                <ul>
                                    <li>Noise Level. Is the level of background noise ok, or will it disrupt you and your class too much?</li>
                                    <li>Capacity. Is it able to accomodate the number of students you have booked?</li>
                                    <li>Amenities &amp; Equipment. Does your class require Wifi? Do you need a projector?</li>
                                    <li>Set-up. Does everyone need their own workspace, or will chairs set up in rows work? Think about the space and what it’s conducive for.</li>
                                    <li>Location. Is the space difficult for people living in the city centre to access? Is it near public transportation? You’ll attract more people if your venue is in a relatively central location.</li>
                                </ul>
                                Generally speaking if it is in a suitable location, and affordable based on your class price then that is all you really need to begin teaching.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#teacher" href="#collapseSix_teacher">Do I have to teach everyone who applies to join my class?<i class="indicator icon-plus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseSix_teacher" class="panel-collapse collapse">
                            <div class="panel-body">
                                No, you can choose to teach whomever you like. When a student books your class, you can then view their profile and either accept or decline their request. If you decline, the student receives an email stating that your class is not available at that time. If you accept, that student is then added to your class!
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#teacher" href="#collapseEleven_teacher">What happens if not enough student sign up to meet my minimum threshold?<i class="indicator icon-plus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseEleven_teacher" class="panel-collapse collapse">
                            <div class="panel-body">
                                You can do the following:
                                <ul>
                                    <li>Contact the students to inform them that class needs to be moved to another future class schedule.</li>
                                    <li>If you have another class partially booked at a future date you can then attempt to merge the two classes together to meet your threshold, you will need to contact the students directly to ensure the new class date and times are suitable for all parties involved.</li>
                                    <li>Cancel that class</li>
                                    <li>Lower the minimum threshold and start teaching, please note that even if you have activated late booking for that class (which allows students to book to join the class even if the course has already started) it doesn't guarantee that new students will book that class.</li>
                                </ul>
                                If you don't make any changes on or before the start date of your class, your class will be automatically cancelled and any payments made will be refunded.
                            </div>
                        </div>
                    </div>
					<div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#teacher" href="#collapseOutside_teacher">What if a student asks to pay the fee outside Classrr?<i class="indicator icon-plus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseOutside_teacher" class="panel-collapse collapse">
                            <div class="panel-body">
                                As a community marketplace, Classrr relies on integrity and trust from our own members. Any payment related to the class you post on Classrr should only be processed via Classrr to protect you and the students, failing to do so may result in permanent suspension from Classrr platform.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#teacher" href="#collapseTwelve_teacher">What kind of cancellation policies can I implement in my classes?<i class="indicator icon-plus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseTwelve_teacher" class="panel-collapse collapse">
                            <div class="panel-body">
                                There are three standard cancellation policies that Classrr will enforce to protect both teacher and student alike including an optional 7-day satisfaction guarantee that you can enable. The cancellation policies available are specified below:
                                <br><br><strong>Flexible</strong>: A full refund is available to students if they cancel anytime up until 1 day before the arranged class starting date, no refund given after the class has started unless the 7-day satisfaction guarantee is enabled. Non-transferrable booking.
                                <br><strong>Moderate</strong>: A 50% refund is available to students if they cancel anytime up until 1 day before the arranged class starting date, no refund given after the class has started unless the 7-day satisfaction guarantee is enabled. Non-transferrable booking.
                                <br><strong>Strict</strong>: The booking is Non-refundable unless the 7-day satisfaction guarantee is enabled. The booking is transferrable for up to 7 days starting from the class starting date and is only available if a request for transfer has been made before the class starting date.
                                <br><br>The following terms apply to all cancellation policies listed above:
                                <ul>
                                    <li>Any Visa fees are to be refunded if the student for whatever reason doesn't receive the applied for visa.</li>
                                    <li>The student Processing fee is non-refundable.</li>
                                    <li>If there are any problems / disagreements about the class / schedule / materials etc. by either party, notice must be given to Classrr within 24 hours of undertaking the first day of class.</li>
                                    <li>Classrr will mediate disputes whenever necessary, and has the final say in all disputes.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#teacher" href="#collapseThirteen_teacher">How does 7-days satisfaction guarantee work?<i class="indicator icon-plus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseThirteen_teacher" class="panel-collapse collapse">
                            <div class="panel-body">
                                The 7-day satisfaction guarantee works like this:<br>
                                The student must first be in attendance of your arranged class in order for the guarantee to work, if the student is in attendance then they have 7 days to lodge any complaints or to notify us of any problems, if there are no problems within that time frame the money they deposited will be released to the teacher in full. It is suggested for teachers to create an attendance list for your protection. This guarantee will override your selected cancellation policy if you choose to enable it.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#teacher" href="#collapseFourteen_teacher">How can I find a good photo of my classroom in order to attract people to attend my class?<i class="indicator icon-plus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseFourteen_teacher" class="panel-collapse collapse">
                            <div class="panel-body">
                                A photo can define what your class is all about. The pictures you use are crucial to attracting interest. You can use a professional photo of your, a photo provided by an organisation such as Creative Commons or simply use royalty-free images. Alternatively you can buy stock photos or hire a professional photographer and graphic designer in order to give your offer the best chance of success possible.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#teacher" href="#collapseSeven_teacher">How long will my class posting stay on the site?<i class="indicator icon-plus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseSeven_teacher" class="panel-collapse collapse">
                            <div class="panel-body">
                                Students will be able to view your listing until you turn it off via your dashboard. If and when you turn it off, it will be saved so at a later date you can turn it on when you become available again.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#teacher" href="#collapseEight_teacher">My student was amazing! How can I leave feedback?<i class="indicator icon-plus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseEight_teacher" class="panel-collapse collapse">
                            <div class="panel-body">
                                Once the class has concluded, you will then be prompted by Classrr to leave student feedback on their profile page directly.
                            </div>
                        </div>
                    </div>
                </div><!-- End panel-group -->

                <h3>Student Questions</h3>

                <div class="panel-group" id="student">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#student" href="#collapseOne_student">I filled in the details for my intended class type and start date however it returned no results, what do I do now?<i class="indicator icon-plus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseOne_student" class="panel-collapse collapse">
                            <div class="panel-body">
                                Unfortunately it seems there are no classes available in your area at this time, but no problem, simply select the option under the search bar titled "Alert me". you can set your price range, and when a new listing is added, you will receive an email alert. Hang tight, Classrr is rapidly expanding with new postings being added daily, classes will be available in your area soon!
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#student" href="#collapseTwo_student">How do I cancel my class reservation?<i class="indicator icon-plus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseTwo_student" class="panel-collapse collapse">
                            <div class="panel-body">
                                If your plans have changed, email <a href="mailto:contact@classrr.com">contact@classrr.com</a> or visit your study plan. Different teachers have different cancellation policies. We will confirm with you first if there is going to be a penalty for cancelling. Teachers will be able to see the number of reservations a student has cancelled over the previous 12 months.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#student" href="#collapseFive_student">How does 7-day satisfaction guarantee work?<i class="indicator icon-plus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseFive_student" class="panel-collapse collapse">
                            <div class="panel-body">
                                The 7-day satification guarantee begins from your very first class, however you must be in attendance of that class for it to be enabled, how it works is that when you book your class Classrr will keep the money you paid for the booking into an account, and we will only release that money to the teacher if there are no complaints or problems discovered within 7 days of the starting class, if any problems should arise it is possible to be elligible for a full refund, if no problems arise then the payment shall be made to the teacher in full after the 7 days have lapsed. Keep in mind however that a first class is not always indicative of how the rest of the course will play out, good teachers try to adapt their content to fit the class in question.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#student" href="#collapseBro_student">What if a teacher doesn't show up?<i class="indicator icon-plus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseBro_student" class="panel-collapse collapse">
                            <div class="panel-body">
                                All bookings made through Classrr are 100% satisfaction guaranteed, if the teacher does not teach a class in accordance with the class description or if you are unsatisfied in any way, please get in contact with us at <a href="mailto:contact@classrr.com">contact@classrr.com</a>.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#student" href="#collapseSeven_student">Will teachers have access to my personal information?<i class="indicator icon-plus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseSeven_student" class="panel-collapse collapse">
                            <div class="panel-body">
                                Yes, private information will be exchanged between students and teachers but only after the booking is successfully confirmed, the information shared may include the following:<br>
                                (1) Name<br>
                                (2) E-mail Address<br>
                                (3) Phone Number<br><br>
                                For overseas students (both with or without a visa service), the teacher may request an access to you for:<br>
                                National ID card / Passport<br>
								You will be prompted with option to approve or deny the access for the information<br><br>								
                                For your assurance we use secure 256-bit SSL connection &amp; encryption technology when processing &amp; distributing your private information. Furthermore, you can check our Privacy Policy for any other questions you may have that are not answered here.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#student" href="#collapseThree_student">What methods of payment can I use?<i class="indicator icon-plus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseThree_student" class="panel-collapse collapse">
                            <div class="panel-body">
                                We want to make the experience of signing up to a class as simple as possible, you are currently able to book through us using a credit card or PayPal account. The hassle of using cash is well and truly over.
                            </div>
                        </div>
                    </div>
					<div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#student" href="#collapseOutside_student">Can I make a payment directly to the teacher?<i class="indicator icon-plus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseOutside_student" class="panel-collapse collapse">
                            <div class="panel-body">
                                Classrr helps you to be protected by placing your payments on secure environment before and during your learning session starts, if a teacher requests direct payment you should report it to us, this kind of behavior usually done by scammers &amp; opportunists to seize the moment of trust into their advantage. <br /><br />
								We have placed a very good system to keep the responsible teachers happy and by that, we're making sure that they can give you the best learning experience possible.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#student" href="#collapseSix_student">I am not satisfied with a booking, how do I receive a refund?<i class="indicator icon-plus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseSix_student" class="panel-collapse collapse">
                            <div class="panel-body">
                                Once the reason for refund has been cleared, we will process your refund request back through your previously used payment method.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#student" href="#collapseFour_student">My teacher was amazing! How can I leave feedback?<i class="indicator icon-plus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseFour_student" class="panel-collapse collapse">
                            <div class="panel-body">
                                Once the class has concluded, you will then be prompted by Classrr to leave Teacher feedback on their profile page directly.
                            </div>
                        </div>
                    </div>
                </div><!-- End panel-group -->

                <h3>Business Owner Questions</h3>

                <div class="panel-group" id="classroom">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#classroom" href="#collapseOne_classroom">How can I list a classroom to be rented out?<i class="indicator icon-plus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseOne_classroom" class="panel-collapse collapse">
                            <div class="panel-body">
                                If you have an empty room you would like to rent out you then you are 90% of the way there! Start by clicking on the 'List a classroom' link on the bottom of the webpage.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#classroom" href="#collapseTwo_classroom">What kind of classroom can I list?<i class="indicator icon-plus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseTwo_classroom" class="panel-collapse collapse">
                            <div class="panel-body">
                                An empty room, a few tables and chairs and a whiteboard is all that is required. A projector, wifi access and even a toilet may bring extra value to your listing.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#classroom" href="#collapseThree_classroom">Are there any fees?<i class="indicator icon-plus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseThree_classroom" class="panel-collapse collapse">
                            <div class="panel-body">
                                There is no charge to list your classroom rental - it is free to post.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#classroom" href="#collapseFour_classroom">How do I get paid?<i class="indicator icon-plus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseFour_classroom" class="panel-collapse collapse">
                            <div class="panel-body">
                                Teachers will find and contact you directly, they will then schedule a meeting to view the classroom and you will get paid based on the terms of your agreement.
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#classroom" href="#collapseFive_classroom">How long my classroom listing stay on the site?<i class="indicator icon-plus pull-right"></i></a>
                            </h4>
                        </div>
                        <div id="collapseFive_classroom" class="panel-collapse collapse">
                            <div class="panel-body">
                                It stays on the site until you decide to take it off, if at anytime you wish to have your listing removed from the website please contact <a href="mailto:contact@classrr.com">contact@classrr.com</a> and we will have it removed for you.
                            </div>
                        </div>
                    </div>
                </div><!-- End panel-group -->

            </div><!-- End col lg-9 -->
        </div><!-- End row -->
    </div><!-- End container -->
@endsection