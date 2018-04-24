<div class="form_title">
<h3><strong>6</strong>@lang('classroom.step_6')</h3>
<p>
    @lang('classroom.step_caption_6', ['link' => 'https://www.classrr.com/support/knowledge-base/create-my-class-curriculum/?ref=giddy'])
</p>
</div>
<div class="step">
<div class="form-group">
    {{-- <label class="total_hours"></label> --}}
    <label>
    	<small>
    	<span class=""><i class="fa  fa-thumbs-o-up"></i> @{{getAll.median | inMinutes }} minutes recommended</span><br>
    	<span class=""><i class="fa  fa-window-minimize"></i> @{{getAll.lowest | inMinutes }} minutes minimum</span><br>
    	<span class=""><i class="fa  fa-window-maximize"></i> @{{getAll.highest | inMinutes }} minutes maximum</span>
    	</small>
    </label>
</div>
{{--<div class="form-group">--}}
{{--<label><input id="classroom_curriculum_later" name="curriculum_later" value="1" class="icheck" type="checkbox"> Set up later</label>--}}
{{--</div>--}}
<div class="curriculum-list" id="classroom_curriculum_container">
   @include('classroom.lecture_form')
</div>
<div class="form-group">
    <label class="error_display"></label>
</div>
<div class="row">
    <input type="hidden" name="total_hours" value="0" readonly="true" />
	<input type="hidden" name="lowest_hour" v-model="getAll.lowest" readonly="true" />
	<input type="hidden" name="highest_hour" v-model="getAll.highest" readonly="true" />
	<input type="hidden" name="median_hour" v-model="getAll.median" readonly="true" />
</div>

</div>