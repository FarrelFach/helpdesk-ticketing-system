<div class="card">
					  <div class="card-header">
						<div class="row">
						  <div class="col">
							<h3 class="card-title">List Open Ticket</h3>
						  </div>
						</div>
					  </div>
					  <!-- /.card-header -->
					  <div class="card-body">
						<div class="table-responsive">
						<table id="tbody2" class="table table-bordered table-hover table-responsive">
						  <thead>
							  <tr>
									<th>No</th>
									<th>id</th>
									<th style="width:20%">title</th>
                    				<th style="width:18%">description</th>
									<th>Category</th>
									<th>Creator</th>
									<th>Assigned To</th>
									<th>Status</th>
									<th>Priority</th>
									<th>action</th>
							  </tr>
						  </thead>
							<tbody >
							  @foreach ($opentickets as $data)
							  <tr>
								<td>{{$loop->iteration}}</td>
								<td>{{ $data->id }}</td>
								<td>{{ $data->title }} @if ($data->attachment->count() > 0)
									<a href="#" data-target="#imageview" data-id="{{ $data->id }}">
										<i class="far fa-eye"></i>
									</a>
								@endif
								</td>
								<td>{{ $data->description }}</td>
								<td>{{ $data->category->name }}</td>
								<td>{{ $data->creator->name }}</td>
								<td id="assignee_{{ $data->id }}">{{ $data->assignedTo ? $data->assignedTo->name : 'Not Assigned' }}</td>
								<td id="status_{{ $data->id }}">
									@if($data->status == 'Open')
										<span class="bg-success border border-success rounded px-2 py-1">{{ $data->status }}</span>
									@elseif($data->status == 'In Progress')
										<span class="bg-warning border border-warning rounded px-2 py-1">{{ $data->status }}</span>
									@else
										<span class="bg-secondary border border-white rounded px-2 py-1">{{ $data->status }}</span>
									@endif
								</td>
								<td>{{ $data->priority }}</td>
								<td>
									<div class="row">
										<div class="col-6">
											<a href="#" class="update-status btn btn-sm btn-primary" data-id="{{ $data->id }}" data-status="In Progress" data-assignee="{{ auth()->user()->id }}">Take</a>
										</div> 
									</div>
								</td>
							  </tr>
							  @endforeach
							</tbody>
						</table>
						</div>
					  </div>
				  	<!-- /.card-body -->
					</div>