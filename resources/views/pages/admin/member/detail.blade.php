<style>
.account-settings .user-profile {
    margin: 0 0 1rem 0;
    padding-bottom: 1rem;
    text-align: center;
}
.account-settings .user-profile .user-avatar {
    margin: 0 0 1rem 0;
}
.account-settings .user-profile .user-avatar img {
    width: 90px;
    height: 90px;
    -webkit-border-radius: 100px;
    -moz-border-radius: 100px;
    border-radius: 100px;
}
.account-settings .user-profile h5.user-name {
    margin: 0 0 0.5rem 0;
}
.account-settings .user-profile h6.user-email {
    margin: 0;
    font-size: 0.8rem;
    font-weight: 400;
    color: #9fa8b9;
}
.account-settings .about {
    margin: 2rem 0 0 0;
    text-align: center;
}
.account-settings .about h5 {
    margin: 0 0 15px 0;
    color: #007ae1;
}
.account-settings .about p {
    font-size: 0.825rem;
}
.form-control {
    border: 1px solid #cfd1d8;
    -webkit-border-radius: 2px;
    -moz-border-radius: 2px;
    border-radius: 2px;
    font-size: .825rem;
    background: #ffffff;
    color: #2e323c;
}

.card {
    background: #ffffff;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    border: 0;
    margin-bottom: 1rem;
}

</style>
@php
        $a = 0;
        $b = 0;
        $c = 0;
        $total = 0;
        for ($i=0; $i < count($counting) ; $i++) { 
          $total += $counting[$i]->cnt; 
          if ($counting[$i]->level == "A") {
            $a = $counting[$i]->cnt;
          }elseif ($counting[$i]->level == "B") {
            $b = $counting[$i]->cnt;
          }elseif($counting[$i]->level == "I"){
            $c = $counting[$i]->cnt;
          }
        }
      @endphp
      <div class="container">
        <div class="row gutters">
        <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12 pl-0">
          <div class="card h-100">
            <div class="card-body">
              <div class="account-settings">
                <div class="user-profile">
                  <div class="user-avatar">
                    @php
                    $url = "../storage/app/public/".$user->gambar;
                    if (((isset($user->gambar) && $user->gambar != "")) && file_exists($url)) {
                        $url = "data:image/jpeg;base64,".base64_encode(file_get_contents($url));
                    }else{
                        $url = asset('assets/images/faces/face0.png');
                    }
                @endphp
                <img src="{{$url}}" style="height: 180px;width:180px;" class="rounded-circle img-thumbnail m-auto" />
                    {{-- <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Maxwell Admin"> --}}
                  </div>
                  <h5 class="user-name">{{$user->nama_pengguna}}</h5>
                  <h6 class="user-email">{{ $user->nama_cg }}</h6>
                </div>
              </div>
              <div class="text-primary mb-3">
                <h5 class="text-center">Curriculum Finish</h5>
              </div>
              <div class="row">
                <div class="col-12">
                  <canvas id="curriculum-finish"></canvas>
                  <div id="curriculum-finish-legend"></div>
                </div>
              </div>
            </div>
            </div>
          </div>
          <div class="col-xl-8 col-lg-8 col-md-8 col-sm-8 col-8">
            <div class="card h-100">
              <div class="card-body">
                <div class="row gutters">
                  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <h6 class="mb-2 text-primary">Data Personal</h6>
                  </div>
                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                      <label for="nik">NIK</label>
                      <input type="text" class="form-control" id="nik" placeholder="nik" value="{{$user->nik}}" disabled>
                    </div>
                  </div>
                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                      <label for="role">Role</label>
                      <input type="text" class="form-control" id="role" placeholder="peran pengguna" value="{{$user->role}}" disabled>
                    </div>
                  </div>
                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                      <label for="tgl_masuk">Join Date</label>
                      <input type="text" class="form-control" id="tgl_masuk" placeholder="Enter tgl_masuk number" value="{{ $user->tgl_masuk }}" disabled>
                    </div>
                  </div>
                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                      <label for="email">Email</label>
                      <input type="email" class="form-control" id="email" placeholder="email" value="{{ $user->email }}" disabled>
                    </div>
                  </div>
                </div>
                <div class="row gutters">
                  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <h6 class="mt-3 mb-2 text-primary">Detail Personal</h6>
                  </div>
                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                      <label for="jabatan">Job Title</label>
                      <input type="name" class="form-control" id="jabatan" placeholder="Enter jabatan" value="{{$user->nama_job_title}}" disabled>
                    </div>
                  </div>
                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                      <label for="Level">Level</label>
                      <input type="name" class="form-control" id="Level" placeholder="Enter Level" value="{{$user->nama_level}}" disabled>
                    </div>
                  </div>
                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                      <label for="Department">Department</label>
                      <input type="text" class="form-control" id="Department" placeholder="Enter Department" value="{{$user->nama_department}}" disabled>
                    </div>
                  </div>
                  <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
                    <div class="form-group">
                      <label for="sd">Sub Department</label>
                      <input type="text" class="form-control" id="sd" placeholder="sd Code" value="{{$user->nama_subdepartment}}" disabled>
                    </div>
                  </div>
                </div>
                {{-- <div class="row gutters">
                  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="text-right">
                      <button type="button" id="submit" name="submit" class="btn btn-primary">Update</button>
                    </div>
                  </div>
                </div> --}}
              </div>
            </div>
          </div>
        </div>
      </div>

    <script>
      $(document).ready(function () {
        var areaData = {
          labels: ["Basic","Intermediate","Advence"],
          datasets: [{
              data: [{{$b}},{{$c}},{{$a}}],
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
            text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[0] + '"></div><p class="mb-0">Total Basic</p></div>');
            text.push('<p class="mb-0">{{ $b }}</p>');
            text.push('</div>');
            text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[1] + '"></div><p class="mb-0">Total Intermediate</p></div>');
            text.push('<p class="mb-0">{{$c}}</p>');
            text.push('</div>');
            text.push('<div class="d-flex justify-content-between mx-4 mx-xl-5 mt-3"><div class="d-flex align-items-center"><div class="mr-3" style="width:20px; height:20px; border-radius: 50%; background-color: ' + chart.data.datasets[0].backgroundColor[2] + '"></div><p class="mb-0">Total Advance</p></div>');
            text.push('<p class="mb-0">{{$a}}</p>');
            text.push('</div>');
          text.push('</div>');
          return text.join("");
        }
        }
        var curriculumFinishChartPlugins = {
          beforeDraw: function(chart) {
            var width = chart.chart.width,
                height = chart.chart.height,
                ctx = chart.chart.ctx;
        
            ctx.restore();
            var fontSize = 3.125;
            ctx.font = "600 " + fontSize + "em sans-serif";
            ctx.textBaseline = "middle";
            ctx.fillStyle = "#000";
        
            var text = "{{ $total }}",
                textX = Math.round((width - ctx.measureText(text).width) / 2),
                textY = height / 2;
        
            ctx.fillText(text, textX, textY);
            ctx.save();
          }
        }
        var curriculumFinishCanvas = $("#curriculum-finish").get(0).getContext("2d");
        var curriculumFinishChart = new Chart(curriculumFinishCanvas, {
          type: 'doughnut',
          data: areaData,
          options: areaOptions,
          plugins : curriculumFinishChartPlugins
        });
        document.getElementById('curriculum-finish-legend').innerHTML = curriculumFinishChart.generateLegend();
      })
    </script>
