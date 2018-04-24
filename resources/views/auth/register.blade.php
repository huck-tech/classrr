@extends('layout')

@section('title', 'Register')

@section('hero')
    <section id="hero">
        <div class="intro_title">
            <h3 class="animated fadeInDown">@lang('page_quotes.register_title')</h3>
            <p class="animated fadeInDown">@lang('page_quotes.register_caption')</p>
            {{--<a href="#" class="animated fadeInUp button_intro">View Tours</a> <a href="#" class="animated fadeInUp button_intro outline">View Tickets</a>--}}
        </div>
    </section><!-- End hero -->

    <div id="position">
        <div class="container">
            <ul>
                <li><a href="{{ route('homepage') }}">@lang('register.home')</a></li>
                <li>@lang('register.register')</li>
            </ul>
        </div>
    </div><!-- Position -->
@endsection

@section('content')

<div class="container margin_60">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">@lang('register.register')</div>
                <div class="panel-body">
                    <form role="form" method="POST" action="{{ url('/register') }}">
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

                        <div class="col-md-8 col-sm-8 col-md-offset-2 col-sm-offset-2">
                            <div class="row">
                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                        <label for="first_name" class="control-label">@lang('register.firstname')</label>

                                        <input id="first_name" type="first_name" placeholder="John" class="form-control" name="first_name" value="{{ old('first_name') }}" required>
                                        @if ($errors->has('first_name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('first_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6">
                                    <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                        <label for="last_name" class="control-label">@lang('register.lastname')</label>

                                        <input id="last_name" type="last_name" placeholder="Doe" class="form-control" name="last_name" value="{{ old('last_name') }}" required>
                                        @if ($errors->has('last_name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('last_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="control-label">@lang('register.email')</label>

                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="control-label">@lang('register.password')</label>

                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="control-label">@lang('register.confirm_password')</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                            </div>

                            <div class="form-group">
                                    <button type="submit" id="completeReg" class="btn btn-primary btn-block">
                                        @lang('register.register')
                                    </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('fbpixel')

<script type="text/javascript">
$('#completeReg').click(function() {
    fbq('track', 'CompleteRegistration');
	qp('track', 'CompleteRegistration');
});
</script>

@endsection
