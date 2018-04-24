@extends('layout')

@section('title', 'Sign Up')

@section('additional_styles')
<link href="{{ asset('css/skins/square/grey.css') }}" rel="stylesheet">
@endsection

@section('additional_javascript')
<script src="{{ asset('js/pw_strenght.js') }}"></script>
@endsection

@section('hero')
    <section id="hero" class="login">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
                    <div id="login">
                        <div class="text-center"><img src="{{ asset('img/logo_sticky-airdojo.png') }}" alt="Image" data-retina="true" ></div>
                        <hr>
                        <form>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class=" form-control" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class=" form-control" id="password1" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <label>Confirm password</label>
                                <input type="password" class=" form-control" id="password2" placeholder="Confirm password">
                            </div>
                            <div id="pass-info" class="clearfix"></div>
                            <button class="btn_full">Create an account</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection