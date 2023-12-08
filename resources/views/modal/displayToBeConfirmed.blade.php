<div class="modal fade bd-example-modal-lg" id="dataModal4" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data from Database</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="tbody1" class="table table-bordered table-hover table-responsive">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>title</th>
                    <th>category</th>
                    <th>assigned_to</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>action</th>
                  </tr>
                  </thead>
                  <tbody id="data-table" style="font-size: 16px">
                  @foreach ($tbctickets as $data)
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{ strlen($data->title) > 35 ? substr($data->title, 0, 35) . '...' : $data->title }}</td>
                    <td>{{ $data->category->name }}</td>
                    <td id="assignee_{{ $data->id }}">{{ $data->assignedTo ? $data->assignedTo->name : 'Not Assigned' }}</td>
                    <td id="status_{{ $data->id }}">
                        <span class="bg-info border border-info rounded p-1">{{ $data->status }}</span>
                    </td>
                    <td>{{ $data->priority }}</td>
                    <td>
                    <div class="row">
                        <div class="col">
                          <a href="#" class="btn btn-sm btn-primary btn-block" data-dismiss="modal" data-target="#Confirmation" data-id="{{$data->id}}">accept</a>
                        </div>
                        <div class="col">
                          <a class="btn btn-sm btn-primary btn-block">Detail</a>
                        </div>
                    </div>
                    </td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="Confirmation" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data from Database</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <form id="myForm" method="POST">
                  {{ csrf_field() }}
                  <input type=text id="id" name="id">
                  <h5>Terima Penyelesaian?</h5>
                <div >
                <button type=submit id="submitFormNo" data-status="Open">Denied</button>
                <button type=submit id="submitFormYes" data-status="Closed">Accept</button>
                </div>
              </form>
              </div>
            </div>
        </div>
    </div>
</div>
<!-- jQuery (Include jQuery only once) -->
<script>
  $(document).on('click', 'a[data-target="#Confirmation"]', function(event) {
        event.preventDefault(); // Prevent the <a> from navigating to a different page

        // Read the data-id attribute
        var id = $(this).data('id'); // Get the value of the data-id attribute
        $('#id').val(id); 
        $('#Confirmation').modal('show');
        console.log('The fuck:', id);
    });
    
    $(document).ready(function () {
      $('#dataModal4').on('show.bs.modal', function() {
        $('#tbody1').load(document.URL + ' #tbody1');
    });
  });

  $(document).ready(function () {
    $('#submitFormNo').click(function (e) {
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
            data: { formData, status: newStatus,},
            success: function (response) {
              console.log('response:', response);
              console.log('status: ', response.status);
              console.log('id: ', response.id);
              $('#Confirmation').modal('hide');
              $('#dataModal4').modal('show');
              $('#count3').load(document.URL + ' #count3');
              $('#count4').load(document.URL + ' #count4');
            },
            error: function (xhr, status, error, response) {
                console.error(error);
                console.log('gagal goblok ', response);
            }
        });
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
              $('#dataModal4').modal('show');
              $('#tbcount').load(document.URL + ' #tbcount');
            },
            error: function (xhr, status, error) {
                console.error(error);
                console.log('gagal goblok');
            }
        });
    });
});
</script>