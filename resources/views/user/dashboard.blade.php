@extends('user_layout')

@section('tab_content')


<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
        <div class="row dashboard-payout">
            <div class="col-md-3 col-sm-3 col-xs-12 text-center item">
                <h5>@lang('dashboard.pending_booking')</h5>
                <p>{{ number_format((float)$pending,0,'',',') }}</p>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 text-center item">
                <h5>@lang('dashboard.active_booking')</h5>
                <p>{{ number_format((float)$active,0,'',',') }}</p>
            </div>
			<div class="col-md-3 col-sm-3 col-xs-12 text-center item">
                <h5>@lang('dashboard.complete_booking')</h5>
                <p>{{ number_format((float)$completed,0,'',',') }}</p>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12 text-center item">
                <h5>@lang('dashboard.available_payout')</h5>
                <p><sup>$</sup>{{ number_format((float)$payout,0,'',',') }}</p>
            </div>
        </div>
		<hr>
        <div class="class-list">
             <h3 class="text-center">@lang('dashboard.search_graph')</h3>
        </div><!-- end class-list -->
		<hr>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 dashboard-panel">
        <h3 class="text-center">You could earn $900 per student for 1-month class</h3>
		{{--
        <h5>Complete your first listing and get</h5>
        <ul>
            <li><a href="#">Tips on welcoming students</a></li>
            <li><a href="#">Tools to meet your goals</a></li>
        </ul>
		--}}
    </div>
</div>




@endsection