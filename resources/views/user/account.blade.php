@extends('user_layout')

@section('additional_javascript')
@parent
<script src="{{ asset('js/verification_controller.js') }}"></script>
        <!--region File Upload-->
<script>
    window.FileAPI = {
        debug: false // debug mode
        , staticPath: '{{ asset('/js/FileAPI/') . '/' }}' // path to *.swf
    };
</script>
<script src="{{ asset('js/FileAPI/FileAPI.min.js') }}"></script>
<script src="{{ asset('js/FileAPI/FileAPI.exif.js') }}"></script>
<script src="{{ asset('js/jquery.fileapi.min.js') }}"></script>
<script>
    $('#multiupload').fileapi({
        url: '{{ route('files_upload') }}',
        multiple: true,
        maxSize: 2 * FileAPI.MB,
        maxFiles: 2,
        accept: 'image/*',
        data: {'_token': Laravel.csrfToken, 'image_type': 'document'},
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
                $thumbnail_div.append($('<input>').attr('name', 'photos_ids[]').attr('type', 'hidden').val(uiEvt.result.id));
                //$thumbnail_div.append($('<input>').attr('name', 'photos_old[]').attr('type', 'hidden').val(JSON.stringify(uiEvt.result)));
            }
        },
        onUpload: function (){
            $('.js-upload-finished-container').show();
        }

    });
</script>
@endsection

@section('tab_content')
    <div class="row">
        @include('shared.flash')

        <div class="col-md-6 col-sm-6 add_bottom_30">
            @if($verification_phone && $verification_phone['is_completed'])
                <h4>@lang('account.phone_verify') &ndash; <span class="text-success">@lang('account.phone_verify_success')</span></h4>
                <div class="form-group">
                    <label>@lang('account.phone_label')</label>
                    <input class="form-control" disabled
                           name="phone" id="phone" type="tel" value="{{ $verification_phone['token'] }}">
                </div>
            @else
                {!!  Form::open(['route' => 'verification_verify_code',
                    'data-verify-code-path' => route('verification_verify_code'),
                    'method' => 'get',
                    'id' => 'sms-verification-form']) !!}

                    <h4>@lang('account.phone_verify')</h4>
                    <div class="form-group">
                        <label>@lang('account.phone_label')</label>
                        <input class="form-control" required
                               name="phone" id="phone" type="tel" placeholder="+15551238877">
                    </div>
                    <div class="form-group" id="sms-input" style="display: none;">
                        <label>@lang('account.sms_code')</label>
                        <input class="form-control" id="sms-code-input"  type="text">
                    </div>
                    <button id="sms-code" class="btn_1 green">@lang('account.btn_send_code')</button>
                    <button id="sms-code-check" class="btn_1 green" style="display: none;">@lang('account.verify_code')</button>
                {!! Form::close() !!}
            @endif
        </div>
        <div class="col-md-6 col-sm-6 add_bottom_30">
            <h4>@lang('account.email_verify')
                @if($verification_email && $verification_email['is_completed'])
                    <span class="text-success">&ndash; @lang('phone_verify_success')</span>
                @endif</h4>
            <div class="form-group">
                <label>@lang('account.email')</label>
                <input class="form-control"  id="new_email" type="email" value="{{ $current_user->email }}" disabled>
            </div>
            @unless($verification_email && $verification_email['is_completed'])
                <button type="submit" id="email-code" class="btn_1 green">@lang('account.btn_verify_email')</button>
            @endunless
        </div>
    </div><!-- End row -->
    <hr>
	<h4>@lang('account.upload_passport')</h4>
    <span class="small-text">@lang('account.upload_pasport_label')</span>
	<hr>
    @if ($documents and count($documents) > 0)
        <h4>@lang('upload_transcript')</h4>
        <div class="row">
            @foreach($documents as $item)
                <div class="col-sm-3">
                    <div class="thumbnail">
                        <img src="{{ $item->getAssetPath() }}" >
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-sm-12">
                <button class="btn_1 green"
                        data-toggle="collapse"
                        data-target="#upload-block">@lang('account.upload_more')</button>
            </div>
        </div>
        <hr>
    @endif
    <div id="upload-block" class="collapse
        @unless ($documents and count($documents) > 0)
        in
        @endif
            ">
        <h4>@lang('account.upload_academic')</h4>
        <span class="small-text">@lang('account.upload_academic_label')</span>
        @include('shared.upload_photos')
    </div>
    <div class="row">
        <div class="col-sm-12">
            <button class="btn btn-danger pull-right"
                    data-toggle="modal" 
                    data-target="#deactivate-modal">@lang('account.btn_deactive')</button>
        </div>
    </div>
    <div id="deactivate-modal" class="modal fade" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">@lang('account.deactive_ask_title')</h4>
                </div>
                <div class="modal-body center">
					@lang('account.deactive_ask_info')
					<hr>
                    <form method="POST" action="{{ route('user_deactivate') }}">
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        <button type="submit"
                            class="btn btn-danger">@lang('account.btn_yes')</button>
                        <button class="btn btn-default" 
                            data-dismiss="modal" 
                            aria-label="Close">@lang('account.btn_no')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
