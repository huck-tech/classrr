@forelse($items as $item)
    <div class="strip_all_tour_list">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4">
				{{--signal--}}
				@if($item['user_id'] % 2 == 0 && $item['id'] % 2 == 0)
				<div class="ribbon_3 popular"><span>Popular</span></div>
				@elseif($item['user_id'] % 2 != 0 && $item['id'] % 2 == 0)
				<div class="ribbon_3"><span>Best Value</span></div>
				@endif
                <div class="img_list"><a href="{{ route('classroom_show', ['id' => $item['id']]) }}" id="viewItem"><img src="{{ $item->getThumb() }}" alt="{{ $item['title'] }}">
				{{--signal--}}
				{{--best value--}}
				@if($item['user_id'] % 2 != 0 && $item['id'] % 2 == 0 && (in_array($item['base_price'], range(17,20))))
				<div class="badge_save">Save<strong>35%</strong></div>
				@elseif($item['user_id'] % 2 != 0 && $item['id'] % 2 == 0 && (in_array($item['base_price'], range(13,16))))
				<div class="badge_save">Save<strong>45%</strong></div>
				@elseif($item['user_id'] % 2 != 0 && $item['id'] % 2 == 0 && (in_array($item['base_price'], range(8,12))))
				<div class="badge_save">Save<strong>60%</strong></div>
				{{--popular--}}
				@elseif($item['user_id'] % 2 == 0 && $item['id'] % 2 == 0 && (in_array($item['base_price'], range(18,22))))
				<div class="badge_save">Save<strong>35%</strong></div>
				@elseif($item['user_id'] % 2 == 0 && $item['id'] % 2 == 0 && (in_array($item['base_price'], range(8,14))))
				<div class="badge_save">Save<strong>40%</strong></div>
				@endif
                    </a>
                </div>
            </div>
            <div class="clearfix visible-xs-block"></div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="tour_list_desc">
                    <a href="{{ route('classroom_show', ['id' => $item['id']]) }}" id="viewItem">
					<p style="color:#e04f67;margin-bottom:12px;">
						<strong>{{ $item->category->name }} - {{ $item['city'] }}</strong>
						{{--signal--}}
						@if($item['user_id'] % 2 == 0 && $item['id'] % 2 == 0)
						<br /><small style="color:red"><mark>{{ rand(1,50) }} students are considering this class right now</mark></small>
						@elseif($item['user_id'] % 2 != 0 && $item['id'] % 2 == 0)
						<br /><small style="color:red"><mark>{{ rand(1,20) }} students are considering this class right now</mark></small>
						@endif
					</p>
					<h3>{{ str_limit($item['title'], 40) }}</h3></a>
					{{--<p>{{ str_limit($item['description'], 65) }}</p> --}}
                    <div class="row">
                        <div class="col-xs-12 teacher-bage">
                            <img class="avatar-sm" src="{{ $item['user']->getAvatarPath() }}" alt="{{ $item['user']->pretty_name() }}">
                            <div class="teacher-bage-name">
                                <div class="rating">
                                    @include('shared.rating_stars', ['rating' => round($item['rating_value'])])
                                    <small>
                                        @include('shared.rating_text', [
                                        'rating' => $item['rating_value'],
                                        'rating_votes' =>$item['rating_votes']])
                                    </small>
                                </div>{{--end rating--}}
                                <h3>{{ $item['user']->pretty_name() }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2">
                <div class="item-details">
					@if ($item['base_price'] == 0 || $item['total_price'] == 0)
					<br /><span class="item-price">$0</span>
					@else
                        @if($item['hasApprovedRewards'])
                            @if($item['discount'])
								<s style="padding-left: 2px;"> {{ '$' . number_format((float)$item['total_price'],0,'',',') }}</s>
								<span class="item-price" style="font-size: 20px">
									<strong>{{ '$' . number_format((float)($item['total_price'] - $item['discount']),0,'',',') }}</strong> 
									<div class="tooltip_styled tooltip-effect-1" data-placement="right">
										<span class="tooltip-item"><i class="icon-info-circled"></i></span>
										@if($item['hasNotEligibleRewards'])
											<div class="tooltip-content">Some of your credits cannot be used for this class, we'll only deduct your eligible credits</div>
										@else
											<div class="tooltip-content">A discount of ${{ $item['discount'] }} automatically applied</div>
										@endif
									</div>
								</span>
                            @else
								<span class="item-price" style="font-size: 20px">
									<strong>{{ '$' . $item['total_price'] }}</strong>
									<div class="tooltip_styled tooltip-effect-1" data-placement="right">
										<span class="tooltip-item"><i class="icon-info-circled"></i></span>
										<div class="tooltip-content">This class is not eligible for your credits</div>
									</div>
								</span>
                            @endif
                        @else
							<span class="item-price" style="font-size: 20px">
								<strong>{{ '$' . number_format((float)$item['total_price'],0,'',',') }}</strong>
							</span>
                        @endif
					@endif
                    <a href="{{ route('classroom_show', ['id' => $item['id']]) }}" id="viewItem" class="btn_1">Details</a>
                    <div class="item-property">
                        <div class="item-property-label"><i class="icon-back-in-time"></i> Duration</div>
						<div class="item-property-value">{{ $item->getCurrentEnrollmentDate() }}</div>
                    </div>
                    <div class="item-property">
                        <div class="item-property-label"><i class="icon-signal-4"></i> Level</div>
                        <div class="item-property-value">{{ $item['level']['title'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div><!--End strip -->
@empty
    <h4>We can't find {{ $query }} classes in {{ $where }} yet. Try to search for something else</h4>
    <div class="subscribe-form form-group row">
        <div class="col-sm-12">
            <p>You can join other {{ rand(75,80) }} subscribers for this search criteria by using this form below:</p>
        </div>
        <div class=" col-sm-6">
            <input type="text" id="subscribe-input" class="form-control" placeholder="example@email.com">
        </div>
        <div class="form-group col-sm-6">
            <button class="btn_1 green medium" data-action="{{ route('subscribe') }}" id="subscribe-btn">Subscribe for this search!</button>
        </div>
		<div class="col-sm-12">
            <p>Alternatively, you can try and teach with us for free. <a href="{{ route('teachers_bonus') }}">We have a good teacher's bonus for you, just check it out here</a>.
			<br /><br />Or make some quick cash by <a href="{{ route('referral_program') }}">joining our referral program here</a>.
			</p>
        </div>
    </div>
@endforelse

<hr>

<div class="text-center" id="page_nav">
    {{ $items->appends(['q' => $query, 'where' => $where, 'when' => $when, 'cat_id' => $category_id, 'duration' => $duration])->links() }}
    {{-- $items->links() --}}
</div><!-- end pagination-->

@section('fbpixel')

<script type="text/javascript">
$( '#viewItem' ).click(function() {
    fbq('track', 'ViewProduct');
	qp('track', 'ViewProduct');
});
</script>

@endsection

@section('customscript')
<!--Map Info-->
<script>
var count = {{ $items->count() }};
@foreach($items as $item)
var name{{ $loop->iteration }} = "{{ $item['title'] }}";
var lat{{ $loop->iteration }} = "{{ $item['lat'] }}";
var lng{{ $loop->iteration }} = "{{ $item['lng'] }}";
var imgmap{{ $loop->iteration }} = "{{ $item->getThumb() }}";
var price{{ $loop->iteration }} = "{{ $item['total_price'] }}";
var desc{{ $loop->iteration }} = "{{ json_decode(str_limit(e($item['description']),65,'...')) }}";
var urlmap{{ $loop->iteration }} = "{{ route('classroom_show', ['id' => $item['id']]) }}";
@endforeach
</script>
<script src="{{ asset('js/map.js') }}"></script>
<script src="{{ asset('js/infobox.js') }}"></script>
@endsection