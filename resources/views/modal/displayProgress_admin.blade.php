<div class="modal fade bd-example-modal-lg" id="displaymodalprogressadmin" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Progress Ticket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="displayprogressadmin" class="table table-bordered table-hover table-responsive" style="width:100%">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th style="width:30%">title</th>
                    <th style="width:30%">description</th>
                    <th>category</th>
                    <th>assigned_to</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>action</th>
                  </tr>
                  </thead>
                  <tbody style="font-size: 16px">
                  @foreach ($allinProgressTickets as $data)
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{ $data->title }}
                    @if ($data->comments->count() > 0)
                      <a href="#" data-target="#commentsmodal" data-id="{{ $data->id }}">
                        <i class="far fa-comment"></i>
                      </a>
                    @endif
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
                        <span class="bg-warning border border-warning rounded px-1">{{ $data->status }}</span>
                    </td>
                    <td>{{ $data->priority }}</td>
                    <td>
                    <div class="row mb-1">
                        @if ($data->assignedTo->id !== auth()->user()->id)
                          <a href="#" class="change-progress btn btn-sm btn-block btn-warning" data-id="{{ $data->id }}" data-assignee="{{ auth()->user()->id }}">Takeover</a>
                        @endif
                      </div>
                        @if ($data->status === 'In Progress')
                        <div class="row mb-1">
                          <a href="#" class="change-progress btn btn-sm btn-block btn-warning" data-id="{{ $data->id }}" data-status="Open">Untake</a>
                        </div>
                      <div class="row mb-1">
                          <a href="#" class="btn btn-sm btn-primary btn-block btn-success" data-target='#solveimagemodal' data-id="{{ $data->id }}" data-status="To Be Confirmed">done</a>
                      </div>
                      @else
                      <p></p>
                      @endif
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
      $('#displaymodalprogressadmin').on('show.bs.modal', function() {
        $('#displayprogressadmin').load(document.URL + ' #displayprogressadmin');
        $('#allcount1').load(document.URL + ' #allcount1');
        $('#allcount2').load(document.URL + ' #allcount2');
        $('#allcount3').load(document.URL + ' #allcount3');
        $('#allcount4').load(document.URL + ' #allcount4');
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
  $(document).ready(function () {
    $(document).on('click','.change-progress',function (e) {
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
                $('#displaymodalprogressadmin').modal('hide');
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