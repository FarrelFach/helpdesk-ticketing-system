@extends('layouts.template')
@section('title', 'List Ticket')
@section('content')
<section class="content">
    <div class="container-fluid">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
		<li class="nav-item" role="presentation">
			<button class="nav-link active" id="open-tab" data-toggle="tab" data-target="#open" type="button" role="tab" aria-controls="open" aria-selected="true">Ticket</button>
		</li>
		<li class="nav-item" role="presentation">
			<button class="nav-link" id="taken-tab" data-toggle="tab" data-target="#progress" type="button" role="tab" aria-controls="progress" aria-selected="false">In Progress Ticket</button>
		</li>
		<li class="nav-item" role="presentation">
			<button class="nav-link" id="taken-tab" data-toggle="tab" data-target="#tbc" type="button" role="tab" aria-controls="tbc" aria-selected="false">To Be Confirmed Ticket</button>
		</li>
		<li class="nav-item" role="presentation">
			<button class="nav-link" id="taken-tab" data-toggle="tab" data-target="#closed" type="button" role="tab" aria-controls="closed" aria-selected="false">Closed Ticket</button>
		</li>
    	</ul>
    	<div class="tab-content" id="myTabContent">
			<div class="tab-pane fade show active" id="open" role="tabpanel" aria-labelledby="open-tab">
				@include('table.open_ticket_table')
			</div>
			  @can('isAdmin')
			<div class="tab-pane fade" id="progress" role="tabpanel" aria-labelledby="taken-tab">
				@include('table.progress_ticket_table')
			</div>
		</div>			  
		@endcan
	</div>
</section>
            <!-- /.card -->
<!-- jQuery (Include jQuery only once) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Bootstrap 4 -->
<script src="{{asset('AdminLTE')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- DataTables & Plugins -->
<script src="{{asset('AdminLTE')}}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{asset('AdminLTE')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{asset('AdminLTE')}}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{asset('AdminLTE')}}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{asset('AdminLTE')}}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{asset('AdminLTE')}}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{asset('AdminLTE')}}/plugins/jszip/jszip.min.js"></script>
<script src="{{asset('AdminLTE')}}/plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{asset('AdminLTE')}}/plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{asset('AdminLTE')}}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{asset('AdminLTE')}}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{asset('AdminLTE')}}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- AdminLTE App -->
<script src="{{asset('AdminLTE')}}/dist/js/adminlte.min.js"></script>
<script src="{{asset('AdminLTE')}}/plugins/PDFObject/pdfobject.js"></script>
<script src="{{asset('AdminLTE')}}/plugins/PDFObject/pdfobject.min.js"></script>


@include('modal.upload_1')
@include('modal.imageview')
@include('modal.pdfview')
@include('modal.comment')

<!-- Page specific script -->
<script>
  $(document).ready(function () {
    $(document).on('click','.update-status',function (e) {
        e.preventDefault(); // Prevent the default link behavior

        var link = $(this);
        var ticketId = link.data('id')
        var newStatus = link.data('status');
        var newAssignee = link.data('assignee');
		var comment = null;
		console.log('Clicked link with ticket ID:', newStatus);
        // Disable the link to prevent further updates
        link.prop('disabled', true);

        // Send an AJAX request to update the status to 'pending'
        $.ajax({
            url: '/update-ticket/' + ticketId,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include the CSRF token
            },
            data: { 
              status: newStatus,
              assignee: newAssignee,
			  comment,
            },
            success: function (response) {
			console.log('Clicked link with ticket ID:', response.detail);
              $('#status_' + ticketId).text(response.updatedStatus);
              $('#assignee_' + ticketId).text(response.updatedAssigned);
              setTimeout(function() {
                  $('#tbody1').load(document.URL + ' #tbody1');
                  $('#tbody2').load(document.URL + ' #tbody2');
              }, 1000);
            },
            error: function (xhr, status, error) {
                console.error(error);
                // Re-enable the link in case of an error
                link.prop('disabled', false);
            }
        });
    });
});
$(document).ready(function () {
    $('#addTicket').click(function (e) {
        e.preventDefault(); // Prevent the default link behavior

        var formData = $('#ticketForm').serialize();

        console.log('Clicked link with ticket ID:', formData);
        $.ajax({
            url: '/add-ticket',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include the CSRF token
            },
            data: formData,
            success: function (response) {
              console.log('response:', response);
			  $('#tbody2').load(document.URL + ' #tbody2');
              $('#addModal').modal('hide');
            },
            error: function (xhr, status, error, response) {
                console.error(error);
                console.log('gagal goblok ', response);
            }
        });
    });
});

$(document).ready(function() {
        @if ($errors->any())
            $('#addModal').modal('show');
            $('#errorMessage').html('<strong>{{ $errors->first() }}</strong>');
        @endif
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
				console.log('hasil fetch: ', response.image_url);

				var imagesContainer = $('#modalImages');
				var imagesContainer = $('#pdf-viewer');
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

$(document).on('click', 'a[data-target="#solveimagemodal"]', function(event) {
        event.preventDefault(); // Prevent the <a> from navigating to a different page

        // Read the data-id attribute
        var id = $(this).data('id'); // Get the value of the data-id attribute
        $('#id_upload').val(id); 
        $('#solveimagemodal').modal('show');
        $('#displaymodalprogressadmin').modal('hide');
        console.log('Id:', id);
    });

	const fileInput = document.getElementById("image2");

	window.addEventListener('paste', e => {
		console.log('Paste event detected1.');
		fileInput.files = e.clipboardData.files;
	});
</script>
@endsection