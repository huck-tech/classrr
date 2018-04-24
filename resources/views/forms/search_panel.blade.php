{!! Form::open(['route' => 'classroom_list', 'method' => 'get', 'id' => 'search-panel-form']) !!}
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Topic</label>
			@if(!empty($query))
            <input type="text" class="form-control" id="search-term-phone" name="q" placeholder="@lang('home.search_learn')" value="{{ $query }}">
			@else
			<input type="text" class="form-control" id="search-term-phone" name="q" placeholder="@lang('home.search_learn')" value="">
			@endif
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label>Location</label>
			@if(!empty($where))
            <input id="search-where-phone" class="search-text" type="text" name="where" value="{{ $where }}" placeholder="@lang('home.search_where')">
			@elseif(isset($city))
			<input id="search-where-phone" class="search-text" type="text" name="where" value="{{ $city }}" placeholder="@lang('home.search_where')">
			@else
			<input id="search-where-phone" class="search-text" type="text" name="where" value="" placeholder="@lang('home.search_where')">
			@endif
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label class="select-label">When?</label>
			@if(!empty($when))
            {{ Form::select('when', $search_month_select, $when, ['placeholder' => trans('home.search_when'), 'name' => 'when', 'class' => 'form-control', 'id' => 'when-phone']) }}
			@else
			{{ Form::select('when', $search_month_select, null, ['placeholder' => trans('home.search_when'), 'name' => 'when', 'class' => 'form-control', 'id' => 'when-phone']) }}
			@endif
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group">
            <label class="select-label">Duration</label>
			@if(!empty($duration))
            {{ Form::select('duration', $search_duration_select, $duration, ['placeholder' => trans('home.search_howlong'), 'name' => 'duration', 'class' => 'form-control', 'id' => 'duration-phone']) }}
			@else
			{{ Form::select('duration', $search_duration_select, null, ['placeholder' => trans('home.search_howlong'), 'name' => 'duration', 'class' => 'form-control', 'id' => 'duration-phone']) }}
			@endif
        </div>
    </div>

</div><!-- End row -->
<hr>
<button type="submit" id="search-mobile" class="btn_1 green search-button"><i class="icon-search"></i>@lang('home.search')</button>
{!! Form::close() !!}

@section('fbpixel')

<script type="text/javascript">
$('#search-mobile').click(function() {
    fbq('track', 'SearchMobile');
	qp('track', 'SearchMobile');
});
</script>

<script type="text/javascript">
$('#search-button').click(function() {
    fbq('track', 'SearchDesktop');
	qp('track', 'SearchDesktop');
});
</script>

@endsection