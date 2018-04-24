@extends('user_layout')

@section('tab_content')

    <div class="row">
        <div class="col-sm-12">
            @include('shared.flash')
            <h3>@lang('transactions.title')</h3>
            <p>@lang('transactions.description')</p>
            <table class="table">
                <thead>
                <tr>
                    <th>#</th>
                    <th>@lang('transactions.type')</th>
                    <th>@lang('transactions.class')</th>
                    <th>@lang('transactions.booking')</th>
                    {{--<th>@lang('transactions.students')</th>--}}
                    <th>@lang('transactions.amount')</th>
                    <th>@lang('transactions.status')</th>
                    <th>@lang('transactions.actions')</th>
                </tr>
                </thead>
                <tbody>
                @foreach($transactions as $item)
                    <tr>
                        <td>{{ $item['uid'] }}</td>
						@if ($item->classroom->user_id === $current_user->id)
                        <td>@lang('transactions.deposit')</td>
						@else
                        <td>@lang('transactions.payment')</td>
                        @endif
                        <td><a href="{{ route('classroom_show', ['id' => $item->classroom->id]) }}" target="_blank">{{ $item->classroom->title }}</a></td>
                        <td>{{ $item['created_at'] }}</td>
						{{--<td>1</td>--}}
                        @if ($item->classroom->user_id === $current_user->id)
                            <td>${{ number_format((float)$item['tutor_commission'],2,'.',',') }}</td>
                        @else
                            <td>${{ number_format((float)$item['price'],2,'.',',') }}</td>
                        @endif
						
						@if($item->payment_status == 'authorized' || $item->payment_status == 'completed' || $item->payment_status == 'in escrow')
                        <td><span class="label label-success">{{ str_replace('_', ' ', $item['payment_status']) }}</span></td>
						@else
						<td><span class="label label-warning">{{ str_replace('_', ' ', $item['payment_status']) }}</span></td>
						@endif
                        <td>
                            @if ($item->payment_status == 'authorized')
								@if ($item->classroom->user_id === $current_user->id)
                                <a href="{{ route('payments_capture', ['id' => $item->id]) }}"
                                   class="btn btn-xs btn-default">@lang('transactions.approve')</a>
                                <a href="#" class="btn btn-xs btn-default" data-toggle="modal" data-target="#rejectModal"
                                   data-id="{{ $item->id }}">reject</a>
                                <a href="{{ route('user_review', ['id' => $item->student_id]) }}" target="_blank">@lang('transactions.student_info')</a>
								@else
									@lang('transactions.waiting_approval')
								@endif
							@elseif ($item->payment_status == 'in escrow' && $item->classroom->user_id === $current_user->id)
								<a href="{{ route('payments_cancel', ['id' => $item->id]) }}"
								   class="btn btn-xs btn-default">@lang('transactions.cancel')</a>
								<a href="{{ route('user_review', ['id' => $item->student_id]) }}" target="_blank">@lang('transactions.student_info')
                                </a>
							@elseif ($item->payment_status == 'in escrow' && $item->classroom->user_id !== $current_user->id)
								<a href="{{ route('payments_cancel', ['id' => $item->id]) }}"
								   class="btn btn-xs btn-default">@lang('transactions.cancel')</a>
							@elseif ($item->payment_status == 'pending' && $item->classroom->user_id !== $current_user->id)
								<a href="{{ route('payments_cancel', ['id' => $item->id]) }}"
								   class="btn btn-xs btn-default">@lang('transactions.cancel')</a>
								<a href="{{ route('payments_escalate', [ $item->id ]) }}"
								   class="btn btn-xs btn-default" target="_blank">@lang('transactions.escalate')</a>
							@elseif ($item->payment_status == 'pending' && $item->classroom->user_id === $current_user->id)
								<a href="{{ route('payments_escalate', [ $item->id ]) }}"
								   class="btn btn-xs btn-default">@lang('transactions.escalate')</a>
								<a href="{{ route('user_review', ['id' => $item->student_id]) }}" target="_blank">@lang('transactions.student_info')</a>
							@elseif ($item->payment_status == 'disputed' && $item->classroom->user_id !== $current_user->id)
								<a href="{{ route('payments_escalate', [ $item->id ]) }}"
								   class="btn btn-xs btn-default" target="_blank">escalate</a>
							@elseif ($item->payment_status == 'disputed' && $item->classroom->user_id === $current_user->id)
								<a href="{{ route('payments_cancel', ['id' => $item->id]) }}"
								   class="btn btn-xs btn-default">@lang('transactions.approve')</a>
								<a href="{{ route('payments_escalate', [ $item->id ]) }}"
								   class="btn btn-xs btn-default" target="_blank">@lang('transactions.escalate')</a>
								<a href="{{ route('user_review', ['id' => $item->student_id]) }}" target="_blank">@lang('transactions.student_info')</a>
							@elseif ($item->payment_status == 'cancelled' || $item->payment_status == 'refunded' || $item->payment_status == 'class_in_progress' || $item->payment_status == 'completed' || $item->payment_status == 'created')
								&nbsp;
                            @endif
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
            {{--
            <p class="text-right">
                <span style="margin-right: 30px;">@lang('transactions.total_payout'): $500</span>
                <a href="#" class="btn btn-sm btn-success">@lang('transactions.request_payout')</a>
            </p>
            --}}
        </div>
    </div><!-- End row -->

    <div class="divider"></div>

    @include('partials.reject-modal')

@endsection