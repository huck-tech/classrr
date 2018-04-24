Hi {{ $student->pretty_name() }},<br><br>

{{ $tutor->first_name }} has sent you a message regarding your booking in {{ $classroom_name->title }}. You can simply reply this message to get back to him.
<br><br>
---<br>

{{ $message_txt }}

<br>---<br><br>
Sent via Classrr.com