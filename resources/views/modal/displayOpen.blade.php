<div class="modal fade bd-example-modal-lg" id="dataModal2" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data from Database</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-hover table-responsive">
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
                  @foreach ($opentickets as $data)
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{ strlen($data->title) > 35 ? substr($data->title, 0, 35) . '...' : $data->title }}</td>
                    <td>{{ $data->category->name }}</td>
                    <td id="assignee_{{ $data->id }}">{{ $data->assignedTo ? $data->assignedTo->name : 'Not Assigned' }}</td>
                    <td id="status_{{ $data->id }}">
                        <span class="bg-success border border-success rounded p-1">{{ $data->status }}</span>
                    </td>
                    <td>{{ $data->priority }}</td>
                    <td>
                    <div class="row">
                        <div class="col">
                          <a class="btn btn-sm btn-primary">Detail</a>
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