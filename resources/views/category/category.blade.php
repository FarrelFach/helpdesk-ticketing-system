@extends('layouts.template')
@section('title', 'List category')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
          <div class="col-6">
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col">
                    <h3 class="card-title">List Tiket</h3>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>no</th>
                    <th>id</th>
                    <th>category</th>
                    <th>action</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($ctg as $data)
                  <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{ $data->id }}</td>
                    <td>{{ $data->name }}</td>
                    <td>
                    <div class="row"> 
                        <div class="col-4">
                          <form action="{{ url('category/'.$data->id) }}" method="POST">
								            @csrf
                              <input type="hidden" name="_method" value="DELETE">
                              <button class="btn btn-sm btn-danger btn-block" type="submit">Hapus</button>
                          </form>
                        </div>
                        <div class="col-4">
                          <a class="btn btn-sm btn-primary btn-block">Edit</a>
                        </div>
                    </div>
                    </td>
                  </tr>
                  @endforeach
                </table>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
          <div clas="col-6">
            <div class="card">
              <div class="card-header">
                    <h3 class="card-title">List Tiket</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <form method="POST" action="{{ url('category') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">category</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nama Kategori">
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                </form>
            </div>
              <!-- /.card-body -->
            </div>
          </div>
        </div>
      </div>
</section>
            <!-- /.card -->
<!-- jQuery (Include jQuery only once) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap 4 -->
<script src="{{asset('AdminLTE')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- DataTables & Plugins -->
<script src="{{asset('AdminLTE')}}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{asset('AdminLTE')}}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="{{asset('AdminLTE')}}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="{{asset('AdminLTE')}}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="{{asset('AdminLTE')}}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="{{asset('AdminLTE')}}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="{{asset('AdminLTE')}}/plugins/jszip/jszip.min.js"></script>
<script src="{{asset('AdminLTE')}}/plugins/pdfmake/pdfmake.min.js"></script>
<script src="{{asset('AdminLTE')}}/plugins/pdfmake/vfs_fonts.js"></script>
<script src="{{asset('AdminLTE')}}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="{{asset('AdminLTE')}}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="{{asset('AdminLTE')}}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<!-- AdminLTE App -->
<script src="{{asset('AdminLTE')}}/dist/js/adminlte.min.js"></script>
@endsection