@if ($students)
    <h4>Students:</h4>
    <ul class="student-list">
    @foreach($students as $student)
        <li><a href="{{ route('user_review', ['id' => $student->student->id]) }}"><span class="book-id">#{{ $student->uid }}</span><br> {{ $student->student->pretty_name() }}</a></li>
    @endforeach
    </ul>
@endif