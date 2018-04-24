{{-- Works better with rounded value use round($rating) --}}
@for($i = 0; $i < 10; $i = $i + 2)
    @if ($rating - $i >= 2)
        <i class=" icon-star voted"></i>
    @elseif ($rating - $i >= 1)
        <i class=" icon-star-half voted"></i>
    @else
        <i class=" icon-star-empty"></i>
    @endif
@endfor