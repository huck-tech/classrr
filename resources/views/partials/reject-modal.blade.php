<!-- Modal Review -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="rejectModalLabel">@lang('transactions.rejection_title')</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['method' => 'post']) !!}

                <div class="form-group">
                    <textarea name="reason" class="form-control" placeholder="Type your reason here..." minlength="1" maxlength="2500" style="height:100px" ></textarea>
                </div>
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

            var rejectModal = $('#rejectModal');

            rejectModal.on('show.bs.modal', function (event) {
                // Button that triggered the modal
                var button = $(event.relatedTarget);

                // Get id from button data attribute
                var bookingId = button.data('id');

                var modal = $(this);

                modal.find('form').attr('action', '/payments/void/' + bookingId);
            });

            rejectModal.find('textarea[name="reason"]').keyup(function(){
                // If there's a value enable the button
                if($(this).val()){
                    rejectModal.find('input[type="submit"]').attr('disabled', false);
                }
                // Else disable it
                else{
                    rejectModal.find('input[type="submit"]').attr('disabled', true);
                }
            });

        });
    </script>
@endsection