@extends('layouts.template')
@section('title', 'Detail Ticket')
@section('content')
<section class="content">
<div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Nama Pembuat</label>
                            <p>{{ $ticket->creator_name }}</p>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Tanggal Dibuat</label>
                            <p>{{ $ticket->created_at }}</p>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Judul</label>
                            <p>{{ $ticket->title }}</p>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Deskripsi</label>
                            <p>{{ $ticket->description }}</p>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Status</label>
                            <p>{{ $ticket->status }}</p>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Prioritas</label>
                            <p>{{ $ticket->priority }}</p>
                    </div>
                    <div class="form-group">
                        <a class="btn btn-primary btn-block" href="{{ route('ticket') }}">Kembali</a>
                    </div>
@endsection