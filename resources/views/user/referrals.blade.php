@extends('user_layout')

@section('additional_styles')
    @parent
    <link href="{{ asset('vendor/bootstrap-tagsinput/css/bootstrap-tagsinput.css') }}" rel="stylesheet">
    <style>
        .bootstrap-tagsinput{
            width: 100%;
            min-height: 250px;
            border: 1px solid #e2e2e2;
        }

        .bootstrap-tagsinput input{
            width: 250px;
        }

        .bootstrap-tagsinput .tag{
            font-size: 100%;
            font-weight: 400;
        }
        .bootstrap-tagsinput .tag.invalid {
            background-color: #ed4f32;
        }
    </style>
@endsection

@section('tab_content')

    <div class="row">
        @include('shared.flash')
    </div>
    <div class="row">
        <div class="box_style_1">
            <h2>Give $25, Get $100</h2>
            <p>Everyone you refer gets $25 in credit. Once they’ve booked a class successfully, you'll get $25 in credit and another $75 when they teach their first class. There is no limit to the amount of credit you can earn through your referral.</p>
			<p><strong>Get paid to share Classrr. <a href="https://classrr.typeform.com/to/PGLc49" target="_blank">Be an Ambassador</a>.</strong></p>
		</div>
        <div class="box_style_1">
            <h2>Refer by email</h2>
            <p>Import your contacts from Gmail – or enter your contacts manually – and we’ll invite them for you.</p>
            <button class="btn_1" data-toggle="modal" data-target="#inviteContactByEmailModal">Invite Contacts</button>
        </div>
        <div class="box_style_1">
            <h2>Share your link</h2>
            <p>Copy your personal referral link and share it with your friends and followers.</p>
            <h4>Referral Link</h4>
            <p>{{ url('/?ref='. $user->referral_code) }}</p>

            <div id="referralLinkShareIcons" style="font-size:20px"></div>

        </div>

        <h2>Referrals stats</h2>
        <table class="table table-stripped" style="border: 1px solid #ddd;">
            <tr><td class="col-md-2">CLICKS</td><td class="col-md-8">Number of times your link has been clicked.</td><td class="col-md-2">{{ number_format((float)$referralStatistics->clicks,0,'',',') }}</td></tr>
            <tr><td class="col-md-2">REFERRALS</td><td class="col-md-8">People who have signed up using your link.</td><td class="col-md-2">{{ number_format((float)$referralStatistics->referrals,0,'',',') }}</td></tr>
            <tr><td class="col-md-2">PENDING</td><td class="col-md-8">Amount you stand to earn when your referrals book or teach their first class.</td><td class="col-md-2">${{ number_format((float)$referralStatistics->pending,0,'',',') }}</td></tr>
            <tr><td class="col-md-2">EARNED</td><td class="col-md-8">Amount that has already earned and waiting for an approval.</td><td class="col-md-2">${{ number_format((float)$referralStatistics->earned,0,'',',') }}</td></tr>
            <tr><td class="col-md-2">APPROVED</td><td class="col-md-8">Amount that has already been approved and can be claimed by your account.</td><td class="col-md-2">${{ number_format((float)$referralStatistics->approved,0,'',',') }}</td></tr>
            <tr><td class="col-md-2">CLAIMED</td><td class="col-md-8">Amount that has already been claimed by your account.</td><td class="col-md-2">${{ number_format((float)$referralStatistics->used,0,'',',') }}</td></tr>
        </table>
		
		Please note: Bidding on branded keywords which include 'Classrr' for ads is prohibited.
    </div>
    <!-- Modal Review -->
    <div class="modal fade" id="inviteContactByEmailModal" tabindex="-1" role="dialog" aria-labelledby="inviteContactByEmailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="inviteContactByEmailModalLabel">Invite your friends</h4>
                </div>
                <div class="modal-body">

                    <div class="row text-center">
                        <h4> Invite your contacts</h4>
                        <button id="invite_gmail_contacts" class="btn"><i class="icon-google"></i> Invite Gmail Contact</button>
                    </div>
                    <br>
                    {!! Form::open(['route' => 'invite_friends', 'method' => 'post']) !!}

                    <div class="form-group">
                        <select name="emails[]" class="form-control" multiple placeholder="Type or paste email address here">
                        </select>
                    </div>
                    <span> Note: You can only send 25 invitations per day ( You have {{ $availableInvitations }} invitations left for today )</span>
                    <hr>
                    <input type="submit" value="Send" class="btn_1" @if(!count(old('emails', [])) || ( count(old('emails', [])) > $availableInvitations )) disabled @endif>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div><!-- End modal review -->
