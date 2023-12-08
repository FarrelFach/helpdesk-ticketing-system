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
              <h7 class="m-n4 font-weight-bold">Click To View</h7>
              <a href="#" data-target="#dataModal2"><h3 id="count1" class="text-white">{{ $countOpen }}</h3></a>
                
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
              <h7 class="m-n4 font-weight-bold">Click To View</h7>
                <a href="#" data-target="#dataModal3"><h3 id="count2" class="text-white">{{ $countProgress }}</h3></a>

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
            <div class="small-box {{ $countTBC > 0 ? 'bg-danger' : 'bg-success' }} text-center">
              <div class="inner">
              <h7 class="m-n4 font-weight-bold">Click To View</h7>
              <a href="#" data-target="#dataModal4"><h3 id="count3" class="text-white">{{ $countTBC }}</h3></a>

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
              <h7 class="m-n4 font-weight-bold">Click To View</h7>
              <a href="#" data-target="#dataModal5"><h3 id="count4" class="text-white">{{ $countClosed }}</h3></a>

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
    <div class="col-12">
              <!-- small box -->
              <div class="small-box bg-success text-center">
                <div class="inner">
                <a type="button" data-toggle="modal" data-target="#addModal"><b style="font-size: 20px">BUAT TICKET</b></a>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
              </div>
            </div>
      </div>
  <div class="row">
    <div class="col">
      <div class="card card-widget widget-user-2">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-success">
                <div class="row">
                  <div class="col-10">
                    <div class="widget-user-image">
                      <img class="img-circle elevation-2" src="@image('/avatar.png')" alt="User Avatar">
                    </div>
                <!-- /.widget-user-image -->
                    <h3 class="widget-user-username">{{ auth()->user()->name }}</h3>
                    <h5 class="widget-user-desc">Anak Magang</h5>
                  </div>
                  <div class="col-2">
                    <div class="wrapper text-center">
                      <h3 class="text-white">{{$count}}</h3>
                      <h5 class="text-white">Total Ticket</h5>
                      <a class="text-white" href="#" data-toggle="modal" data-target="#dataModal1"><h5>See All</h5></a>
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
  @can('isAdmin')
  <div class="row mx-2">
    <!-- PIE CHART -->
    <div class="card card-danger">
              <div class="card-header">
                <h3 class="card-title">Pie Chart</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
  </div>
  @endcan
</section>
<script src="{{asset('AdminLTE')}}/plugins/jquery/jquery.min.js"></script>
<!-- ChartJS -->
<script src="{{asset('AdminLTE')}}/plugins/chart.js/Chart.min.js"></script>
@include('modal.displayAll')
@include('modal.displayOpen')
@include('modal.displayToBeConfirmed')
@include('modal.displayProgress')
@include('modal.displayClosed')
@include('modal.add_ticket')
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
$(document).ready(function () {
    $('#addTicket').click(function (e) {
        e.preventDefault(); // Prevent the default link behavior

        var formData = $('#ticketForm').serialize();

        console.log('Clicked link with ticket ID:', formData);
        $.ajax({
            url: '/add-ticket-home',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include the CSRF token
            },
            data: formData,
            success: function (response) {
              console.log('response:', response);
              $('#count1').load(document.URL + ' #count1');
              $('#addModal').modal('hide');
            },
            error: function (xhr, status, error, response) {
                console.error(error);
                console.log('gagal goblok ', response);
            }
        });
    });
});

$(document).ready(function() {
        @if ($errors->any())
            $('#addModal').modal('show');
            $('#errorMessage').html('<strong>{{ $errors->first() }}</strong>');
        @endif
    });
    var dataFromDB = <?php echo json_encode($dataFromDB); ?>;

    var labels = dataFromDB.map(item => item.category_id);
    var values = dataFromDB.map(item => item.count);

    var ctx = document.getElementById('pieChart').getContext('2d');
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.6)',
                    'rgba(54, 162, 235, 0.6)',
                    'rgba(255, 206, 86, 0.6)',
                    // Add more colors as needed
                ]
            }]
        },
        options: {
            // Additional options for your chart
        }
    });
  </script>
@endsection
