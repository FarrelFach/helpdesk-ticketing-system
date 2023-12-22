<div class="modal fade bd-example-modal-lg" id="displaymodaltbc" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">To Be Confirmed Ticket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="displaytbc" class="table table-bordered table-hover table-responsive" style="width:100%">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th style="width:30%">title</th>
                    <th style="width:25%">description</th>
                    <th>category</th>
                    <th>assigned_to</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>action</th>
                  </tr>
                  </thead>
                  <tbody style="font-size: 16px">
                  @foreach ($tbcTickets as $data)
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
                    @if ($data->attachments)
                        @foreach ($data->attachments as $attachment)
                            @if ($attachment->detail === 'second')
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
                        <span class="bg-info border border-info rounded p-1">{{ $data->status }}</span>
                    </td>
                    <td>{{ $data->priority }}</td>
                    <td>
                    <div class="row">
                      @can('isUser')
                        <div class="col">
                          <a href="#" class="btn btn-sm btn-primary btn-block" data-dismiss="modal" data-target="#Confirmation" data-id="{{$data->id}}">accept</a>
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
    </div>
</div>
@include('modal.confirmation')
<!-- jQuery (Include jQuery only once) -->
<script>
  $(document).on('click', 'a[data-target="#Confirmation"]', function(event) {
        event.preventDefault(); // Prevent the <a> from navigating to a different page

        // Read the data-id attribute
        var id = $(this).data('id'); // Get the value of the data-id attribute
        $('#id').val(id); 
        console.log('The fuck:', id);
        $('#Confirmation').modal('show');
        var ticketId = $(this).data('id');

    $(document).ready(function () {
      $('#displaymodaltbc').on('show.bs.modal', function() {
        $('#displaytbc').load(document.URL + ' #displaytbc');
        $('#count1').load(document.URL + ' #count1');
        $('#count2').load(document.URL + ' #count2');
        $('#count3').load(document.URL + ' #count3');
        $('#count4').load(document.URL + ' #count4');
      });
    });
});
</script>