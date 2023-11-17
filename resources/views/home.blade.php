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
              <a class="allticket" href="#" data-toggle="modal" data-target="#dataModal" data-id="{{ auth()->user()->id }}"><h3 class="text-white">{{ $count }}</h3></a>

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
                <a href="#" data-toggle="modal" data-target="#dataModal" data-id="Open"><h3 class="text-white">{{ $countOpen }}</h3></a>

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
              <a href="#" data-toggle="modal" data-target="#dataModal" data-id="Closed"><h3 class="text-white"><h3 class="text-white">{{ $countClose }}</h3></a>

                <p>Tiket tertutup</p>
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
              <a href="#" data-toggle="modal" data-target="#dataModal" data-id="Pending"><h3 class="text-white"><h3 class="text-white">{{ $countPending }}</h3></a>

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
<div class="modal fade bd-example-modal-lg" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel">Data from Database</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('modal.display');
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    // Attach a click event listener to the <a> element
    $('a[data-target="#dataModal"]').on('click', function(event) {
        event.preventDefault(); // Prevent the <a> from navigating to a different page

        // Read the data-id attribute
        var id = $(this).data('id'); // Get the value of the data-id attribute

        // Make an AJAX request to fetch data based on the ID
        $.ajax({
            url: '/fetch-data/' + id, // Update the URL to include the ID
            method: 'GET',
            success: function(data) {
                // Clear any existing data in the table
                $('#data-table').empty();

                // Add the fetched data to the table
                $.each(data, function(index, item) {
                    $('#data-table').append('<tr><td>' + item.id + '</td><td>' + item.created_by + '</td><td>' + item.title + '</td><td>' + item.description + '</td><td>' + item.status + '</td><td>' + item.priority + '</td></tr>');
                    // Add more columns as needed
                });
            },
            error: function() {
                alert('Failed to fetch data.');
            }
        });
    });

    // Attach a click event listener to the <a> element
    $('a[class="allticket"]').on('click', function(event) {
        event.preventDefault(); // Prevent the <a> from navigating to a different page

        // Read the data-id attribute
        var id = $(this).data('id'); // Get the value of the data-id attribute

        // Make an AJAX request to fetch data based on the ID
        $.ajax({
            url: '/fetch-dataAll/' + id, // Update the URL to include the ID
            method: 'GET',
            success: function(data) {
                // Clear any existing data in the table
                $('#data-table').empty();

                // Add the fetched data to the table
                $.each(data, function(index, item) {
                    $('#data-table').append('<tr><td>' + item.id + '</td><td>' + item.created_by + '</td><td>' + item.title + '</td><td>' + item.description + '</td><td>' + item.status + '</td><td>' + item.priority + '</td></tr>');
                    // Add more columns as needed
                });
            },
            error: function() {
                alert('Failed to fetch data.');
            }
        });
        console.log('It success getting this:', id);
    });

    $(document).ready(function() {
        @if ($errors->any() || session('error'))
            $('#addUserModal').modal('show');
        @endif
    });
</script>
@endsection
