window.App = new Vue({
	el: '#app',
	data: {
		userSkills: [],
		remainingPointOrigin: 0,
		userRemainingPoint: 0,
		suggestionSkills: [],
		search_url: '',		
		suggestion_save_url: '',
		currentPage: 1,	
		nextPage: 0,		
		maxPoint: 0,
		keyword: '',		
		preloader: false,		
		preloaderSubmit: false,
		resultTitle: '',
		alertMessage: '',
		skill_suggestion_url: '',
	},
	computed: {		
		showPreloader: function() {
			return { 'col-lg-12': true, 'hidden': ! this.preloader };
		},
		showPreloaderSubmit: function() {
			return { 'container-fluid': true, 'hidden': ! this.preloaderSubmit };
		},
		showEmpty: function() {
			var hidden = !! (_.size(this.suggestionSkills) > 0);
			return { 'col-lg-12': true, 'hidden': hidden };	
		},	
		showLoadMore: function() {
			var hidden = true;
			if(this.nextPage > 0 ) {
			 	hidden  = false;
			}
			return { 'col-lg-12 col-md-12 col-xs-12': true, 'hidden': hidden };
		},
		filledSkills: function() {
			if(_.size(this.suggestionSkills) > 0 ) {
				var filledSkills = _.filter(this.suggestionSkills, function(skill) {
					if(_.has(skill,'gain_point') ) {
						if(skill.gain_point > 0) {
							return true;
						} 
						return false;
					} 
					return false;					

				});
				return filledSkills;
			}
			return [];
		},
		filledSkillsIds: function() {
			if(_.size(this.filledSkills) > 0) {
				return _.pluck(this.filledSkills, 'id');
			}
			return [];
		},
		showSuggestion: function() {
			var hidden = true;
			var noSkills = _.size(this.suggestionSkills) == 0 || false;
			var noPreloader = ! this.preloader;

			if(noSkills && noPreloader) {
				hidden = false;
			}
			return { 'col-lg-12 col-md-12 col-xs-12': true, 'hidden': hidden };
		},
		showMessage: function() {
			var hidden = true;
			if(this.alertMessage !== '') {
				hidden = false;
			}
			return { 'col-lg-12 col-md-12 col-xs-12': true, 'hidden': hidden };
		}
	},
	created: function() {
		Vue.nextTick( function() {
			App.setDefault();
			App.firstLoadSuggestion();
		});

		$.ajaxSetup({ 
			headers: {
				'X-CSRF-TOKEN': Laravel.csrfToken,
			}
		});
	},
	methods: {
		setDefault: function() {
			var userRemainingPoint = window.DataDEFAULT.remaining_point || undefined;
			var search_url = window.DataDEFAULT.search_url || undefined;
			var suggestion_save_url = window.DataDEFAULT.suggestion_save_url || undefined;
			var skill_suggestion_url = window.DataDEFAULT.skill_suggestion_url || undefined;
			var user_skills = window.DataDEFAULT.formated_skills || undefined;

			if(userRemainingPoint) {
				this.userRemainingPoint = userRemainingPoint;
				this.remainingPointOrigin = userRemainingPoint;
			}

			if(search_url) {
				this.search_url = search_url;
			}

			if(suggestion_save_url) {
				this.suggestion_save_url = suggestion_save_url;
			}

			if(skill_suggestion_url) {
				this.skill_suggestion_url = skill_suggestion_url;
			}

			if(user_skills) {
				this.userSkills = user_skills;
			}
		},
		firstLoadSuggestion: _.debounce(function() { this.getApiData(false, 0) },200),
		skillSearch: _.debounce(function() {
			var keyword = this.keyword || '';
			if(keyword.length > 0) {
				this.getApiData(true, 1);				
			} else {
				this.getApiData(false, 0);
			}
		}, 300),
		getApiData: function(loadNext, search) {
			// Reset remaining point each time search is running
			this.userRemainingPoint = this.remainingPointOrigin;

			var showNext = loadNext || false;
			var isSearch = search || 0;

			this.preloader = true;			
			var apiUrl = this.search_url;

			if(apiUrl != '') {
				$.ajax({
					url: apiUrl,
					method: 'GET',	
					dataType: 'json',
					data: { 'keyword': App.keyword, 'is_search': isSearch },		
				}).fail(function(jqXHR, textStatus) {					
					App.errorLoadInit(textStatus);
					App.preloader = false;
				}).done(function( response) {					
					var setNextPage    = response.current_page + 1;
					var setCurrentPage = response.current_page;
					var getSkills      = response.data;
					var formatedSkills = [];
					var countData      = _.size(getSkills);

					if(countData == 6) {
											
						if(setNextPage > 0 && setCurrentPage > 0 && showNext) {
							// Set Page for search skills
							Vue.set(App,'nextPage', setNextPage );
							Vue.set(App,'currentPage', setCurrentPage );
							Vue.set(App,'resultTitle', 'Search result');
						} else {
							// Next Page is Zero when showing suggestion skills
							Vue.set(App,'nextPage', 0);
							Vue.set(App,'resultTitle', 'Suggested skill(s) for you');
						}
					}

					if(countData < 6) {
						Vue.set(App,'nextPage', 0 );
					}

					if(countData > 0) {

						_.each(getSkills, function(value, key) {							
							var userSkills = App.userSkills;

							var inUserSkill = _.findWhere(userSkills, { id: value.id });						

							if(typeof inUserSkill == 'undefined') {
								var setSkill = {
									id: value.id,
									origin_point: 0,
									name: value.name,
									is_max: false,
									max_level: value.max_level,
								};

								formatedSkills.push(setSkill);
							}

							if(_.size(inUserSkill) > 0) {
								var setSkill = {
									id: inUserSkill.id,
									name: inUserSkill.name,
									origin_point: inUserSkill.origin_point,
									gain_point: inUserSkill.gain_point,
									is_max: inUserSkill.is_max,
									max_level: inUserSkill.max_level,
								};

								formatedSkills.push(setSkill);								
							}
						});	

					}

					Vue.set(App,'suggestionSkills', formatedSkills);						
					App.preloader = false;					
				});
			}	
		},		
		setAgainFilledSkills: function(skills) {
			var filledIds = this.filledSkillsIds;
			var filledSkills = this.filledSkills;
		},
		errorLoadInit: function(msg, title) {
			var getTitle = title || 'error';
			// return $('#btn-save-suggestion').notify({ title: title, message: msg }, { type: 'danger' });
			// return alert(msg);
			// console.log(msg)
		},
		countPoint: function(item) {
			return 0;
		},
		progressPoint: function(item) {			
			var progress = 0;
			var originPoint = item.origin_point || 0;
			var gainPoint = this.gainPoint(item);
			var maxLevel = item.max_level || 5;
			if(_.has(item, 'max_level')) {						
				progress = ( (originPoint + gainPoint) / maxLevel) * 100;
			}
			return 'width:' + progress + '%';
		},
		loadMore: function() {
			this.preloader = true;								
			var apiUrl = this.search_url;
			var nextPage = this.nextPage;
			var isSearch = _.size(App.keyword) > 0 ? 1: 0;

			if(nextPage > 0) {
				if(apiUrl != '') {
					$.ajax({
						url: apiUrl,
						method: 'GET',	
						dataType: 'json',
						data: { 'keyword': App.keyword, 'page': nextPage, 'is_search' : isSearch },		
					}).fail(function(jqXHR, textStatus) {					
						App.errorLoadInit(textStatus);
						App.preloader = false;
					}).done(function( response) {					
						var setNextPage    = response.current_page + 1;
						var setCurrentPage = response.current_page;
						var getSkills      = response.data;
						var formatedSkills = [];
						var countData   = _.size(getSkills);
						var skills 		= App.collectionUnion(App.suggestionSkills, getSkills, function(item) {
							return item.id;
						});												

						if(countData == 6) {
													
							if(setNextPage > 0 && setCurrentPage > 0) {
								Vue.set(App,'nextPage', setNextPage );
								Vue.set(App,'currentPage', setCurrentPage );
							}
						}

						if(countData < 6) {
							Vue.set(App,'nextPage', 0 );							
						}

						if(countData > 0) {

							_.each(skills, function(value, key) {							
								var userSkills = App.userSkills;
								var filledSkills = App.filledSkills;

								var inUserSkill = _.findWhere(userSkills, { id: value.id });
								var inFilledSkill = _.findWhere(filledSkills, { id: value.id });								
								// console.log(inFilledSkill);

								if(_.size(inUserSkill) > 0) {
									var setSkill = {
										id: inUserSkill.id,
										name: inUserSkill.name,
										origin_point: inUserSkill.origin_point,
										gain_point: 0,
										is_max: inUserSkill.is_max,
										max_level: value.max_level,
									};

									formatedSkills.push(setSkill);									
								} else if(_.size(inFilledSkill) > 0) {
									var setSkill = {
										id: inFilledSkill.id,
										name: inFilledSkill.name,
										origin_point: inFilledSkill.origin_point,
										gain_point: inFilledSkill.gain_point,
										is_max: inFilledSkill.is_max,
										max_level: value.max_level,
									};

									formatedSkills.push(setSkill);	
								} else {
									var setSkill = {
										id: value.id,
										origin_point: 0,
										gain_point: 0,
										name: value.name,
										is_max: false,
										max_level: 5,
									};

									formatedSkills.push(setSkill);
								}
							});	

						}

						Vue.set(App,'suggestionSkills', formatedSkills);

						App.preloader = false;						
					});
				}	
				// End If ApiUrl !=0
			}
			// End if nextPage > 0
		},
		collectionUnion: function collectionUnion() {  
			// Function for merging response data of skills, used by load more function
			var args = Array.prototype.slice.call(arguments);
			var it = args.pop();
			return _.uniq(_.flatten(args, true), it);
		},
		addPoint: function(item) {
			if(this.userRemainingPoint > 0) {
				var itemIndex = _.findIndex(this.suggestionSkills, item);
				var maxLevel = item.max_level || 5;
				if(itemIndex > -1) {
					var newItem = item;					
					// If gain_point property exist, then plus 1
					if(_.has(newItem, 'gain_point')) {
						// Increment, when gain_point less than maxLevel
						var sumPoint = newItem['origin_point'] + newItem['gain_point'];
						if(sumPoint < maxLevel) {
							newItem['gain_point'] += 1;						
							this.userRemainingPoint -=1;
						}
					} else {
						// If gain_point property does not exist, then set to 1
						newItem['gain_point'] = 1;
						this.userRemainingPoint -=1;
					}
					/// Remove existing one;
					this.suggestionSkills.splice(itemIndex, 1);
					// Replace with the new one;
					this.suggestionSkills.splice(itemIndex, 0, newItem);					
				}
			}
		},
		reducePoint: function(item) {						
			var itemIndex = _.findIndex(this.suggestionSkills, item);

			if(itemIndex > -1) {
				var newItem = item;					
				// If gain_point property exist, then plus 1
				if(_.has(newItem, 'gain_point')) {
					var point = newItem['gain_point'];
					if(point > 0) {
						newItem['gain_point'] -= 1;
						this.userRemainingPoint+=1;
					}
				} else {
					// If gain_point property does not exist, then set to 1
					newItem['gain_point'] = 0;
				}

				/// Remove existing one;
				this.suggestionSkills.splice(itemIndex, 1);
				// Replace with the new one;
				this.suggestionSkills.splice(itemIndex, 0, newItem);
			}			
		},
		gainPoint: function(item) {
			if(_.has(item,'gain_point')) {
				return item.gain_point;
			}
			return 0;
		},
		sumPoint: function(item) {
			var gainPoint = item.gain_point || 0;
			var originPoint = item.origin_point || 0;
			return gainPoint + originPoint;
		},
		saveSuggestion: function() {
			var apiUrlSave = this.suggestion_save_url;
			var countFilledSkills = _.size(this.filledSkills);
			if(countFilledSkills <= 0 ) {
			 	return this.errorLoadInit('No point filled');
			}
			if(apiUrlSave != '') {
				this.preloaderSubmit = true;
				$.ajaxSetup({ 
					headers: {
						'X-CSRF-TOKEN': Laravel.csrfToken,
					}
				});
				$.ajax({
					url: apiUrlSave,
					method: 'POST',
					dataType: 'json',
					data: { 'skills' : App.filledSkills }
				}).fail(function(jqXHR, textStatus) {
					var error = jqXHR.responseText || '';
					App.errorLoadInit(error);
					App.preloaderSubmit = false;
				}).done(function(response) {
					location.reload();
					App.preloaderSubmit = false;
				});
			} else {
				return App.errorLoadInit('Temporarily can save the skills');
			}
		},
		giveSuggestion: function() {
			var apiUrl = this.skill_suggestion_url || '';
			if(apiUrl !== '') {
				App.preloader = true;
				$.ajax({
					url: apiUrl,
					method: 'POST',
					dataType: 'json',
					data: { 'skill_name': App.keyword },					
				}).fail(function(jqXHR, textStatus) {
					var error = jqXHR.responseText || 'Error occuring';					
					// App.errorLoadInit(error);
					App.preloader = false;
				}).done(function(response) {
					var msg = response.message || 'Success storing';
					App.successMessage(msg);
					App.preloader = false;
				});
			}
		},
		successMessage: function(msg) {			
			this.alertMessage = msg;
			setTimeout(function() {				
				App.alertMessage = '';
			}, 3000);
		},
		hasReachMax: function(itemObject) {
			if(_.has(itemObject,'origin_point')) {
				if(itemObject.origin_point == 5) {
					return true;
				}
				return false;
			}
			return false;		
		},
		showMinusSign: function(item) {
			if(_.has(item, 'gain_point')) {
				if(item.gain_point > 0) {
					return true
				} 				
			}
			return false;
		},
		showPlusSign: function(item) {
			var gainPoint   = item.gain_point || 0;
			var originPoint = item.origin_point || 0;
			var maxLevel    = item.max_level || 5;
			var sumPoint    = originPoint + gainPoint;

			if(sumPoint < maxLevel) {
				return true;
			}
			return false;
		}
	}
});