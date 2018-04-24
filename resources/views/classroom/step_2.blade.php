<div class="form_title">
<h3><strong>2</strong>@lang('classroom.step_2')</h3>
<p>
	@lang('classroom.step_caption_2')
</p>
</div>
<div class="step">
<div class="row">
	<div class="col-md-6 col-sm-6">
		<div class="form-group">
			<label>@lang('classroom.label_country')</label>
			{{ Form::select('country_id', $countries, null, ['placeholder' => 'Select your country', 'class' => 'form-control']) }}
		</div>
	</div>
	<div class="col-md-6 col-sm-6">
		<div class="form-group">
			<label><i class="icon-lightbulb-3"></i>@lang('classroom.tip')</label>
			<span class="small-text">@lang('classroom.tip_content', ['link' => 'mailto:contact@classrr.com'])</span>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6 col-sm-6">
		<div class="form-group">
			<label>@lang('classroom.label_street')</label>
			{{ Form::text('address_1', null, ['class' => 'form-control']) }}
		</div>
	</div>
	<div class="col-md-6 col-sm-6">
		<div class="form-group">
			<label>@lang('classroom.label_apt')</label>
			{{ Form::text('address_2', null, ['class' => 'form-control']) }}
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label>@lang('classroom.label_city')</label>
			{{ Form::text('city', null, ['class' => 'form-control']) }}
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<label>@lang('classroom.label_state')</label>
			{{ Form::text('state', null, ['class' => 'form-control']) }}
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<label>@lang('classroom.label_postal_code')</label>
			{{ Form::text('zip_code', null, ['class' => 'form-control']) }}
		</div>
	</div>
</div><!--End row -->
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label>@lang('classroom.label_location_gps')</label>
			<div id="map"></div>
			{{ Form::text('lat', null, ['placeholder' => 'Lat', 'class' => 'form-control hidden', 'id' => 'lat']) }}
			{{ Form::text('lng', null, ['placeholder' => 'Long', 'class' => 'form-control hidden', 'id' => 'lng']) }}
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="form-group">
			<label>@lang('classroom.label_how_get_there')</label>
			{{ Form::textarea('location_comments', null, [
				'placeholder' => 'Explain the best direction to find your classroom by public transportation like bus or train. Is it inside a mall or a coffee shop?',
				'style' => 'height:100px;',
				'class' => 'form-control']) }}
		</div>
	</div>
</div>

</div><!--End step -->