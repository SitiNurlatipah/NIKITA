@extends('layouts.master')

@section('title', 'White Tag General')
@push('style')
<style>
     
.panel-title a:after {
    font-family:Fontawesome;
    content:'\f077';
    float:right;
    font-size:10px;
    font-weight:300;
}
.panel-title a.collapsed:after {
    font-family:Fontawesome;
    content:'\f078';
}
.accordion {
        width: 100%;
    }

    .card-header {
        padding: 1.2rem !important;
        border-radius: 40px !important;
    }

</style>
@endpush
@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card mb-0">
        <div id="accordion-gen" class="accordion">
        <div class="card">
            <div class="card-header card-title" data-toggle="collapse" href="#graphgen">
            White Tag
            </div>
                <div id="graphgen" class="card-body collapse show" data-parent="#accordion-gen" aria-expanded="true">
                        <div class="row mb-0">
                            <label class="col-sm-2 col-form-label pr-0">Circle Group</label>
                            <div class="col-sm-4 pl-0 m-auto">
                                <select name="" id="selectCG" class="float-right form-control form-control-sm">
                                    <option value="all">-- Filter By Cirle Group --</option>
                                </select>
                            </div>
                            <div class="col-6">
                            </div>
                        </div>
                    <div class="row col-12">
                        <div id="elementSkillCategory" class="col-md-6">
                            <canvas id="pieChart" class="mb-2"></canvas>
                        </div>
                        <div id="elementCompGroup" class="col-md-6" style="display: none">
                            <canvas id="pieCompGroup" class="mb-2 "></canvas>
                        </div>
                    </div>
                </div>

          {{-- <div class="card-body">
            <h4 class="card-title">Graphic White Tag General</h4>
          </div> --}}
        </div>
        </div>
      </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                {{-- <p class="card-title">White Tag</p> --}}
                <ul class="nav nav-pills mb-3">
                    <li class="nav-item active">
                        <a class="nav-link active btn-primary" data-toggle="tab" href="#pills-home" type="button">White Tag CG</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-primary" data-toggle="tab" href="#pills-profile" type="button">White Tag All</a>
                    </li>
                </ul>
                <div class="row">
                    <div class="col-12 flex">
                        <div class="tab-pane container fade in active show" id="pills-home">
                            <div class="table-responsive">
                                <table class="display nowrap expandable-table table-striped table-hover" id="table-cg" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Nama Anggota</th>
                                            <th>Job Title</th>
                                            <th>Dept</th>
                                            <th>Divisi</th>
                                            <th>Liga CG</th>
                                            <th class="text-center">Action</th>
                                        </tr> 
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane container fade" id="pills-profile">
                            @if(Auth::user()->peran_pengguna == '1')
                                <a href="{!!route('exportWhiteTagAll')!!}" class="btn btn-inverse-info float-left mb-2">Export</a>
                            @endif
                            <div class="table-responsive">
                                <table class="display nowrap expandable-table table-striped table-hover" id="table-white-tag-all" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Nama Anggota</th>
                                            <th>No Competency</th>
                                            <th>Skill Category</th>
                                            <th>Competency</th>
                                            <th>Level</th>
                                            <th>Competency Group</th>
                                            {{-- <th>Competency Group</th> --}}
                                            <th>Start</th>
                                            <th>Actual</th>
                                            <th>Target</th>
                                            <th class="text-center">Status</th>
                                        </tr> 
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal --}}
<div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="modal-tambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header p-3">
                <h5 class="modal-title" id="modal-tambahLabel">Edit White Tag General</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{!!route('actionWhiteTag')!!}" id="formWhiteTag" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="user_id" name="user_id" value="">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class=" display expandable-table table-striped table-hover" id="tableEdit" style="width:100%">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="text-center">No</th>
                                    <th rowspan="2">No. Competency</th>
                                    <th rowspan="2">Skill Category</th>
                                    <th rowspan="2">Competency</th>
                                    <th rowspan="2">Level</th>
                                    <th rowspan="2">Competency Group</th>
                                    <th colspan="3" class="text-center">Action</th>
                                    <th class="text-center" rowspan="2">Status</th>
                                </tr> 
                                <tr>
                                    <th class="text-center" style="min-width:90px">Start</th>
                                    <th class="text-center" style="min-width:90px">Actual</th>
                                    <th class="text-center" style="min-width:90px">Target</th>
                                </tr>
                            </thead>
                            <tbody id="formMapComp">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="submitWhiteTag" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="modal-detailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header p-3">
                <h5 class="modal-title" id="modal-detailLabel">Detail White Tag General</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class=" display expandable-table table-striped table-hover" id="table-detail" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>No Competency</th>
                                <th>Skill Category</th>
                                <th>Competency</th>
                                <th>Level</th>
                                <th>Competency Group</th>
                                <th class="text-center">Start</th>
                                <th class="text-center">Actual</th>
                                <th class="text-center">Target</th>
                                <th class="text-center">Status</th>
                            </tr> 
                        </thead>
                        <tbody id="formMapComp"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-hapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
    <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">Hapus Data</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Yakin ingin menghapus data ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="" class="btn btn-success">Lanjutkan</a>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
