@extends('layout')

@section('title', 'User Profile')

@section('additional_styles')
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
@endsection

@section('additional_javascript')
    <script>
        $('#approve-student').on('click', function(e){
            e.preventDefault();
            var data = {student_id: $(this).data('studentId')};
            $.ajax({
                url: '{{ route('user_approve') }}',
                data: data,
                beforeSend: function () {
                    //$(this).prop('disabled', true).text('Loading...');
                },
                success: function (data) {
					//$(this).prop('disabled', true).text('Approved');
                },
                error: function () {
					//$(this).prop('disabled', false).text('Something went wrong');
                },
                complete: function () {
                    //$(this).prop('disabled', true).text('Approved');
                }
            });
        });
    </script>
	{{--
    <script>
        $('#tutor-contact-form').on('submit', function (e) {
            e.preventDefault();
            $form = $(this);
            $.ajax({
                url: '{{ route('user_send_message') }}',
                method: 'post',
                data: $form.serialize(),
                beforeSend: function () {
                    $form.find('.submit-btn').prop('disabled', true).text('Loading...');
					$.notify('Sending message...');
                },
                success: function (data) {
                    console.log(data);
                    if (data && data.status === true) {
                        $form.find('.submit-btn').replaceWith($('<span class="text-success"/>').text('Message was successfully sent. Thank you!'));

                    }
                },
                error: function () {
					$.notify({title: 'Error', message: 'Sorry! Email gateway error, try again later.'}, {type: 'danger'});
					$form.find('.submit-btn').prop('disabled', false).text('Send Again');
                },
                complete: function () {
                
                }
            });

        });
    </script>
	--}}
@endsection

@section('content')
<div class="container margin_60">
    <div class="content">
        <section class="content-single">
            <div class="row">

                <div class="col-md-6 col-sm-6">
                    <h4>Student profile
                        @if($booking['tutor_approved']) &ndash; <span class="text-success"> &check; Approved By You</span>@endunless</h4>
                    <ul id="profile_summary">
                        <li>First name <span>{{ $review_user['first_name'] }}</span></li>
                        <li>Last name <span>{{ $review_user['last_name'] }}</span></li>
                        <li>Date of birth <span>{{ $review_user['dob'] ?: 'N/A' }}</span></li>
                        <li>Phone verified <span>{{ $verification_phone ? 'Yes' : 'No' }}</span></li>
                        <li>Email verified <span>{{ $verification_email ? 'Yes' : 'No' }}</span></li>
					</ul>
					<hr>
					<h4>Transaction History</h4>
					<hr>
					<ul id="profile_summary">
						@forelse($bookings as $book)
                        <li>Booking # <span>{{ $book['uid'] }}</span></li>
						<li>Class ID <span>{{ $book['classroom_id'] }}</span></li>
						<li>Enrollment Date <span>{{ $book['start_date'] }}</span></li>
						<li>Class Time <span>{{ $book['day_time'] }}</span></li>
						<li>Status <span>{{ $book['payment_status'] }}</span></li>
						<hr>
						@empty
						<span>No active booking</span>
						@endforelse
                    </ul>
                </div>
                <div class="col-md-6 col-sm-6">
                    <img src="{{ $review_user['avatar'] ? $review_user['avatar']->getAssetPath() : asset('img/empty_avatar_256x256.png') }}" alt="Image" class="img-responsive styled profile_pic">
                    </p>
					<hr>
					<div class="col-sm-12">
						<a href="{{ route('user_messages') }}" class="btn_1 white">
                        <i class="icon-email"></i> Send Message</a>
					</div>
                </div>
            </div><!-- End row -->
            @unless($booking['tutor_approved'])
                <hr>
                @if ($documents and count($documents) > 0)
                    <h4>Student documents</h4>
                    <div class="row">
                        @foreach($documents as $item)
                            <div class="col-sm-3">
                                <div class="thumbnail">
                                    <img src="{{ $item->getAssetPath() }}" >
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="row">
                    <div class="col-sm-12">
                        <button class="btn_1 green"
                                id="approve-student"
                                data-student-id="{{ $review_user['id'] }}">Approve Student</button>
                    </div>
                </div>
            @endunless
			
            {{--<hr>
            <div class="row">
			<div class="col-md-6">
                    <h3>Contact form</h3>
                    <div>
                        <form id="tutor-contact-form">
                            {{ csrf_field() }}
                            <input type="hidden" name="student_id" id="student_id" value="{{ $review_user['id'] }}">
                            <div class="form-group">
                                <label for="">From</label>
                                <input type="text" class="form-control" value="{{ $current_user->email }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="">Message</label>
                                <textarea name="message" id="message" class="form-control" rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn_1 submit-btn">Send</button>
                            </div>
                        </form>
                    </div>
			</div>
            </div>--}}

        </section>
    </div>

</div>
@endsection