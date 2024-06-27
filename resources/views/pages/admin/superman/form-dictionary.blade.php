<div class="row">
  <div class="col-md-4">
    @isset($curriculum)
      <input type="hidden" value="{{$curriculum->id_curriculum_superman}}" name="id_curriculum_superman">  
    @endisset
    @if($type == "edit")
      <div class="form-group row ml-0 mb-0">
          <label class="col-sm-5 col-form-label">No. Competency</label>
          <div class="col-sm-7">
              <input type="text" value="{{$curriculum->no_curriculum_superman}}" class="form-control form-control-sm" disabled="">
          </div>
      </div>
      <div class="form-group row ml-0 mb-0">
        <label class="col-sm-5 col-form-label">Competency</label>
        <div class="col-sm-7">
            <input type="text" value="{{$curriculum->curriculum_superman}}" class="form-control form-control-sm" disabled="">
        </div>
    </div>
    @else
        <div class="form-group ml-0 mb-1">
          <label for="id_curriculum_superman" class="col-sm-5">Competency</label>
          <div class="col-sm-12">
            <select id="id_curriculum_superman" onchange="changeTraining(this)" class="selectpicker form-control form-control-sm"
                name="id_curriculum_superman" data-live-search="true" data-hide-disabled="true"
                data-actions-box="true">
                <option value="">Pilih Competency</option>
                @foreach($competencies as $competency)
                  <option class="select-cr" value="{{$competency->id_curriculum_superman}}" id="{{ $competency->curriculum_group }}">{{$competency->curriculum_superman}} ({{$competency->no_curriculum_superman}})</option>
                @endforeach
            </select>
            {{-- <select name="id_curriculum_superman" onchange="changeTraining(this)" class="form-control form-control-sm" id="" required>
              <option value="">Pilih Competency</option>
              @foreach($competencies as $competency)
                <option value="{{$competency->id_curriculum_superman}}">({{$competency->no_curriculum_superman}}) - {{$competency->curriculum_superman}} </option>
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
          <button class="btn btn-success float-right" id="btnAddRowJobTitle" {{isset($curriculum) ? '' : 'disabled'}} curriculum-id="{{isset($curriculum) ? $curriculum->id_curriculum_superman : ''}}" type="button" onclick="addRow(this)">
              <i class="icon-plus"></i> Add Row Member
          </button>
      </div>
  </div>
  <div class="table-responsive" style="overflow-x: unset;">
      <table class="display nowrap expandable-table table-striped table-hover search-data" id=""  style="width:100%">
          <thead>
              <tr>
                  <th style="min-width: 100px;" class="text-left">Member</th>
                  <th style="min-width: 100px;" class="text-center">Target</th>
                  @if(Auth::user()->peran_pengguna == 1)
                  <th style="align-content: center"></th>
                  @endif
              </tr>
          </thead>
          <tbody id="bodyCompetencies">
            @forelse ($directories as $key => $directory)
              @php
                $lists = json_decode($directory["list"])->list;
              @endphp
              <tr>
                <td>
                  <select class="selectpicker form-control form-control-sm selectEdit" name="datas[{{$key}}][id_user]" required data-live-search="true" data-hide-disabled="true"
                  data-actions-box="true">
                      <option value="">Pilih Member</option>
                      @foreach($users as $user)
                        <option class="select-cr" {{($user->id_user == $directory->id_user) ? "selected" : ''}} value="{{$user->id_user}}">{{$user->nama_pengguna}}</option>
                      @endforeach
                  </select>
                </td>
                @foreach ($lists as $k => $list)
                  <td>
                    <input type="hidden" name="datas[{{$key}}][data][{{$k}}][id_dictionary_superman]" value="{{$list->id}}">
                    <input type="hidden" name="datas[{{$key}}][data][{{$k}}][target]" value="{{$list->target}}">
                    <select class="form-control form-control-sm" name="datas[{{$key}}][data][{{$k}}][target]" required>
                        <option value="">Pilih Target</option>
                        <option {{($list->target == "0") ? "selected" : ''}} value="0">0</option>
                        <option {{($list->target == "1") ? "selected" : ''}} value="1">1</option>
                        <option {{($list->target == "2") ? "selected" : ''}} value="2">2</option>
                        <option {{($list->target == "3") ? "selected" : ''}} value="3">3</option>
                        <option {{($list->target == "4") ? "selected" : ''}} value="4">4</option>
                    </select>
                  </td>
                @endforeach
                @if(Auth::user()->peran_pengguna == 1)
                  <td style="text-align: center">
                    <button type="button" onclick="delRow(this)" class="btn btn-inverse-danger btn-icon mr-1"><i class="icon-trash"></i></button>
                  </td>
                @endif
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
  $("#id_curriculum_superman").selectpicker('refresh');
  $(".selectEdit").selectpicker('refresh');
    $('select').on('change', function() {
      idd = $("option:selected").attr("id_curriculum_superman") ;
        if(idd == 5){
          $("#myView").html('<img src="{{ asset("assets/images/general.png") }}" id="img-key" class="img-accordion" style="max-height:200px;margin-left:100px">');
        }else{
          $("#myView").html('<img src="{{ asset("assets/images/Functional.png") }}" id="img-key" class="img-accordion" style="max-height:200px; margin-left:100px">');
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
        const url = "{!!route('addRowSuperman')!!}?curriculumId="+curriculumId
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
            $("#bodyCompetencies").prepend(tr);
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