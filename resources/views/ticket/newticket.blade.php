@extends('layouts.template')
@section('title', 'List Ticket')
@section('content')
<section class="content">
<div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col">
                    <h3 class="card-title">List Tiket</h3>
                  </div>
                  <div class="col-2">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">Buat Tiket</button>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                        <th>Id</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Creator</th>
                        <th>Assigned To</th>
                        <th>Category</th>
                        <th>action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->id }}</td>
                            <td>{{ $ticket->title }}</td>
                            <td>{{ $ticket->status }}</td>
                            <td>{{ $ticket->priority }}</td>
                            <td>{{ $ticket->creator->name }}</td>
                            <td>{{ $ticket->assignee ? $ticket->assignee->name : 'Not Assigned' }}</td>
                            <td>{{ $ticket->category->name }}</td>
                            <td>
                              <div class="row">
                                <div class="col-4">
                                  <form action="{{ url('ticket/'.$ticket->id) }}" method="POST">
                                    @csrf
                                      <input type="hidden" name="_method" value="DELETE">
                                      <button class="btn btn-sm btn-danger btn-block m-2" type="submit">Hapus</button>
                                  </form>
                                  </div>
                                  <div class="col-4">
                                  <a href="#" class="update-status btn btn-sm btn-primary btn-block m-2" data-id="{{ $ticket->id }}" data-status="open">take</a>
                                  </div>
                                  <div class="col-4">
                                  <a class="btn btn-sm btn-primary btn-block m-2">Detail</a>
                                  </div>
                                  <div class="col-4">
                                  <a class="btn btn-sm btn-primary btn-block m-2">Edit</a>
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
      </div>
</section>
            <!-- /.card -->
<!-- jQuery (Include jQuery only once) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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


<!-- Page specific script -->
<script>
  $(document).ready(function () {
    $('.update-status').click(function (e) {
        e.preventDefault(); // Prevent the default link behavior

        var link = $(this);
        var row = link.closest('tr');
        var ticketId = link.data('id')
        var statusCell = row.find('.status');
        var newStatus = link.data('status');

        console.log('Clicked link with ticket ID:', ticketId);
        console.log('New status:', newStatus);

        // Disable the link to prevent further updates
        link.prop('disabled', true);

        // Send an AJAX request to update the status to 'pending'
        $.ajax({
            url: '/update-ticket-status/' + ticketId,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include the CSRF token
            },
            data: { status: newStatus },
            success: function (response) {
                // Handle the response from the server
                if (response.success) {
                    // Update the status column with the new status
                    statusCell.html('<span class="bg-warning border border-warning rounded">' + newStatus + '</span>');
                } else {
                    alert('Failed to update status.');
                    // Re-enable the link if there was an error
                    link.prop('disabled', false);
                }
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
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      @include('modal.add_ticket'); 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
@endsection