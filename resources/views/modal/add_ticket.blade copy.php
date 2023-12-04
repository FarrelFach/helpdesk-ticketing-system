<div class="modal fade bd-example-modal-lg" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="POST" action="{{ url('ticket') }}" enctype="multipart/form-data">
				@csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Pembuat</label>
                            <p>{{ auth()->user()->name }}</p>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Tanggal Dibuat</label>
                            <p>{{ now()->format('Y-m-d') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Judul</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="judul" placeholder="Enter judul">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Deskripsi</label>
                            <textarea type="text" class="form-control" id="description" name="description" placeholder="Enter description" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                        <label for="exampleInputEmail1">Prioritas (Tidak Wajib)</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="prioritas" value="low">
                                <label class="form-check-label">Rendah</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="prioritas" value="medium">
                                <label class="form-check-label">Sedang</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="prioritas" value="high">
                                <label class="form-check-label">Tinggi</label>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>