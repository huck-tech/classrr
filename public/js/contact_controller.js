$(function () {
    $('#tutor-contact-form').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: '/contact',
            data: {},
            beforeSend: function(){},
            success: function(data){
            },
            error: function(){console.log('Something going wrong');},
            complete: function(){}
        });
    });
});