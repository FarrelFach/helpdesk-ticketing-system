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
              <a class="allticket" href="#" data-toggle="modal" data-target="#dataModal1" data-id="{{ auth()->user()->id }}"><h3 class="text-white">{{ $count }}</h3></a>

                <p>Total Tiket</p>
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
                <a href="#" data-toggle="modal" data-target="#dataModal2" data-id="Open"><h3 class="text-white">{{ $countOpen }}</h3></a>

                <p>Tiket Terbuka</p>
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
              <a href="#" data-toggle="modal" data-target="#dataModal3" data-id="Closed"><h3 class="text-white"><h3 class="text-white">{{ $countProgress }}</h3></a>

                <p>Tiket In Progress</p>
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
              <a href="#" data-toggle="modal" data-target="#dataModal4" data-id="Pending"><h3 class="text-white"><h3 class="text-white">{{ $countTBC }}</h3></a>

                <p>Tiket Pending</p>
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
                <div class="widget-user-image">
                  <img class="img-circle elevation-2" src="@image('/avatar.png')" alt="User Avatar">
                </div>
                <!-- /.widget-user-image -->
                <h3 class="widget-user-username">{{ auth()->user()->name }}</h3>
                <h5 class="widget-user-desc">Anak Magang</h5>
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
@include('modal.displayAll')
@include('modal.displayOpen')
@include('modal.displayToBeConfirmed')
@include('modal.displayProgress')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

@endsection