@push('script')
<script type="text/javascript">
  $(document).ready(function () {
    $(".nav-pills a").click(function(){
        $(this).tab('show');
    });

    $('.nav-pills a').on('show.bs.tab', function(){
        $('.tab-pane').each(function(i,obj){
            if(!$(this).hasClass("active")){
                $(this).show()
            }else{
                $(this).hide()
            }
        });
    })

    $("#tableEdit").DataTable({
        searching: true
    });

    chartSkillCategory();
    whiteTagAllDataTable();
    initDatatable();
    getCg();
    $('[data-toggle="tooltip"]').tooltip({
        animation: true,
        placement: "top",
        trigger: "hover focus"
    });

    $("#submitWhiteTag").click(function (e) {
        e.preventDefault()
        var form = $("#formWhiteTag")
        const url = form.attr("action");
        var formData = form.serialize();
        $.ajax({
            url:url,
            type:"post",
            cache:false,
            data:formData,
            success:function(data){
                $("#modal-tambah").modal('hide');
                $('#table-cg').DataTable().destroy();
                initDatatable();
                Swal.fire({
                    position:'top-end',
                    icon:'success',
                    title:data.message,
                    showConfirmButton:false,
                    timer:1500
                });
            },
            error:function(err){
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: err.responseJSON.message,
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        })
    })

    $("#selectCG").change(function(){
        chartSkillCategory($(this).val());
        chartCompGroup(idSkillCategory)
    })

});

    var idSkillCategory = null

  function getMapComp(id) {
    $('#tableEdit').DataTable().destroy()
    $("#user_id").val(id);
      const url = "{!! route('formWhiteTag') !!}?id="+id+"&type=general";
      $.ajax({
          url:url,
          cache:false,
          success: function(html) {
              $("#formMapComp").html(html);
              $('#tableEdit').DataTable({
                searching: true
              }).reload();
          },
          error: function(req, sts, err) {
              console.log(err);
          }

      });
  }

  function detailWhiteTag(id) {
      const url = "{{ route('detailWhiteTag') }}?id="+id+"&type=general";
      $('#table-detail').DataTable().destroy();
      var dtJson = $('#table-detail').DataTable({
          ajax:  url,
          autoWidth: true,
          serverSide: true,
          processing: true,
          searching: true,
          dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
          displayLength: 10,
          language: {
              paginate: {
                  // remove previous & next text from pagination
                  previous: '&nbsp;',
                  next: '&nbsp;'
              }
          },
          scrollX: true,
          columns: [
              {
                  data: 'DT_RowIndex', name: 'DT_RowIndex'
              },
              {
                  data: 'no_training'
              },
              {
                  data: 'skill_category'
              },
              {
                  data: 'training_module'
              },
              {
                  data: 'level'
              },
              {
                  data: 'training_module_group'
              },
              {
                data: 'start'
                },
                {
                    data: 'actual'
                },
                {
                    data: 'target'
                },
                {
                    data: 'tagingStatus'
                },
          ]
      });

  }


  function initDatatable() {
      var dtJson = $('#table-cg').DataTable({
          ajax: "{{ route('memberJson') }}",
          autoWidth: false,
          serverSide: true,
          processing: true,
          aaSorting: [
              [0, "desc"]
          ],
          searching: true,
          dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
          displayLength: 10,
          lengthMenu: [10, 15, 20],
          language: {
              paginate: {
                  // remove previous & next text from pagination
                  previous: '&nbsp;',
                  next: '&nbsp;'
              }
          },
          scrollX: true,
          columns: [
              {
                  data: 'DT_RowIndex', name: 'DT_RowIndex'
              },
              {
                  data: 'nama_pengguna'
              },
              {
                  data: 'nama_job_title'
              },
              {
                  data: 'nama_department'
              },
              {
                  data: 'nama_divisi'
              },
              {
                  data: 'nama_cg'
              },
              {
                  data: 'action'
              }
          ],
      })
  }

  function whiteTagAllDataTable(){
    var dtJson = $('#table-white-tag-all').DataTable({
          ajax: "{{ route('whiteTagAll') }}",
          autoWidth: false,
          serverSide: true,
          processing: true,
          aaSorting: [
              [0, "desc"]
          ],
          searching: true,
          dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
          displayLength: 10,
          lengthMenu: [10, 15, 20],
          language: {
              paginate: {
                  // remove previous & next text from pagination
                  previous: '&nbsp;',
                  next: '&nbsp;'
              }
          },
          scrollX: true,
          columns: [
              {
                  data: 'DT_RowIndex', name: 'DT_RowIndex'
              },
              {
                  data: 'nama_pengguna'
              },
              {
                  data: 'no_training_module'
              },
              {
                  data: 'skill_category'
              },
              {
                  data: 'training_module'
              },
              {
                  data: 'level'
              },
              {
                data: 'compGroupName'
              },
            //   {
            //       data: 'training_module_group'
            //   },
              {
                  data: 'start'
              },
              {
                  data: 'actual'
              },
              {
                  data:'target'
              },
              {
                  data:'tagingStatus'
              }
          ],
      })
  }

    var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
    var dataCharSkill = {
        labels : [],
        datasets : [
            {
                label: [],
                data: [],
                identity : [],
                backgroundColor: [],
                borderWidth: 1
            }
        ]
    }

    var optionChartSkill = {
        responsive: true,
        title: {
            display: true,
            text: 'Chart Skill Category',
            align: 'center',
            position : 'top',
            fullSize : true
        },
        legend: {
        position: 'right',
        labels: {
            boxWidth: 20,
            boxHeight : 20,
            pointStyle : 'circle' 
        }
      },
        onClick:function(e){
            var activePoints = pieChartSkill.getElementsAtEvent(e);
            if(activePoints.length > 0){
                $("#elementCompGroup").show();
                $("#elementSkillCategory").attr("class","col-md-6");
                var selectedIndex = activePoints[0]._index;
                chartCompGroup(this.data.datasets[0].identity[selectedIndex])
                idSkillCategory = this.data.datasets[0].identity[selectedIndex]
            }else{
                return;
            }
        }
    }

    var pieChartSkill = new Chart(pieChartCanvas, {
        type: 'pie',
        data: dataCharSkill,
        options: optionChartSkill
    });

  function chartSkillCategory(cg){
    if(cg){
        var url = "{{route('chartSkillCategory')}}?cg="+cg
    }else{
        var url = "{{route('chartSkillCategory')}}?cg=all"
    }
    $.ajax({
        url:url,
        cache:false,
        success: function(res) {
            pieChartSkill.data.labels = res.data.label
            pieChartSkill.data.datasets[0].label = res.data.label
            pieChartSkill.data.datasets[0].data = res.data.data
            pieChartSkill.data.datasets[0].identity = res.data.identity
            pieChartSkill.data.datasets[0].backgroundColor = res.data.backgroundColour
            pieChartSkill.update()
        },
        error: function(req, sts, err) {
            
        }
    })
  }

  var pieCompGroupCanvas = $("#pieCompGroup").get(0).getContext("2d");
  var data = {
      labels : [],
      datasets : [
          {
              label: [],
              data: [],
              backgroundColor: [],
              borderWidth: 1
          }
      ]
  }
  
  var option = {
      responsive: true,
      legend: {
        position: 'right',
        labels: {
            boxWidth: 20,
            boxHeight : 20,
            pointStyle : 'circle' 
        }
      },
      title: {
        display: true,
        text: '',
        align: 'center',
        position : 'top',
        fullSize : true
      }
  }

  var compGroupChart = new Chart(pieCompGroupCanvas, {
      type: 'pie',
      data: data,
      options: option
  });
  function chartCompGroup(id){
    url = '{{route("chartCompGroup")}}?id='+id+"&cg="+$("#selectCG").val()
    $.ajax({
        url:url,
        cache:false,
        success: function(res) {
            compGroupChart.options.title.text = res.data.title
            compGroupChart.data.labels = res.data.label
            compGroupChart.data.datasets[0].label = res.data.label
            compGroupChart.data.datasets[0].data = res.data.data
            compGroupChart.data.datasets[0].backgroundColor = res.data.backgroundColor
            compGroupChart.update()
        },
        error: function(req, sts, err) {
            
        }
    })
  }

  function getCg() {
            $.ajax({
                type: "GET",
                url: "{{ route('get.cg') }}",
                success: function(res) {
                    var option = "";
                    for (let i = 0; i < res.data.length; i++) {
                        option += '<option value="' + res.data[i].id_cg + '">' + res.data[i].nama_cg + '</option>';
                    }
                    $('#selectCG').html();
                    $('#selectCG').append(option);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(xhr);
                    alert(xhr.status);
                    alert(thrownError);
                }
            })
        }

</script>
@endpush