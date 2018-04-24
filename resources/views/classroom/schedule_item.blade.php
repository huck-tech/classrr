<ul class="schedule-legend">
    @foreach($formatted_schedule as $weekday => $day_schedule)
        @if ($day_schedule[$day_time])
            <li>
                <span class="label label-danger">{{ $weekday }}</span>
                <span class="item">
                    {{ $day_schedule[$day_time]['from'] . ':00' }} &ndash;
                    {{ $day_schedule[$day_time]['to'] . ':00' }}
                </span>
            </li>
        @endif
    @endforeach
</ul>