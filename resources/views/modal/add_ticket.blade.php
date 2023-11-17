<form method="POST" action="{{ url('ticket') }}" enctype="multipart/form-data">
@csrf
                        <div class="card-body">
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