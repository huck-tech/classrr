<!-- Modal -->
<div class="modal fade" id="skill-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title text-center" id="skill-modal-title">Add skills into this class<br /><em>You can only add skills that you mastered</em></h4>
			</div>
			<div class="modal-body">			
				<form v-on:submit.prevent>
				<div class="row">

					<div class="col-lg-12">
						<input type="text" name="keyword" class="form-control" @keyup="skillSearch" v-model="keyword" placeholder="Type skill's name ..." autocomplete="off" />
					</div>					

					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">												
						<div class="" id="skill-content">
							<span v-for="(item, index) in skills" :key="item.id" :class="cssClassSelected(item)" @click="pickSkill(item)">@{{item.name}}</span>
							<div :class="showLoadMore"><span @click="loadMore" class="btn_1 green btn-xs">more+</span></div>
							
							<div :class="showEmpty">
								<div class="alert alert-info"><i class="fa fa-info-circle"></i> <strong>No skill found</strong></div>
							</div>
							{{--
							<div :class="showSuggestion">
								<div class="alert alert-warning"><i class="fa fa-lightbulb-o"></i> Send <strong>@{{ keyword }}</strong> for suggestion <span class="btn-xs btn_1 green" @click="sendSuggestion()">click</span></div>
							</div>

							<div :class="showMessage">
								<div class="alert alert-success"><i class="fa fa-check-o"></i> @{{ alertMessage }}</div>
							</div>
							--}}
							<div :class="showPreloader">
							<div class='sk-spinner sk-spinner-wave'>
								<div class='sk-rect1'></div>
								<div class='sk-rect2'></div>
								<div class='sk-rect3'></div>										
							</div>
							</div>
						</div>										
					</div>

				</div>	
				</form>		
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>				
			</div>
		</div>
	</div>
</div>