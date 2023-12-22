<div class="modal fade bd-example-modal-lg" id="displaymodalopen" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Open Ticket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="displayopen"class="table table-bordered table-hover table-responsive" style="width:100%">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th style="width:30%">title</th>
                    <th style="width:30%">description</th>
                    <th>category</th>
                    <th>assigned_to</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody style="font-size: 16px">
                  @foreach ($openTickets as $data)
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{ $data->title }}
                    @if ($data->attachment)
                        @foreach ($data->attachment as $attachment)
                            @if ($attachment->detail === 'first')
                                <a href="#" data-target="#imageview" data-id="{{ $data->id }}">
                                    <img src="{{ asset('images/' . $attachment->image_url) }}" alt="Image" width="200">
                                </a>
                            @endif
                        @endforeach
                    @endif
                    </td>
                    <td>{{ $data->description }}</td>
                    <td>{{ $data->category->name }}</td>
                    <td id="assignee_{{ $data->id }}">{{ $data->assignedTo ? $data->assignedTo->name : 'Not Assigned' }}</td>
                    <td id="status_{{ $data->id }}">
                        <span class="bg-success border border-success rounded p-1">{{ $data->status }}</span>
                    </td>
                    <td>{{ $data->priority }}</td>
                    <td>
                        <a href="#" class="cancel-ticket btn btn-sm btn-danger" data-id="{{ $data->id }}" data-status="Cancelled">Cancel</a>
                    </td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
  $(document).ready(function () {
      $('#displaymodalopen').on('show.bs.modal', function() {
        $('#displayopen').load(document.URL + ' #displayopen');
        $('#count1').load(document.URL + ' #count1');
        $('#count2').load(document.URL + ' #count2');
        $('#count3').load(document.URL + ' #count3');
        $('#count4').load(document.URL + ' #count4');
    });
});

$(document).ready(function () {
    $(document).on('click','.cancel-ticket',function (e) {
        e.preventDefault(); // Prevent the default link behavior

        var link = $(this);
        var id = link.data('id')
        var newStatus = link.data('status');
        var newAssignee = link.data('assignee');
        console.log('Clicked link with ticket ID:', id);
        console.log('Clicked link with ticket ID:', newStatus);
        console.log('Clicked link with ticket ID:', newAssignee);
        
        // Disable the link to prevent further updates
        link.prop('disabled', true);

        // Send an AJAX request to update the status to 'pending'
        $.ajax({
            url: '/update-ticket/' + id,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include the CSRF token
            },
            data: { 
              status: newStatus,
              assignee: newAssignee
            },
            success: function (response) {
                console.log('Clicked link with ticket ID:', response);
                console.log('Clicked link with ticket ID:', response.status);
                console.log('Clicked link with ticket ID:', response.assigned_to);
                $('#count1').load(document.URL + ' #count1');
                $('#displaymodalopen').modal('hide');
            },
            error: function (xhr, status, error) {
                console.error(error);
                // Re-enable the link in case of an error
                link.prop('disabled', false);
            }
        });
    });
});
$(document).on('click', 'a[data-target="#imageview"]', function(event) {
	event.preventDefault(); // Prevent the default link behavior
    var ticketId = $(this).data('id'); // Extract ticket ID from data- attribute
    console.log('cek id: ', ticketId);
    $.ajax({
        url: '/tickets/' + ticketId,
		    headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include the CSRF token
            },
        type: 'GET',
        success: function (response) {
				console.log('hasil fetch: ', response);

				var imagesContainer = $('#modalImages');
				imagesContainer.empty();

                var imageUrl = response.image_url;
                var fileType = response.file_type;

                if (fileType === 'pdf') {
                  PDFObject.embed(imageUrl, "#pdf-viewer", {
                  height: 'calc(100vh - 120px)', // Adjust the height of the PDF viewer
                  width: '100%', // Adjust the width as needed
                  pdfOpenParams: {
                    view: 'FitV', // Set PDF view mode (optional)
                    scrollbar: '1', // Show scrollbar (optional)
                  }});
                  $('#pdfview').modal('show');
                } else if (fileType === 'jpg' || fileType === 'jpeg' || fileType === 'png') {
                    // Handle image file display (e.g., display in an image tag)
                    var img = $('<img />').attr('src', imageUrl).attr('alt', 'Ticket Image');
                    
                    img.css('max-width', '100%');
                    img.css('max-height', '100%');

                    imagesContainer.append(img);
                    $('#imageview').modal('show');
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

$(document).on('click', 'a[data-target="#commentsmodal"]', function(event) {
	event.preventDefault(); // Prevent the default link behavior
    var ticketId = $(this).data('id'); // Extract ticket ID from data- attribute
	console.log('cek id: ', ticketId);
    $.ajax({
        url: '/ticketcomments/' + ticketId,
        type: 'GET',
        success: function (response) {
			console.log('cek id: ', response);
            var comments_denied = response.comments_denied;
			var comments_solve = response.comments_solve;
            var modalBody = $('#commentsmodal .modal-body');
            modalBody.empty();

			if (comments_solve || comments_denied) {
                    var maxLength = Math.max(comments_solve.length, comments_denied.length);

                    for (var i = 0; i < maxLength; i++) {
                        var solveComment = comments_solve[i] || {}; // Use empty object if index is out of bounds
                        var deniedComment = comments_denied[i] || {}; // Use empty object if index is out of bounds

                        var cardSolve = `
                            <div class="row">
                                <div class="col">
                                    <div class="card mb-3 bg-success">
										<div class="card-header">
											<div class="row">
												<div class="col">
													<h5 class="card-title">${solveComment.user?.name || ''}</h5>
												</div>
												<div class="col">
													<h5 class="card-title">${solveComment.created_at || ''}</h5>
												</div>
											</div>
										</div>
                                        <div class="card-body">
											<div class="row">
												<p class="card-text">${solveComment.comment_text || ''}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;

                        var cardDenied = `
                            <div class="row">
                                <div class="col">
                                    <div class="card mb-3 bg-danger">
										<div class="card-header">
												<div class="row">
													<div class="col">
														<h5 class="card-title">${solveComment.user?.name || ''}</h5>
													</div>
													<div class="col">
														<h5 class="card-title">${solveComment.created_at || ''}</h5>
													</div>
												</div>
											</div>
                                        <div class="card-body">
                                            <p class="card-text">${deniedComment.comment_text || ''}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;

                        modalBody.append(cardSolve);
                        modalBody.append(cardDenied);
                    }
                } else {
                    modalBody.append('<p>No comments available.</p>');
                }


			$('#commentsmodal').modal('show');
			},
        error: function (error, response) {
            console.error('Error fetching ticket details:', error);
			console.log('cek response: ', response);
        }
    });
});
</script>