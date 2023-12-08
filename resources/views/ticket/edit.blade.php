@extends('layouts.template')
@section('title', 'Detail ticket')
@section('content')
<section class="content">
<div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="row">
                  <div class="col-8">
                    <h3 class="card-title"><b>List Tiket In Progress</b></h3>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <form method="POST" action="{{ url('ticket/update') }}" enctype="multipart/form-data">
				@csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Pembuat</label>
                            <p>{{ $ticket->id }}</p>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Pembuat</label>
                            <p>{{ $ticket->creator->name }}</p>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Tanggal Dibuat</label>
                            <p>{{ $ticket->created_at }}</p>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Judul</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="judul" placeholder="Enter judul" value="{{$ticket->title}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Kategori</label>
                            <select name="category" class="custom-select mb-3" required>
                            @foreach ($Category as $data)
                                <option value="{{$data->id}}">{{$data->name}}</option>
                            @endforeach
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Prioritas</label>
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
                        <label>Assigned To</label>
                            <select name="category" class="custom-select mb-3" required>
                            @foreach ($user as $data)
                                <option value="{{$data->id}}">{{$data->name}}</option>
                            @endforeach
                        <div class="form-group">
                            <label for="exampleInputEmail1">Deskripsi</label>
                            <textarea type="text" class="form-control" id="description" name="description" placeholder="Enter description" rows="3" value="{{$ticket->description}}"></textarea>
                        </div>
                        <!-- /.card-body -->

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
@endsection