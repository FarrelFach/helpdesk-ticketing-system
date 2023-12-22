@extends('layouts.template')
@section('title', 'Home')
@section('content')
<section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        @can('isUser')
        <div class="row">
          <div class="col-auto">
              <!-- Small box -->
              <div class="small-box bg-warning px-2">
                  <div class="inner">
                      <a type="button" data-toggle="modal" data-target="#addModal">
                          <h5><i class="fas fa-plus"></i> Buat Ticket</h5>
                      </a>
                  </div>
              </div>
          </div>
      </div>
      @endcan
        <div class="row">
          <div class="col-6 col-lg-3">
            <!-- small box -->
            <div class="small-box bg-success text-center">
              <div class="inner">
                <h7 class="m-n4 font-weight-bold">Click To View</h7>
              @can("isUser")
                <a href="#" data-target="#displaymodalopen"><h3 id="count1" class="text-white">{{ $openCount }}</h3></a>
              @endcan
              @can("isAdmin")
                <a href="#" data-target="#displaymodalopenadmin"><h3 id="allcount1" class="text-white">{{ $allopenCount }}</h3></a>
              @endcan  
                <p>Ticket Terbuka</p>
              </div>
              
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success text-center">
              <div class="inner">
                <h7 class="m-n4 font-weight-bold">Click To View</h7>
              @can("isUser")
                <a href="#" data-target="#displaymodalprogress"><h3 id="count2" class="text-white">{{ $inProgressCount }}</h3></a>
              @endcan
              @can("isAdmin")
                <a href="#" data-target="#displaymodalprogressadmin"><h3 id="allcount2" class="text-white">{{ $allinProgressCount }}</h3></a>
              @endcan 

                <p>Tiket In Progress</p>
                
              </div>
              
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box {{ $tbcCount > 0 ? 'bg-danger' : 'bg-success' }} text-center" id="tbcbox">
              <div class="inner">
                <h7 class="m-n4 font-weight-bold">Click To View</h7>
              @can("isUser")
                <a href="#" data-target="#displaymodaltbc"><h3 id="count3" class="text-white">{{ $tbcCount }}</h3></a>
              @endcan
              @can("isAdmin")
                <a href="#" data-target="#displaymodaltbcadmin"><h3 id="allcount3" class="text-white">{{ $alltbcCount }}</h3></a>
              @endcan 

                <p>Tiket To Be Confirmed</p>
                
              </div>
              
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success text-center">
              <div class="inner">
              <h7 class="m-n4 font-weight-bold">Click To View</h7>
              @can("isUser")
                <a href="#" data-target="#displaymodalclosed"><h3 id="count4" class="text-white">{{ $closedCount }}</h3></a>
              @endcan
              @can("isAdmin")
                <a href="#" data-target="#displaymodalclosedadmin"><h3 id="allcount4" class="text-white">{{ $allclosedCount }}</h3></a>
              @endcan 

                <p>Tiket Closed</p>
                
              </div>
              
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
  <div class="row">
    <div class="col-6">
      <div class="card card-widget widget-user-2">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-success">
                <div class="row">
                  <div class="col-10">
                      <!--div class="widget-user-image">
                        <img class="img-circle elevation-2" src="@image('/avatar.png')" alt="User Avatar">
                      </div>
                    < /.widget-user-image -->
                    <h3 class="widget-user-username">{{ auth()->user()->name }}</h3>
                    <h5 class="widget-user-desc">{{ auth()->user()->department }}</h5>
                  </div>
                  <div class="col-2">
                    <div class="wrapper text-center">
                      @if (auth()->user()->role === 'admin')
                      <h3 class="text-white">{{$allcount}}</h3>
                      @else
                      <h3 class="text-white" id='assignedticket'>{{$count}}</h3>
                      @endif
                      <h5 class="text-white">Total Ticket</h5>
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
                </ul>
              </div>
      </div>
    </div>
  @can('isAdmin')
  <div class="col-6">
    <!-- PIE CHART -->
          <div class="card card-success">
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
  </div>
  @endcan
</section>
<script src="{{asset('AdminLTE')}}/plugins/jquery/jquery.min.js"></script>
<!-- ChartJS -->
<script src="{{asset('AdminLTE')}}/plugins/chart.js/Chart.min.js"></script>

@include('modal.displayOpen')
@include('modal.displayToBeConfirmed')
@include('modal.displayProgress')
@include('modal.displayClosed')
@include('modal.add_ticket')
@include('modal.displayOpen_admin')
@include('modal.displayProgress_admin')
@include('modal.displayToBeConfirmed_admin')
@include('modal.displayClosed_admin')
@include('modal.upload')
@include('modal.imageview')
@include('modal.pdfview')
@include('modal.comment')
<script>
const fileInput1 = document.getElementById("image1");
const fileInput2 = document.getElementById("image2");

