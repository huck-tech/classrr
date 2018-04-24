@extends('user_layout')

@section('title', trans('profile.page_title'))

@section('additional_styles')
@parent
        <!-- Radio and check inputs -->
<link href="{{ asset('css/skins/square/grey.css') }}" rel="stylesheet">
<link href="{{ asset('css/shop.css') }}" rel="stylesheet"/>
<link href="{{ asset('css/profile-skill.css') }}" rel="stylesheet"/>
@endsection

@section('additional_javascript')
@parent
<!--region File Upload-->
<script>
    window.FileAPI = {
        debug: false // debug mode
        , staticPath: '{{ asset('/js/FileAPI/') . '/' }}' // path to *.swf
    };

    window.DataDEFAULT = {!! json_encode($data_default) !!};    
</script>
<script type="text/javascript" src="{{ asset('js/profile/profile.js') }}"></script>
<script src="{{ asset('js/FileAPI/FileAPI.min.js') }}"></script>
<script src="{{ asset('js/FileAPI/FileAPI.exif.js') }}"></script>
<script src="{{ asset('js/jquery.fileapi.min.js') }}"></script>
<script>
$('.fileinput-button').fileapi({
    url: '{{ route('files_upload') }}',
    multiple: false,
    maxSize: 1 * FileAPI.MB,
    accept: 'image/jpeg',
    data: {'_token': Laravel.csrfToken, 'image_type': 'avatar'},

    autoUpload: true,
    elements: {
        active: { show: '.js-upload', hide: '.js-browse' },
        progress: '#progress .progress-bar',
        dnd: {
            el: $('.upload-drop-zone'),
            hover: 'dnd-hover'
        }
    },
    onBeforeUpload: function (evt, uiEvt){
        //$('#progress .progress-bar').css('width', 0);
        $('#js-upload-finished').empty();
    },
    onComplete: function (evt, uiEvt){
        console.log(uiEvt);
        $('.js-upload-finished-container').fadeIn();
        if (uiEvt.error) {
            $('#js-upload-finished').append('<div class="alert alert-danger" role="alert">'+uiEvt.result.error+'</div>');
        } else {
            $('#js-upload-finished').append('<div class="alert alert-success" role="alert">'+uiEvt.result.name+' has been uploaded</div>');
            $('<input>').attr('name', 'avatar_id').attr('type', 'hidden').val(uiEvt.result.id).appendTo('#js-upload-finished');
            $('<input>').attr('name', 'original_name').attr('type', 'hidden').val(uiEvt.result.name).appendTo('#js-upload-finished');
        }
    },
            //
        onSelect: function (evt, data){
	        data.all; // All files
	        data.files; // Correct files
	        if( data.other.length ){
	            // errors
	            var errors = data.other[0].errors;
                console.log(errors)
	            if( errors ){
		            $.notify({ 
			            title: '<strong>Photo error!</strong><br>', 
			            message: 'Maximum file size is 1MB.<br>Photo size must be 512x512.<br>JPEG Only' },
			            { type: 'danger' });
	                //errors.maxSize; // File size exceeds the maximum size `@see maxSize`
	                //errors.maxFiles; // Number of files selected exceeds the maximum `@see maxFiles`
	                //errors.minWidth; // Width of the image is smaller than the specified `@see imageSize`
	                //errors.minHeight;
	                //errors.maxWidth; // Width of the image greater than the specified `@see imageSize`
	                //errors.maxHeight;
	            }
	        }
	    }
        //
});
</script>
<!--endregion File Upload-->

<script src="{{ asset('js/icheck.js') }}"></script>
<script>
    $('input.icheck').iCheck({
        checkboxClass: 'icheckbox_square-grey',
        radioClass: 'iradio_square-grey'
    });
</script>
<script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
<script>
    $('input.date-pick').datepicker();
</script>

<script type="text/javascript" src="{{ url('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
{!! JsValidator::formRequest('App\Http\Requests\StoreProfile', '#store_profile') !!}
@endsection

