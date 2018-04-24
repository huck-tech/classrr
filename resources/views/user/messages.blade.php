@extends('user_layout')

@section('additional_styles')
    @parent
    <link href="{{ asset('css/user/messages.css') }}" rel="stylesheet">
@endsection

@section('tab_content')
    @if(count($messages))
        <div id="preloader" style="position:absolute;opacity: 0.8;">
            <div class="sk-spinner sk-spinner-wave">
                <div class="sk-rect1"></div>
                <div class="sk-rect2"></div>
                <div class="sk-rect3"></div>
                <div class="sk-rect4"></div>
                <div class="sk-rect5"></div>
            </div>
        </div>
    @endif

    <div class="row">
        @include('shared.flash')
    </div>
    <div class="row message-container">
        @if(count($messages))
        <div class="col-sm-3 col-xs-2 messages-list">
            <div class="messages-list-header text-center">
                <span class="hidden-xs">@lang('messages.messages')</span>
                <span class="hidden-lg hidden-md hidden-sm"><i class="fa fa-inbox" aria-hidden="true" title="Messages"></i></span>
            </div>
            <div class="messages-list-rooms">
                @foreach($messages as $message)
                <a href="#" class="messages-list-item @if(isset($currentMessageId) && $message->id == $currentMessageId) active @endif"
                   data-message-id="{{ $message->id }}"
                   data-message-title="{{ $message->title }}"
                   data-message-related-to-type="{{ $message->messageable_type }}"
                   data-message-related-to-id="{{ $message->messageable_id }}"
                   data-message-partner-name="{{ $message->partner()->nameOrEmail() }}"
                   data-message-archived-by="{{ $message->archived_by }}"
                   data-message-archived-reason="{{ $message->archived_reason }}"
                   data-message-archived-at="{{ $message->archived_at }}"
                   data-message-is-reported-by-current-user="{{ $message->messageable_type == 'booking' && $message->messageable ?$message->messageable->isReportedByCurrentUser():false }}"
                >
                    <div class="row">
                        <div class="col-sm-4 col-xs-12">
                            <img src="{{ $message->partner()->getAvatarPath() }}" class="img-circle img-responsive" title="{{ $message->partner()->nameOrEmail() }}">
                        </div>
                        <div class="col-sm-8 hidden-xs messages-details-preview">
                            @if($message->archived_at)
                                <span class="pull-right" style="color:#111">
                                    <i title="Archived" class="fa fa-archive" aria-hidden="true"></i>
                                </span>
                            @endif
                            <span class="unread-count pull-right" title="Unread messages count" @if(!$message->getUnreadRepliesCount()) hidden @endif>
                                {{ $message->getUnreadRepliesCount() }}
                            </span>
                            <span class="message-partner">
                                {{ str_limit($message->partner()->nameOrEmail(), 20) }}
                            </span>
                            <span class="message-title">{{ str_limit($message->title, 25) }}</span>
                            <span class="message-last-reply">
                                {{ str_limit($message->lastReplySenderFirstName(true) . ': ' . $message->lastReplyText(), 25) }}
                            </span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        <div class="col-sm-9  col-xs-10 message-replies">
            <div class="message-header">
                <span class="message-archived pull-right"></span>
                <span class="message-partner"></span>
                <span class="message-title"></span>
            </div>
            <div class="message-body">
            </div>
            <form class="message-reply-form">
                <input type="hidden" name="message_id" value="">
                <div class="col-sm-10 col-xs-8">
                    <div class="form-group">
                        <textarea class="form-control" name='message' minlength="1" maxlength="2500"></textarea>
                    </div>
                </div>
                <div class="col-sm-2 col-xs-4">
                    <div class="form-group">
                        <button type="submit" class="btn btn-block" value="Send" style="min-height: 35px;">
                            <span class="submitButtonText">Send</span>
                            <div class="loader" style="position:relative;opacity: 0.8;" hidden>
                                <div class="sk-spinner sk-spinner-wave">
                                    <div class="sk-rect1"></div>
                                    <div class="sk-rect2"></div>
                                    <div class="sk-rect3"></div>
                                    <div class="sk-rect4"></div>
                                    <div class="sk-rect5"></div>
                                </div>
                            </div>
                        </button>
                    </div>
                </div>
            </form>
            <div class="text-center archived-form-replacer" hidden>
                <span>@lang('messages.cannot_send')</span>
            </div>
        </div>
        @else
            <div class="messages-list-header text-center">
                <span class="row">@lang('messages.empty_inbox')</span>
            </div>
        @endif
    </div>

    @include('partials.report-modal')
