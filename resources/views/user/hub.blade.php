@extends('user_layout')

@section('tab_content')


    <ul class="nav nav-tabs">
        <li class="active"><a href="#resources" data-toggle="tab">@lang('hub.teaching')</a></li>
        <li><a href="#rental" data-toggle="tab">@lang('hub.classroom')</a></li>
        <li><a href="#wowair" data-toggle="tab">@lang('hub.wowair')</a></li>
        <li><a href="#southwest" data-toggle="tab">@lang('hub.southwest')</a></li>
        <li><a href="#airasia" data-toggle="tab">@lang('hub.airasia')</a></li>
        <li><a href="#airbnb" data-toggle="tab">@lang('hub.airbnb')</a></li>
        <li><a href="#gettingaround" data-toggle="tab">@lang('hub.getting_around')</a></li>
        <li><a href="#visaservices" data-toggle="tab">@lang('hub.visa')</a></li>
        <li><a href="#entertainment" data-toggle="tab">@lang('hub.entertainment')</a></li>
    </ul>
    <div class="tab-content studyplan-tabs">
        <div class="tab-pane active" id="resources">
            <h3>@lang('hub.soon_teaching')</a></h3><br />           
        </div>
        <div class="tab-pane" id="rental">
            <h3 class="text-center">@lang('hub.soon_classroom')</a></h3><br />
        </div>
        <div class="tab-pane" id="wowair">
            <h3 class="text-center">@lang('hub.wowair')</a></h3><br />
        </div>
        <div class="tab-pane" id="southwest">
            <h3 class="text-center">@lang('hub.soon_airplane')</a></h3><br />
        </div>
        <div class="tab-pane" id="airasia">
            <h3 class="text-left">@lang('hub.soon_airasia')</a></h3>
        </div>
        <div class="tab-pane" id="airbnb">
            <h3 class="text-left">@lang('hub.soon_airbnb')</a></h3>
        </div>
        <div class="tab-pane" id="gettingaround">
            <h3 class="text-left">@lang('hub.soon_lyft')</a></h3>
        </div>
        <div class="tab-pane" id="visaservices">
            <h3 class="text-center">@lang('hub.soon_visa')</a></h3><br />
        </div>
        <div class="tab-pane" id="entertainment">
            <h3 class="text-center">@lang('hub.soon_entertainment')</a></h3><br />
        </div>
    </div>
	
@endsection