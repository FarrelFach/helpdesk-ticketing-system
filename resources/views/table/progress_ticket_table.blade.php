<div class="card">
				  <div class="card-header">
					<div class="row">
					  <div class="col-8">
						<h3 class="card-title"><b>List Tiket In Progress</b></h3>
					  </div>
					  <div class="col-4">
						<a href="/openAll" class="btn btn-sm btn-primary m-2">Open All</a>
						<a href="/empty" class="btn btn-sm btn-primary m-2">Empty table</a>
					  </div>
					</div>
				  </div>
				  <!-- /.card-header -->
				  <div class="card-body">
					<div class="table-responsive">
						<table id="tbody1" class="table table-bordered table-hover table-responsive">
						  <thead>
						  <tr>
								<th>No</th>
								<th>id</th>
								<th style="width:20%">title</th>
                    			<th style="width:18%">description</th>
								<th>Creator</th>
								<th>Assigned To</th>
								<th>Status</th>
								<th>Priority</th>
								<th>action</th>
						  </tr>
						  </thead>
						  <tbody>
						  @foreach ($takentickets as $data)
						  <tr>
							<td>{{$loop->iteration}}</td>
							<td>{{ $data->id }}</td>
							<td>{{ $data->title }}
								@if ($data->attachment->count() > 0)
									<a href="#" data-toggle="modal" data-target="#imageview" data-id="{{ $data->id }}">
										<i class="far fa-eye"></i>
									</a>
								@endif
								@if ($data->comments->count() > 0)
									<a href="#" data-target="#commentsmodal" data-id="{{ $data->id }}">
										<i class="far fa-comment"></i>
									</a>
								@endif
							</td>
							<td>{{ $data->category->name }}</td>
							<td>{{ $data->creator->name }}</td>
							<td id="assignee_{{ $data->id }}">{{ $data->assignedTo ? $data->assignedTo->name : 'Not Assigned' }}</td>
							<td id="status_{{ $data->id }}">
								@if($data->status == 'Open')
									<span class="bg-success border border-success rounded p-2">{{ $data->status }}</span>
								@elseif($data->status == 'In Progress')
									<span class="bg-warning border border-warning rounded p-2">{{ $data->status }}</span>
								@elseif($data->status == 'To Be Confirmed')
									<span class="bg-info border border-info rounded p-2">{{ $data->status }}</span>
								@else
									<span class="bg-secondary border border-white rounded p-2">{{ $data->status }}</span>
								@endif
							</td>
							<td>{{ $data->priority }}</td>
							<td>						
							<div class="row mb-2">
								@if ($data->assignedTo->id !== auth()->user()->id)
								<div class="col">
									<a href="#" class="update-status btn btn-sm btn-block btn-warning" data-id="{{ $data->id }}" data-assignee="{{ auth()->user()->id }}">Takeover</a>
								</div> 
								@endif
								@if ($data->status === 'In Progress')
								<div class="col">
									<a href="#" class="update-status btn btn-sm btn-block btn-warning" data-id="{{ $data->id }}" data-status="Open">Untake</a>
								</div>
							</div>
							<div class="row">
								<div class="col">
									<a href="#" class="btn btn-sm btn-primary btn-block btn-success" data-target='#solveimagemodal' data-id="{{ $data->id }}" data-status="To Be Confirmed">done</a>
								</div>
							</div>
							@else
							<p></p>
							@endif	
							</td>
						  </tr>
						  @endforeach
						</table>
					</div>
				  </div>
					  <!-- /.card-body -->
				</div>