@extends('layouts.master')

@section('title', 'Dashboard')

@push('style')
  <style>
    .card-box {
    padding: 20px;
    border-radius: 3px;
    margin-bottom: 13px;
    background-color: #fff;
}

.social-links li a {
    border-radius: 50%;
    color: rgba(121, 121, 121, .8);
    display: inline-block;
    height: 30px;
    line-height: 27px;
    border: 2px solid rgba(121, 121, 121, .5);
    text-align: center;
    width: 30px
}

.social-links li a:hover {
    color: #797979;
    border: 2px solid #797979
}
.thumb-lg {
    height: 130px;
    width: 130px;
}
.img-thumbnail {
    padding: .25rem;
    background-color: #fff;
    border: 1px solid #dee2e6;
    border-radius: .25rem;
    max-width: 100%;
    height: 80%;
}
.text-pink {
    color: #ff679b!important;
}
.btn-rounded {
    border-radius: 2em;
}
.text-muted {
    color: #98a6ad!important;
}
h4 {
    line-height: 22px;
    font-size: 18px;
}
.our-cg{
  margin: 0 auto;
  text-align: center;
  position: absolute;
  top: 22px;
  right: 150px;
  left: 150px;
  font-family: 'Monteserrat', 'Nunito';
  font-size: 29px;
  font-weight: 600;
  color: #373435;
}
  </style>
