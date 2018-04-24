$(function () {
    $('#sms-verification-form').on('submit', function(){});
    $.validator.addMethod('phone', function(value, element){
        return this.optional( element ) || /^\+.*?\d/.test( value );
    }, 'Please start phone with +');
    var validator = $('#sms-verification-form').validate({
        rules: {phone: {
            required: true,
            phone: true
        }}
    });

    $('#email-code').on('click', function (e) {
        e.preventDefault();
        $button = $(this);
        $.ajax({
            url: '/verification/getemail',
            beforeSend: function () {
                $button.prop('disabled', true).text('Loading...');
                $.notify('Sending verification email...');
            },
            success: function (data) {
                if (data.status && data.status === 'success') {
                    $.notify(data.message);
                    $button.fadeOut();
                }
            },
            error: function () {
                $.notify({title: 'Error', message: 'Sorry! Email gateway error, try again later.'}, {type: 'danger'});
                $button.prop('disabled', false).text('Send Again');

            },
            complete: function () {

            }
        });
    });

    $('#sms-code').on('click', function (e) {
        e.preventDefault();
        if (!validator.element('#phone')) return false;
        $button = $(this);
        $.ajax({
            url: '/verification/getsms',
            data: {'phone': $('#phone').val()},
            beforeSend: function () {
                $button.prop('disabled', true).text('Loading...');
                $.notify('Sending verification sms...');
            },
            success: function (data) {
                if (data.status && data.status === 'success') {
                    $.notify(data.message);
                    $button.fadeOut();
                    $('#phone').prop('disabled');
                    $('#sms-input').fadeIn();
                    $('#sms-code-check').fadeIn();
                }
            },
            error: function () {
                $.notify({title: 'Error', message: 'Sorry! SMS gateway error, try again later.'}, {type: 'danger'});
                $button.prop('disabled', false).text('Send Again');
            },
            complete: function () {

            }
        });
    });

    $('#sms-code-check').on('click', function(e){
        e.preventDefault();
        $button = $(this);
        $.ajax({
            url: '/verification/verifycode',
            data: {'code': $('#sms-code-input').val(), 'phone': $('#phone').val()},
            beforeSend: function () {
                $button.prop('disabled', true).text('Loading...');
                $.notify('Checking code...');
            },
            success: function (data) {
                if (data.status && data.status === 'success') {
                    $.notify(data.message);
                    $button.fadeOut();
                } else {
                    $.notify({title: 'Error', message: data.message}, {type: 'danger'});
                    $button.prop('disabled', false).text('Try Again');
                }
            },
            error: function () {
                $.notify({title: 'Error', message: 'Sorry! SMS gateway error, try again later.'}, {type: 'danger'});
                $button.prop('disabled', false).text('Try Again');
            },
            complete: function () {

            }
        });
    });
});