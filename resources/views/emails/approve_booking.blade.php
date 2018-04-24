Hi {{ $student->pretty_name() }},
<br><br>
{{ $classroom->user->first_name }} has approved your booking for {{ $classroom->title }}.
<br><br>
This is the information for your booking:
<br><br>
{{ $booking->id }}
@include('classroom.schedule_item', ['formatted_schedule' => $booking->classroom->getFormattedSchedule(), 'day_time' => $booking->day_time])
<br><br>
Start date: {{ $booking->start_date }}<br>
{{ $booking->classroom->country->name }}<br>
{{ $booking->classroom->address_1 }},
{{ $booking->classroom->address_2 }}
{{ $booking->classroom->city }}<br>
{{ $booking->classroom->state }}<br>
{{ $booking->classroom->zip_code }}<br>
<br><br>
You will be attending the class for {{ $classroom->duration->title }} and we wish you enjoy your stay and learn as much as you want. You can <a href="{{ route('user_studyplan')  }}">click here</a> to access your study plan and get more detailed information.
<br><br>
Regards,<br>
Classrr Team