window.addEventListener('paste', e => {
  console.log('Paste event detected1.');
  fileInput1.files = e.clipboardData.files;
});
window.addEventListener('paste', e => {
  console.log('Paste event detected2.');
  fileInput2.files = e.clipboardData.files;
});
</script>
<script>
$(document).ready(function () {
    $(document).on('click', 'a[data-target="#displaymodalopen"]', function(event) {
      console.log("berhasil terpanggil open");
      $('#displaymodalopen').modal('show');
    });

    $(document).on('click', 'a[data-target="#displaymodalopenadmin"]', function(event) {
      console.log("berhasil terpanggil open admin");
      $('#displaymodalopenadmin').modal('show');
    });
    
    $(document).on('click', 'a[data-target="#displaymodalprogress"]', function(event) {
      console.log("berhasil terpanggil progress");
      $('#displaymodalprogress').modal('show');
    });
    
    $(document).on('click', 'a[data-target="#displaymodalprogressadmin"]', function(event) {
      console.log("berhasil terpanggil porgress admin");
      $('#displaymodalprogressadmin').modal('show');
    });

    $(document).on('click', 'a[data-target="#displaymodaltbc"]', function(event) {
      console.log("berhasil terpanggil tbc");
      $('#displaymodaltbc').modal('show');
    });

    $(document).on('click', 'a[data-target="#displaymodaltbcadmin"]', function(event) {
      console.log("berhasil terpanggil tbc admin");
      $('#displaymodaltbcadmin').modal('show');
    });

    $(document).on('click', 'a[data-target="#displaymodalclosed"]', function(event) {
      console.log("berhasil terpanggil closed");
      $('#displaymodalclosed').modal('show');
    });

    $(document).on('click', 'a[data-target="#displaymodalclosedadmin"]', function(event) {
      console.log("berhasil terpanggil closed admin");
      $('#displaymodalclosedadmin').modal('show');
    });
});
$(document).ready(function () {
    $('#ticketForm').submit(function(e) {
        e.preventDefault(); // Prevent the default link behavior

        let formData = new FormData(this);

        $.ajax({
            url: '/add-ticket-home',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include the CSRF token
            },
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            cache: false,
            success: function (response) {
              $("#ticketForm")[0].reset();
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

$(document).on('click', 'a[data-target="#imageview"]', function(event) {
	event.preventDefault(); // Prevent the default link behavior
    var ticketId = $(this).data('id'); // Extract ticket ID from data- attribute
    console.log('cek id: ', ticketId);
    $.ajax({
        url: '/tickets/' + ticketId,
		    headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include the CSRF token
            },
        type: 'GET',
        success: function (response) {
				console.log('hasil fetch: ', response);

				var imagesContainer = $('#modalImages');
				imagesContainer.empty();

                var imageUrl = response.image_url;
                var fileType = response.file_type;

                if (fileType === 'pdf') {
                  PDFObject.embed(imageUrl, "#pdf-viewer", {
                  height: 'calc(100vh - 120px)', // Adjust the height of the PDF viewer
                  width: '100%', // Adjust the width as needed
                  pdfOpenParams: {
                    view: 'FitV', // Set PDF view mode (optional)
                    scrollbar: '1', // Show scrollbar (optional)
                  }});
                  $('#pdfview').modal('show');
                } else if (fileType === 'jpg' || fileType === 'jpeg' || fileType === 'png') {
                    // Handle image file display (e.g., display in an image tag)
                    var img = $('<img />').attr('src', imageUrl).attr('alt', 'Ticket Image');
                    
                    img.css('max-width', '100%');
                    img.css('max-height', '100%');

                    imagesContainer.append(img);
                    $('#imageview').modal('show');
                } else {
                    // Handle other file types accordingly
                    // ...
                }
        },
        error: function (error, response) {
            console.error('Error fetching ticket details:', error);
			console.log('hasil fetch: ', response);
        }
    });
});

$(document).on('click', 'a[data-target="#commentsmodal"]', function(event) {
	event.preventDefault(); // Prevent the default link behavior
    var ticketId = $(this).data('id'); // Extract ticket ID from data- attribute
	console.log('cek id: ', ticketId);
    $.ajax({
        url: '/ticketcomments/' + ticketId,
        type: 'GET',
        success: function (response) {
			console.log('cek id: ', response);
            var comments_denied = response.comments_denied;
			var comments_solve = response.comments_solve;
            var modalBody = $('#commentsmodal .modal-body');
            modalBody.empty();

			if (comments_solve || comments_denied) {
                    var maxLength = Math.max(comments_solve.length, comments_denied.length);

                    for (var i = 0; i < maxLength; i++) {
                        var solveComment = comments_solve[i] || {}; // Use empty object if index is out of bounds
                        var deniedComment = comments_denied[i] || {}; // Use empty object if index is out of bounds

                        var cardSolve = `
                            <div class="row">
                                <div class="col">
                                    <div class="card mb-3 bg-success">
										<div class="card-header">
											<div class="row">
												<div class="col">
													<h5 class="card-title">${solveComment.user?.name || ''}</h5>
												</div>
												<div class="col">
													<h5 class="card-title">${solveComment.created_at || ''}</h5>
												</div>
											</div>
										</div>
                                        <div class="card-body">
											<div class="row">
												<p class="card-text">${solveComment.comment_text || ''}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;

                        var cardDenied = `
                            <div class="row">
                                <div class="col">
                                    <div class="card mb-3 bg-danger">
										<div class="card-header">
												<div class="row">
													<div class="col">
														<h5 class="card-title">${solveComment.user?.name || ''}</h5>
													</div>
													<div class="col">
														<h5 class="card-title">${solveComment.created_at || ''}</h5>
													</div>
												</div>
											</div>
                                        <div class="card-body">
                                            <p class="card-text">${deniedComment.comment_text || ''}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;

                        modalBody.append(cardSolve);
                        modalBody.append(cardDenied);
                    }
                } else {
                    modalBody.append('<p>No comments available.</p>');
                }


			$('#commentsmodal').modal('show');
			},
        error: function (error, response) {
            console.error('Error fetching ticket details:', error);
			console.log('cek response: ', response);
        }
    });
});
</script>
@endsection
