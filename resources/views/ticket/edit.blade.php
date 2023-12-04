@extends('layouts.template')
@section('title', 'Detail Ticket')
@section('content')
<form method="POST" action="{{ url('ticket/update') }}" enctype="multipart/form-data">
				@csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Pembuat</label>
                            <p>{{ $Ticket->id }}</p>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Pembuat</label>
                            <p></p>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Tanggal Dibuat</label>
                            <p>{{ $Ticket->created_at }}</p>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Judul</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="judul" placeholder="Enter judul" value="{{$Ticket->title}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Kategori</label>
                            <select name="category" class="custom-select mb-3" required>
                            @foreach ($Category as $data)
                                <option value="{{$data->id}}">{{$data->name}}</option>
                            @endforeach
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
                        <label for="exampleInputEmail1">Assigned To</label>
                            <select name="category" class="custom-select mb-3" required>
                            @foreach ($user as $data)
                                <option value="{{$data->id}}">{{$data->name}}</option>
                            @endforeach
                        <div class="form-group">
                            <label for="exampleInputEmail1">Deskripsi</label>
                            <textarea type="text" class="form-control" id="description" name="description" placeholder="Enter description" rows="3" value="{{$Ticket->description}}"></textarea>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
@endsection