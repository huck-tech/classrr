@if ($rating)
    {{ round($rating, 1) }} ({{ $rating_votes }} {{ trans_choice('votes', $rating_votes) }})
@endif