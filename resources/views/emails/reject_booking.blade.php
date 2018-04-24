Hi {{ $student->pretty_name() }},
<br><br>
Unfortunately the booking you have made for {{ $classroom->title }} is not available at the schedule you made. You can always contact the teacher and find the best time, we also provide wide range of available classes near you, please feel free to check them here {{ route('classroom_list') }}.
<br><br>
Regards,<br>
Classrr Team