@endsection

@section('additional_javascript')
    @parent
    <script src="{{ asset('vendor/bootstrap-tagsinput/js/bootstrap-tagsinput.min.js') }}"></script>
    <script async defer src="https://apis.google.com/js/api.js"
            onload="this.onload=function(){};handleClientLoad()"
            onreadystatechange="if (this.readyState === 'complete') this.onload()">
    </script>

    <script>

        var GoogleAuth,
            SCOPE = 'https://www.google.com/m8/feeds';

        function handleClientLoad() {
            // Load the API's client and auth2 modules.
            // Call the initClient function after the modules load.
            gapi.load('client:auth2', initClient);
        }

        // Initialize google api
        function initClient() {
            // Initialize the gapi.client
            gapi.client.init({
                'clientId': '{{ config('services.google.client_id') }}',
                'scope': SCOPE
            }).then(function () {
                GoogleAuth = gapi.auth2.getAuthInstance();
            });

            $('#invite_gmail_contacts').click(function(){
                GoogleAuth.signIn().then(function(e){
                    fetchGmailContacts();
                });
            });
        }

        // Fetch gmail contacts
        function fetchGmailContacts() {

            var token = GoogleAuth.currentUser.get().Zi.access_token;

            $.ajax({
                url: "https://www.google.com/m8/feeds/contacts/default/full?access_token=" + token + "&max-results=1000&alt=json",
                dataType: "jsonp",
            }).done(function(data) {

                var contacts = data.feed.entry;

                if(contacts.length) {
                    for (var key in contacts) {
                        if(contacts[key].gd$email) {
                            $('select[name="emails[]"]').tagsinput('add', contacts[key].gd$email[0].address);
                        }
                    }
                }
            });
        }

        $(function ($) {

            var userFullName = '{{ $user->pretty_name() }}',
                referralLink = '{{ url('/?ref='. $user->referral_code) }}',
                availableInvitations = '{{ $availableInvitations }}';

            $("#referralLinkShareIcons").jsSocials({
                url: referralLink,
                text: 'Hey, ' + userFullName + ' here, I use Classrr to learn with a teacher & classmates. Get your $25 study credit now.',
                shareIn: "popup",
                showLabel: false,
				showCount: false,
                shares: ["facebook", "twitter", "googleplus", "linkedin", "pinterest", "stumbleupon", "whatsapp", "email"]
            });

            // Initialize tags input
            $('select[name="emails[]"]').tagsinput({
                confirmKeys: [13, 32] // Confirm tag using both space and enter
            });

            // Get old emails if any
            var emails = {!! json_encode(old('emails', []))  !!};

            // Add old emails if any
            if(emails.length) {
                for (var key in emails) {
                    if(emails[key]) {
                        $('select[name="emails[]"]').tagsinput('add', emails[key]);
                    }
                }
            }

            // Listen to item added to show if it's valid or invalid email
            $('select[name="emails[]"]').on('itemAdded', function(event) {

                // Get item
                var item = event.item;

                // Email check regex
                var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

                // Check if item is a valid email
                if(!regex.test(item)){
                    // Add class invalid
                    $('.bootstrap-tagsinput').find('.tag').last().addClass('invalid');
                }else{
                    // Add Class valid
                    $('.bootstrap-tagsinput').find('.tag').last().addClass('valid');
                }
            });

            // Get invite contacts modal
            var inviteContactByEmailModal = $('#inviteContactByEmailModal');

            // Listen to change of emails select to enable and disable submit button
            inviteContactByEmailModal.find('select[name="emails[]"]').change(function(){

                var emails = $(this).val(),
                    validEmailsExist = false,
                    validEmailsCount = 0;

                // If there's a valid value enable the button
                if(emails && emails.length){

                    for(var key in emails){
                        // Email check regex
                        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;

                        // Check if item is a valid email
                        if(regex.test(emails[key])){
                            validEmailsExist = true;
                            validEmailsCount++;
                        }
                    }
                    if(validEmailsExist  && ( validEmailsCount <= availableInvitations )) {
                        inviteContactByEmailModal.find('input[type="submit"]').attr('disabled', false);
                    }else{
                        inviteContactByEmailModal.find('input[type="submit"]').attr('disabled', true);
                    }
                }
                // Else disable it
                else{
                    inviteContactByEmailModal.find('input[type="submit"]').attr('disabled', true);
                }
            });

            // disable enter key from subitting the form
            $(document).on("keypress", "form", function(event) {
                return event.keyCode != 13;
            });
        });
    </script>
@endsection