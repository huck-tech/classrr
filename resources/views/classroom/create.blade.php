@extends('layout')

@section('title', 'Add listing')

@section('additional_styles')
<link href="{{ asset('css/skins/square/grey.css') }}" rel="stylesheet">
<link href="{{ asset('css/date_time_picker.css') }}" rel="stylesheet">
<link href="{{ asset('css/modal-skill.css') }}" rel="stylesheet">
@endsection

@section('additional_javascript')
<!--region File Upload-->
<script>
	window.Api = {!! json_encode([ 'search_skill_url' => $search_skill_url, 'skill_suggestion_url' => $skill_suggestion_url]) !!};	
	@if(isset($data_default)) 
		window.DataDEFAULT = {!! json_encode( $data_default ) !!};
	@endif

	window.FileAPI = {
		debug: false // debug mode
		, staticPath: '{{ asset('/js/FileAPI/') . '/' }}' // path to *.swf
	};
</script>
<script src="{{ asset('js/FileAPI/FileAPI.min.js') }}"></script>
<script src="{{ asset('js/FileAPI/FileAPI.exif.js') }}"></script>
<script src="{{ asset('js/jquery.fileapi.js') }}"></script>
<script>
$(document).ready(function() {
	//
	$('#multiupload').fileapi({
		url: '{{ route('files_upload') }}',
		@if ($classroom->photos)
		files: [
			@foreach($classroom->photos as $photo)
			{
				src: "{{ $photo->getResizedPath('128x128') }}",
				name: "{{ $photo->original_name }}",
				size: {{ $photo->file_size }},
				id: {{ $photo->id }}
			}@unless ($loop->last), @endunless
			@endforeach
		],
		@endif
		multiple: true,
		maxSize: 2 * FileAPI.MB,
		maxFiles: 4,
		imageSize: { minWidth: 600, minHeight: 400, maxWidth: 3840, maxHeight: 2160 },
		accept: 'image/*',
		data: {'_token': Laravel.csrfToken},
		autoUpload: true,
		elements: {
			progress: '#progress .progress-bar',
			list: '.js-files',
			file: {
				tpl: '.js-file-tpl',
				preview: {
					el: '.preview',
					width: 128,
					height: 128
				},
				upload: { show: '.progress', hide: '.b-thumb__rotate' },
				complete: { hide: '.progress' },
				progress: '.progress .progress-bar'
			},
			dnd: {
				el: $('.upload-drop-zone'),
				hover: 'dnd-hover'
			}
		},
		onFileComplete: function (evt, uiEvt) {
			//Find div id in file object
			// No other way :(((
			var $thumbnail_div = null;
			for (key in uiEvt.file) {
				if (/^fileapi/.test(key)) $thumbnail_div = $('#' + uiEvt.file[key]);
			}
			if (uiEvt.error) {
				$thumbnail_div.find('.error').text(uiEvt.result.error).show();
			} else {
				//$thumbnail_div.append($('<input>').attr('name', 'photos_ids[]').attr('type', 'hidden').val(uiEvt.result.id));
				$thumbnail_div.find('.photo-id-input').attr('value', uiEvt.result.id);

				//$thumbnail_div.append($('<input>').attr('name', 'photos_old[]').attr('type', 'hidden').val(JSON.stringify(uiEvt.result)));
			}
		},
		onUpload: function (){
			$('.js-upload-finished-container').show();
		},
		//
		onSelect: function (evt, data){
			data.all; // All files
			data.files; // Correct files
			if( data.other.length ){
				// errors
				var errors = data.other[0].errors;
				if( errors ){
					$.notify({ 
						title: '<strong>Photos error!</strong><br>', 
						message: 'Maximum file size is 2MB.<br>Minimum size is 600x400.<br>2 photos maximum.' },
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

});
</script>
<!--endregion File Upload-->

<script src="{{ asset('js/icheck.js') }}"></script>
<script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
<script>
$(document).ready(function() {
	$('input.icheck').iCheck({
		checkboxClass: 'icheckbox_square-grey',
		radioClass: 'iradio_square-grey'
	});

	$('input.date-pick').datepicker({'startDate': '+1d'});    

	var el = document.getElementById('classroom_curriculum_container');
	var sortable = Sortable.create(el, {
		animation: 150,
		handle: ".draglecture",
		draggable: ".item",
		onEnd: function(el){
		   $('#classroom_curriculum_container').find('.order').each(function(i, e) {
			   $(e).val(i + 1);
		   });
		}
	});
 });
</script>

<script>
	// $('#classroom_curriculum_container').sortable();
	// var el = document.getElementById('classroom_curriculum_container');
	// var sortable = Sortable.create(el, {
	//     animation: 150,
	//     handle: ".draglecture",
	//     draggable: ".item",
	//     onEnd: function(el){
//            $('#classroom_curriculum_container').find('.order').each(function(i, e) {
//                $(e).val(i + 1);
//            });
	//     }
	// });
</script>
<script type="text/javascript" src="{{ asset('js/classroom/vue-select2.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/classroom/classroom.js') }}"></script>
<script>
	//Set up some of our variables.
	var map; //Will contain map object.
	var marker = false; ////Has the user plotted their location marker?

	//Function called to initialize / create the map.
	//This is called when the page has loaded.
	function initMap() {

	var map = new google.maps.Map(document.getElementById('map'), {
		center: {lat: 37.0625, lng: -95.677068},
		zoom: 4
	});

	// Try HTML5 geolocation.
	if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(function(position) {
			var pos = {
				lat: position.coords.latitude,
				lng: position.coords.longitude,
			};

		map.setCenter(pos);
		map.setZoom(15);
		}, function() {
			handleLocationError(true, map.getCenter());
		});
		} else {
		// Browser doesn't support Geolocation
			handleLocationError(false, map.getCenter());
		}

		//Listen for any clicks on the map.
		google.maps.event.addListener(map, 'click', function(event) {
			//Get the location that the user clicked.
			var clickedLocation = event.latLng;
			//If the marker hasn't been added.
			if(marker === false){
				//Create the marker.
				marker = new google.maps.Marker({
					position: clickedLocation,
					map: map,
					draggable: true //make it draggable
				});
				//Listen for drag events!
				google.maps.event.addListener(marker, 'dragend', function(event){
					markerLocation();
				});
			} else{
				//Marker has already been added, so just change its location.
				marker.setPosition(clickedLocation);
			}
			//Get the marker's location.
			markerLocation();
		});
	}

	//This function will get the marker's current location and then add the lat/long
	//values to our textfields so that we can save the location.
	function markerLocation(){
		//Get location.
		var currentLocation = marker.getPosition();
		//Add lat and lng values to a field that we can save.
		document.getElementById('lat').value = currentLocation.lat(); //latitude
		document.getElementById('lng').value = currentLocation.lng(); //longitude
	}


	//Load the map when the page has finished loading.
	google.maps.event.addDomListener(window, 'load', initMap);
</script>

{!! JsValidator::formRequest('App\Http\Requests\StoreClassroom', '#classroom_form') !!}
@endsection

@section('hero')
	<section id="hero">
		<div class="intro_title">
			<h3 class="animated fadeInDown">@lang('page_quotes.classroom_create_title')</h3>
			<p class="animated fadeInDown">@lang('page_quotes.classroom_create_caption')</p>
			{{--<a href="#" class="animated fadeInUp button_intro">View Tours</a> <a href="#" class="animated fadeInUp button_intro outline">View Tickets</a>--}}
		</div>
	</section><!-- End hero -->
@endsection

@section('content')
	<div class="container margin_30" id="app">    
		<div class="row">
			<div class="col-md-4 col-sm-12 text-center">

				<h4>@lang('classroom.reason_1')</h4>
				<p>
					@lang('classroom.reason_content_1')
				</p>
			</div>
			<div class="col-md-4 col-sm-12 text-center">

				<h4>@lang('classroom.reason_2')</h4>
				<p>
					@lang('classroom.reason_content_2')
				</p>
			</div>
			<div class="col-md-4 col-sm-12 text-center">

				<h4>@lang('classroom.reason_3')</h4>
				<p>
					@lang('classroom.reason_content_3')
				</p>
			</div>
		</div><!-- End row -->
		<div class="main_title">
			<p>
				<a href="https://www.classrr.com/support/knowledge-base/how-do-i-create-a-class?ref=giddy" target="_blank">@lang('classroom.first_time')</a>
			</p>
		</div>

		{!! Form::model($classroom, ['route' => 'classroom_store', 'method' => 'post', 'id' => 'classroom_form']) !!}
		@if ($classroom['id'])
			{{ Form::hidden('id', null) }}
		@endif
		<div class="row classroom_form">
			<div class="col-md-offset-2 col-md-8 add_bottom_15">
				<div class="form_title">
					<h3><strong>1</strong>@lang('classroom.step_1')</h3>
					<p>
						@lang('classroom.step_caption_1')
					</p>
				</div>
				@if (count($errors) > 0)
					<div class="alert alert-danger">
						<ul>
							@foreach ($errors->all() as $error)
								<li>{!! $error !!}</li>
							@endforeach
						</ul>
					</div>
				@endif

				<div class="step">
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label>@lang('classroom.label_category')</label>
								{{ Form::select('category_id', $categories, null, ['placeholder' => 'Pick a category', 'class' => 'form-control', 'v-model' => 'category','@change' => 'skillSearch()']) }}
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label>@lang('classroom.label_classname')</label>
								{{--<input type="text" name="title" class="form-control">--}}
								{{ Form::text('title', null, [
									'placeholder' => 'e.g Learn Mandarin in Shanghai',
									'class' => 'form-control']) }}
								<small>@lang('classroom.label_classname_caption')</small>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label>@lang('classroom.label_details')</label>
								{{ Form::textarea('description', null, [
									'placeholder' => 'What will you teach in this class? What student can expect to get from learning in this class?',
									'style' => 'height:200px;',
									'class' => 'form-control']) }}
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-4 col-sm-4">
							<div class="form-group">
								<label>@lang('classroom.label_difficulty')</label>
								{{ Form::select('level_id', $levels, null, ['placeholder' => 'Pick a level', 'class' => 'form-control']) }}
							</div>
						</div>
						<div class="col-md-4 col-sm-4">
							<div class="form-group">
								<label>@lang('classroom.label_student')
									<div class="tooltip_styled tooltip-effect-1" data-placement="right">
									<span class="tooltip-item"><i class="icon-info-circled"></i></span>
										<div class="tooltip-content">@lang('classroom.label_student_tooltip')</a></div>
									</div>
								</label>
								{{ Form::number('number_student', null, [
								'placeholder' => 'Max 6 students',
								'max' => 6,
								'min' => 1,
								'class' => 'form-control']) }}
							</div>
						</div>
					</div>
				</div><!--End step -->

				@include('classroom.step_2')
				@include('classroom.step_3')
				@include('classroom.step_4')
				@include('classroom.step_5')
				@include('classroom.step_6')
				@include('classroom.step_7')
			
				<div id="policy">
					<h4>@lang('classroom.label_terms')</h4>
					<div class="form-group">
						<label>
							<input type="checkbox" class="icheck" required id="policy_terms">
							@lang('classroom.checkbox_terms', ['link' => route('terms')])
						</label>
					</div>
					<button class="btn_1 green medium" type="submit" @if(isset($email_verified) && !$email_verified) disabled @endif>
						@lang('classroom.list_now')
					</button>
				</div>
			</div>


		</div><!--End row -->
		{!! Form::close() !!}

	</div><!--End container -->

@endsection
