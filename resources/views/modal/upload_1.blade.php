<div class="modal fade bd-example-modal-lg" id="solveimagemodal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Upload Solve</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form method="POST" id="imageForm2" enctype="multipart/form-data">
            @csrf
                <input type="hidden" name="id" id="id_upload" />
                <input type="hidden" name="status" value="To Be Confirmed"/>
                <div class="input-group mb-3">
                  <input type="file" name="image" id="image2" />
                </div>
                <div class="input-group mb-3">
                    <textarea type="text" id="commentdone" name="comment" placeholder="Comment" rows="3"></textarea>
                </div>
                <button type="submit" id="solveimageform" class="done-status btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
  </div>
</div>
<script>

  $(document).ready(function () {
    $('#solveimageform').click(function (e)  {
        e.preventDefault(); // Prevent the default link behavior

        var link = $(this);
        var id = $("#id_upload").val();
        var newStatus = link.data('status');
        var newAssignee = link.data('assignee');
        var formElement = document.getElementById('imageForm2'); // Assuming imageform is the ID of your form
        var formData = new FormData(formElement);
        console.log('Clicked link with ticket ID:', id);
        console.log('Clicked link with ticket status:', formData.get('status'));
        console.log('Clicked link with ticket id:', formData.get('id'));
        // Disable the link to prevent further updates
        link.prop('disabled', true);

        // Send an AJAX request to update the status to 'pending'
        $.ajax({
            url: '/solve/' + id,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include the CSRF token
            },
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success: function (response) {
              console.log('Clicked link with ticket ID:', response);
                console.log('Clicked link with ticket detail:', response.detail);
                console.log('Clicked link with ticket status:', response.status);
                console.log('Clicked link with ticket assigned:', response.assigned_to);
                $('#tbody1').load(document.URL + ' #tbody1');
                $('#tbody2').load(document.URL + ' #tbody2');
                $('#solveimagemodal').modal('hide');
            },
            error: function (xhr, status, error) {
                console.error(error);
                // Re-enable the link in case of an error
                link.prop('disabled', false);
            }
        });
    });
});
</script>