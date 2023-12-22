<div class="modal fade bd-example-modal-lg" id="Confirmation" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                <form id="myForm" method="POST">
                  {{ csrf_field() }}
                  <h5>Terima Penyelesaian?</h5>
                  <input type="hidden" id="id" name="id"/>
                    <button class="btn btn-sm btn-danger mx-2" type=submit id="submitFormNo" data-status="In Progress">Denied</button>
                    <button class="btn btn-sm btn-success mx-2" type=submit id="submitFormYes" data-status="Closed">Accept</button>
                 </form>
                </div>
                <div class="row">
                    <a href="#" class="bukti btn btn-sm btn-primary btn-success" data-toggle="modal" data-target="#imageviewsolve">
                        Bukti Penyelesaian
                        <i class="far fa-eye"></i>
                      </a>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="Comment" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Comments</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <form id="CommentForm" method="POST">
                  {{ csrf_field() }}
                  <h5>Berikan Alasan Kenapa: </h5>
                    <input type="hidden" id="id_next">
                    <input type="hidden" name="status" value="In Progress"/>
                  <div class="input-group mb-3">
                    <input type="text" id="commentgreat" name="comment" rows="3"></input>
                  </div>
                <button class="btn btn-sm btn-danger btn-block mx-2" type=submit id="denialform" data-status="In Progress">Denied</button>
              </form>
              </div>
            </div>
        </div>
    </div>
</div>
@include('modal.pdfviewsolve')
@include('modal.imageviewsolve')
<script>
$(document).ready(function () {
    $('#submitFormNo').click(function (e) {
        e.preventDefault(); // Prevent the default link behavior

        var id = $('#myForm input[name="id"]').val(); // Get the value of the input field named 'id'
        $('#id_next').val(id);
        $('#Confirmation').modal('hide'); // Corrected spelling
        $('#Comment').modal('show');
        console.log('ID:', id);

        // Send an AJAX request to update the status to 'pending'
    });

    $('#submitFormYes').click(function (e) {
        e.preventDefault(); // Prevent the default link behavior

        var formData = $('#myForm').serialize();
        var newStatus = $(this).data('status');
        id = $("#id").val();

        console.log('Clicked link with ticket ID:', formData);
        console.log('New status:', newStatus);
        console.log('id:', id);

        // Send an AJAX request to update the status to 'pending'
        $.ajax({
            url: '/update-ticket/' + id,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include the CSRF token
            },
            data: { status: newStatus, formData },
            success: function (response) {
              console.log('The response:', response);
              $('#Confirmation').modal('hide');
              $('#tbcbox').load(document.URL + ' #tbcbox');
              $('#count4').load(document.URL + ' #count4');
            },
            error: function (xhr, status, error) {
                console.error(error);
                console.log('gagal goblok');
            }
        });
    });
});

$(document).ready(function () {
    $('#denialform').click(function (e) {
        e.preventDefault(); // Prevent the default link behavior

        var formData = $('#CommentForm').serialize();
        var newStatus = $(this).data('status');
        var id = $("#id_next").val();
        var commentText = $('#commentgreat').val(); // Fetch the comment text

        // Append the comment text to the serialized form data
        formData += '&comment=' + encodeURIComponent(commentText);

        console.log('Clicked link with ticket ID:', formData);
        console.log('New status:', newStatus);
        console.log('id:', id);

        // Send an AJAX request to update the status to 'pending'
        $.ajax({
            url: '/solve/' + id,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include the CSRF token
            },
            data: formData,
            success: function (response) {
              console.log('response: ', response);
              $('#Comment').modal('hide');
              $('#tbcbox').load(document.URL + ' #tbcbox');
              $('#count2').load(document.URL + ' #count2');
            },
            error: function (xhr, status, error, response) {
                console.error(error);
                console.log('gagal goblok ', response);
            }
        });
    });
});

$(document).on('click', '.bukti', function(event) {
	event.preventDefault(); // Prevent the default link behavior
    var ticketId = $('#myForm input[name="id"]').val(); // Extract ticket ID from data- attribute
    console.log('cek id: ', ticketId);
    $.ajax({
        url: '/ticketssolves/' + ticketId,
		    headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include the CSRF token
            },
        type: 'GET',
        success: function (response) {
				console.log('hasil fetch: ', response);

				var imagesContainer = $('#modalImagessolve');
				imagesContainer.empty();

                var imageUrl = response.image_url;
                var fileType = response.file_type;

                if (fileType === 'pdf') {
					PDFObject.embed(imageUrl, "#pdf-viewer-solve", {
					height: 'calc(100vh - 120px)', // Adjust the height of the PDF viewer
					width: '100%', // Adjust the width as needed
					pdfOpenParams: {
						view: 'FitV', // Set PDF view mode (optional)
						scrollbar: '1', // Show scrollbar (optional)
					}});
					$('#pdfviewsolve').modal('show');
                } else if (fileType === 'jpg' || fileType === 'jpeg' || fileType === 'png') {
                    // Handle image file display (e.g., display in an image tag)
                    var img = $('<img />').attr('src', imageUrl).attr('alt', 'Ticket Image');
                    
					img.css('max-width', '100%');
					img.css('max-height', '100%');

					imagesContainer.append(img);
                    $('#imageviewsolve').modal('show');
                } else {
                    // Handle other file types accordingly
                    // ...
                }
        },
        error: function (error, response) {
            console.error('Error fetching ticket details:', error);
			console.log('hasil fetch: ', response);
        }
    });
});
</script>