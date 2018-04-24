<ul>

    @unless (Auth::check())
        <li><a href="{{ route('get') }}">@lang('navtop.become_teacher')</a></li>
    @else
        <li><a href="{{ route('classroom_create') }}">@lang('navtop.start_my_class')</a></li>
    @endif
        <li class="submenu"><a href="javascript:void(0);" class="show-submenu">@lang('navtop.compass')<i class="icon-down-open-mini"></i></a>
            <ul>
                <li><a href="{{ route('free_learning') }}">@lang('navtop.free_learning')</a></li>
                <li><a href="{{ route('travel_deals') }}">@lang('navtop.free_travel')</a></li>
                <li><a href="{{ route('teachers_bonus') }}">@lang('navtop.teacher_bonus')</a></li>
                <li><a href="{{ route('rentals') }}">@lang('navtop.classroom')</a></li>
                <li><a href="{{ route('bootcamp') }}">@lang('navtop.bootcamp')</a></li>
                    {{--<li><a href="{{ route('mystery') }}">Get Paid Learning</a></li>--}}
            </ul>
        </li>
    @if (Auth::check())
        <li><a href="{{ route('show_profile', auth()->user()->profile_slug) }}">@lang('navtop.my_profile')</a></li>
        <li class="submenu"><a href="javascript:void(0);" class="show-submenu">{{ Auth::user()->email }}<i class="icon-down-open-mini"></i></a>
            <ul>
                <li><a href="{{ route('user_dashboard') }}">@lang('navtop.dashboard')</a></li>
                <li><a href="{{ route('user_listing') }}">@lang('navtop.portfolio')</a></li>
                <li><a href="{{ route('user_profile') }}">@lang('navtop.profile')</a></li>
                <li><a href="{{ route('user_account') }}">@lang('navtop.account')</a></li>
                <li><a href="{{ route('user_reviews') }}">@lang('navtop.reviews')</a></li>
                <li><a href="{{ route('user_transactions') }}">@lang('navtop.transactions')</a></li>
                <li><a href="{{ route('user_studyplan') }}">@lang('navtop.study_plan')</a></li>
                <li><a href="{{ route('user_hub') }}">@lang('navtop.hub')</a></li>
                <li><a href="{{ route('user_messages') }}">@lang('navtop.messages')</a></li>
                <li><a href="{{ route('user_referrals') }}">@lang('navtop.referrals')</a></li>
                <li><a href="{{ url('/logout') }}">@lang('navtop.logout')</a></li>
            </ul>
        </li>
    @else
        <li class="hidden-xs hidden-sm">
            <div class="dropdown dropdown-access">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" id="access_link">@lang('navtop.login')</a>
                <div class="dropdown-menu">
                    <div class="row">
                        <div class="col-xs-12">
                            <a href="{{ route('oauth', ['provider' => 'facebook']) }}" class="bt_oauth bt_facebook">
                                <i class="icon-facebook"></i> Facebook </a>
                            <a href="{{ route('oauth', ['provider' => 'google']) }}" class="bt_oauth bt_google">
                                <i class="icon-googleplus"></i> Google Plus </a>

                            <a href="{{ route('oauth', ['provider' => 'linkedin']) }}" class="bt_oauth bt_linkedin">
                                <i class="icon-linkedin"></i> LinkedIn </a>


                        </div>
                    </div>
                    <div class="login-or">
                        <hr class="hr-or">
                        <span class="span-or">@lang('navtop.or')</span>
                    </div>
                    <form role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="text" name="email" class="form-control" id="inputUsernameEmail" placeholder="@lang('navtop.email')">
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" id="inputPassword" placeholder="@lang('navtop.password')">
                        </div>
                        <div class="form-group">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember"> @lang('navtop.remember_me')
                                </label>
                            </div>
                        </div>

                        <a id="forgot_pw" href="{{ url('/password/reset') }}">@lang('navtop.forget_password')</a>

                        <input type="submit" name="Sign_in" value="@lang('navtop.login')" id="Sign_in" class="button_drop">
                        {{-- <input type="submit" name="Sign_up" value="@lang('navtop.register')" id="Sign_up" class="button_drop outline"> --}}
                    </form>
                </div>
            </div><!-- End Dropdown access -->
        </li>
        <li class="visible-sm visible-xs submenu"><a href="javascript:void(0);" class="show-submenu">@lang('navtop.login')<i class="icon-down-open-mini"></i></a>
            <ul>
                <li class="visible-sm visible-xs"><a href="{{ route('login') }}">@lang('navtop.via') Email</a></li>
                <li class="visible-sm visible-xs"><a href="{{ route('oauth', ['provider' => 'facebook']) }}">@lang('navtop.via') Facebook</a></li>
                <li class="visible-sm visible-xs"><a href="{{ route('oauth', ['provider' => 'google']) }}">@lang('navtop.via') Google</a></li>
                <li class="visible-sm visible-xs"><a href="{{ route('oauth', ['provider' => 'linkedin']) }}">@lang('navtop.via') LinkedIn</a></li>
            </ul>
        </li>
        <li><a href="{{ route('register') }}">@lang('navtop.register')</a></li>
    @endif
</ul>