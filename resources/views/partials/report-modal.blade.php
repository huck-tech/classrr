<!-- Modal Review -->
<div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="reportModalLabel">@lang('messages.provide_reason')</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['method' => 'post']) !!}

                <div class="form-group">
                    <textarea name="report" class="form-control" placeholder="Type your reason here..." minlength="1" maxlength="2500" style="height:100px" ></textarea>
                </div>
				<strong>@lang('messages.help_our')</strong>
				<ul>
					<li>@lang('messages.help_1')</li>
					<li>@lang('messages.help_2')</li>
					<li>@lang('messages.help_3')</li>
				</ul>
				<hr>
				
                <input type="submit" value="Submit" class="btn_1" disabled>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div><!-- End modal review -->


@section('customscript')
    @parent
    <script>
        $(function () {

            var reportModal = $('#reportModal');

            reportModal.on('show.bs.modal', function (event) {
                // Button that triggered the modal
                var button = $(event.relatedTarget);

                // Get id from button data attribute
                var bookingId = button.data('id');

                var modal = $(this);

                modal.find('form').attr('action', '/payments/report/' + bookingId);
            });

            reportModal.find('textarea[name="report"]').keyup(function(){
                // If there's a value enable the button
                if($(this).val()){
                    reportModal.find('input[type="submit"]').attr('disabled', false);
                }
                // Else disable it
                else{
                    reportModal.find('input[type="submit"]').attr('disabled', true);
                }
            });

        });
    </script>
@endsection