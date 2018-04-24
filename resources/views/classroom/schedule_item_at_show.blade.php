@foreach($formatted_schedule as $weekday => $day_schedule)
    @if (isset($day_schedule[$day_time]))
        <tr>
            <td>
                {{ $weekday }}
            </td>
            <td>
                {{ $day_schedule[$day_time]['from'] . ':00' }} &ndash;
                {{ $day_schedule[$day_time]['to'] . ':00' }}
            </td>
        </tr>
    @endif
@endforeach