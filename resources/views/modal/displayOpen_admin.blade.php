<div class="modal fade bd-example-modal-lg" id="displaymodalopenadmin" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Open Ticket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <div class="table-responsive">
                <table id="displayopenadmin" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th style="width: 20%; max-width: 150px; overflow-wrap: break-word;">title</th>
                    <th style="width: 10%; max-width: 100px; overflow-wrap: break-word;">description</th>
                    <th>category</th>
                    <th>assigned_to</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>action</th>
                  </tr>
                  </thead>
                  <tbody style="font-size: 16px">
                  @foreach ($allopenTickets as $data)
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{ $data->title }}
                    @if($data->attachment)
                        @foreach($data->attachment as $attachment)
                            @if($attachment->detail === 'first')
                                <a href="#" data-target="#imageview" data-id="{{ $data->id }}">
                                    <img src="{{ asset('images/' . $attachment->image_url) }}" alt="Image" width="200">
                                </a>
                            @endif
                        @endforeach
                    @endif
                    </td>
                    <td style="max-width: 150px; overflow-wrap: break-word;">{{ $data->description }}</td>
                    <td>{{ $data->category->name }}</td>
                    <td id="assignee_{{ $data->id }}">{{ $data->assignedTo ? $data->assignedTo->name : 'Not Assigned' }}</td>
                    <td id="status_{{ $data->id }}" style="font-size: 14px">
                        <span class="bg-success border border-success rounded p-1">{{ $data->status }}</span>
                    </td>
                    <td>{{ $data->priority }}</td>
                    <td>
                    <div class="row">
                        <div class="col">
                            <a href="#" data-toggle="modal" data-target="displaymodalopenadmin" class="take-ticket btn btn-sm btn-primary btn-block" data-id="{{ $data->id }}" data-status="In Progress" data-assignee="{{ auth()->user()->id }}">take</a>
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
</div>
<script>
  $(document).ready(function () {
      $('#displaymodalopenadmin').on('show.bs.modal', function() {
        $('#displayopenadmin').load(document.URL + ' #displayopenadmin');
        $('#allcount1').load(document.URL + ' #allcount1');
        $('#allcount2').load(document.URL + ' #allcount2');
        $('#allcount3').load(document.URL + ' #allcount3');
        $('#allcount4').load(document.URL + ' #allcount4');
    });
});

$(document).ready(function () {
    $(document).on('click','.take-ticket',function (e) {
        e.preventDefault(); // Prevent the default link behavior

        var link = $(this);
        var ticketId = link.data('id')
        var newStatus = link.data('status');
        var newAssignee = link.data('assignee');

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
              assignee: newAssignee  
            },
            success: function (response) {
                console.log('Clicked link with ticket ID:', response);
                console.log('Clicked link with ticket ID:', response.status);
                console.log('Clicked link with ticket ID:', response.assigned_to);
                $('#allcount1').load(document.URL + ' #allcount1');
                $('#allcount2').load(document.URL + ' #allcount2');
                $('#displaymodalopenadmin').modal('hide');
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