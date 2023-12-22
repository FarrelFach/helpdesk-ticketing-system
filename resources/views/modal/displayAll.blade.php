<div class="modal fade bd-example-modal-lg" id="displaymodalall" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">All Ticket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="displayall" class="table table-bordered table-hover table-responsive">
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
                  @foreach ($Ticket as $data)
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{ $data->title }}</td>
                    <td>{{ $data->description }}</td>
                    <td>{{ $data->category->name }}</td>
                    <td id="assignee_{{ $data->id }}">{{ $data->assignedTo ? $data->assignedTo->name : 'Not Assigned' }}</td>
                    <td id="status_{{ $data->id }}" style="font-size: 14px">
                        @if($data->status == 'Open')
                            <span class="bg-success border border-success rounded p-1">{{ $data->status }}</span>
                        @elseif($data->status == 'In Progress')
                            <span class="bg-warning border border-warning rounded p-1">{{ $data->status }}</span>
                        @elseif($data->status == 'To Be Confirmed...')
                            <span class="bg-info border border-info rounded p-1">{{ $data->status }}</span>
                        @else
                            <span class="bg-secondary border border-white rounded p-1">{{ $data->status }}</span>
                        @endif
                    </td>
                    <td>{{ $data->priority }}</td>
                    <td>
                    <div class="row">
                        <div class="col">
                        <a href="#" class="btn btn-sm btn-primary btn-block m-2" data-toggle="modal" data-target="#detailModal1" data-id="{{ $data->id }}">detail</a>
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
<div class="modal fade bd-example-modal-lg" id="detailModal1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">detail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputPassword1">Pembuat</label>
                            <span id="name"></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Judul</label>
                        <span id="title"></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Deskripsi</label>
                        <span id="status"></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Status</label>
                        <span id="priority"></span>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Prioritas</label>
                        <span id="desc"></span>
                    </div>
      </div>
      <div class="modal-footer">
      <a href="#" class="btn btn-primary m-2" data-dismiss="modal">kembali</a>  
    </div>
    </div>
  </div>
</div>
<script>
  $(document).ready(function () {
      $('#dataModal1').on('show.bs.modal', function() {
        $('#displayall').load(document.URL + ' #displayall');
    });
});
// Attach a click event listener to the <a> element
$(document).on('click', 'a[data-target="#detailModal1"]', function(event) {
        event.preventDefault(); // Prevent the <a> from navigating to a different page

        // Read the data-id attribute
        var id = $(this).data('id'); // Get the value of the data-id attribute
        console.log('Clicked link with ticket ID:', id);
        // Make an AJAX request to fetch data based on the ID
        $.ajax({
            url: '/fetch-data-ticket-home/' + id, // Update the URL to include the ID
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include the CSRF token
            },
            success: function(data) {
                    // Access individual properties from the response
                    var ticket = data[0][0]; // Assuming the structure remains consistent
                    $('#name').text(ticket.creator.name); // Update content using text() instead of html()
                    $('#title').text(ticket.title);
                    $('#priority').text(ticket.priority);
                    $('#status').text(ticket.status);
                    $('#desc').text(ticket.description);
                    $('#detailModal1').modal('show');
                  },
            error: function() {
                alert('Failed to fetch data.');
            }
        });
    });
</script>