@endsection

@section('additional_javascript')
    @parent
    <script>

        $(function(){
            var messageBody = $('.message-body'),
                messageListItem = $('.messages-list-item'),
                messageReplyForm = $('.message-reply-form'),
                archivedFormReplacer = $('.archived-form-replacer');

            var currentUserId = {{ Auth::user()->id }},
                messagesList,
                currentMessageId,
                currentFirstReply,
                currentFirstReplyId,
                currentLastReplyId,
                currentMessageTitle,
                currentMessageRelatedToType,
                currentMessageRelatedToId,
                currentMessagePartnerName,
                currentMessageArchivedBy,
                currentMessageArchivedReason,
                currentMessageArchivedAt,
                currentMessageIsReportedByCurrentUser,
                currentMessageUnreadRepliesCountSpan,
                anotherRequestPending = false,
                newRepliesRequestPending = false,
                previousRepliesRequestPending = false,
                updateMessagesRequestPending= false;

            // On clicking on message open it's replies
            $('body').on('click' , '.messages-list-item' ,function(e){
                e.preventDefault();

                if(currentMessageId == $(this).data('message-id')){
                    return false;
                }

                $('#preloader').fadeIn('slow');

                messageBody.html('');

                $('.messages-list-item').removeClass('active');
                $(this).addClass('active');

                // Get message details
                currentMessageId = $(this).data('message-id');
                currentMessageTitle = $(this).data('message-title');
                currentMessageRelatedToType = $(this).data('message-related-to-type');
                currentMessageRelatedToId = $(this).data('message-related-to-id');
                currentMessagePartnerName = $(this).data('message-partner-name');
                currentMessageArchivedBy = $(this).data('message-archived-by');
                currentMessageArchivedReason = $(this).data('message-archived-reason');
                currentMessageArchivedAt = $(this).data('message-archived-at');
                currentMessageIsReportedByCurrentUser = $(this).data('message-is-reported-by-current-user');
                currentMessageUnreadRepliesCountSpan = $(this).find('.unread-count');

                // Get message replies header and set it's values
                var messageRepliesHeader = $('.message-replies .message-header');
                messageRepliesHeader.find('.message-title').html('\
                    <span class="hidden-xs">This message related to: ' + currentMessageTitle +'</span>\
                    <span class="hidden-lg hidden-md hidden-sm" title="' + currentMessageTitle + '">' + currentMessageTitle.substring(0, 30) +'....</span>\
                ');
                messageRepliesHeader.find('.message-partner').text(currentMessagePartnerName);

                // If message is archived set and show archive details
                if(currentMessageArchivedAt){
                    var html = '<span class="hidden-xs">Archived at: ' + currentMessageArchivedAt + '</span>';

                    var reason;
                    if(currentMessageArchivedReason == 'booking_cancelled'){
                        reason = 'Booking cancelled'
                    }else if(currentMessageArchivedReason == 'booking_disputed'){
                        reason = 'Booking disputed'
                    }else if(currentMessageArchivedReason == 'booking_escalated') {
                        reason = 'Booking escalated'
                    }else if(currentMessageArchivedReason == 'reported_spam'){
                        reason = 'Reported as spam'
                    }else{
                        reason = '';
                    }

                    html += '<br><span class="hidden-xs">Reason: ' + reason + '</span>';
                    html += '<span class="hidden-lg hidden-md hidden-sm"><i class="fa fa-archive" aria-hidden="true" title="Archived at: ' + currentMessageArchivedAt + ' Reason: ' + reason + '"></i></span>';

                    messageRepliesHeader.find('.message-archived').html(html);

                    if(currentMessageArchivedReason == 'reported_spam' && currentUserId == currentMessageArchivedBy) {
                        archivedFormReplacer.find('a').parent().remove();
                        archivedFormReplacer.append('<div class="row"><a href="/user/messages/' + currentMessageId + '/unarchive" class="btn btn-sm btn-success">Reopen chat</a></div>');
                    }else if(currentMessageArchivedReason == 'booking_escalated' && !currentMessageIsReportedByCurrentUser) {
                        archivedFormReplacer.find('a').parent().remove();
                        archivedFormReplacer.append('\
                            <div class="row">\
                                <a data-id="' + currentMessageRelatedToId + '" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#reportModal">\
                                    Report\
                                </a>\
                                <span class="row">You have 7 days to provide reason or appeal to any issue regarding to this booking</span>\
                            </div>\
                        ');
                    }else if(currentMessageArchivedReason == 'booking_escalated' && currentMessageIsReportedByCurrentUser) {
                        archivedFormReplacer.find('a').parent().remove();
                        archivedFormReplacer.append('\
                            <div class="row">\
                                <a class="btn btn-sm btn-default disabled">\
                                    Report Submitted\
                                </a>\
                            </div>\
                        ');
                    } else {
                        archivedFormReplacer.find('a').parent().remove();
                    }

                    archivedFormReplacer.show();
                    messageReplyForm.hide();

                }
                // Else show report spam button
                else if(currentMessageRelatedToType == 'classroom'){
                    messageRepliesHeader.find('.message-archived').html('<a href="/user/messages/' + currentMessageId + '/archive/reported_spam" class="btn btn-sm btn-danger">Report</a>');

                    archivedFormReplacer.hide();
                    messageReplyForm.show();
                }else{
                    messageRepliesHeader.find('.message-archived').html('');

                    archivedFormReplacer.hide();
                    messageReplyForm.show();
                }

                anotherRequestPending = true;

                $.ajax({
                    method: 'GET',
                    url: '/user/messages/' + currentMessageId + '/replies',
                    success: function(response){

                        repopulateMessagesReplies(response)
                            .then(function () {

                                messageBody.scrollTop(messageBody.prop("scrollHeight"));

                                messageReplyForm.find('input[name="message_id"]').val(currentMessageId);

                                currentMessageUnreadRepliesCountSpan.fadeOut(3000);

                                anotherRequestPending = false;

                                $('#preloader').fadeOut('slow');
                            });
                    }
                })
            });

            // On submitting the message reply form we should send the message to back end and refresh replies
            messageReplyForm.submit(function(e){

                e.preventDefault();

                var form = $(this);

                // Get message from text area
                var message = $(this).find('textarea[name="message"]').val();

                // Check value before sending to backend
                if(message) {

                    form.find('.loader').fadeIn('slow');
                    form.find('.submitButtonText').hide();
                    form.find('button[type="submit"]').attr('disabled', true);
                    form.find('textarea[name="message"]').attr('disabled', true);

                    currentLastReplyId = $('.message-body-reply').length?$('.message-body-reply').last().data('id') : '';
                    anotherRequestPending = true;

                    var oldCurrentMessageId = currentMessageId;

                    $.ajax({
                        method: 'POST',
                        url: '/user/messages/' + currentMessageId + '/replies?last_reply_id=' + currentLastReplyId,
                        data: {
                            _token: '{{ csrf_token() }}',
                            message: message,
                            last_reply_id: currentLastReplyId
                        },
                        success: function (response) {

                            if(oldCurrentMessageId == currentMessageId) {
                                repopulateMessagesReplies(response, true)
                                    .then(function () {

                                        messageBody.animate({scrollTop: messageBody.prop("scrollHeight")});

                                        form.find('textarea[name="message"]').val('');

                                        form.find('textarea[name="message"]').attr('disabled', false);
                                        form.find('textarea[name="message"]').focus();
                                        form.find('button[type="submit"]').attr('disabled', false);
                                        form.find('.loader').hide();

                                        form.find('.submitButtonText').fadeIn('slow');

                                        anotherRequestPending = false;
                                    });
                            }else{
                                form.find('textarea[name="message"]').val('');

                                form.find('textarea[name="message"]').attr('disabled', false);
                                form.find('textarea[name="message"]').focus();
                                form.find('button[type="submit"]').attr('disabled', false);
                                form.find('.loader').hide();

                                form.find('.submitButtonText').fadeIn('slow');

                                anotherRequestPending = false;
                            }
                        }
                    });
                }
            });

            // Make Enter key submit message while not shift+enter
            messageReplyForm.find('textarea[name="message"]').keydown(function(e){
                if(e.keyCode == 13 && !e.shiftKey) {
                    e.preventDefault();
                    messageReplyForm.submit();
                }
            });

            // If there is an active message trigger click to load it's messages
            if($('.messages-list-item.active').length){
                $('.messages-list-item.active').click();
            }
            // Else click on first message to load it's replies
            else {
                if (messageListItem[0]) {
                    messageListItem[0].click();
                }
            }

            // Repopulate replies
            function repopulateMessagesReplies(response, newReplies, prepend){

                var dfd = jQuery.Deferred();

                var length = response.length;

                if(length) {
                    $.each(response, function (index, reply) {

                        var senderName = (reply.sender.first_name && reply.sender.last_name) ? (reply.sender.first_name + ' ' + reply.sender.last_name) : reply.sender.email;

                        var senderImage = reply.sender.profile_avatar ? '/storage/' + reply.sender.profile_avatar.path : '/img/empty_avatar_256x256.png';

                        var replyId = reply.id;

                        var replyText = reply.text;

                        var replyDate = reply.created_at;

                        if(messageBody.find("[data-id='" + replyId + "']").length){

                            if (index === (length - 1)) {

                                setTimeout(function () {
                                    $('.new-replies').removeClass('new-replies');
                                }, 3000);


                                dfd.resolve();
                            }

                            return false;
                        }

                        if(prepend){
                            messageBody.prepend(
                                '<span class="message-body-reply" data-id=' + replyId + '>\
                                    <div class="row">\
                                        <div class="col-md-1 col-sm-3 col-xs-3">\
                                            <img src="' + senderImage + '" class="img-circle img-responsive">\
                                        </div>\
                                        <div class="col-md-11 col-sm-9 col-xs-9">\
                                            <span class="sender">' + senderName + '<span class="pull-right small">' + replyDate + '</span></span>\
                                            <span class="reply">' + replyText + '</span>\
                                        </div>\
                                    </div>\
                                </span>'
                            );
                        }else {
                            messageBody.append(
                                '<span class="message-body-reply' + (newReplies ? ' new-replies' : '') + '" data-id=' + replyId + '>\
                                    <div class="row">\
                                        <div class="col-sm-1 col-sm-3 col-xs-3">\
                                            <img src="' + senderImage + '" class="img-circle img-responsive">\
                                        </div>\
                                        <div class="col-md-11 col-sm-9 col-xs-9">\
                                            <span class="sender">' + senderName + '<span class="pull-right small hidden-xs">' + replyDate + '</span><i class="fa fa-clock-o pull-right hidden-lg hidden-md hidden-sm" aria-hidden="true" title="' + replyDate + '"></i></span>\
                                            <span class="reply">' + replyText + '</span>\
                                        </div>\
                                    </div>\
                                </span>'
                            );

                        }

                        if (index === (length - 1)) {

                            setTimeout(function () {
                                $('.new-replies').removeClass('new-replies');
                            }, 3000);


                            dfd.resolve();
                        }
                    });
                }else{
                    dfd.resolve();
                }

                return dfd.promise();
            }

            function updateReplies()
            {
                // CHeck if no pedngin request pending we shoul do the call
                if (newRepliesRequestPending == false && anotherRequestPending == false && currentMessageId && !document.hidden) {

                    // Set request pending to true to avoid overlaping
                    newRepliesRequestPending = true;

                    // Get the last reply id
                    currentLastReplyId = $('.message-body-reply').length?$('.message-body-reply').last().data('id') : '';

                    var oldCurrentMessageId = currentMessageId;
                    var oldCurrentLastReplyId = currentLastReplyId;

                    // Do the ajax call to get the new replies
                    $.ajax({
                        method: 'GET',
                        url: '/user/messages/' + currentMessageId + '/replies?last_reply_id=' + currentLastReplyId,
                        success: function (response) {

                            currentLastReplyId = $('.message-body-reply').length?$('.message-body-reply').last().data('id') : '';

                            if(oldCurrentMessageId == currentMessageId && oldCurrentLastReplyId == currentLastReplyId) {
                                repopulateMessagesReplies(response, true)
                                    .then(function () {

                                        // If we have more replies we should scroll to the end
                                        if (response.length) {
                                            messageBody.animate({scrollTop: messageBody.prop("scrollHeight")});
                                        }

                                        // Set request pending to false
                                        newRepliesRequestPending = false;

                                        //Run the next
                                        setTimeout(updateReplies, 2000);
                                    });
                            }else{

                                // Set request pending to false
                                newRepliesRequestPending = false;

                                //Run the next
                                setTimeout(updateReplies, 2000);
                            }
                        }
                    })
                }else{
                    //Run the next
                    setTimeout(updateReplies, 2000);
                }
            }

            setTimeout(updateReplies, 2000);


            $('.message-body').scroll(function (event) {

                // Get scroll position
                var scroll = $(this).scrollTop();

                // if scroll postion equal 0 so we should load earlier messages
                if(scroll == 0){

                    // No pervious request pending we shoul do the call
                    if (previousRepliesRequestPending == false && currentMessageId) {

                        // Set request pending to true to avoid overlaping
                        previousRepliesRequestPending = true;

                        // Get the old height
                        var oldHeight = messageBody.prop("scrollHeight");

                        // Get the first reply and get it's id
                        currentFirstReply = $('.message-body-reply').first();
                        currentFirstReplyId = currentFirstReply.data('id');

                        // Do the ajax call to get the previous replies
                        $.ajax({
                            method: 'GET',
                            url: '/user/messages/' + currentMessageId + '/previous-replies/' + currentFirstReplyId,
                            success: function (response) {

                                // Repopulate the messages
                                repopulateMessagesReplies(response, false, true)
                                    .then(function () {

                                        // Get new height
                                        newHeight = messageBody.prop("scrollHeight");

                                        // Scroll to the same previous postion
                                        messageBody.scrollTop( newHeight - oldHeight);

                                        // Set request pending to false
                                        previousRepliesRequestPending = false;
                                    });
                            }
                        })
                    }
                }

            });


            // Repopulate replies
            function repopulateMessages(response){

                var dfd = jQuery.Deferred();

                var length = response.length;

                if(length) {

                    var html = '';
                    $.each(response, function (index, message) {

                        html += '<a href="#" class="messages-list-item ' + (message.id == currentMessageId ?'active':'') + '"\
                                    data-message-id="' + message.id + '"\
                                    data-message-title="' + message.title + '"\
                                    data-message-related-to-type="' + message.messageable_type + '"\
                                    data-message-related-to-id="' + message.messageable_id + '"\
                                    data-message-partner-name="' + message.partner.name + '"\
                                    data-message-archived-by="' + message.archived_by + '"\
                                    data-message-archived-reason="' + message.archived_reason + '"\
                                    data-message-archived-at="' + message.archived_at + '"\
                                    data-message-is-reported-by-current-user="' + message.isReportedByCurrentUser + '"\
                                >\
                                    <div class="row">\
                                        <div class="col-sm-4 col-xs-12">\
                                            <img src="' + message.partner.avatarPath + '" class="img-circle img-responsive" title="' + message.partner.name + '">\
                                        </div>\
                                        <div class="col-sm-8 hidden-xs messages-details-preview">\
                                            ' + (message.archived_at?'<span class="pull-right" style="color:#111"><i title="Archived" class="fa fa-archive" aria-hidden="true"></i></span>':'') + '\
                                            <span class="unread-count pull-right" title="Unread messages count" ' + (message.unreadRepliesCount && message.id != currentMessageId?'':'hidden') + '>\
                                                ' + message.unreadRepliesCount + '\
                                            </span>\
                                            <span class="message-partner">\
                                                ' + message.partner.name.substring(0, 20) + '\
                                            </span>\
                                            <span class="message-title">' + message.title.substring(0, 25) + '</span>\
                                            <span class="message-last-reply">\
                                                ' + message.lastReplySenderFirstName + ': ' + message.lastReplyText.substring(0, 25) + '\
                                            </span>\
                                        </div>\
                                    </div>\
                            </a>';

                        if (index === (length - 1)) {
                            dfd.resolve();
                        }
                    });

                    messagesList.html(html);
                }else{
                    dfd.resolve();
                }

                return dfd.promise();
            }

            function updateMessages()
            {
                // CHeck if no pedngin request pending we shoul do the call
                if (updateMessagesRequestPending == false && currentMessageId && !document.hidden) {

                    // Set request pending to true to avoid overlaping
                    updateMessagesRequestPending = true;

                    messagesList = $('.messages-list-rooms');

                    // Do the ajax call to get the new replies
                    $.ajax({
                        method: 'GET',
                        url: '/user/messages',
                        success: function (response) {

                            repopulateMessages(response, true)
                                .then(function () {
                                    // Set request pending to false
                                    updateMessagesRequestPending = false;

                                    //Run the next
                                    setTimeout(updateMessages, 10000);
                                });
                        }
                    })
                }else{
                    //Run the next
                    setTimeout(updateMessages, 10000);
                }
            }

            setTimeout(updateMessages, 10000);
        });
    </script>
@endsection