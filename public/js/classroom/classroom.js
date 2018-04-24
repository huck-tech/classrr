Vue.component('v-select', VueSelect.VueSelect);

Vue.directive('delay-execute', {
    acceptStatement: true,
    bind: function () {
        this._delayRunTimeout = parseInt(this.arg, 10) || 1000;
    },
    update: function (handle) {
        this.reset();
        this._delayRunTimer = setTimeout(handle, this._delayRunTimeout);
    },
    reset: function () {
        clearTimeout(this._delayRunTimer);
    },
    unbind: function () {
        this.reset();
    }
});

window.App = new Vue({
	el: '#app',
	data: {
		low: 0,
		median: 0,
		high: 0,		
		duration: 0,	
		lecture_duration: [],
		weekdays: {
			mon: [],
			tue: [],
			wed: [],
			thu: [],
			fri: [],
			sat: [],
			sun: []
		},
		skills: [],
		pick_skills: [],		
		search_skill_page: '',
		search_skill_url: '',
		preloader: false,
		keyword: '',
		category: 0,	
		nextPage: 0,
		currentPage: 1,	
		alertMessage: '',
	},
	created: function() {
		EventBus.$on('hour-check', function(day, hour, checked) {
			App.changeWeekdays(day, hour, checked);
		});				
		Vue.nextTick(function () {
			App.firstSkillLoad();
		});
		this.setDefaultData();

		$.ajaxSetup({ 
			headers: {
				'X-CSRF-TOKEN': Laravel.csrfToken,
			}
		});
	},	
	computed: {			
		durationClass: function() {
			var duration = this.duration;
			if(duration == 1) {
				return 4;
			}
			if(duration == 2) {
				return 12;
			}
			return 0;
		},
		partitionTime: function() {
			var morning = false;
			var afternoon = false;
			var evening = false;
			var groupWeekdays = this.groupWeekdays;
			_.mapObject(groupWeekdays, function(val, key) {
				if(_.isEqual(morning, false)) {
					if(_.has(groupWeekdays[key], 'morning')) {
						morning = true;
					}
				}

				if(_.isEqual(afternoon, false)) {
					if(_.has(groupWeekdays[key], 'afternoon')) {
						afternoon = true;
					}
				}					

				if(_.isEqual(evening, false)) {
					if(_.has(groupWeekdays[key], 'evening')) {
						evening = true;
					}
				}
			}.bind(this));

			return morning + afternoon + evening;				
		},
		groupWeekdays: function() {
			var groupWeekdays =  {
				mon: {},				
				tue: {},
				wed: {},
				thu: {},
				fri: {},
				sat: {},
				sun: {}
			};

			_.mapObject(this.weekdays, function(val, key) {
				if(this.morningHour(val) > 0) {
					groupWeekdays[key]['morning'] = this.morningHour(val);
				}

				if(this.afternoonHour(val) > 0) {
					groupWeekdays[key]['afternoon'] = this.afternoonHour(val);
				}

				if(this.eveningHour(val) > 0) {
					groupWeekdays[key]['evening'] = this.eveningHour(val);
				}
			}.bind(this));

			return groupWeekdays;
		},			
		getAll: function() {
			var weekHours = {};
			var duration = this.durationClass;					

			// Duration Start With 4 weeks.
			if(duration > 3) {					
				var countMorning = this.totalMorningInWeek() * duration;
				var countAfternoon = this.totalAfternoonInWeek() * duration;
				var countEvening = this.totalEveningInWeek() * duration;
				var countAll = countMorning + countAfternoon + countEvening;
				// Just set object property when count is not zero
				if(countMorning > 0 ) {
					weekHours['morning'] = countMorning;
				}

				if(countAfternoon > 0 ) {
					weekHours['afternoon'] = countAfternoon;
				}

				if(countEvening > 0 ) {
					weekHours['evening'] = countEvening;
				}

				var lowest = _.min(weekHours);
				var highest = _.max(weekHours);
				var median = countAll / _.size(weekHours);

				return { 'lowest': lowest, 'median': median, 'highest': highest };
			}				
			return { 'lowest': null, 'median': null, 'highest': null };
		},		
		lowestHourCount: function() {
			var count = [];
			_.each(this.groupWeekdays, function(value, key, list) {
				//  Get lowest total hour each day in groupWeekdays					
				var getValue = _.values(value);						
				var min = _.min(getValue);					

				if(_.isNumber(min)) {
					count.push(min);					
				}
			});			

			var result = _.min(count);
			if(result == 'Infinity') {
				return null;
			}
			return result;
		},
		highestHourCount: function() {
			var count = [];				
			_.each(this.groupWeekdays, function(value, key, list) {
				//  Get lowest total hour each day in groupWeekdays					
				var getValue = _.values(value);					
				var max = _.max(getValue);	
				if(_.isNumber(max)) {
					count.push(max);					
				}
			});

			var result = _.max(count); 

			if(result == '-Infinity') {
				return null;
			}
			return result;
		},
		showPreloader: function() {
			return { 'col-lg-12': true, 'hidden': ! this.preloader };
		},
		showEmpty: function() {
			var hidden = !! (_.size(this.skills) > 0);
			return { 'col-lg-12': true, 'hidden': hidden };	
		},
		pick_skill_ids: function() {
			if(_.size(this.pick_skills) > 0) {
				return _.pluck(this.pick_skills,'id');
			}
			return [];
		},
		showLoadMore: function() {
			var hidden = true;
			if(this.nextPage > 0 ) {
			 	hidden  = false;
			}
			return { 'col-lg-12 col-md-12 col-xs-12': true, 'hidden': hidden };
		},
		showSuggestion: function() {
			var hidden = true;
			var noSkills = _.size(this.skills) == 0 || false;
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
	filters: {
		inMinutes: function(hour) {
			var roundHour = Math.round(hour);
			return roundHour * 60;
		}
	},
	methods: {			
		addToCount: function (key, hours) {				
			this.weekdays[key].push(hours);
		},
		morningHour: function(items) {
			var hour = _.filter(items, function(num) {
				return num >= 7 && num <= 12;
			});

			return _.size(hour);
		},
		afternoonHour: function(items) {
			var hour = _.filter(items, function(num) {
				return num >= 13 && num <= 17 ;
			});
			return _.size(hour);
		},
		eveningHour: function(items) {
			var hour = 	_.filter(items, function(num) {
				return num >= 18 && num <= 24;
			});
			
			return _.size(hour);
		},
		sortBy: function(items) {
			return _.sortBy(items, function(num) {
				return num;
			});
		},
		changeWeekdays: function(day, hour, checked) {
			var weekdays   = this.weekdays[day];
			var getChecked = !checked;				
			var exists     = _.contains(weekdays, hour);

			if(getChecked) {
				if(!exists) {
					weekdays.push(hour);
				}
			} else {
				if(exists) {
					var remaining = _.without(weekdays, hour);
					this.$set(this.weekdays, day,  remaining);
				}
			}
		},
		totalMorningInWeek: function() {
			var groupWeekdays = this.groupWeekdays;
			var total = 0;
			_.mapObject(groupWeekdays, function(val, key) {
				if( _.has(groupWeekdays[key], 'morning') ) {
					total+=groupWeekdays[key].morning;
				}
			});
			return total;
		},
		totalAfternoonInWeek: function() {
			var groupWeekdays = this.groupWeekdays;
			var total = 0;
			_.mapObject(groupWeekdays, function(val, key) {
				if( _.has(groupWeekdays[key], 'afternoon') ) {
					total+=groupWeekdays[key].afternoon;
				}
			});
			return total;
		},
		totalEveningInWeek: function() {
			var groupWeekdays = this.groupWeekdays;
			var total = 0;
			_.mapObject(groupWeekdays, function(val, key) {
				if( _.has(groupWeekdays[key], 'evening') ) {
					total+=groupWeekdays[key].evening;
				}
			});
			return total;
		},
		firstSkillLoad: function() {
			this.getApiData();
		},	
		getApiData: function() {
			this.preloader = true;			
			var apiUrl = Api.search_skill_url;

			if(apiUrl != '') {
				$.ajax({
					url: apiUrl,
					method: 'GET',	
					dataType: 'json',
					data: { 'keyword': App.keyword, 'category': App.category },				
				}).fail(function(jqXHR, textStatus) {					
					App.errorLoadInit(textStatus);
					App.preloader = false;
				}).done(function( response) {					
					var setNextPage    = response.current_page + 1;
					var setCurrentPage = response.current_page;
					var getSkills      = response.data;
					var countData      = _.size(getSkills);

					if(countData == 15) {
											
						if(setNextPage > 0 && setCurrentPage > 0) {
							Vue.set(App,'nextPage', setNextPage );
							Vue.set(App,'currentPage', setCurrentPage );
						}
					}

					if(countData < 15) {
						Vue.set(App,'nextPage', 0 );
					}

					Vue.set(App,'skills', getSkills);						
					App.preloader = false;		
				});
			}
		},
		skillSearch: _.debounce(
			function() {			
				this.getApiData();			
			},
		200),
		loadMore: function() {
			this.preloader = true;			
			var apiUrl = Api.search_skill_url;
			var nextPage = this.nextPage;
			if(nextPage > 0) {
				if(apiUrl != '') {
					$.ajax({
						url: apiUrl,
						method: 'GET',	
						dataType: 'json',
						data: { 'keyword': App.keyword, 'page': nextPage },		
					}).fail(function(jqXHR, textStatus) {					
						App.errorLoadInit(textStatus);
						App.preloader = false;
					}).done(function( response) {					
						var setNextPage    = response.current_page + 1;
						var setCurrentPage = response.current_page;
						var getSkills   = response.data;
						var countData   = _.size(getSkills);
						var skills 		= App.collectionUnion(App.skills, getSkills, function(item) {
							return item.id;
						});												

						if(countData == 15) {
													
							if(setNextPage > 0 && setCurrentPage > 0) {
								Vue.set(App,'nextPage', setNextPage );
								Vue.set(App,'currentPage', setCurrentPage );
							}
						}

						if(countData < 15) {
							Vue.set(App,'nextPage', 0 );							
						}

						Vue.set(App,'skills', skills);

						App.preloader = false;						
					});
				}	
				// End If ApiUrl !=0
			}
			// End if nextPage > 0
		},
		errorLoadInit: function(msg) {
			// return alert(msg);
		},
		cssClassSelected: function(item) {
			var picks = this.pick_skill_ids;
			var active = !! _.contains(picks, item.id);

			return {'selected-tag': true, 'active': active};
		},
		pickSkill: function(item) {
			var picks = this.pick_skills;
			var isPicked = !! ( _.size(_.findWhere(picks, item)) > 0 );
			if(! isPicked) {
				this.pick_skills.push(item);				
			} else {
				var indexSkill = _.findIndex(picks, item);				
				if(indexSkill > -1) {					
					this.pick_skills.splice(indexSkill, 1);
				}
			}

		},
		setDefaultData: function() {
			var dataDefault = window.DataDEFAULT || undefined;

			if(typeof dataDefault != 'undefined') {
				var category = dataDefault.category_id || 0;
				var skills = dataDefault.skills || [];				
				var duration = dataDefault.duration_id || 0;
				var schedule = dataDefault.schedule || undefined;				

				this.category = category;
				this.pick_skills = skills;
				this.duration = duration;
				this.search_skill_url =  Api.search_skill_url;

				if(typeof schedule !== 'undefined') {
					Vue.set(this,'weekdays', schedule);
				}
			}
		},
		collectionUnion: function() {  
			// Function for merging response data of skills, used by load more function
			var args = Array.prototype.slice.call(arguments);
			var it = args.pop();
			return _.uniq(_.flatten(args, true), it);
		},
		sendSuggestion: function() {
			var apiUrl = Api.skill_suggestion_url || '';
			if(apiUrl !== '') {
				App.preloader = true;
				$.ajax({
					url: apiUrl,
					method: 'POST',
					dataType: 'json',
					data: { 'skill_name': App.keyword },					
				}).fail(function(jqXHR, textStatus) {
					var error = jqXHR.responseText || 'Error occuring';
					App.errorLoadInit(error);
					App.preloader = false;
				}).done(function(response) {
					var msg = response.message || 'Success storing';
					App.successMessage(msg);
					App.preloader = false;
				});
			}
		},
		successMessage(msg) {			
			this.alertMessage = msg;
			setTimeout(function() {				
				App.alertMessage = '';
			}, 3000);
		}
	}
});