var selected_hours = 0;
function build_legend() {
    var morning_class = 0;
    var afternoon_class = 0;
    var evening_class = 0;
    var schedule = {};
    var schedule_json = {}; // To send end result to server
    var weekdays = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];

    // Print schedule to legend
    var $legend = $('#schedule-selected').empty();
    for (var n = 0; n < 7; n++) {

        var weekday = weekdays[n];
        schedule[weekday] = [];
        $('.hour-check.' + weekday + '.active').each(function(i, e){
            schedule[weekday].push($(e).data('hour'));
        });

        if (schedule[weekday].length > 0) {
            schedule_json[weekday] = [];
            // Todo: iterate over hours
            var legend_row = '<li><span class="label label-danger">' + weekday + '</span> ';
            var have_morning = false;
            var have_afternoon = false;
            var have_evening = false;
            var afternoon = false;
                for (var i = 0; i < schedule[weekday].length; i++) {
                var hours = [];
                if (schedule[weekday][i] >= 7 && schedule[weekday][i] <= 12) {
                    morning_class = 1;
                    hours.push(schedule[weekday][i]);
                    start_hour = schedule[weekday][i] + ':00';
                    item = '<span class="item">Morning from ' + start_hour + ' to ';
                    stop_hour = (schedule[weekday][i] + 1) + ':00';
                    for (var j = i + 1; j < schedule[weekday].length && schedule[weekday][j] == schedule[weekday][i]+1;j++) {
                        hours.push(schedule[weekday][j]);
                        stop_hour = (schedule[weekday][j] + 1) + ':00';
                        i = j;
                    }
                    item += stop_hour;

                    if (!have_morning) {
                        schedule_json[weekday] = schedule_json[weekday].concat(hours);
                        have_morning = true;
                    } else {
                        item = '';
                    }
                    legend_row += item + '</span>';

                } else if (schedule[weekday][i] >= 13 && schedule[weekday][i] <= 17) {
                    evening_class = 1;
                    hours.push(schedule[weekday][i]);
                    start_hour = schedule[weekday][i] + ':00';
                    item = '<span class="item">Afternoon from ' + start_hour + ' to ';
                    stop_hour = (schedule[weekday][i] + 1) + ':00';
                    for (var j = i + 1; j < schedule[weekday].length && schedule[weekday][j] == schedule[weekday][i]+1;j++) {
                        hours.push(schedule[weekday][j]);
                        stop_hour = (schedule[weekday][j] + 1) + ':00';
                        i = j;
                    }
                    item += stop_hour;
                    afternoon = true;
                    if (!have_afternoon) {
                        schedule_json[weekday] = schedule_json[weekday].concat(hours);
                        have_afternoon = true;
                    } else {
                        item = '';
                    }
                    legend_row += item + '</span>';
                } else {
                    afternoon_class = 1;
                    hours.push(schedule[weekday][i]);
                    start_hour = schedule[weekday][i] + ':00';
                    item = '<span class="item">Evening from ' + start_hour + ' to ';
                    stop_hour = (schedule[weekday][i] + 1) + ':00';
                    for (var j = i + 1; j < schedule[weekday].length && schedule[weekday][j] == schedule[weekday][i]+1;j++) {
                        hours.push(schedule[weekday][j]);
                        stop_hour = (schedule[weekday][j] + 1) + ':00';
                        i = j;
                    }
                    item += stop_hour;

                    if (!have_evening) {
                        schedule_json[weekday] = schedule_json[weekday].concat(hours);
                        have_evening = true;
                    } else {
                        item = '';
                    }
                    legend_row += item + '</span>';
                }
            }
            window.type_of_classes = morning_class + evening_class + afternoon_class;
            legend_row += '</li>';
            $legend.append(legend_row);
        }
    }
    $('#schedule_json').val(JSON.stringify(schedule_json));

};

$('.class_duration').on('change', function() {
    var duration_of_class = ($(this).val() == 2 ? 12 : 4);
    
    window.duration_of_class = duration_of_class;    

    var minutes = duration_of_class * window.selected_minutes / window.type_of_classes;  
    window.minutes = minutes;
    var m = minutes  % 60;
    var h = (minutes-m)/60;
    var HRSMINS = h.toString() + ":" + (m<10?"0":"") + m.toString();
    $('.total_hours').empty();
    $('.total_hours').append('Total number of hours <span class="selected_hours">' + HRSMINS + '</span>');
});

