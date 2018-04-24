@extends('layout')

@section('title', 'Learn directly from teachers around you')
@section('meta_description', 'Classrr Referral terms &amp; conditions')

@section('additional_styles')
    <style>
        ul.tooltips_demo {
            list-style:none;
            margin:0;
            padding:0;
        }
        ul.tooltips_demo li{
            margin-right:20px;
            display:inline-block;
        }
    </style>
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
                <li>Referral Terms and Conditions</li>
            </ul>
        </div>
    </div><!-- Position -->
@endsection

@section('content')
    <div class="container margin_60">
        <div class="row">

            <div class="col-lg-12 col-md-8 col-sm-8">

                <div class="row">
                    <div class="col-md-12">

                        <!-- Headings & Paragraph Copy -->
                        <h1>Classrr Referral Program Terms &amp; Conditions</h1>
                        <h2>Last updated: August 10, 2017</h2>
						
						<p>The Classrr Referral Program allows registered Classrr users (a "Classrr User") to earn discount ("Learning Credits") toward future study by referring friends to Classrr.<br />
						To participate, Classrr Users must agree to these terms, which become part of the Classrr <a href="{{ route('terms') }}">Terms of Service</a>.</p>
                        
						<h3>How to Earn Referral Learning Credits</h3>
						
						<p>Classrr Users can earn Learning Credits towards future Classrr study if: (i) a referred friend clicks on their referral link to create a valid Classrr account that complies with our <a href="{{ route('terms') }}">Terms of Service</a>; 
						and (ii) the referred friend completes a Qualifying Booking either as a student or as a teacher. 
						Neither the Classrr User may be the teacher nor the student on the Qualifying Booking booked by the referred friend.</p>
						
						<p>The referring Classrr User will be credited with the Learning Credit amount described in the referral invitation or accompanying promotional materials. 
						The maximum Learning Credit per User will be $7,500 USD, 
						unless indicated otherwise in the referral invitation or accompanying promotional materials.</p>
						
						<h3>Qualifying Booking</h3>
						
						<p>A Qualifying Booking must have a total value (excluding handling fees or taxes) indicated in the referral invitation or accompanying promotional materials. 
						It must be booked and paid for via the Classrr platform, and the referred friend must complete the study before the Classrr User can receive Learning Credits.</p>
						
						<h3>Redeeming Learning Credits</h3>
						
						<p>Learning Credits may only be redeemed via the Classrr Site, Application and Services. 
						Learning Credits will automatically appear as a discount on the checkout page, and must be used on a booking within one year from the date they are issued. 
						After one year, the Learning Credits will expire. Learning Credits are automatic discounts issued for promotional purposes; 
						they have no cash value and may not be transferred or exchanged for cash.</p>
						
						<p>Learning Credits may not be earned by creating multiple Classrr Accounts. 
						Learning Credits accrued in separate Classrr accounts may not be combined into one Classrr account.</p>
						
						<p>A Classrr user may redeem up to $300 Learning Credits for classes with total price between $80-$900 and up to $500 Learning Credits for classes with total price above $900, handling fee &amp; taxes is excluded from total price calculation.</p>
						
						<h3>Sharing Referral Links</h3>
						
						<p>Referrals should only be used for personal and non-commercial purposes, and only shared with personal connections that will appreciate receiving these invitations. 
						Referral links should not be published or distributed where there is no reasonable basis for believing that all or most of the recipients are personal friends (such as coupon websites, Reddit, or Wikipedia).</p>
                    
						<h3>Referred Friends</h3>
						
						<p>Referred friends that have signed up using a valid referral link will also receive a 
						Learning Credit indicated in the referral invitation or accompanying promotional materials that can be used on their next Qualifying Booking on Classrr.</p>
						
						<h3>Multiple Referrals</h3>
						
						<p>A referred friend may only use one referral link. 
						If a referred friend receives referral links from multiple Classrr Users, 
						only the corresponding Classrr User of the referral link used by the referred friend will receive Learning Credit.</p>
						
						<h3>Exclusive Referral Program</h3>
						
						<p>During the promotional period, Classrr may work with a 3rd-party entity or brand ("a Partner", "our Partner", "the Partner") to 
						market, promote, provide benefits and deals, and other causes which may be disclosed on our Partners page. 
						If the exclusive referral program ("The Partnership") is using the same referral system, a partner may redeem another form of 
						rewards such as cash, perks, and other valuable offers.</p>

						<p>These following clauses need to be recognized by our partner:</p>

						<ul>
							<li>Respect Intellectual Property Rights</li>
							<li>Disclose Your Connection to Classrr</li>
							<li>Maintain Clear and Prominent Disclosure</li>
							<li>Give Your Honest and Truthful Opinions</li>
							<li>Only Make Factual Statements That Are Truthful and Can Be Verified</li>
							<li>Do Not Send E-mail Messages on Classrr's Behalf Unless Expressly Requested To Do So</li>
							<li>Comply with other policies and laws</li>
							<li>Protect Your Personal Information</li>
							<li>Respect Others’ Privacy</li>
						</ul>
						
						<p>A termination of this program will not result in a cancellation of any pending reward for the partner otherwise 
						stated differently in a written agreements concerning such subject matter between Classrr and the partner.</p>

						<p>Classrr may terminate these Terms and/or the Services under any Term Sheet: (i) immediately in the event of a material breach 
						by the partner or (ii) for convenience at any time.</p>

						<p>The partner will not be entitled to, and hereby waives any right to seek, injunctive relief to enforce the provisions 
						of these Terms, and The partner's sole remedy for any breach by Classrr shall be to recover monetary damages, 
						if any, subject to the terms and conditions herein.</p>
						
						<h3>Severability</h3>
						
						<p>If any provision in these terms are held to be invalid, void, or unenforceable, 
						such provision (or the part of it that is making it invalid, void or unenforceable) 
						will be struck and not affect the validity of and enforceability of the remaining provisions.</p>
						
						<h3>Termination and Changes</h3>
						
						<p>Classrr may suspend or terminate the Referral Program or a user’s ability to participate in the Referral Program at any time for any reason.</p>
						
						<p>We reserve the right to suspend accounts or remove Learning Credits if we notice any activity 
						that we believe is abusive, fraudulent, or in violation of the Classrr Terms of Service. 
						We reserve the right to review and investigate all referral activities and to suspend accounts or 
						modify referrals in our sole discretion as deemed fair and appropriate.</p>
						
						<p>The scope, variety, and type of services and products that you may obtain by redeeming Learning Credits can change at any time.</p>
						
						<h3>Updates to the Terms</h3>
						
						<p>We can update these terms at any time without prior notice. 
						If we modify these terms, we will post the modification on the Classrr.com website, applications, or services, 
						which are effective upon posting. Continued participation in the Referral Program after any
						modification shall constitute consent to such modification.</p>
												
					</div>
                </div><!-- Edn row -->
            </div><!-- End col-lg-9-->
        </div>
    </div><!-- End container -->
@endsection