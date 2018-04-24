<div class="modal fade" id="modal-skill" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h5 class="modal-title text-center" id="skill-modal-title">Add your skills (<a href="https://www.classrr.com/support/knowledge-base/skill-distribution-network/" target="_blank">Learn more</a>)</h5>
			</div>
			<div class="modal-body skill-box">			
				<form v-on:submit.prevent>
				<div class="row">

					<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
						<input type="text" name="keyword" class="form-control" @keyup="skillSearch" v-model="keyword" placeholder="Search skill" autocomplete="off" />
					</div>				
					<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">						
						<h5>@{{ resultTitle }}</h5>
					</div>					
					
					@include('user.modal-skill-item')										

					<div :class="showEmpty">
						<div class="alert alert-info"><i class="fa fa-info-circle"></i> <strong>No skill found</strong></div>
					</div>					

					<div :class="showSuggestion">
						<div class="alert alert-warning"><i class="fa fa-lightbulb-o"></i> Send <strong>@{{ keyword }}</strong> for suggestion <span class="btn-xs btn_1 green" @click="giveSuggestion()">click here</span></div>
					</div>

					<div :class="showMessage">
						<div class="alert alert-success"><i class="fa fa-check-o"></i> @{{ alertMessage }}</div>
					</div>

					<div :class="showPreloader">
					<div class='sk-spinner sk-spinner-wave'>
						<div class='sk-rect1'></div>
						<div class='sk-rect2'></div>
						<div class='sk-rect3'></div>										
					</div>
					</div>

					<div :class="showPreloaderSubmit" id="preloader">
					<div class='sk-spinner sk-spinner-wave'>
						<div class='sk-rect1'></div>
						<div class='sk-rect2'></div>
						<div class='sk-rect3'></div>										
					</div>
					</div>

				</div>	
				</form>		
			</div>
			<div class="modal-footer">
				<span class="pull-left">You have unspent @{{ userRemainingPoint }} skill point(s)</span>
				<a class="btn btn-default" href="{{ route('user_account') }}">Migrate Academic Transcripts</a>
				<button type="button" class="btn btn-info" @click="saveSuggestion()" id="btn-save-suggestion">Submit</button>
			</div>
		</div>
	</div>
</div>