@endpush
@section('content')
<!-- BEGIN: Content-->
  <div class="row">
    <div class="col-md-12 mb-2">
      <div class="row">
        <div class="col-12 col-xl-8 mb-4 mb-xl-0">
          <h3 class="font-weight-bold">Welcome {{ Auth::user()->nama_pengguna }} 😁</h3>
          <h6 class="font-weight-normal mb-0">Hy you are in mapping competencies aplication, login as
          <span class="text-primary">
            @php
                if(Auth::user()->peran_pengguna == 1){
                  echo 'Admin';
                }
                else if(Auth::user()->peran_pengguna == 2){
                  echo 'CG Leader';
                }
                else{
                  echo 'Anggota';
                }
            @endphp
          </span></h6>
        </div>
        <div class="col-12 col-xl-4">
          <div class="justify-content-end d-flex">
            <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
              <button class="btn btn-sm btn-light bg-white" type="button" id="dropdownMenuDate2" aria-expanded="true">
                {{-- <i class="mdi mdi-calendar"></i>  --}}
                <div id="clock" class="glow"></div>
              </button>
              <button class="btn btn-sm btn-light bg-white" type="button" id="dropdownMenuDate2" aria-expanded="true">
                <div id="date" class="glow mini"></div>
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row" style="margin-bottom: -10px">
    <div class="col-md-6 grid-margin stretch-card" style="margin-bottom: 2rem !important;">
    {{-- <div class="col-md-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body" style="max-height: 250px">
          <h5>Competent Employee</h5>
          <canvas id="barChart" class="p-3 mb-0" style="max-width: 450px; margin-left:50px"></canvas>
        </div>
      </div> --}}
      <div class="card tale-bg">
        <div class="card-people mt-auto" style="padding-top: 0px !important;">
          <img src="{{ asset('assets/images/dashboard/employee.png')}}" alt="people" style="height:264px; padding: 52px 30px 0px 30px">
          <h4 class=" our-cg">We're {{ $data['nama_cg'] }} !</h4>
          <div class="weather-info">
            <div class="d-flex">
              <div class="ml-2">
              </div>
              {{-- <div>
                <h2 class="mb-0 font-weight-normal"><i class="icon-sun mr-2"></i>31<sup>C</sup></h2>
              </div> --}}
              {{-- <div class="ml-2">
                <h4 class="location font-weight-normal">Purwakarta</h4>
                <h6 class="font-weight-normal">Indonesia</h6>
              </div> --}}
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6 grid-margin transparent" style="margin-bottom: 2rem !important;">
      <div class="row">
        <div class="col-md-6 mb-4 stretch-card transparent">
          <div class="card card-tale">
            <div class="card-body">
              <p class="mb-4">CG Name</p>
              <p class="fs-30 mb-2">{{ $data['nama_cg'] }}</p>
              {{-- <p>10.00% (30 days)</p> --}}
            </div>
          </div>
        </div>
        <div class="col-md-6 mb-4 stretch-card transparent">
          <div class="card card-dark-blue">
            <div class="card-body">
              <p class="mb-4">Member Count</p>
              <p class="fs-30 mb-2">{{ $jumlah[0]->cg }}</p>
              {{-- <p>22.00% (30 days)</p> --}}
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 mb-4 mb-lg-0 stretch-card transparent">
          <div class="card card-light-blue">
            <div class="card-body">
              <p class="mb-4">Department</p>
              <p class="fs-30 mb-2">{{  $data['nama_department'] }}</p>
              {{-- <p>2.00% (30 days)</p> --}}
            </div>
          </div>
        </div>
        <div class="col-md-6 stretch-card transparent">
          <div class="card card-light-danger">
            <div class="card-body">
              <p class="mb-4">Rotation</p>
              <p class="fs-30 mb-2">0</p>
              {{-- <p>0.22% (30 days)</p> --}}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    @foreach ($members as $member)
    <div class="col-md-2 ms-6 stretch-card profile-card pl-0 pr-0">
        @php
          $url = "../storage/app/public/".$member->gambar;
          if ((isset($member->gambar) && $member->gambar != "") && file_exists($url)) {
                  $url = "data:image/jpeg;base64,".base64_encode(file_get_contents($url));
          }else{
              $url = asset('assets/images/faces/face0.png');
          }
        @endphp
        <div class="text-center card-box">
          <div class="member-card" style="width: 150px">
            <div class="thumb-lg member-thumb mx-auto"><img src="{{$url}}" class="rounded-circle img-thumbnail" alt="profile-image"></div>
              <div class="float-none" style="height: 140px">
                  <h5 style="height: 40px">{{ ucwords($member->nama_pengguna) }}</h4>
                  <p class="text-muted">{{$member->nama_department}}</span></p>
              </div>
              <div class="d-flex flex-row justify-content-center">
                <button type="button" style="position:absolute; bottom:50px;" class="btn btn-primary btn-rounded" data-toggle="modal" data-target="#modal-detail-user" onclick="detail({{$member->id}})">Detail</button>
              </div>
        </div>
        </div>
      </div>
      @endforeach
    <div class="modal fade" id="modal-detail-user" tabindex="-1" role="dialog" aria-labelledby="modal-detail-user" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header" style="padding: 15px">
            <h4 class="modal-title" id="myModalLabel17">Detail Employee</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="bodyDetail" style="padding: 20px 26px"></div>
          {{-- <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div> --}}
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
      <div class="card position-relative">
        <div class="card-body">
          <div id="detailedReports" class="carousel slide detailed-report-carousel position-static pt-2" data-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <div class="row">
                  <div class="col-md-12 col-xl-3 d-flex flex-column justify-content-start">
                    <div class="ml-xl-4 mt-3">
                    <p class="card-title">Member Count Circle Group</p>
                      <h1 class="text-primary">{{ $total_cg[0]->cg }}</h1>
                      <h3 class="font-weight-500 mb-xl-4 text-primary">Member</h3>
                      <p class="mb-2 mb-xl-0">This total counts the number of employees who have joined the Circle Group on the Nikita application.</p>
                    </div>
                    </div>
                  <div class="col-md-12 col-xl-9">
                    <div class="row">
                      <div class="col-md-6 border-right">
                        <div class="table-responsive mb-3 mb-md-0 mt-3">
                          <table class="table table-borderless report-table">
                            @foreach ($jml_cg as $jml_cg)
                                      <tr>
                                        <td class="text-muted">{{ $jml_cg->nama_cg }}</td>
                                        <td class="w-50 px-0">
                                          <div class="progress progress-md mx-4">
                                            <div class="progress-bar 
                                            @php
                                                if(intval($jml_cg->cg) >= 20){
                                                  echo "bg-primary";
                                                } else if(intval($jml_cg->cg) >= 14){
                                                  echo "bg-info";
                                                } else if(intval($jml_cg->cg) >= 7){
                                                  echo "bg-warning";
                                                }else{
                                                  echo "bg-danger"; 
                                                }
                                            @endphp
                                            " role="progressbar" style="width: {{ $jml_cg->cg }}%" aria-valuenow="{{ $jml_cg->cg }}" aria-valuemin="0" aria-valuemax="100"></div>
                                          </div>
                                        </td>
                                        <td><h5 class="font-weight-bold mb-0">{{ $jml_cg->cg }}</h5></td>
                                      </tr>
                                      {{-- <td>{{ $data->department->nama_department }}</td> --}}
                                        {{-- {{ $data->id_cg }}
                                        {{ $data->id_cg }} --}}
                            @endforeach
                          </table>
                        </div>
                      </div>
                      <div class="col-md-6 mt-3">
                        <canvas id="south-america-chart"></canvas>
                        <div id="south-america-legend"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              {{-- <div class="carousel-item">
                <div class="row">
                  <div class="col-md-12 col-xl-3 d-flex flex-column justify-content-start">
                    <div class="ml-xl-4 mt-3">
                    <p class="card-title">Detailed Reports</p>
                      <h1 class="text-primary">$34040</h1>
                      <h3 class="font-weight-500 mb-xl-4 text-primary">North America</h3>
                      <p class="mb-2 mb-xl-0">The total number of sessions within the date range. It is the period time a user is actively engaged with your website, page or app, etc</p>
                    </div>
                    </div>
                  <div class="col-md-12 col-xl-9">
                    <div class="row">
                      <div class="col-md-6 border-right">
                        <div class="table-responsive mb-3 mb-md-0 mt-3">
                          <table class="table table-borderless report-table">
                            <tr>
                              <td class="text-muted">Illinois</td>
                              <td class="w-100 px-0">
                                <div class="progress progress-md mx-4">
                                  <div class="progress-bar bg-primary" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </td>
                              <td><h5 class="font-weight-bold mb-0">713</h5></td>
                            </tr>
                            <tr>
                              <td class="text-muted">Washington</td>
                              <td class="w-100 px-0">
                                <div class="progress progress-md mx-4">
                                  <div class="progress-bar bg-warning" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </td>
                              <td><h5 class="font-weight-bold mb-0">583</h5></td>
                            </tr>
                            <tr>
                              <td class="text-muted">Mississippi</td>
                              <td class="w-100 px-0">
                                <div class="progress progress-md mx-4">
                                  <div class="progress-bar bg-danger" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </td>
                              <td><h5 class="font-weight-bold mb-0">924</h5></td>
                            </tr>
                            <tr>
                              <td class="text-muted">California</td>
                              <td class="w-100 px-0">
                                <div class="progress progress-md mx-4">
                                  <div class="progress-bar bg-info" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </td>
                              <td><h5 class="font-weight-bold mb-0">664</h5></td>
                            </tr>
                            <tr>
                              <td class="text-muted">Maryland</td>
                              <td class="w-100 px-0">
                                <div class="progress progress-md mx-4">
                                  <div class="progress-bar bg-primary" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </td>
                              <td><h5 class="font-weight-bold mb-0">560</h5></td>
                            </tr>
                            <tr>
                              <td class="text-muted">Alaska</td>
                              <td class="w-100 px-0">
                                <div class="progress progress-md mx-4">
                                  <div class="progress-bar bg-danger" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                              </td>
                              <td><h5 class="font-weight-bold mb-0">793</h5></td>
                            </tr>
                          </table>
                        </div>
                      </div>
                      <div class="col-md-6 mt-3">
                        <canvas id="north-america-chart"></canvas>
                        <div id="north-america-legend"></div>
                      </div>
                    </div>
                  </div>
                </div>
              </div> --}}
            </div>
            <a class="carousel-control-prev" href="#detailedReports" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#detailedReports" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  @php
      $url = "../storage/app/public/".Auth::User()->gambar;
      if ((isset(Auth::User()->gambar) && Auth::User()->gambar != "") && file_exists($url)) {
              $url = "data:image/jpeg;base64,".base64_encode(file_get_contents($url));
      }else{
          $url = asset('assets/images/faces/face0.png');
      }
  @endphp