@section('tab_content')
<div id="app">
{!! Form::model($current_user, ['route' => 'user_store', 'method' => 'post', 'id' => 'store_profile']) !!}

    <div class="row">
        @include('shared.flash')

        <div class="col-md-6 col-sm-6">
            <h4>@lang('profile.your_profile')</h4>
            <ul id="profile_summary">
                <li>@lang('profile.email') <span>{{ $current_user['email'] }}</span></li>
                <li>@lang('profile.first_name') <span>{{ $current_user['first_name'] }}</span></li>
                <li>@lang('profile.last_name') <span>{{ $current_user['last_name'] }}</span></li>
                <li>@lang('profile.phone') <span>{{ $current_user['phone'] ?: 'N/A' }}</span></li>
                <li>@lang('profile.date_birth') <span>{{ $current_user['dob'] ?: 'N/A' }}</span></li>
                <li>@lang('profile.street') <span>{{ $current_user['address'] ?: 'N/A' }}</span></li>
                <li>@lang('profile.city') <span>{{ $current_user['city'] ?: 'N/A' }}</span></li>
                <li>@lang('profile.zip_code') <span>{{ $current_user['zip_code'] ?: 'N/A' }}</span></li>
                <li>@lang('profile.country') <span>{{ $current_user['country']['name'] ?: 'N/A' }}</span></li>
            </ul>
        </div>
        <div class="col-md-6 col-sm-6">
            <img src="{{ $current_user['profile_avatar'] ? asset('storage/' . $current_user['profile_avatar']['path']) : asset('img/empty_avatar_256x256.png') }}" alt="Image" class="img-responsive styled profile_pic">
            </p>
        </div>
    </div><!-- End row -->

    <div class="divider"></div>

    <div class="row">
        <div class="col-md-12">
            <h4>@lang('profile.edit_profile')</h4>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label>@lang('profile.label_first_name')
                    <div class="tooltip_styled tooltip-effect-1" data-placement="right">
                        <span class="tooltip-item"><i class="icon-info-circled"></i></span>
                        <div class="tooltip-content">@lang('profile.label_first_name_tooltip')</div>
                    </div>
                </label>
                {{ Form::text('first_name', null, ['class' => 'form-control']) }}
                <span class="small-text">@lang('profile.label_first_name_caption')</span>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label>@lang('profile.label_last_name')</label>
                {{ Form::text('last_name', null, ['class' => 'form-control']) }}
            </div>
        </div>
    </div><!-- End row -->

    <div class="row">
        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label>@lang('profile.label_phone_number')</label>
                {{ Form::text('phone', null, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label>@lang('profile.label_date_birth')</label>
                {{ Form::text('dob', null, [
                    'class' => 'date-pick form-control',
                    'data-date-format' => config('app.dateformat_js'),
                    'data-date-start-view' => '2'
                    ]) }}
            </div>
        </div>
    </div><!-- End row -->

    <div class="row">
        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label>@lang('profile.label_about_me')</label>
                {{ Form::textarea('about_me', null, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label>@lang('profile.label_i_am')</label>
                <p><span>@lang('profile.label_male') {{ Form::radio('gender', 'male', null, ['class' => 'icheck']) }}</span>
                    <span>@lang('profile.label_female') {{ Form::radio('gender', 'female', null, ['class' => 'icheck']) }}</span></p>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-12">
            <h4>@lang('profile.edit_profile')</h4>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label>@lang('profile.label_street')</label>
                {{ Form::text('address', null, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label>@lang('profile.label_city')</label>
                {{ Form::text('city', null, ['class' => 'form-control']) }}
            </div>
        </div>
    </div><!-- End row -->

    <div class="row">
        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label>@lang('profile.zip_code')</label>
                {{ Form::text('zip_code', null, ['class' => 'form-control']) }}
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label>@lang('profile.label_country')</label>
                {{ Form::select('country_id', $countries, null, ['placeholder' => 'Select your country', 'class' => 'form-control']) }}
                <span class="small-text">@lang('profile.label_country_caption')</span>
            </div>
        </div>
    </div><!-- End row -->

    <hr>

    <!-- File Upload-->
    <h4>@lang('profile.upload_profile_photo')</h4>
    <div class="form-inline upload_1">
        <div class="form-group">
            <span class="btn_1 green fileinput-button">
                <i class="icon-plus"></i>
                <span>Select file...</span>
                            <!-- The file input field used as target for the file upload widget -->
                <input id="js-upload-files" type="file"
                       name="image"
                       accept="{{ implode(',', config('app.image_types')) }}"
                       data-url="{{ route('files_upload') }}">
            </span>
        </div>
        {{--<button type="submit" class="btn_1 green" id="js-upload-submit">Upload file</button>--}}
    </div>

    <!-- Hidden on mobiles -->
    <div class="hidden-xs">
        <!-- Drop Zone -->
        <h5>Or drag and drop files below</h5>
        <div class="upload-drop-zone" id="drop-zone">
            Just drag and drop files here
        </div>
        <!-- Progress Bar -->
        <div id="progress" class="progress">
            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                {{--<span class="sr-only"><span class="progress-value">0</span>% @lang('profile.complete')</span>--}}
            </div>
        </div>
        <!-- Upload Finished -->
        @unless (old('avatar_id'))
            <div class="js-upload-finished-container" style="display: none;">
                <h5>@lang('profile.proccesed_files')</h5>
                <div id="js-upload-finished" class="list-group">
                </div>
            </div>
        @else
            {{-- if Previous request is ended with error load old file --}}
            <div class="js-upload-finished-container">
                <h5>@lang('profile.proccesed_files')</h5>
                <div id="js-upload-finished" class="list-group">
                    <div class="alert alert-success" role="alert">{{ old('original_name') }} @lang('profile.been_uploaded')</div>
                    <input type="hidden" name="avatar_id" value="{{ old('avatar_id') }}">
                    <input type="hidden" name="original_name" value="{{ old('original_name') }}">
                </div>
            </div>
        @endunless


    </div>

    <hr>
    <!-- Add Skill -->
    <div class="row">
        <div class="col-lg-12 col-md-12"><h4>@lang('profile.skills')</h4>
		<span class="small-text">@lang('profile.skills_caption')</span><br /><br />
		</div>            
        <div class="col-lg-12 col-md-12">
        @forelse($user->skills as $skill)
        <span class="{{ is_max_level($skill->pivot->amount_point, $skill->max_level)? 'label label-success': 'label label-default' }}">{{ $skill->name }}</span><span class="badge badge-info">{{ $skill->pivot->amount_point }}</span>
        @empty
        <div class="alert alert-info">@lang('profile.no_skills')</div>
        @endforelse
		<br /><br />
		<a class="btn_1 blue fileinput-button" href="{{ route('user_account') }}">
            @lang('profile.migrate_transcript')
        </a>
		@if($user->skill_points > 0)
		<a class="btn_1 green fileinput-button" data-toggle="modal" data-target="#modal-skill">
            <i class="icon-plus"></i> @lang('profile.from_skill_points')
        </a>
		@endif
        </div>
    </div>
    <!-- End Skill -->
    <hr>
    <!-- Add Skill -->
    <div class="row">
        <div class="col-lg-12 col-md-12"><h4>@lang('profile.social')</h4>
		<span class="small-text">@lang('profile.social_caption')</span><br /><br />
		</div>
        <div class="col-lg-12 col-md-12">
            <div class="form-inline">
            @if(!$user->facebook_id)
            <a href="{{ route('oauth', 'facebook') }}" class="btn_1 bt_facebook"><i class="icon-facebook"></i> Link my Facebook </a>
            @else
            <span class="btn_1"><i class="icon-facebook"></i> @lang('profile.connected')</span>
            @endif
            </div>
        </div>    
    </div>
    <hr>
    <button id="update-profile" type="submit" class="btn_1 green">@lang('profile.update_profile')</button>
{!! Form::close() !!}
@include('user.modal-skill')
</div>
@endsection
