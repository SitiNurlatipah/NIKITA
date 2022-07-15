<div class="row">
  <div class="col-md-4">
    @isset($curriculum)
      <input type="hidden" value="{{$curriculum->id_curriculum}}" name="id_curriculum">  
    @endisset
    @if($type == "edit")
      <div class="form-group row ml-0 mb-0">
          <label class="col-sm-5 col-form-label">No. Competency</label>
          <div class="col-sm-7">
              <input type="text" value="{{$curriculum->no_training_module}}" class="form-control form-control-sm" disabled="">
          </div>
      </div>
      <div class="form-group row ml-0 mb-0">
        <label class="col-sm-5 col-form-label">Competency</label>
        <div class="col-sm-7">
            <input type="text" value="{{$curriculum->training_module}}" class="form-control form-control-sm" disabled="">
        </div>
    </div>
    @else
        <div class="form-group ml-0 mb-1">
          <label for="id_curriculum" class="col-sm-5">Competency</label>
          <div class="col-sm-12">
            <select id="id_curriculum" onchange="changeTraining(this)" class="selectpicker form-control form-control-sm"
                name="id_curriculum" data-live-search="true" data-hide-disabled="true"
                data-actions-box="true">
                @foreach($competencies as $competency)
                  <option class="select-cr" value="{{$competency->id_curriculum}}" id="{{ $competency->training_module_group }}">{{$competency->training_module}} ({{$competency->no_training_module}})</option>
                @endforeach
            </select>
            {{-- <select name="id_curriculum" onchange="changeTraining(this)" class="form-control form-control-sm" id="" required>
              <option value="">Pilih Competency</option>
              @foreach($competencies as $competency)
                <option value="{{$competency->id_curriculum}}">({{$competency->no_training_module}}) - {{$competency->training_module}} </option>
              @endforeach
            </select> --}}
          </div>
      </div>
    @endif
  </div>
  <div class="col-md-8">
      <div id="myView">
      </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12 mb-3 mt-3">
      <div class="col-sm mb-2">
          <button class="btn btn-success float-right" id="btnAddRowJobTitle" {{isset($curriculum) ? '' : 'disabled'}} curriculum-id="{{isset($curriculum) ? $curriculum->id_curriculum : ''}}" type="button" onclick="addRow(this)">
              <i class="icon-plus"></i> Add Row Job Title
          </button>
      </div>
  </div>
  <div class="table-responsive">
      <table class="display nowrap expandable-table table-striped table-hover" style="width:100%">
          <thead>
              <tr>
                  <th style="min-width: 100px;" class="text-left">Job Title</th>
                  <th style="min-width: 100px;" class="text-center">Y0-Y1</th>
                  <th style="min-width: 100px;" class="text-center">Y2-Y3</th>
                  <th style="min-width: 100px;" class="text-center">Y4-Y5</th>
                  <th style="min-width: 100px;" class="text-center">Y6-Y7</th>
                  <th style="min-width: 100px;" class="text-center">Y8-Y9</th>
                  <th style="min-width: 100px;" class="text-center">YN</th>
                  <th style="align-content: center"></th>
              </tr>
          </thead>
          <tbody id="bodyCompetencies">
            @forelse ($directories as $key => $directory)
              @php
                $lists = json_decode($directory["list"])->list;
              @endphp
              <tr>
                <td>
                  <select class="selectpicker form-control form-control-sm selectEdit" name="datas[{{$key}}][id_job_title]" required data-live-search="true" data-hide-disabled="true"
                  data-actions-box="true">
                      <option value="">Pilih Job Title</option>
                      @foreach($jobTitles as $job)
                        <option class="select-cr" {{($job->id_job_title == $directory->id_job_title) ? "selected" : ''}} value="{{$job->id_job_title}}">{{$job->nama_job_title}}</option>
                      @endforeach
                  </select>
                </td>
                @foreach ($lists as $k => $list)
                  <td>
                    <input type="hidden" name="datas[{{$key}}][data][{{$k}}][id_directory]" value="{{$list->id}}">
                    <input type="hidden" name="datas[{{$key}}][data][{{$k}}][between]" value="{{$list->between}}">
                    <select class="form-control form-control-sm" name="datas[{{$key}}][data][{{$k}}][target]" required>
                        <option value="">Pilih Target</option>
                        <option {{($list->target == "0") ? "selected" : ''}} value="0">0</option>
                        <option {{($list->target == "1") ? "selected" : ''}} value="1">1</option>
                        <option {{($list->target == "2") ? "selected" : ''}} value="2">2</option>
                        <option {{($list->target == "3") ? "selected" : ''}} value="3">3</option>
                        <option {{($list->target == "4") ? "selected" : ''}} value="4">4</option>
                        <option {{($list->target == "5") ? "selected" : ''}} value="5">5</option>
                    </select>
                  </td>
                @endforeach
                <td style="text-align: center">
                  <button type="button" onclick="delRow(this)" class="btn btn-inverse-danger btn-icon mr-1"><i class="icon-trash"></i></button>
              </td>
              </tr>
            @empty
              <tr id="rowDefault">
                <td colspan="8" class="text-center">Please Insert Job Title</td>
              </tr>
            @endforelse
          </tbody>
      </table>
  </div>
</div>
<script>

$(document).ready(function(){
  $("#id_curriculum").selectpicker('refresh');
  $(".selectEdit").selectpicker('refresh');
    $('select').on('change', function() {
      idd = $("option:selected").attr("id") ;
        if(idd == 5){
          $("#myView").html('<img src="{{ asset("assets/images/general.png") }}" id="img-key" class="img-accordion" style="max-height:400px;margin-left:100px">');
        }else{
          $("#myView").html('<img src="{{ asset("assets/images/functional.png") }}" id="img-key" class="img-accordion" style="max-height:400px; margin-left:100px">');

        }
    });
  });


  function changeTraining(el) {
    var val = $(el).val();
    if(val){
      $("#btnAddRowJobTitle").removeAttr("disabled");
      $("#btnAddRowJobTitle").attr("curriculum-id",val);
    }else{
      $("#btnAddRowJobTitle").attr("disabled",true);
      $("#btnAddRowJobTitle").attr("curriculum-id","");
    }
  }

  function addRow(el) {
        var options = "";
        var curriculumId = $(el).attr("curriculum-id");
        const url = "{!!route('addRow')!!}?curriculumId="+curriculumId
        $.ajax({
          url:url,
          type:"get",
          cache:false,
          success:function(html){
            var rowDefault = $("#bodyCompetencies").find("#rowDefault");
            if(rowDefault){
              rowDefault.remove();
            }
            tr = document.createElement("tr");
            tr.innerHTML = html;
            $("#bodyCompetencies").append(tr);
            $(".selectNew").selectpicker('refresh');
          }
        })
    }

    function delRow(el) {
      $(el).closest("tr").remove();
      var length = $("#bodyCompetencies").children().length;
      if(length <= 0){
        var html = "<tr id='rowDefault'><td colspan='8' class='text-center'>Silakan Tambahkan Job Title</td></tr>";
        $("#bodyCompetencies").html(html);
      }

    }
</script>