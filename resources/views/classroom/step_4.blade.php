<div class="form_title">
<h3><strong>4</strong>@lang('classroom.step_4')</h3>
<p>
	@lang('classroom.step_caption_4')
</p>
</div>

<div class="step">
<div class="row">
<div class="col-md-6 col-sm-6">
	<div class="form-group">
		<label>@lang('classroom.label_duration')
			<div class="tooltip_styled tooltip-effect-1" data-placement="right">
			<span class="tooltip-item"><i class="icon-info-circled"></i></span>
				<div class="tooltip-content">@lang('classroom.label_duration_tooltip')</div>
			</div>
		</label>
		{{ Form::select('duration_id', $durations, null, ['placeholder' => 'Duration', 'class' => 'form-control class_duration', 'v-model'=>'duration']) }}
	</div>
</div>
<div class="col-md-6 col-sm-6">
	<div class="form-group">
		<label>@lang('classroom.label_enrollment')
			<div class="tooltip_styled tooltip-effect-1" data-placement="right">
			<span class="tooltip-item"><i class="icon-info-circled"></i></span>
				<div class="tooltip-content">@lang('classroom.label_enrollment_tooltip')</div>
			</div>
		</label>
		{{ Form::text('enrollment_date', null, [
			'class' => 'date-pick form-control',
			'data-date-format' => 'M d, yyyy'
			]) }}
	</div>
</div>
</div>
<div class="row">
<div class="col-md-12 col-sm-12">
	<ul class="schedule-legend">
		<li><span class="legend-box morning"></span>@lang('classroom.label_morning_group')</li>
		<li><span class="legend-box afternoon"></span> @lang('classroom.label_afternoon_group')</li>
		<li><span class="legend-box evening"></span> @lang('classroom.label_evening_group')</li>
	</ul>
	<input type="hidden" name="schedule_json" id="schedule_json">
	<table id="scheduler" class="hidden-xs" border="1">
		<tbody>
		<tr>
			<td><i class="icon-clock"></i></td>
			@foreach($hours as $hour)
				<td>{{ sprintf('%02d', $hour) }}</td>
			@endforeach
		</tr>
		@foreach($weekdays as $weekday)
			<tr>
				<td class="weekday">{{ $weekday }}</td>
				@foreach($hours as $hour)
					<td @if ($hour >= 7 and $hour <= 12)
							class="{{ $weekday }} hour-check morning"
						@elseif ($hour >= 13 and $hour <= 17)
							class="{{ $weekday }} hour-check afternoon"
						@else
							class="{{ $weekday }} hour-check evening"
						@endif
						data-weekday="{{ $weekday }}"
						data-hour="{{ $hour }}"
						>
						<input type="checkbox" name="schedule[{{ $weekday }}][{{ $hour }}]"
							   @if (isset($classroom['schedule']) &&
									isset($classroom['schedule'][$weekday]) &&
									in_array($hour, $classroom['schedule'][$weekday]))
									   checked="checked"
							   @endif
							   value="1">
					</td>
				@endforeach
			</tr>
		@endforeach
		</tbody>
	</table>
	<table id="scheduler-mobile" class="visible-xs" border="1">
		<tbody>
		<tr>
			<td></td>
			@foreach($weekdays as $weekday)
				<td class="weekday">{{ $weekday }}</td>
			@endforeach
		</tr>
		@foreach($hours as $hour)
			<tr>
				<td class="hour">{{ sprintf('%02d', $hour) }}</td>
				@foreach($weekdays as $weekday)
					<td @if ($hour >= 7 and $hour <= 12)
						class="{{ $weekday }} hour-check morning"
						@elseif ($hour >= 13 and $hour <= 17)
						class="{{ $weekday }} hour-check afternoon"
						@else
						class="{{ $weekday }} hour-check evening"
						@endif
						data-weekday="{{ $weekday }}"
						data-hour="{{ $hour }}"
					>
						<input type="checkbox"
							   name="schedule[{{ $weekday }}][{{ $hour }}]"
							   @if (isset($classroom['schedule']) &&
								 isset($classroom['schedule'][$weekday]) &&
								 in_array($hour, $classroom['schedule'][$weekday]))
									checked="checked"
							   @endif
							   value="1">
					</td>
				@endforeach
			</tr>
		@endforeach
		</tbody>
	</table>
	<div class="schedule-error"></div>

	<h6>@lang('classroom.you_select'):</h6>
	<ul id="schedule-selected" class="schedule-legend">
		<li>Nothing yet</li>
	</ul>
</div>
</div>
</div><!--End step -->
