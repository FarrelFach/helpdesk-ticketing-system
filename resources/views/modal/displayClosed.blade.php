<div class="modal fade bd-example-modal-lg" id="displaymodalclosed" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Closed Ticket</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <div class="modal-body">
                <table id="displayclosed" class="table table-bordered table-hover table-responsive" style="width:100%">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th style="width:30%">title</th>
                    <th style="width:30%">description</th>
                    <th>category</th>
                    <th>assigned_to</th>
                    <th>Status</th>
                    <th>Priority</th>
                  </tr>
                  </thead>
                  <tbody style="font-size: 16px">
                  @foreach ($closedTickets as $data)
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
                    @if ($data->attachment)
                        @foreach ($data->attachment as $attachment)
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
                        <span class="bg-success border border-success rounded p-1">{{ $data->status }}</span>
                    </td>
                    <td>{{ $data->priority }}</td>
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
      $('#displaymodalclosed').on('show.bs.modal', function() {
        $('#displayclosed').load(document.URL + ' #displayclosed');
        $('#count1').load(document.URL + ' #count1');
        $('#count2').load(document.URL + ' #count2');
        $('#count3').load(document.URL + ' #count3');
        $('#count4').load(document.URL + ' #count4');
    });
});
</script>