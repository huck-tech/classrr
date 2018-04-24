@forelse ($classroom['curriculum'] as $lecture)
<div class="row item" data-lecture-id="{{ $lecture['id'] }}">
<div class="col-md-8 col-sm-8">
    <div class="form-group">
        @include('forms.lecture_field', ['lecture' => $lecture])
    </div>
</div>
<div class="col-md-4 col-sm-4">
    <div class="form-group">
        <ul class="lecture_ctrls">
            @unless ($loop->first)
                <li><a class="draglecture btn btn-sm btn-info" href="#">
                        <i class="icon-move"></i>
                        Drag this item
                        <span class="dnd-icon"><i class="icon-ellipsis-vert"></i><i class="icon-ellipsis-vert"></i></span>
                    </a></li>
                <li><a class="js-link delete_lecture" href="#">@lang('classroom.remove_lecture')</a></li>
            @endunless
            <li><a class="js-link add_lecture" href="#">@lang('classroom.add_lecture')</a></li>
        </ul>
    </div>
</div>
</div>
@empty
<div class="row item" data-lecture-id="">
<div class="col-md-8 col-sm-8">
    <div class="form-group">
        @include('forms.lecture_field', ['lecture' => null])
    </div>
</div>
<div class="col-md-4 col-sm-4">
    <div class="form-group">
        <ul class="lecture_ctrls">
            <li><a class="js-link add_lecture" href="#">Add another lecture</a></li>
        </ul>
    </div>
</div>
</div>
@endforelse


<div class="row" id="lecture_item_blank" style="display: none;">
<div class="col-md-8 col-sm-8">
<div class="form-group">
    @include('forms.lecture_field', ['lecture' => null])
</div>
</div>
<div class="col-md-4 col-sm-4">
<div class="form-group">
        <ul class="lecture_ctrls">
            <li><a class="draglecture btn btn-sm btn-info" href="#">
                    <i class="icon-move"></i>
                    Drag this item
                    <span class="dnd-icon"><i class="icon-ellipsis-vert"></i><i class="icon-ellipsis-vert"></i></span>
                </a></li>
            <li><a class="js-link delete_lecture" href="#">@lang('classroom.remove_lecture')</a></li>
            <li><a class="js-link add_lecture" href="#">@lang('classroom.add_lecture')</a></li>
        </ul>
</div>
</div>
</div>