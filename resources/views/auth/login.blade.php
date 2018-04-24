@extends('layout')

@section('title', 'Login')

@section('hero')
    <section id="hero">
        <div class="intro_title">
            <h3 class="animated fadeInDown">@lang('page_quotes.home_title')</h3>
            <p class="animated fadeInDown">@lang('page_quotes.home_caption')</p>
            {{--<a href="#" class="animated fadeInUp button_intro">View Tours</a> <a href="#" class="animated fadeInUp button_intro outline">View Tickets</a>--}}
        </div>
    </section><!-- End hero -->

    <div id="position">
        <div class="container">
            <ul>
                <li><a href="{{ route('homepage') }}">@lang('login.home')</a></li>
                <li>@lang('login.login')</li>
            </ul>
        </div>
    </div><!-- Position -->
@endsection


@section('content')
<div class="container margin_60">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('login.login')</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
                        {{ csrf_field() }}
						<div class="row">
                            <div class="col-md-4 col-sm-4 login_social">
                                <a href="{{ route('oauth', ['provider' => 'facebook']) }}" class="bt_oauth bt_facebook"><i class="icon-facebook"></i> Facebook</a>
                            </div>
                            <div class="col-md-4 col-sm-4 login_social">
                                <a href="{{ route('oauth', ['provider' => 'google']) }}" class="bt_oauth bt_google"><i class="icon-googleplus"></i>Google+</a>
                            </div>
							<div class="col-md-4 col-sm-4 login_social">
                                <a href="{{ route('oauth', ['provider' => 'linkedin']) }}" class="bt_oauth bt_linkedin"><i class="icon-linkedin"></i>LinkedIn</a>
                            </div>
                        </div> <!-- end row -->
                        <div class="login-or"><hr class="hr-or"><span class="span-or">or</span></div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">@lang('login.email')</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">@lang('login.password')</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> @lang('login.remember_me')
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn_1">
                                    @lang('login.login')
                                </button>

                                <a class="btn btn-link" href="{{ url('/password/reset') }}">
                                    @lang('login.forget_password')
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
