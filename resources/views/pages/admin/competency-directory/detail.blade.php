<div class="row">
  <div class="col-md-6">
      <div class="form-group row mb-2">
          <label class="col-sm-5">No. Competency</label>
          <div class="col-sm-7">
              <input type="text" value="{{$curriculum->no_training_module}}" class="form-control form-control-sm" disabled="">
          </div>
      </div>
      <div class="form-group row mb-2">
        <label class="col-sm-5">Competency</label>
        <div class="col-sm-7">
            <input type="text" value="{{$curriculum->training_module}}" class="form-control form-control-sm" disabled="">
        </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="table-responsive">
      <table class="display table-striped expandable-table" style="width:100%">
          <thead>
              <tr>
                  <th>Job Title</th>
                  <th class="text-center" style="min-width: 80px">Y0-Y1</th>
                  <th class="text-center" style="min-width: 80px">Y2-Y3</th>
                  <th class="text-center" style="min-width: 80px">Y4-Y5</th>
                  <th class="text-center" style="min-width: 80px">Y6-Y7</th>
                  <th class="text-center" style="min-width: 80px">Y8-Y9</th>
                  <th class="text-center" style="min-width: 80px">YN</th>
              </tr>
          </thead>
          <tbody>
            @forelse ($directories as $key => $directory)
              @php
                $lists = json_decode($directory["list"])->list;
              @endphp
              <tr>
                <td>
                  {{$directory->nama_job_title}}
                </td>
                @foreach ($lists as $k => $list)
                  @php
                    switch($list->target){
                      case 0:
                        $existingUrl = asset('assets/images/point/0.png');
                      break;
                      case 1:
                        $existingUrl = asset('assets/images/point/1.png');
                      break;
                      case 2:
                        $existingUrl = asset('assets/images/point/2.png');
                      break;
                      case 3:
                        $existingUrl = asset('assets/images/point/3.png');
                      break;
                      case 4:
                        $existingUrl = asset('assets/images/point/4.png');
                      break;
                      case 5:
                        $existingUrl = asset('assets/images/point/5.png');
                      break;
                      default:
                        $existingUrl = "";
                      break;
                    }
                  @endphp
                  <td class="text-center">
                    <img src="{{$existingUrl}}" title="{{$list->target}}" style="width:30px;height:30px" alt="">
                  </td>
                @endforeach
              </tr>
            @empty
             <tr>
                <td style="text-align: center" colspan="7">
                  No matching records found
                </td>
              </tr>
            @endforelse
          </tbody>
      </table>
  </div>
</div>