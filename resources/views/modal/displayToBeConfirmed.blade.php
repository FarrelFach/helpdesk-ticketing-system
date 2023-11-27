<div class="modal fade bd-example-modal-lg" id="dataModal4" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel">Data from Database</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="tbody" class="table table-bordered table-hover table-responsive">
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
                          <a href="#" class="update-status btn btn-sm btn-primary btn-block" data-id="{{ $data->id }}" data-status="Closed">accept</a>
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
<!-- jQuery (Include jQuery only once) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function () {
    $('.update-status').click(function (e) {
        e.preventDefault(); // Prevent the default link behavior

        var link = $(this);
        var ticketId = link.data('id')
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
              $('#status_' + ticketId).text(response.updatedStatus);
              setTimeout(function() {
                  $('#tbody').load(document.URL + ' #tbody');
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
</script>