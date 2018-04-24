function get_prebook_price() {
    $.ajax({
        url: '/booking/calc_total',
        data: {
            'item_id': $('#item_id').val(),
            'time': $('#time-select').val(),
            'enrollment_date': $('#enrollment_date-select').val()},
        beforeSend: function(){},
        success: function(data){
            $('#prebook-result').html(data);
        },
        error: function(){console.log('Something going wrong');},
        complete: function(){}
    });
};

$(function(){
    get_prebook_price();
    $('#enrollment_date-select, #time-select').on('change', get_prebook_price);
});