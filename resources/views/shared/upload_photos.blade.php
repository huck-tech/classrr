<div id="multiupload">
    <div class="form-inline upload_1">
        <div class="form-group">
            <span class="btn_1 green fileinput-button">
                <i class="icon-plus"></i>
                <span>Select files...</span>
                <!-- The file input field used as target for the file upload widget -->
                <input id="js-upload-files" type="file"
                       name="image"
                       accept=""
                       data-url="{{ route('files_upload') }}">
            </span>
        </div>
        {{--<button type="submit" class="btn_1 green" id="js-upload-submit">Upload file</button>--}}
    </div>

    <div class="hidden-xs">
        <!-- Drop Zone -->
        <h5>@lang('classroom.or_drag_files_below')</h5>
        <div class="upload-drop-zone" id="drop-zone">
            Just drag and drop files here
        </div>
        <!-- Progress Bar -->
        <div id="progress" class="progress">
            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                {{--<span class="sr-only"><span class="progress-value">0</span>% Complete</span>--}}
            </div>
        </div>
        <!-- Upload Finished -->
        <div class="js-upload-finished-container">
            <h5>Processed files</h5>

            <div class="js-files">
                <div class="js-file-tpl thumbnail pull-left" id="<%-uid%>" title="<%-name%>, <%-sizeText%>">
                    <div data-fileapi="file.remove" class="delete"></div>
                    <div class="preview">
                        <div class="preview-pic"></div>
                    </div>
                    <div class="progress progress-small"><div class="progress-bar"></div></div>
                    <div class="thumbnail-name"><%-name%></div>
                    <input type="hidden" class="photo-id-input" name="photos_ids[]" value="<%-id%>">
                    <div class="error"></div>
                </div>
            </div>
        </div>
    </div>
</div>