<!-- END: Content-->
@endsection
@push('script')
<script>
$(document).ready(function() {
  var role = '{{ Auth::user()->peran_pengguna}}';
  // profilecard();
  setInterval(displayTime,1000);

function displayTime(){
  const timeNow = new Date();
  document.getElementById('clock').innerText = "Pukul   " + timeNow.toLocaleString('id-ID',{
    timeStyle:'medium'
  });

  document.getElementById('date').innerText = timeNow.toLocaleString('id-ID',{
    dateStyle:'full'
  });
  // console.log(timeNow);  
}

displayTime();
})

if ($("#south-america-chart").length) {
      var areaData = {
        labels: ["Jan", "Feb", "Mar"],
        datasets: [{
            data: [60, 70, 70],
            backgroundColor: [
              "#4B49AC","#FFC100", "#248AFD",
            ],
            borderColor: "rgba(0,0,0,0)"
          }
        ]
      };
      var areaOptions = {
        responsive: true,
        maintainAspectRatio: true,
        segmentShowStroke: false,
        cutoutPercentage: 78,
        elements: {
          arc: {
              borderWidth: 4
          }
        },      
        legend: {
          display: false
        },
        tooltips: {
          enabled: true
        },
        legendCallback: function(chart) { 
          var text = [];
          text.push('<div class="report-chart">');
            text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[0] + '"></div><p class="mb-0">Total Circle Group</p></div>');
            text.push('<p class="mb-0">{{ $total_cg_name[0]->cg }}</p>');
            text.push('</div>');
            text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[1] + '"></div><p class="mb-0">Total Curriculumn</p></div>');
            text.push('<p class="mb-0">231</p>');
            text.push('</div>');
            text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[2] + '"></div><p class="mb-0">Total Competencies achieved</p></div>');
            text.push('<p class="mb-0">420</p>');
            text.push('</div>');
          text.push('</div>');
          return text.join("");
        },
      }
      var southAmericaChartPlugins = {
        beforeDraw: function(chart) {
          var width = chart.chart.width,
              height = chart.chart.height,
              ctx = chart.chart.ctx;
      
          ctx.restore();
          var fontSize = 3.125;
          ctx.font = "600 " + fontSize + "em sans-serif";
          ctx.textBaseline = "middle";
          ctx.fillStyle = "#000";
      
          var text = "{{ $total_cg[0]->cg }}",
              textX = Math.round((width - ctx.measureText(text).width) / 2),
              textY = height / 2;
      
          ctx.fillText(text, textX, textY);
          ctx.save();
        }
      }
      var southAmericaChartCanvas = $("#south-america-chart").get(0).getContext("2d");
      var southAmericaChart = new Chart(southAmericaChartCanvas, {
        type: 'doughnut',
        data: areaData,
        options: areaOptions,
        plugins: southAmericaChartPlugins
      });
      document.getElementById('south-america-legend').innerHTML = southAmericaChart.generateLegend();
    }

  function detail(id) {
    const url = "{!! route('Member.detail') !!}?id="+id;
    $.ajax({
      type:"get",
      url:url,
      cache:false,
      success:function(html){
          $("#bodyDetail").html(html);
      }
    })
  }

  var data = {
    labels: ["Windy A", "Maria K", "Rezki R", "Chandra P", "Natha"],
    datasets: [{
      label: '# Jumlah Competencies',
      data: [800, 700, 630, 600, 530],
      backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
      ],
      borderColor: [
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
      ],
      borderWidth: 1,
      fill: false
    }]
  };
  var options = {
    scales: {
      yAxes: [{
        ticks: {
          data : ["100%", "81.37%", "70%", "50%", "30%"],
          beginAtZero: true
        }
      }]
    },
    legend: {
      display: false
    },
    elements: {
      point: {
        radius: 0
      }
    }

  };
  if ($("#barChart").length) {
    var barChartCanvas = $("#barChart").get(0).getContext("2d");
    // This will get the first returned node in the jQuery collection.
    var barChart = new Chart(barChartCanvas, {
      type: 'bar',
      data: data,
      options: options
    });
  }
</script>
@endpush
