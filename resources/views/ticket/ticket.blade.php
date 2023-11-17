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
                  @foreach ($tickets as $data)
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{ $data->id }}</td>
                    <td>{{ strlen($data->title) > 5 ? substr($data->title, 0, 5) . '...' : $data->title }}</td>
                    <td>{{ $data->category->name }}</td>
                    <td>{{ $data->creator->name }}</td>
                    <td>{{ $data->assignee ? $data->assignee->name : 'Not Assigned' }}</td>
                    <td class="status">
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
                        <div class="col-4">
                          <form action="{{ url('ticket/'.$data->id) }}" method="POST">
								            @csrf
                              <input type="hidden" name="_method" value="DELETE">
                              <button class="btn btn-sm btn-danger btn-block" type="submit">Hapus</button>
                          </form>
                        </div>
                        <div class="col-4">
                          <a href="#" class="update-status btn btn-sm btn-primary btn-block" data-id="{{ $data->id }}" data-status="In Progress">take</a>
                        </div>
                        <div class="col-4">
                          <a class="btn btn-sm btn-primary btn-block">Detail</a>
                        </div>
                        <div class="col-4">
                          <a class="btn btn-sm btn-primary btn-block">Edit</a>
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