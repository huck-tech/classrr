<!-- Modal Review -->
<div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="contactModalLabel">Send A Message</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['method' => 'post']) !!}

                <div class="form-group">
                    <textarea name="message" class="form-control" placeholder="Type your message here..." minlength="1" maxlength="2500" style="height:100px" ></textarea>
                </div>
				<strong>Please include:</strong>
				<ul>
					<li>Learning objectives</li>
					<li>Relevant information</li>
					<li>Your availability</li>
					<li>Your budget</li>
				</ul>
				<hr>

                <input type="submit" value="Send" class="btn_1" disabled>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div><!-- End modal review -->


@section('customscript')
    @parent
    <script>
        $(function () {

            var contactModal = $('#contactModal');

            contactModal.on('show.bs.modal', function (event) {
                // Button that triggered the modal
                var button = $(event.relatedTarget);

                // Get id from button data attribute
                var messageId = button.data('id');

                var modal = $(this);

                modal.find('form').attr('action', '/classroom/' + messageId + '/contact');
            });

            contactModal.find('textarea[name="message"]').keyup(function(){
                // If there's a value enable the button
                if($(this).val()){
                    contactModal.find('input[type="submit"]').attr('disabled', false);
                }
                // Else disable it
                else{
                    contactModal.find('input[type="submit"]').attr('disabled', true);
                }
            });

        });
    </script>
@endsection