$(function(){
    // Scheduler
    $('.hour-check').each(function(i, e){
        var checked = $(e).children('input').prop('checked');        
        if (checked) {
            $(e).addClass('active');
        }        
    });

    var mobile_view = $('#scheduler-mobile').is(":visible");
    if (mobile_view) $('#scheduler').remove();

    build_legend();

    $('.hour-check').on('click', function(){
        $(this).toggleClass('active');
        var checked = $(this).children('input').prop('checked');
        var getWeekDay = $(this).data('weekday');
        var getHour = $(this).data('hour');

        EventBus.$emit('hour-check', getWeekDay,getHour, checked );

        $(this).children('input').prop('checked', !checked);
        setTimeout(
            function(){
                //Count number of total selected hours and format it like 4:00. selected_hours are declared on the line 1
                $('.selected_hours').empty();
                selected_hours = (checked == false ? selected_hours + 1 : selected_hours - 1);
                var minutes = selected_hours * 60;
                window.selected_minutes = minutes;
                minutes = window.duration_of_class * minutes / window.type_of_classes;
                window.minutes = minutes;
                var m = minutes  % 60;
                var h = (minutes-m)/60;
                var HRSMINS = h.toString() + ":" + (m<10?"0":"") + m.toString();
                $('.total_hours').empty();
                $('.total_hours').append('Total number of hours <span class="selected_hours">' + HRSMINS + '</span>');
            },
            1000
        );
        build_legend();
    });
    // End scheduler

    // Pricing
    $('input[name=pricing]').on('ifClicked', function() {
        var $this = $(this);
        if ($this.val() == 'fixed') {
            $('#pricing-step').addClass('pricing-fixed');
            $('#pricing-step').removeClass('pricing-flexible');
        } else {
            $('#pricing-step').removeClass('pricing-fixed');
            $('#pricing-step').addClass('pricing-flexible');

        }
    });
    $('#add_weekend_fee').on('ifClicked', function() {
        if (!$(this).prop('checked')) {
            $('#add_weekend_fee_input').show();
        } else {
            $('#add_weekend_fee_input').hide();
        }
    });
    // End Pricing

    var rule_counter = 1;
    $('#add_classroom_rule').click(function(e){
        e.preventDefault();
        if (rule_counter >= 8) return;
        $('#classroom_rules_container').append('<div class="item"><input type="text" name="rules[]" class="form-control"><a href="#" class="delete_rule"><i class="icon-cancel-circle"></i></a></div>');
        rule_counter++;
    });

    // Handle classroom form submit
    $('#classroom_form').on('submit', function(e){

        //region Handle custom validation
        function errorSpan(message, class_name) {
            return $('<span/>').text(message).attr('class', 'error-block ' + class_name);
        }
        // Pricing is set
        var $elem = $('input[name=pricing]:checked');
        if ($elem.length === 0) {
            errorSpan('Select pricing option.', 'base_price_error').appendTo($('.pricing-errors'));
            e.preventDefault();
        } else {
            var value = $elem.val(); // fixed or flexible
            var $input = $('input[name=base_price_' + value + ']');
            if (!$input.val()) {
                errorSpan('The base price field is required.', 'base_price_error').insertAfter($input);
                e.preventDefault();
            } else {
                $('.base_price_error').remove();
            }
        }

        // Check if schedule not empty
        if ($('.hour-check.active').length === 0) {
            errorSpan('Select your class hours.', 'schedule_error').appendTo($('.schedule-error'));
            e.preventDefault();
        }

        // Photos
        if ($('.js-files .thumbnail:visible').length < 2) {
            errorSpan('At least 2 photos required.', 'error').appendTo($('#multiupload'));
            e.preventDefault();
        }

        // Check terms
        if ($('#policy_terms:checked').length === 0) {
            errorSpan('Terms accept is required.', 'terms_error').appendTo($('#policy_terms').closest('.form-group'));
            e.preventDefault();
        }
        //endregion End validation

        //region Handle Curriculum Lectures order
        var lecture_counter = 0;
        $('#classroom_form .item').each(function(i, item){
            lecture_counter++;
            var $item = $(item);
            var lecture_id = $item.data('lectureId');
            if (!lecture_id) {
                lecture_id = 'new' + lecture_counter;
            }
            $item.find('.input').each(function(i, input){
                var $input = $(input);
                $input.attr('name', $input.data('name').replace('{lecture_id}', lecture_id));
            });
            // Set final order before submit
            $item.find('.order').val(lecture_counter);
        });
        //endregion
    });
    $('#classroom_curriculum_container').on('click', '.add_lecture', function(e){
        e.preventDefault();
        var new_item = $('#lecture_item_blank').clone();
        new_item.prop('id', '').addClass('item');
        $("#classroom_curriculum_container").append(new_item);
        new_item.fadeIn();
    });

    $('#classroom_curriculum_container').on('keyup change', '.lecture-duration, .class_duration', function(e) {
        var arrNumber = new Array();
        $('.lecture-duration').each(function(){
            arrNumber.push($(this).val());
        });
        var total = 0;
        for (var i = 0; i < arrNumber.length; i++) {
            total += arrNumber[i] << 0;
        }
        if(!$.isNumeric(window.minutes)) {
            $('.total_hours').empty();
            $('.total_hours').append('Select the time first');
            return false;
        }
        var final_minutes = window.minutes - total;
        if (final_minutes < 0 ) {
            final_minutes = 0;
        }
        var m = final_minutes  % 60;
        var h = (final_minutes-m)/60;
        var HRSMINS = h.toString() + ":" + (m<10?"0":"") + m.toString();
        $('.selected_hours').empty();
        $('.selected_hours').append(HRSMINS);
    });

function updateSelectedHours() {
        console.log('fired!');
        var arrNumber = new Array();
        $('.lecture-duration').each(function () {
            arrNumber.push($(this).val());
        });
        var total = 0;
        for (var i = 0; i < arrNumber.length; i++) {
            total += arrNumber[i] << 0;
        }
        if (!$.isNumeric(window.minutes)) {
            $('.total_hours').empty();
            $('.total_hours').append('Select the time first');
            return false;
        }
        var final_minutes = window.minutes - total;
        $('.error_display').empty();
        if ((window.minutes / 100 * 20) < final_minutes) {
            $('.error_display').append('At least 80% of curriculum should be set');
        }
        if ((window.minutes / 100 * 110) < total) {
            $('.error_display').append('You can set only 110% of the curriculum');
        }
        if (final_minutes < 0) {
            final_minutes = 0;
        }
        var m = final_minutes % 60;
        var h = (final_minutes - m) / 60;
        var HRSMINS = h.toString() + ":" + (m < 10 ? "0" : "") + m.toString();
        $('.selected_hours').empty();
        $('.selected_hours').append(HRSMINS);

    }
    $('#classroom_curriculum_container').on('click', '.delete_lecture', function(e){
        e.preventDefault();
        $item = $(this).closest('.item');
        $('#classroom_curriculum_container')
            .append($('<input type="hidden">').attr('name', 'remove_lecture[]').val($item.data('lectureId')));
        $item.remove();
        $.total_hours_counter();
    });

    $('#classroom_curriculum_container').on('keyup', '.lecture-duration',  function(e) {
        jQuery.total_hours_counter = function() {
            var arrNumber = [];
            $('.lecture-duration').each(function(){
                arrNumber.push($(this).val());
            });
            var total = 0;
            for (var i = 0; i < arrNumber.length; i++) {
                total += arrNumber[i] << 0;
            }
            if(!$.isNumeric(window.minutes)) {
                $('.total_hours').empty();
                $('.total_hours').append('Select the time first');
                return false;
            }
            var final_minutes = window.minutes - total;
            $('.error_display').empty();
            if ((window.minutes / 100 * 20) < final_minutes) {
                $('.error_display').append('At least 80% of curriculum should be set');
            }
            if((window.minutes / 100 * 110) < total ){
                $('.error_display').append('You can set only 110% of the curriculum');
            }
            if (final_minutes < 0 ) {
                final_minutes = 0;
            }
            var m = final_minutes  % 60;
            var h = (final_minutes-m)/60;
            var HRSMINS = h.toString() + ":" + (m<10?"0":"") + m.toString();
            $('.selected_hours').empty();
            $('.selected_hours').append(HRSMINS);

        }
        $.total_hours_counter();


    });
    updateSelectedHours();

    $('#classroom_rules_container').on('click', '.delete_rule', function(e){
        e.preventDefault();
        $(this).closest('.item').remove();
    });

    $('#toBook').click(function(e) {
        e.preventDefault();
        //console.log('to-book');
        var book_panel_top = $('#booking-panel').offset().top;
        $('body,html').animate({scrollTop: book_panel_top},500);

    });
    if (document.getElementById('booking-panel')) {
        setInterval(function () {

            var book_panel_top = $('#booking-panel').offset().top;
            if ($(window).scrollTop() < book_panel_top - 300) {
                $('#toBook').attr('class', 'visible-xs');
            } else {
                $('#toBook').attr('class', '');
            }
        }, 1000);
    }

    $('#classroom_curriculum_later').on('ifToggled', function(){
        $('#classroom_curriculum_container').toggle();
    });


});
