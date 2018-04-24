<div class="form_title">
<h3><strong>5</strong>@lang('classroom.step_5')</h3>
<p>
    @lang('classroom.step_caption_5')
</p>
</div>

<div class="step">


<div class="row">
<div class="col-md-6 col-sm-6">
    <div class="form-group">
        <label>@lang('classroom.label_cancellation')
        	<div class="tooltip_styled tooltip-effect-1" data-placement="right">
			<span class="tooltip-item"><i class="icon-info-circled"></i></span>
				<div class="tooltip-content">@lang('classroom.label_cancellation_tooltip', ['link' => 'https://www.classrr.com/support/knowledge-base/kind-cancellation-policies-can-implement-classes/'])</div>
			</div>
        </label>
        {{ Form::select('cancellation_policy', App\Classroom::CANCELLATION, null, ['class' => 'form-control']) }}

    </div>
</div>
<div class="col-md-6 col-sm-6">
    <div class="form-group">
        <label>@lang('classroom.label_guarantee')
			<div class="tooltip_styled tooltip-effect-1" data-placement="right">
			<span class="tooltip-item"><i class="icon-info-circled"></i></span>
				<div class="tooltip-content">@lang('classroom.label_guarantee_tooltip', ['link' => 'https://www.classrr.com/support/knowledge-base/7-days-satisfaction-guarantee-work/'])</div>
			</div>
		</label>        
        <p class="text-notice">{{ Form::checkbox('is_guaranteed', '1', null, ['class' => 'icheck']) }} @lang('classroom.checkbox_guarantee') </p>

    </div>
</div>
</div>
<div class="row">
<div class="col-md-6 col-sm-6">
    <div class="form-group">
        <label>@lang('classroom.label_main_language')</label>
        {{ Form::text('language', null, ['placeholder' => 'e.g English, Mandarin, Local', 'class' => 'form-control']) }}
    </div>
</div>
<div class="col-md-6 col-sm-6">
    <div class="form-group">
        <label>&nbsp;</label>        
        <p class="text-notice">{{ Form::checkbox('is_international', '1', null, ['class' => 'icheck']) }} @lang('classroom.checkbox_visa')</p>

    </div>
</div>
</div>
<div class="row">
<div class="col-md-6 col-sm-6">
    <div class="form-group">
        <label>@lang('classroom.label_age_range')</label>
        {{ Form::text('age_range', null, ['placeholder' => 'e.g All ages, 18 and older', 'class' => 'form-control']) }}
    </div>
</div>
<div class="col-md-6 col-sm-6">
    <div class="form-group">
        <label>&nbsp;</label>        
        <p class="text-notice">{{ Form::checkbox('late_signup', '1', null, ['class' => 'icheck']) }} @lang('classroom.checkbox_late_enrollment')
		</p>
    </div>
</div>

</div>

<div class="row">
<div class="col-md-12 col-sm-12">
    <div class="form-group">
        <label>@lang('classroom.label_asociate_teachers')</label>
        {{ Form::email('associated_tutors', null, ['placeholder' => 'e.g email1@mail.com, email2@mail.com', 'class' => 'form-control', 'multiple' => 'true']) }}
        <span class="small-text">@lang('classroom.label_asociate_teachers_caption')</span>
    </div>
</div>
</div>

<div class="row">
<div class="col-md-6 col-sm-6">
    <div class="form-group" id="classroom_rules_container">
        <label>@lang('classroom.label_classroom_rules')</label>
        @unless ($classroom['rules'])
            <input type="text" name="rules[]" class="form-control" placeholder="Additional class rule">
        @else
            @foreach($classroom['rules'] as $rule)
                <div class="item">
                    <input type="text" name="rules[]" class="form-control" value="{{ $rule }}">
                    <a href="#" class="delete_rule"><i class="icon-cancel-circle"></i></a>
                </div>
            @endforeach
        @endunless
    </div>
</div>
<div class="col-md-6 col-sm-6">
    <div class="form-group">
        <label>&nbsp;</label>
        <p class="text-notice"><a id="add_classroom_rule" class="js-link" href="#">@lang('classroom.label_classroom_rules_add')</a></p>
    </div>
</div>

</div>


<div class="row" style="margin-bottom: 15px;">
<div class="col-md-12">
    <h4>@lang('classroom.label_upload_classroom_photos')</h4>
    @include('shared.upload_photos')
</div>
</div>


</div>