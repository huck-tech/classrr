@extends('user_layout')

@section('additional_javascript')
@parent
<script>
    function initBookingMap() {
        $('.booking-map').each(function (i, el) {
            $el = $(el);
            var tloc = {lat: $el.data('lat'), lng: $el.data('lng')};
            var tmap = new google.maps.Map(el, {
                center: tloc,
                zoom: 8
            });

            var tmarker = new google.maps.Marker({
                position: tloc,
                map: tmap
            });
        });
    }
    $(function () {
        initBookingMap();
        $('.nav-tabs a').on('click', function () {
            if ($(this).attr('href') === '#booking') initBookingMap();
        });

    });

</script>
@endsection

@section('tab_content')


    <ul class="nav nav-tabs">
        <li class="active"><a href="#classrooms" data-toggle="tab">@lang('studyplan.teacher') ({{ $classrooms->count() }})</a></li>
        <li><a href="#bookings" data-toggle="tab">@lang('studyplan.student') ({{ $bookings->count() }})</a></li>
    </ul>

    <div class="tab-content studyplan-tabs">
        <div class="tab-pane active" id="classrooms">
            @forelse($classrooms as $item)
                <div class="strip_booking study_plan">
                    <div class="row">
                        {{--<div class="col-md-2 col-sm-2">--}}
                            {{--<div class="date">--}}
                                {{--<span class="month">{{ $item['id'] }}</span>--}}
                                {{--<span class="day"><strong>23</strong>Sat</span>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        <div class="col-sm-8 col-sm-offset-1">
                            <h3 class="class_booking">{{ $item['title'] }} <span>{{ $item['duration']['title'] }} / {{ $item['level']['title'] }} </span></h3>
                            <div class="row">
	                            @if ($item->isOpenAt('morning'))
                                <div class="col-md-4">
                                    <h4>Morning <i class="icon-user-1"></i> </h4>
                                    @include('classroom.schedule_item', ['formatted_schedule' => $item->getFormattedSchedule(), 'day_time' => 'morning'])
                                    @include('classroom.students', ['students' => $item->getStudents('morning')])
                                </div>
                                @endif
                                @if ($item->isOpenAt('afternoon'))
                                <div class="col-md-4">
                                    <h4>Afternoon <i class="icon-user-1"></i> </h4>
                                    @include('classroom.schedule_item', ['formatted_schedule' => $item->getFormattedSchedule(), 'day_time' => 'afternoon'])
                                    @include('classroom.students', ['students' => $item->getStudents('afternoon')])
                                </div>
                                @endif
                                @if ($item->isOpenAt('evening'))
                                <div class="col-md-4">
                                    <h4>Evening <i class="icon-user-1"></i> </h4>
                                    @include('classroom.schedule_item', ['formatted_schedule' => $item->getFormattedSchedule(), 'day_time' => 'evening'])
                                    @include('classroom.students', ['students' => $item->getStudents('evening')])
                                </div>
                                @endif
                            </div>
                        </div>
                        {{--
                        <div class="col-md-2 col-sm-3">
                            <ul class="info_booking">
                                <li><strong>Booking id</strong> 23442</li>
                                <li><strong>Booked on</strong> Sat. 23 Dec. 2016</li>
                            </ul>
                        </div>
                        --}}
                        <div class="col-md-2 col-sm-2">
                            <div class="booking_buttons">
                                <a href="{{ route('classroom_show', ['id' => $item['id']]) }}" class="btn_2">@lang('studyplan.details')</a>
                                <a href="{{ route('classroom_edit', ['id' => $item['id']]) }}" class="btn_3">@lang('studyplan.edit')</a>
                            </div>
                        </div>

                    </div><!-- End row -->
                </div><!-- End strip booking -->
            @empty
                <h3 class="text-center">@lang('studyplan.no_teaching', route('classroom_create'))</h3>
            @endforelse
        </div>
        <div class="tab-pane" id="bookings">
            @forelse($bookings as $booking)
                <div class="booking">
                    <div class="row">
                        <div class="col-sm-11 col-sm-offset-1">
                            <h2><span class="book-id">#{{$booking->uid}}</span></h2>
                            <h2>{{ $booking->classroom->title }}</h2>
                        </div>
                        <div class="col-sm-11 col-sm-offset-1">
                            <ul class="booking-legend-1">
                                <li>{{ $booking->classroom->user->pretty_name() }}</li>
                                <li>${{ sprintf('%.2f', $booking->price) }}</li>
								<li><strong>{{ $booking->payment_status }}</strong></li>
                            </ul>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-5 col-sm-offset-1">
                            <h3>Address</h3>
                            <div>
                                {{ $booking->classroom->country->name }}<br>
                                {{ $booking->classroom->address_1 }},
                                {{ $booking->classroom->address_2 }}
                                {{ $booking->classroom->city }}<br>
                                {{ $booking->classroom->state }}<br>
                                {{ $booking->classroom->zip_code }}<br>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <h3>@lang('studyplan.how_go_there')</h3>
                            <div>{{ $booking->classroom->location_comments }}</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-11 col-sm-offset-1">
                            <div class="booking-map" data-lng="{{ $booking->classroom->lng }}" data-lat="{{ $booking->classroom->lat }}"></div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm-11 col-sm-offset-1">
                            <h3>@lang('studyplan.classroom_schedule') <br>
                                <span class="small">@lang('studyplan.start_date') {{ $booking->start_date }} @lang('studyplan.for') {{ $booking->classroom->duration->title }}</span>
                            </h3>

                            <div>
                                @include('classroom.schedule_item', ['formatted_schedule' => $booking->classroom->getFormattedSchedule(), 'day_time' => $booking->day_time])
                            </div>
							
                            {{--<div>
                                <a class="btn_1" href="{{ route('payments_cancel', ['id' => $booking->uid]) }}">Cancel</a>
                            </div>--}}
                        </div>
                    </div>

                </div>
				<hr>
            @empty
                <h3 class="text-center">@lang('studyplan.no_enroll_class') <a href="{{ route('classroom_list') }}">@lang('studyplan.start_now')</a></h3>
            @endforelse
        </div>

    </div>
	
@endsection