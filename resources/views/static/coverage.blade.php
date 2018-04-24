@extends('layout')

@section('title', 'Global Education Community')
@section('meta_description', 'Classrr has a fast-growing, global network of affordable education provided by independent &amp; creative teachers.')

@section('additional_styles')
@endsection

@section('additional_javascript')
@endsection

@section('hero')
    <section id="hero">
        <div class="intro_title">
            <h3 class="animated fadeInDown">Education, wherever you are</h3>
            <p class="animated fadeInDown">Discover amazing education like you discover great movies</p>
            {{--<a href="{{ route('register') }}" class="animated fadeInUp button_intro">Register</a> <a href="{{ route('login') }}" class="animated fadeInUp button_intro outline">Login Now</a>--}}
        </div>
    </section><!-- End hero -->

    <div id="position">
        <div class="container">
            <ul>
                <li><a href="{{ route('homepage') }}">Home</a></li>
                <li>Coverage</li>
            </ul>
        </div>
    </div><!-- Position -->
@endsection

@section('content')
    <div class="container margin_60">
        <div class="main_title">
            <h2><span>United States</span></h2>
        </div>
        <hr>
        <div class="row">
        	<div class="col-xs-12 col-xs-offset-0" style="margin-bottom:6em;">
                    <div class="row">
                    @for($a = 0; $a < $sho; $a++)
                        <div class="col-sm-3 text-center" style="margin-bottom:3em;">
                           <strong><h4>{{ $states[$a] }} - <a href="{{ route('classroom_list') }}?where={{ $states[$a] }}">{{ $teacher[$a] }}</a></h4></strong>
                        </div>
                    @endfor
                    </div>
                </div>    
        </div>
        <div class="main_title">
            <h2><span>The World</span></h2>
        </div>
        <div class="row">
        	<div class="col-xs-12 col-xs-offset-0" style="margin-bottom:6em;">
                    <div class="row">
                    @for($a = 0; $a < $sho2; $a++)
                        <div class="col-sm-3 text-center" style="margin-bottom:3em;">
                           <strong><h4>{{ $country[$a] }} - <a href="{{ route('classroom_list') }}?where={{ $country[$a] }}">{{ $teacher2[$a] }}</a></h4></strong>
                        </div>
                    @endfor
                    </div>
                </div>    
        </div>
        <hr>
    </div><!-- End container -->
@endsection