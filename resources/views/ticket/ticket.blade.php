@extends('layouts.template')
@section('title', 'List Ticket')
@section('content')
<section class="content">
    <div class="container-fluid">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
		<li class="nav-item" role="presentation">
			<button class="nav-link" id="open-tab" data-toggle="tab" data-target="#open" type="button" role="tab" aria-controls="open" aria-selected="false">Ticket</button>
		</li>
		@can('isAdmin')
		<li class="nav-item" role="presentation">
			<button class="nav-link active" id="taken-tab" data-toggle="tab" data-target="#taken" type="button" role="tab" aria-controls="taken" aria-selected="true">Taken Ticket</button>
		</li>
		@endcan
    </ul>
    <div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="open" role="tabpanel" aria-labelledby="open-tab">
				  <div class="card">
					  <div class="card-header">
						<div class="row">
						  <div class="col">
							<h3 class="card-title">List Tiket</h3>
						  </div>
						  <div class="col-2">
							<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Buat Tiket</button>
						  </div>
						</div>
					  </div>
					  <!-- /.card-header -->
					  <div class="card-body">
						<div class="table-responsive">
						<table id="tbody2" class="table table-bordered table-hover table-responsive">
						  <thead>
							  <tr>
									<th>No</th>
									<th>id</th>
									<th>Title</th>
									<th>Category</th>
									<th>Creator</th>
									<th>Assigned To</th>
									<th>Status</th>
									<th>Priority</th>
									<th>action</th>
							  </tr>
						  </thead>
							<tbody >
							  @foreach ($opentickets as $data)
							  <tr>
								<td>{{$loop->iteration}}</td>
								<td>{{ $data->id }}</td>
								<td>{{ strlen($data->title) > 30 ? substr($data->title, 0, 30) . '...' : $data->title }}</td>
								<td>{{ $data->category->name }}</td>
								<td>{{ $data->creator->name }}</td>
								<td id="assignee_{{ $data->id }}">{{ $data->assignedTo ? $data->assignedTo->name : 'Not Assigned' }}</td>
								<td id="status_{{ $data->id }}">
									@if($data->status == 'Open')
										<span class="bg-success border border-success rounded p-2">{{ $data->status }}</span>
									@elseif($data->status == 'In Progress')
										<span class="bg-warning border border-warning rounded p-2">{{ $data->status }}</span>
									@else
										<span class="bg-secondary border border-white rounded p-2">{{ $data->status }}</span>
									@endif
								</td>
								<td>{{ $data->priority }}</td>
								<td>
									<div class="row">
										<div class="col">
										  <a href="#" class="btn btn-sm btn-primary btn-block m-2" data-toggle="modal" data-target="#ticketModal1" data-id="{{ $data->id }}">detail</a>
										</div> 
										@can('isAdmin')
										<div class="col-4">
										  <form action="{{ url('ticket/'.$data->id) }}" method="POST">
															@csrf
											  <input type="hidden" name="_method" value="DELETE">
											  <button class="btn btn-sm btn-danger btn-block m-2" type="submit">Hapus</button>
										  </form>
										</div>
										<div class="col-4">
										  <a href="#" class="update-status btn btn-sm btn-primary btn-block m-2" data-id="{{ $data->id }}" data-status="In Progress" data-assignee="{{ auth()->user()->id }}">take</a>
										</div>
										<div class="col-4">
										  <a href="{{ route('ticket.edit', ['ticket' => $data->id]) }}" class="btn btn-sm btn-primary btn-block m-2">Edit</a>
										</div>
										@endcan
									</div>
								</td>
							  </tr>
							  @endforeach
							</tbody>
						</table>
						</div>
					  </div>
				  <!-- /.card-body -->
				</div>
			  </div>
			  @can('isAdmin')
			<div class="tab-pane fade" id="taken" role="tabpanel" aria-labelledby="taken-tab">
				<div class="card">
				  <div class="card-header">
					<div class="row">
					  <div class="col-8">
						<h3 class="card-title"><b>List Tiket In Progress</b></h3>
					  </div>
					  <div class="col-4">
						<a href="/openAll" class="btn btn-sm btn-primary m-2">Open All</a>
						<a href="/empty" class="btn btn-sm btn-primary m-2">Empty table</a>
					  </div>
					</div>
				  </div>
				  <!-- /.card-header -->
				  <div class="card-body">
					<div class="table-responsive">
						<table id="tbody1" class="table table-bordered table-hover table-responsive">
						  <thead>
						  <tr>
								<th>No</th>
								<th>id</th>
								<th>Title</th>
								<th>Category</th>
								<th>Creator</th>
								<th>Assigned To</th>
								<th>Status</th>
								<th>Priority</th>
								<th>action</th>
						  </tr>
						  </thead>
						  <tbody>
						  @foreach ($takentickets as $data)
						  <tr>
							<td>{{$loop->iteration}}</td>
							<td>{{ $data->id }}</td>
							<td>{{ strlen($data->title) > 30 ? substr($data->title, 0,30) . '...' : $data->title }}</td>
							<td>{{ $data->category->name }}</td>
							<td>{{ $data->creator->name }}</td>
							<td id="assignee_{{ $data->id }}">{{ $data->assignedTo ? $data->assignedTo->name : 'Not Assigned' }}</td>
							<td id="status_{{ $data->id }}">
								@if($data->status == 'Open')
									<span class="bg-success border border-success rounded p-2">{{ $data->status }}</span>
								@elseif($data->status == 'In Progress')
									<span class="bg-warning border border-warning rounded p-2">{{ $data->status }}</span>
								@elseif($data->status == 'To Be Confirmed')
									<span class="bg-info border border-info rounded p-2">{{ $data->status }}</span>
								@else
									<span class="bg-secondary border border-white rounded p-2">{{ $data->status }}</span>
								@endif
							</td>
							<td>{{ $data->priority }}</td>
							<td>
							<div class="row"> 
								<div class="col-4">
								  <form action="{{ url('ticket/'.$data->id) }}" method="POST">
													@csrf
									  <input type="hidden" name="_method" value="DELETE">
									  <button class="btn btn-sm btn-danger btn-block m-2" type="submit">Hapus</button>
								  </form>
								</div>
								<div class="col-4">
									<a href="#" class="update-status btn btn-sm btn-info btn-block m-2" data-id="{{ $data->id }}" data-status="To Be Confirmed">Done</a>
								</div>
								<div class="col-4">
								  <button type="button" class="btn btn-sm btn-primary btn-block m-2" data-toggle="modal" data-target="#DetailModal">Detail</button>
								</div>
								<div class="col-4">
								  <a href="/edit/{{$data->id}}" class="btn btn-sm btn-primary btn-block m-2">Edit</a>
								</div>
							</div>
							</td>
						  </tr>
						  @endforeach
						</table>
						</div>
					  </div>
					  <!-- /.card-body -->
					</div>
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

