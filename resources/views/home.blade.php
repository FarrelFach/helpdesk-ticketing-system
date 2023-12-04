@extends('layouts.template')
@section('title', 'Home')
@section('content')
<section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success text-center">
              <div class="inner">
              <a href="#" data-target="#dataModal2"><h3 class="text-white">{{ $countOpen }}</h3></a>

                <p>Ticket Terbuka</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success text-center">
              <div class="inner">
                <a href="#" data-target="#dataModal3"><h3 class="text-white">{{ $countProgress }}</h3></a>

                <p>Tiket In Progress</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success text-center">
              <div class="inner">
              <a href="#" data-target="#dataModal4"><h3 id="tbcount" class="text-white">{{ $countTBC }}</h3></a>

                <p>Tiket To Be Confirmed</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success text-center">
              <div class="inner">
              <a href="#" data-target="#dataModal5"><h3 class="text-white">{{ $countClosed }}</h3></a>

                <p>Tiket Closed</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
  <div class="row">
    <div class="col">
      <div class="card card-widget widget-user-2">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-success">
                <div class="row">
                  <div class="col-8">
                    <div class="widget-user-image">
                      <img class="img-circle elevation-2" src="@image('/avatar.png')" alt="User Avatar">
                    </div>
                <!-- /.widget-user-image -->
                    <h3 class="widget-user-username">{{ auth()->user()->name }}</h3>
                    <h5 class="widget-user-desc">Anak Magang</h5>
                  </div>
                  <div class="col-4">
                    <div class="container justify-content-center m-2">
                      <h3 class="text-white"><h1 class="widget-user-username text-center text-white">{{$count}}</h1>
                      <h5 class="widget-user-desc text-center">Total Ticket</h5>
                      <a href="#" class="btn btn-sm btn-success text-center" data-toggle="modal" data-target="#dataModal1"><h5>See All</h5></a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer p-0">
                <ul class="list-group flex-column">
                  <li class="list-group-item">
                      NIK: <b>{{ auth()->user()->nik }}</b>
                  </li>
                  <li class="list-group-item">
                      Departement: <b>{{ auth()->user()->department }}</b>
                  </li>
                  <li class="list-group-item">
                      Kelamin: <b>Laki-laki</b>
                  </li>
                  <li class="list-group-item">
                      Followers <span class="float-right badge bg-danger">842</span>
                  </li>
                </ul>
              </div>
            </div>
      </div>
    </div>
  </div>
</section>
<script src="{{asset('AdminLTE')}}/plugins/jquery/jquery.min.js"></script>
@include('modal.displayAll')
@include('modal.displayOpen')
@include('modal.displayToBeConfirmed')
@include('modal.displayProgress')
@include('modal.displayClosed')
@include('modal.test')
<script>
$(document).ready(function () {
    $(document).on('click', 'a[data-target="#dataModal1"]', function(event) {
      console.log("berhasil terpanggil");
      $('#dataModal1').modal('show');
    });
    
    
    $(document).on('click', 'a[data-target="#dataModal2"]', function(event) {
      console.log("berhasil terpanggil");
      $('#dataModal2').modal('show');
    });
    
    $(document).on('click', 'a[data-target="#dataModal3"]', function(event) {
      console.log("berhasil terpanggil");
      $('#dataModal3').modal('show');
    });
   
    $(document).on('click', 'a[data-target="#dataModal4"]', function(event) {
      console.log("berhasil terpanggil");
      $('#dataModal4').modal('show');
    });
    $(document).on('click', 'a[data-target="#dataModal5"]', function(event) {
      console.log("berhasil terpanggil");
      $('#dataModal5').modal('show');
    });
});
  </script>
@endsection
