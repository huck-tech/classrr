<div class="form_title">
<h3><strong>3</strong>@lang('classroom.step_3')</h3>
<p>
	@lang('classroom.step_caption_3')
</p>
</div>
<div class="step {{ $classroom['pricing'] ? 'pricing-' . $classroom['pricing'] : '' }}" id="pricing-step">
<div class="row">
<div class="col-sm-12 pricing-errors"></div>
<div class="col-md-6 col-sm-6">
<div class="form-group">
	<label>{{ Form::radio('pricing', 'fixed', null, ['class' => 'icheck']) }} @lang('classroom.label_fixed_price')</label>

</div>
<div class="fixed-block">
	<div class="form-group">
		<label>@lang('classroom.label_base_price')</label>
			<input type="number" class="form-control"
				   name="base_price_fixed"
				   @if ($classroom['pricing'] == 'fixed')
				   value="{{ $classroom['base_price'] }}"
				   @endif
			>
			{{--{{ Form::text('base_price', null, ['class' => 'form-control']) }}--}}
		<span class="small-text">@lang('classroom.label_fixed_price_caption')</span>
	</div>
</div><!--/fixed-block-->
</div>
<div class="col-md-6 col-sm-6">
<div class="form-group">
	<label>{{ Form::radio('pricing', 'flexible', null, ['class' => 'icheck']) }} @lang('classroom.label_flexible_price')</label>
</div>
<div class="flexible-block">
	<div class="form-group">
		<label>@lang('classroom.label_base_price')</label>
		<input type="number" class="form-control"
			   name="base_price_flexible"
			   @if ($classroom['pricing'] == 'flexible')
			   value="{{ $classroom['base_price'] }}"
			   @endif
		>

		{{--{{ Form::text('base_price', null, ['class' => 'form-control']) }}--}}
		<span class="small-text">@lang('classroom.label_flexible_price_caption')</span>
	</div>

	<div class="row">
		<div class="col-md-4">
			<div class="form-group">
				<label>@lang('classroom.label_morning') +$</label>
				{{ Form::number('price_morning', null, ['class' => 'form-control']) }}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label>@lang('classroom.label_afternoon') +$</label>
				{{ Form::number('price_afternoon', null, ['class' => 'form-control']) }}
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label>@lang('classroom.label_evening') +$</label>
				{{ Form::number('price_evening', null, ['class' => 'form-control']) }}
			</div>
		</div>

	</div>
	<div class="row">
		<div class="col-md-8">
			<div class="form-group">
				<label>&nbsp;</label>				
				<p class="text-notice">{{ Form::checkbox('add_weekend_fee', '1', null, ['class' => 'icheck', 'id' => 'add_weekend_fee']) }} @lang('classroom.label_weekend_fee')</p>
			</div>
		</div>

		<div class="col-md-4" id="add_weekend_fee_input"
			 @if (!$classroom['add_weekend_fee'])
			 style="display:none;"
			 @endif
		>
			<div class="form-group">
				<label>@lang('classroom.weekend') +$</label>
				{{ Form::number('price_weekend', null, ['class' => 'form-control']) }}
			</div>
		</div>


	</div>
</div>


</div>
</div>
</div>