var query_bag = {};
$(function(){


    function makeSearchRequest(event) {
        if (event) event.preventDefault();

        var is_mobile_screen = $('#search-panel-form').is(':visible');

        if (is_mobile_screen) {
            query_bag['q'] = $('#search-term-phone').val();
            query_bag['where'] = $('#search-where-phone').val();
            query_bag['when'] = $('#when-phone').val();
            query_bag['duration'] = $('#duration-phone').val();
        } else {
            query_bag['where'] = $('#search-where').val();
        }
		
		/* now we can accept empty location
        if (!query_bag['where']) {
            $('#search-where-phone').css('border', '1px solid #ff4700');
            $('#search-where').css('border', '1px solid #ff4700');
            $.notify({message: 'Location is required!'}, {type: 'danger'});
            return;
        } else {
            $('#search-where-phone').css('border', 'none');
            $('#search-where').css('border', 'none');
        }
		*/

        $.ajax({
            url: '/classroom/list',
            data: query_bag,
            beforeSend: function() {
                $('#search-results').addClass('loading');
            },
            success: function(data) {
                $('#search-results-container').html(data);
            },
            complete: function() {
                $('#search-results').removeClass('loading');
            }
        });
        console.log(query_bag);
    }


    //region Initialization controls from request

        //region Search bar
            $('#search-term').on('change', function() {query_bag['q'] = $(this).val();});
            if ($.QueryString['q']) {
                query_bag['q'] = $.QueryString['q'];
                $('#search-term').val(query_bag['q']);
                $('#search-term-phone').val(query_bag['q']);
            }
            if ($.QueryString['where']) {
                query_bag['where'] = $.QueryString['where'];
                $('#search-where').val(query_bag['where']);
            }
            $('#when .dd-selected-value').on('change', function() {query_bag['when'] = $(this).val();});
            if ($.QueryString['when'] && /^\d{4}\-\d{2}$/.test($.QueryString['when'])) {
                query_bag['when'] = $.QueryString['when'];
                $('#when').ddslick('selectByVal', query_bag['when']);
            }
            $('#duration .dd-selected-value').on('change', function() {query_bag['duration'] = $(this).val();});
            if ($.QueryString['duration']) {
                query_bag['duration'] = parseInt($.QueryString['duration']);
                $('#duration').ddslick('selectByVal', query_bag['duration']);
            }
            // Events
            $('#search-panel-form').on('submit', makeSearchRequest);
            $('#search-bar-form').on('submit', makeSearchRequest);
            $('.search-button').on('click', makeSearchRequest);
        //endregion

        //region Order By
            if ($.QueryString['sort_price']) {
                query_bag['sort_price'] = ($.QueryString['sort_price'] == 'asc' ? 'asc' : 'desc');
                $('#sort_price').val(query_bag['sort_price']);
            }
            if ($.QueryString['sort_rating']) {
                query_bag['sort_rating'] = ($.QueryString['sort_rating'] == 'asc' ? 'asc' : 'desc');
                $('#sort_rating').val(query_bag['sort_rating']);
            }
            // Events
            $('#sort_price').on('change', function(e) {
                if ($('#sort_price').val()) query_bag['sort_price'] = $('#sort_price').val();
                makeSearchRequest(e);
            });
            $('#sort_rating').on('change', function(e) {
                if ($('#sort_rating').val()) query_bag['sort_rating'] = $('#sort_rating').val();
                makeSearchRequest(e);
            });
        //endregion

        //region Filter sidebar
            if ($.QueryString['cat_id']) {
                query_bag['cat_id'] = parseInt($.QueryString['cat_id'], 10);
                $('#cat_nav a').removeClass('active');
                $('#cat_nav_' + query_bag['cat_id']).attr('class', 'active');
            } else {
                $('#cat_nav_0').attr('class', 'active');
            }

            if ($.QueryString['lvl_ids']) {
                query_bag['lvl_ids'] = $.QueryString['lvl_ids'];
                levels = query_bag['lvl_ids'].split(',');
                $.each(levels, function(i, el) {
                    lvl_id = parseInt(el);
                    $('#lvl_nav_' + el).iCheck('check');
                });
            }

            if ($.QueryString['day_ids']) {
                query_bag['day_ids'] = $.QueryString['day_ids'];
                days = query_bag['day_ids'].split(',');
                $.each(days, function(i, el) {
                    day_id = parseInt(el);
                    $('#day_nav_' + el).iCheck('check');
                });
            }

            if ($.QueryString['time_ids']) {
                query_bag['time_ids'] = $.QueryString['time_ids'];
                time = query_bag['time_ids'].split(',');
                $.each(time, function(i, el) {
                    time_id = parseInt(el);
                    $('#time_nav_' + el).iCheck('check');
                });
            }

            $("#price_range").ionRangeSlider({
                hide_min_max: true, keyboard: true, min: 4, max: 40, from: 4, to: 40,
                type: 'double', step: 1, prefix: "$", grid: true,
                onFinish: function (o) {query_bag['price'] = o.from + ';' + o.to; makeSearchRequest();}
            });
            if ($.QueryString['price']) {
                query_bag['price'] = $.QueryString['price'];
                range = query_bag['price'].split(';');
                if (range[0] && range[1]){
                    $("#price_range").data("ionRangeSlider").update({from:parseInt(range[0]),to:parseInt(range[1])});
                }
            }
        //endregion

    //endregion Initialization

    //region Controllers

        // Categories controller on click
        $('#cat_nav a').on('click', function(e) {
            $('#cat_nav a').removeClass('active');
            $(this).attr('class', 'active');
            query_bag['cat_id'] = parseInt($(this).data('id'));
            makeSearchRequest(e);
        });

        // iCheckboxes on change
        $('#lvl_nav input[type=checkbox]').on('ifToggled', function(e){
            ids = '';
            $('#lvl_nav input[type=checkbox]').each(function(i, el){
                if ($(el).prop('checked')) {
                    if (ids !== '') ids += ',';
                    ids += $(el).val();
                }
            });
            if (ids !== '') query_bag['lvl_ids'] = ids;
            makeSearchRequest(e);
        });
        $('#day_nav input[type=checkbox]').on('ifToggled', function(e){
            ids = '';
            $('#day_nav input[type=checkbox]').each(function(i, el){
                if ($(el).prop('checked')) {
                    if (ids !== '') ids += ',';
                    ids += $(el).val();
                }
            });
            if (ids !== '') query_bag['day_ids'] = ids;
            makeSearchRequest(e);
        });
        $('#time_nav input[type=checkbox]').on('ifToggled', function(e){
            ids = '';
            $('#time_nav input[type=checkbox]').each(function(i, el){
                if ($(el).prop('checked')) {
                    if (ids !== '') ids += ',';
                    ids += $(el).val();
                }
            });
            if (ids !== '') query_bag['time_ids'] = ids;
            makeSearchRequest(e);
        });


    //endregion


    // No results

    $('#search-results').on('click', '#subscribe-btn', function (e) {
        e.preventDefault();
        var $this = $(this);
        var init_text = $this.text();
        console.log('hi');
        $.ajax({
            url: $this.data('action'),
            method: 'post',
            dataType: 'json',
            data: {'email': $('#subscribe-input').val(), 'query_bag': query_bag, '_token': Laravel.csrfToken},
            beforeSend: function() {
                $this.prop('disabled', true).text('Loading...');
            },
            success: function(data) {
                if (data && data.status === 'success') {
                    $('.subscribe-form').replaceWith($('<h2 class="text-success"/>').text('Thank you!'));
                    $.notify('Congrats! You are subscribed on new search results!');
                }
            },
            error: function(data) {
            },
            complete: function() {
                $this.prop('disabled', false).text(init_text);
            }
        });
    });

});