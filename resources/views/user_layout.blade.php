@extends('layout')

@section('title', 'User Profile')

@section('additional_styles')
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.switch.css') }}" rel="stylesheet">
    <link href="{{ asset('css/skins/square/grey.css') }}" rel="stylesheet">
@endsection

@section('additional_javascript')    
    <script src="{{ asset('js/tabs.js') }}"></script>
    <script src="{{ asset('js/icheck.js') }}"></script>
    <script>
    $(document).ready(function() {
        $('input.icheck').iCheck({
            checkboxClass: 'icheckbox_square-grey',
            radioClass: 'iradio_square-grey'
        });
    });
    </script>
    {{--<script>new CBPFWTabs( document.getElementById( 'tabs' ) );</script>--}}
@endsection

@section('content')

    <div class="margin_30 container">
		<div class="main_title">
            <p>
                <a href="https://www.classrr.com/support/knowledge-base/how-do-i-use-classrr?ref=giddy" target="_blank"><strong>Learn how to navigate through your User Dashboard</strong></a>
			</p>
        </div>
        <div id="tabs" class="tabs">
            <nav>
                <ul>
                    {{--<li class="tab-current"><a href="{{ route('user_dashboard') }}" class="icon-home-1"><span>Dashboard</span></a></li>--}}
		
                    <li class="{{ Route::is('user_dashboard')?'tab-current':'' }}"><a href="{{ route('user_dashboard') }}" class="icon-home-1"><span>Dashboard</span></a></li>
                    <li class="{{ Route::is('user_listing')?'tab-current':'' }}"><a href="{{ route('user_listing') }}" class="icon-th-list-3"><span>Portfolio</span></a></li>
                    <li class="{{ Route::is('user_profile')?'tab-current':'' }}"><a href="{{ route('user_profile') }}" class="icon-vcard"><span>Profile</span></a></li>
                    <li class="{{ Route::is('user_account')?'tab-current':'' }}"><a href="{{ route('user_account') }}" class="icon-settings"><span>Account</span></a></li>
                    <li class="{{ Route::is('user_reviews')?'tab-current':'' }}"><a href="{{ route('user_reviews') }}" class="icon-thumbs-up"><span>Reviews</span></a></li>
                    <li class="{{ Route::is('user_transactions')?'tab-current':'' }}"><a href="{{ route('user_transactions') }}" class="icon-money"><span>Transactions</span></a></li>
                    <li class="{{ Route::is('user_studyplan')?'tab-current':'' }}"><a href="{{ route('user_studyplan') }}" class="icon-calendar-circled"><span>Study Plan</span></a></li>
                    <li class="{{ Route::is('user_hub')?'tab-current':'' }}"><a href="{{ route('user_hub') }}" class="icon-globe"><span>Hub</span></a></li>
					<li class="{{ Route::is('user_messages')?'tab-current':'' }}"><a href="{{ route('user_messages') }}" class="icon-chat"><span>Messages</span></a></li>
                    <li class="{{ Route::is('user_referrals')?'tab-current':'' }}"><a href="{{ route('user_referrals') }}" class="icon-users"><span>Referrals</span></a></li>
                </ul>
            </nav>
            <div class="content">

                <section class="content-current">

                    @yield('tab_content')

                </section><!-- End section 1 -->


            </div><!-- End content -->
        </div><!-- End tabs -->
    </div><!-- end container -->

@endsection