@include('modal.add_ticket')
@include('modal.ticket_detail')
<!-- Page specific script -->
<script>
  $(document).ready(function () {
    $(document).on('click','.update-status',function (e) {
        e.preventDefault(); // Prevent the default link behavior

        var link = $(this);
        var ticketId = link.data('id')
        var newStatus = link.data('status');
        var newAssignee = link.data('assignee');

        // Disable the link to prevent further updates
        link.prop('disabled', true);

        // Send an AJAX request to update the status to 'pending'
        $.ajax({
            url: '/updateticket/' + ticketId,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include the CSRF token
            },
            data: { 
              status: newStatus,
              assignee: newAssignee  
            },
            success: function (response) {
              $('#status_' + ticketId).text(response.updatedStatus);
              $('#assignee_' + ticketId).text(response.updatedAssigned);
              setTimeout(function() {
                  $('#tbody1').load(document.URL + ' #tbody1');
                  $('#tbody2').load(document.URL + ' #tbody2');
              }, 3000);
            },
            error: function (xhr, status, error) {
                console.error(error);
                // Re-enable the link in case of an error
                link.prop('disabled', false);
            }
        });
    });
});

// Attach a click event listener to the <a> element
$(document).on('click', 'a[data-target="#ticketModal1"]', function(event) {
        event.preventDefault(); // Prevent the <a> from navigating to a different page

        // Read the data-id attribute
        var id = $(this).data('id'); // Get the value of the data-id attribute
        console.log('Clicked link with ticket ID:', id);
        // Make an AJAX request to fetch data based on the ID
        $.ajax({
            url: '/fetch-data-ticket/' + id, // Update the URL to include the ID
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include the CSRF token
            },
            success: function(data) {
                    // Access individual properties from the response
                    console.log('Clicked link with ticket ID:', data);
                    var ticket = data[0]; // Assuming the structure remains consistent
                    $('#name').text(ticket.creator.name); // Update content using text() instead of html()
                    $('#title').text(ticket.title);
                    $('#priority').text(ticket.priority);
                    $('#status').text(ticket.status);
                    $('#desc').text(ticket.description);
                    $('#ticketModal1').modal('show');
                  },
            error: function() {
                alert('Failed to fetch data.');
            }
        });
    });
  
    $(document).on('click', 'a[data-target="#editModal1"]', function(event) {
        event.preventDefault(); // Prevent the <a> from navigating to a different page

        // Read the data-id attribute
        var id = $(this).data('id'); // Get the value of the data-id attribute
        console.log('Clicked link with ticket ID:', id);
        // Make an AJAX request to fetch data based on the ID
        $.ajax({
            url: '/fetch-data-ticket/' + id, // Update the URL to include the ID
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include the CSRF token
            },
            success: function(data) {
                    // Access individual properties from the response
                    console.log('Clicked link with ticket ID:', data);
                    var ticket = data[0]; // Assuming the structure remains consistent
                    $('#name').text(ticket.creator.name); // Update content using text() instead of html()
                    $('#title').text(ticket.title);
                    $('#priority').text(ticket.priority);
                    $('#status').text(ticket.status);
                    $('#desc').text(ticket.description);
                    $('#ticketModal1').modal('show');
                  },
            error: function() {
                alert('Failed to fetch data.');
            }
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
</script>
@endsection