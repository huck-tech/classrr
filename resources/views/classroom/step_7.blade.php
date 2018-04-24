<div class="form_title">
	<h3><strong>7</strong>@lang('classroom.step_7')</h3>
	<p>
		@lang('classroom.step_caption_7')	
	</p>
</div>
<div class="step">
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">		
		<span class="selected-tag-active" v-for="(skill, index) in pick_skills" :key="skill.id" @click="pickSkill(skill)">@{{ skill.name }}</span>
		<input type="hidden" name="skills" v-model="pick_skill_ids" value="{{ old('skills') }}" />
	</div>
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">		
		<button type="button" class="btn_1 green fileinput-button" data-toggle="modal" data-target="#skill-modal">
  			@lang('classroom.browse_skills')
		</button>		
	</div>		
</div>
</div>

@include('classroom.modal_skill')