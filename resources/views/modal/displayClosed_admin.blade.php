<div class="modal fade bd-example-modal-lg" id="displaymodalclosedadmin" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Closed Ticket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table id="displayclosedadmin" class="table table-bordered table-hover table-responsive" style="width:100%">
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
                  @foreach ($allclosedTickets as $data)
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
                        <span class="bg-warning border border-warning rounded px-1">{{ $data->status }}</span>
                    </td>
                    <td>{{ $data->priority }}</td>
                    <td>
                      <div class="row">
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
<script>
  $(document).ready(function () {
      $('#displaymodalclosedadmin').on('show.bs.modal', function() {
        $('#displayclosedadmin').load(document.URL + ' #displayclosedadmin');
        $('#allcount1').load(document.URL + ' #allcount1');
        $('#allcount2').load(document.URL + ' #allcount2');
        $('#allcount3').load(document.URL + ' #allcount3');
        $('#allcount4').load(document.URL + ' #allcount4');
    });
});
</script>