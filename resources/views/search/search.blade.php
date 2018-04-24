@extends('layout')

@section('title_tag')
    <title>Top 20 {{ $query }} Class Taught by Creative Teachers - Classrr {{ $where }}</title>
@endsection

@section('additional_metas')
  <meta name="twitter:title" content="Top 20 {{ $query }} Class Taught by Creative Teachers - Classrr {{ $where }}">
  <meta name="twitter:description" content="{{ date('F d, Y') }} - Learn {{ $query }} from people in {{ ($where) }}. Find creative teachers to study with in 72 countries. Learn anywhere anytime with Classrr.">
  <meta name="twitter:card" content="summary" />
  <meta name="twitter:site" content="@classrrcom" />
  <meta name="twitter:data2" content="Classrr" />
  <meta name="twitter:label2" content="Marketplace" />
  <meta name="twitter:domain" content="classrr.com" />
@endsection

@section('meta_title', 'Top 20 '.$query.' Class Taught by Creative Teachers - Classrr '.e($where))
@section('meta_description', date('F d, Y').' - Learn '.$query.' from people in '.e($where).'. Find creative teachers to study in 72 countries. Learn anywhere anytime with Classrr.')

@section('prop_title', 'Top 20 '.$query.' Class Taught by Creative Teachers - Classrr '.e($where))
@section('prop_description', date('F d, Y').' - Learn '.$query.' from people in '.e($where).'. Find creative teachers to study in 72 countries. Learn anywhere anytime with Classrr.')
@section('prop_image', asset('img/features-intro-01.jpg'))

@section('og_title', 'Top 20 '.$query.' Class Taught by Creative Teachers - Classrr '.e($where))
@section('og_description', date('F d, Y').' - Learn '.$query.' from people in '.e($where).'. Find creative teachers to study in 72 countries. Learn anywhere anytime with Classrr.')
@section('og_image', asset('img/features-intro-01.jpg'))
@section('og_url', Request::url())

@section('additional_styles')
        <!-- Radio and check inputs -->
<link href="{{ asset('css/skins/square/grey.css') }}" rel="stylesheet">
<!-- Range slider -->
<link href="{{ asset('css/ion.rangeSlider.css') }}" rel="stylesheet" >
<link href="{{ asset('css/ion.rangeSlider.skinFlat.css') }}" rel="stylesheet">
@endsection

@section('additional_javascript')
    <script src="{{ asset('js/search_controller.js') }}"></script>
    <script src="{{ asset('js/icheck.js') }}"></script>
    <script>
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-grey',
            radioClass: 'iradio_square-grey'
        });

    </script>
@endsection

@section('query', $query)

@section('content')
<div class="collapse" id="collapseMap">
			<div id="map" class="map"></div>
		</div>
		<!-- End Map -->
    <div  class="container margin_30">
		@if(!Auth::user() && !request()->cookie('referral_code'))
		<div class="main_title">
            <p>
                <a href="{{ route('register', ['ref' => 'LwOby7']) }}">Register to claim your free $25 discount today</a>
			</p>
        </div>
		@elseif(!Auth::user() && request()->cookie('referral_code'))
		<div class="main_title">
            <p>
                <a href="{{ route('register') }}">You have a $25 credit from a friend. <strong>Complete your registration to claim it</strong></a>
			</p>
        </div>
		@elseif(request()->cookie('login'))
		@endif
        <div class="row">
            <aside class="col-lg-3 col-md-3">
				<p>
						<a class="btn_map" data-toggle="collapse" href="#collapseMap" aria-expanded="false" aria-controls="collapseMap" data-text-swap="Hide map" data-text-original="View on map">View on map</a>
					</p>
                <div class="box_style_cat">
                    <ul id="cat_nav">
                        <li><a href="#" id="cat_nav_0" data-id="0">
                                <i class="icon_set_1_icon-51"></i>All classrooms <span>{{--counter--}}</span></a></li>
                        @foreach($categories as $category)
                            <li><a href="#" id="cat_nav_{{ $category['id'] }}" data-id="{{ $category['id'] }}">
                                    <i class="icon_set_1_icon-51"></i>
                                    {{ $category['name'] }}
                                    <span>{{--counter--}}</span></a></li>
                        @endforeach
                    </ul>
                </div>

                <div id="filters_col">
                    <a data-toggle="collapse" href="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters" id="filters_col_bt"><i class="icon_set_1_icon-65"></i>Filters <i class="icon-plus-1 pull-right"></i></a>
                    <div class="collapse" id="collapseFilters">
                        <div class="filter_type">
                            <h6>Level</h6>
                            <ul id="lvl_nav">
                                @foreach($levels as $level)
                                    <li><label><input id="lvl_nav_{{ $level['id'] }}" class="filter" type="checkbox" value="{{ $level['id'] }}">{{ $level['title'] }}</label></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="filter_type">
                            <h6>Schedule</h6>
                            <ul id="day_nav">
                                @foreach($weekdays as $key => $weekday)
                                    <li><label><input id="day_nav_{{ $loop->iteration }}" type="checkbox" value="{{ $loop->iteration }}">{{ $weekday }}</label></li>
                                @endforeach

                            </ul>
                        </div>
                        <div class="filter_type">
                            <h6>Class time</h6>
                            <ul id="time_nav">
                                @foreach($class_time as $time)
                                    <li><label><input id="time_nav_{{ $loop->iteration }}" type="checkbox" value="{{ $loop->iteration }}">{{ $time }}</label></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="filter_type">
                            <h6>Price</h6>
                            <input type="text" id="price_range" name="price_range" value="">
                        </div>


                    </div><!--End collapse -->
                </div><!--End filters col-->

            </aside><!--End aside -->
            <div class="col-lg-9 col-md-9">

                <div id="tools">

                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-6">
                            <div class="styled-select-filters">
                                <select name="sort_price" id="sort_price">
                                    <option value="" selected>Sort by price</option>
                                    <option value="asc">Lowest price</option>
                                    <option value="desc">Highest price</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-6">
                            <div class="styled-select-filters">
                                <select  name="sort_rating" id="sort_rating">
                                    <option value="" selected>Sort by ranking</option>
                                    <option value="asc">Lowest ranking</option>
                                    <option value="desc">Highest ranking</option>
                                </select>
                            </div>
                        </div>
						<div class="text-center hidden-xs" id="shareIcons"></div>
                    </div>
                </div><!--/tools -->

                <div id="search-results">
                    <div class="spinner"></div>
                    <div id="search-results-container">
                        @include('search.results', ['items' => $items, 'query' => $query, 'where' => $where, 'cat_id' => $category_id, 'when' => $when, 'duration' => $duration])
                    </div>
                </div><!-- end #search-results-->
            </div><!-- End col lg-9 -->
        </div><!-- End row -->
    </div><!-- End container -->

@endsection