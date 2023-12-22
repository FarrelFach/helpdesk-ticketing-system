@extends('layouts.template')
@section('title', 'History')
@section('content')
<section class="content">
<div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col">
                    <h3 class="card-title">History</h3>
                  </div>
                  <div class="col-2">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Buat User</button>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>id</th>
                    <th>Action</th>
                    <th>Ticket_Id</th>
                    <th>Field</th>
                    <th>Old_Value</th>
                    <th>New_Value</th>
                    <th>Created_at</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($history as $data)
                  <tr>
                    <td>{{ $data->id }}</td>
                    <td>{{ $data->action }}</td>
                    <td>{{ $data->ticket_id }}</td>
                    <td>{{ $data->field }}</td>
                    <td>{{ $data->old_value }}</td>
                    <td>{{ $data->new_value }}</td>
                    <td>{{ $data->created_at }}</td>
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
        var userId = link.data('id')
        var statusCell = row.find('.status');
        var newStatus = link.data('status');

        console.log('Clicked link with user ID:', userId);
        console.log('New status:', newStatus);

        // Disable the link to prevent further updates
        link.prop('disabled', true);

        // Send an AJAX request to update the status to 'pending'
        $.ajax({
            url: '/update-user-status/' + userId,
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

    $(document).ready(function() {
        @if ($errors->any())
            $('#myModal').modal('show');
            $('#errorMessage').html('<strong>{{ $errors->first() }}</strong>');
        @endif
    });
</script>
<div class="modal fade bd-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      @include('modal.add_user'); 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
@endsection