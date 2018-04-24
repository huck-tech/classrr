<tr>
    <td>
        Details
    </td>
    <td class="text-right">
        <span id="hours-total">{{ $item['total_days'] }} Classes &amp; {{ $item['total_hours'] }} Hrs</span>
    </td>
</tr>
{{--
<tr>
    <td>
        Total Hours
    </td>
    <td class="text-right">
        <span id="hours-total"></span>
    </td>
</tr>
--}}
<tr>
    <td>
        Fee Breakdown
    </td>
    <td class="text-right">
        @unless(isset($item['weekend_hours']) && $item['weekend_hours'])
            ${{ $item['base_price'] }} x {{ $item['total_hours'] }} hrs
        @else
            ${{ $item['base_price'] }} x {{ $item['total_hours'] - $item['weekend_hours'] }} hrs <br>
                +<span class="small">weekend</span> ${{ $item['base_price'] + $item['weekend_fee'] }}<span class="small"></span> x {{ $item['weekend_hours'] }} hrs
        @endif
    </td>
</tr>
<tr>
    <td>
        Handling Fee (0%) <div class="tooltip_styled tooltip-effect-1" data-placement="right"><span class="tooltip-item"><i class="icon-info-circled"></i></span>
			<div class="tooltip-content">The fee that imposed by PayPal to process your payment</div>
		</div>
    </td>
    <td class="text-right">
        {{--<span>{{ '$' . sprintf('%.2f', $item['price_before'] * 0.05) }}</span>--}}
        $0.00
    </td>
</tr>
<tr class="total">
    <td>
        Total cost
    </td>
    <td class="text-right">
        @if($hasApprovedRewards)
            @if($discount)
				{{ '$' . number_format((float)($item['total_price'] - $discount),2,'.',',') }}<br />
				<small>
				<div class="tooltip_styled tooltip-effect-1" data-placement="right">
                    <span class="tooltip-item"><i class="icon-info-circled"></i></span>
                    @if($hasNotEligibleRewards)
                        <div class="tooltip-content">Some of your credits cannot be used for this class, we'll only deduct your eligible credits</div>
                    @else
                        <div class="tooltip-content">A discount of ${{ $discount }} automatically applied</div>
                    @endif
                </div><s> {{ '$' . number_format((float)$item['total_price'],2,'.',',') }}</s>
				</small>
            @else
                <div class="tooltip_styled tooltip-effect-1" data-placement="right">
                    <span class="tooltip-item"><i class="icon-info-circled"></i></span>
                    <div class="tooltip-content">This class is not eligible for your credits</div>
                </div>
				{{ '$' . number_format((float)$item['total_price'],2,'.',',') }}
            @endif
        @else
            {{ '$' . number_format((float)$item['total_price'],2,'.',',') }}
        @endif
    </td>
</tr>