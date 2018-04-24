{!! Form::open(['route' => 'classroom_list', 'method' => 'get', 'id' => 'search-bar-form']) !!}
<div class="search-bar-item">
	@if(!empty($query))
    <input id="search-term" class="search-text" name="q" type="text" placeholder="@lang('home.search_learn')" value="{{ $query }}">
	@else
	<input id="search-term" class="search-text" name="q" type="text" placeholder="@lang('home.search_learn')" value="">
	@endif
</div>
<div class="search-bar-item" id="where-select">
	@if(!empty($where))
    <input id="search-where" class="search-text" name="where" type="text" value="{{ $where }}" placeholder="@lang('home.search_where')">
	@elseif(isset($city))
	<input id="search-where" class="search-text" name="where" type="text" value="{{ $city }}, {{ $country }}" placeholder="@lang('home.search_where')">
	@else
	<input id="search-where" class="search-text" name="where" type="text" value="" placeholder="@lang('home.search_where')">
	@endif
</div>

<div class="search-bar-item" id="when-select">
	@if(!empty($when))
    {{ Form::select('when', $search_month_select, $when, ['placeholder' => trans('home.search_when'), 'class' => 'ddslick', 'name' => 'when', 'id' => 'when']) }}
	@else
	{{ Form::select('when', $search_month_select, null, ['placeholder' => trans('home.search_when'), 'class' => 'ddslick', 'name' => 'when', 'id' => 'when']) }}
	@endif
</div>

<div class="search-bar-item" id="duration-select">
	@if(!empty($duration))
    {{ Form::select('duration', $search_duration_select, $duration, ['placeholder' => trans('home.search_howlong'), 'class' => 'ddslick', 'name' => 'duration', 'id' => 'duration']) }}
	@else
	{{ Form::select('duration', $search_duration_select, null, ['placeholder' => trans('home.search_howlong'), 'class' => 'ddslick', 'name' => 'duration', 'id' => 'duration']) }}
	@endif
</div>
<div class="search-bar-item">
    <button id="search-button" class="btn search-button" type="submit">
        <i class="icon-search"></i>
        @lang('home.search')
    </button>

</div>
{!! Form::close() !!}