@extends('layouts.master')

@section('title', 'Mapping Competencies')
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

/* #table-white-tag-all td{
    font-size: 0.75rem;
    padding: 0px;
}

table.dataTable.table-sm > thead > tr > th:not(.sorting_disabled) {
    padding-right: 0px;
} */

</style>
@endpush
@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card mb-0">
        <div id="accordion-gen" class="accordion">
        <div class="card">
            <div class="card-header card-title" data-toggle="collapse" href="#graphgen">
            Mapping Competencies
            </div>
            @if(Auth::user()->peran_pengguna == '1')
                <div id="graphgen" class="card-body collapse show pb-1" data-parent="#accordion-gen" aria-expanded="true">
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
                            <canvas id="pieCompGroup" class="mb-2"></canvas>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        </div>
      </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
            @if(Auth::user()->peran_pengguna == '3')
            <div class="row">
                    <div class="col-12 flex">
                            <div class="table-responsive">
                                <table class="display expandable-table table-sm table-striped table-hover" id="table-role-member" style="width:100% !important">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Anggota</th>
                                            <th>No Competency</th>
                                            <th>Skill Category</th>
                                            <th>Competency</th>
                                            <th>Level</th>
                                            <th>Competency Group</th>
                                            <th>Start</th>
                                            <th>Actual</th>
                                            <th>Target</th>
                                            <th>Status</th>
                                            <th>Evidence</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                    </div>
                </div>
            @else
                <ul class="nav nav-pills nav-mapcomp">
                    <li class="nav-item active">
                        <a class="nav-link active btn-primary" data-toggle="tab" href="#pills-home" type="button" data-toggle="tooltip" data-placement="top" title="Edit Actual Point">All</a>
                    </li>
                    @if(Auth::user()->peran_pengguna == '1' || Auth::user()->peran_pengguna == '4')
                    <li class="nav-item">
                        <a class="nav-link btn-primary" data-toggle="tab" href="#pills-mapcompcorporate" type="button" data-toggle="tooltip" data-placement="top" title="Edit Mapcomp Corporate">Corporate</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link btn-primary" data-toggle="tab" href="#pills-profile" type="button" data-toggle="tooltip" data-placement="top" title="Lihat Semua Competencies">Preview</a>
                    </li>
                </ul>
                <div class="row">
                    <div class="col-12 flex">
                        <div class="tab-pane container fade in active show tab-mapcomp" id="pills-home">
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
                        @if(Auth::user()->peran_pengguna == '1' || Auth::user()->peran_pengguna == '4')
                        <div class="tab-pane container fade tab-mapcomp" id="pills-mapcompcorporate">                            
                            <div class="table-responsive">
                                <table class="display expandable-table table-sm table-striped table-hover" id="table-corporate" style="width:100% !important">
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
                        @endif
                        <div class="tab-pane container fade tab-mapcomp" id="pills-profile">
                                <a href="{!!route('exportWhiteTagAll')!!}" class="btn btn-sm btn-inverse-success float-right mb-2"><i class="icon-file"></i> Export to Excel</a>
                            <div class="table-responsive">
                                <table class="display expandable-table table-sm table-striped table-hover" id="table-white-tag-all" style="width:100% !important">
                                    <thead>
                                        <tr>
                                            <th>No</th>
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
                                            <th>Status</th>
                                            <th>Evidence</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            </div>
        </div>
    </div>
</div>

{{-- Modal --}}
<div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="modal-tambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header p-3">
                <h5 class="modal-title" id="modal-tambahLabel">Edit Mapping Competencies</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{!!route('actionWhiteTag')!!}" id="formWhiteTag" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="user_id" name="user_id" value="">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="display expandable-table table-striped table-hover" id="tableEdit" style="width:100%">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="text-center">No</th>
                                    <th rowspan="2">No. Competency</th>
                                    <th rowspan="2">Skill Category</th>
                                    <th rowspan="2">Competency</th>
                                    <th rowspan="2">Level</th>
                                    <th rowspan="2">Competency Group</th>
                                    <th colspan="4" class="text-center">Action</th>
                                    <th class="text-center" rowspan="2">Status</th>
                                </tr>
                                <tr>
                                    <th class="text-center" style="min-width:90px">Start</th>
                                    <th class="text-center" style="min-width:90px">Actual</th>
                                    <th class="text-center" style="min-width:50px">Target</th>
                                    <th class="text-center" style="min-width:90px">Evidence</th>
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
<div class="modal fade" id="modal-tambah-corporate" tabindex="-1" role="dialog" aria-labelledby="modal-tambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header p-3">
                <h5 class="modal-title" id="modal-tambahCorporate">Edit Corporate Competencies</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{!!route('action.corporate.WhiteTag')!!}" id="formCorporateWhiteTag" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="user_id_corporate" name="user_id_corporate" value="">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="display expandable-table table-striped table-hover" id="tableCorporateEdit" style="width:100%">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="text-center">No</th>
                                    <th rowspan="2">No. Competency</th>
                                    <th rowspan="2">Skill Category</th>
                                    <th rowspan="2">Competency</th>
                                    <th rowspan="2">Level</th>
                                    <th rowspan="2">Competency Group</th>
                                    <th colspan="4" class="text-center">Action</th>
                                    <th class="text-center" rowspan="2">Status</th>
                                </tr>
                                <tr>
                                    <th class="text-center" style="min-width:90px">Start</th>
                                    <th class="text-center" style="min-width:90px">Actual</th>
                                    <th class="text-center" style="min-width:50px">Target</th>
                                    <th class="text-center" style="min-width:90px">Evidence</th>
                                </tr>
                            </thead>
                            <tbody id="formCorporateComp">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="submitCorporate" class="btn btn-primary">Save changes</button>
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
                    <table class="display expandable-table table-striped table-hover" id="table-detail" width="100%">
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
                                <th class="text-center">Evidence</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody id="formMapComp"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-detail-corporate" tabindex="-1" role="dialog" aria-labelledby="modal-detailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header p-3">
                <h5 class="modal-title" id="modal-detailCorporate">Detail Corporate Competencies</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="display expandable-table table-striped table-hover" id="table-detail-corporate" width="100%">
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
                                <th class="text-center">Evidence</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody id="formCorporateComp"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

<div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-labelledby="modal-tambahLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-small" style="max-width: 1000px;" role="document">
            <div class="modal-content">
                <div class="modal-header p-3">
                    <h5 class="modal-title" id="modal-tambahLabel">Import New Curriculum</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('importWhiteTag') }}" id="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body pt-3 pb-3">
                        <input type="file" name="file" class="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@push('script')
<script type="text/javascript">
  $(document).ready(function () {

    $(".nav-mapcomp a").click(function(){
    // Menampilkan konten tab yang dipilih
    var targetTab = $(this).attr("href");
    $(".tab-mapcomp").hide(); // Menyembunyikan semua konten tab
    $(targetTab).show(); // Menampilkan konten tab yang dipilih
});
    
    chartSkillCategory();
    getCg();
    whiteTagAllDataTable();
    initDatatable();
    corporateDatatable();
    whiteTagDataTableRoleMember();
    $('[data-toggle="tooltip"]').tooltip({
        animation: true,
        placement: "top",
        trigger: "hover focus"
    });

    $("#submitWhiteTag").click(function (e) {
        var tableEdit = $('#tableEdit').DataTable();
        e.preventDefault()
        var form = $("#formWhiteTag")
        const url = form.attr("action");
        var formSerialize = $("#formWhiteTag > input[name=user_id], input[name=_token]").serialize()
        var serializeDatatable = tableEdit.$('input,select,textarea').serialize()
        var formData = formSerialize+'&'+serializeDatatable

        console.log(serializeDatatable);
        // exit();
        $.ajax({
            url:url,
            type:"post",
            cache:false,
            data:formData,
            success:function(data){
                console.log(data);
                $("#modal-tambah").modal('hide');
                $('#table-cg').DataTable().destroy();
                initDatatable();
                Swal.fire({
                    position:'center',
                    icon:'success',
                    title:data.message,
                    showConfirmButton:false,
                    timer:1500
                });
            },
            error:function(err){
                console.log(err)
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: err.statusText,
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        })
    })
    $("#submitCorporate").click(function (e) {
        var tableEdit = $('#tableCorporateEdit').DataTable();
        e.preventDefault()
        var form = $("#formCorporateWhiteTag")
        const url = form.attr("action");
        var formSerialize = $("#formCorporateWhiteTag > input[name=user_id_corporate], input[name=_token]").serialize()
        var serializeDatatable = tableEdit.$('input,select,textarea').serialize()
        var formData = formSerialize+'&'+serializeDatatable

        console.log(serializeDatatable);
        // exit();
        $.ajax({
            url:url,
            type:"post",
            cache:false,
            data:formData,
            success:function(data){
                console.log(data);
                $("#modal-tambah-corporate").modal('hide');
                $('#table-cg').DataTable().destroy();
                $('#table-corporate').DataTable().destroy();
                initDatatable();
                corporateDatatable();
                Swal.fire({
                    position:'center',
                    icon:'success',
                    title:data.message,
                    showConfirmButton:false,
                    timer:1500
                });
            },
            error:function(err){
                console.log(err)
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: err.statusText,
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

  function getMapComp(id, el) {
    //tombol add mapping competencies
    // $('#tableEdit').DataTable().destroy()
    $("#user_id").val(id);
    var nama = $(el).attr("userName")
    console.log(nama);
    $("#modal-tambahLabel").html('Edit Mapping Competencies <b>('+nama+')</b>')
      const url = "{!! route('formWhiteTag') !!}?id="+id+"&type=general";
      $.ajax({
        url:url,
        // cache:false,
        type:'GET',
        success: function(html) {
            $("#formMapComp").show();
                    if($.fn.DataTable.isDataTable( '#tableEdit' )){
                        $('#tableEdit').DataTable().destroy()
                    }
                    $("#formMapComp").html(html);
                    tableEdit = $('#tableEdit').DataTable({
                        searching: true,
                        retrieve: true,
                        paging: true,
                columnDefs: [
                    {
                        orderable: false,
                        targets: [6, 7, 8],
                    },
                    {
                                width: "200px",
                                targets: 9
                            }
                ]
            });
        },
        error: function(req, sts, err) {
            console.log(err);
        }

      });
  }
  function getCorporateComp(id, el) {
    //tombol add mapping competencies
    // $('#tableEdit').DataTable().destroy()
    $("#user_id_corporate").val(id);
    var nama = $(el).attr("userName")
    console.log(nama);
    $("#modal-tambahCorporate").html('Edit Corporate Competencies <b>('+nama+')</b>')
      const url = "{!! route('form.corporate.WhiteTag') !!}?id="+id+"&type=general";
      $.ajax({
        url:url,
        // cache:false,
        type:'GET',
        success: function(html) {
            $("#formCorporateComp").show();
                    if($.fn.DataTable.isDataTable( '#tableCorporateEdit' )){
                        $('#tableCorporateEdit').DataTable().destroy()
                    }
                    $("#formCorporateComp").html(html);
                    tableCorporateEdit = $('#tableCorporateEdit').DataTable({
                        searching: true,
                        retrieve: true,
                        paging: true,
                columnDefs: [
                    {
                        orderable: false,
                        targets: [6, 7, 8],
                    },
                    {
                                width: "200px",
                                targets: 9
                            }
                ]
            });
        },
        error: function(req, sts, err) {
            console.log(err);
        }

      });
  }

  function detailWhiteTag(id, el) {
    console.log("cek read");
      const url = "{{ route('detailWhiteTag') }}?id="+id+"&type=general";
      var name = $(el).attr("userName");
      $("#modal-detailLabel").html('Detail Mapping Competencies <b>('+name+')</b>')
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
          columnDefs: [
                { "width": "150px", "targets": 9 }
          ],
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
                    data: 'ket'
                },
                {
                    data: 'tagingStatus'
                },
          ]
      });

  }
  function detailCorporate(id, el) {
    console.log("cek read");
      const url = "{{ route('detail.corporate') }}?id="+id+"&type=general";
      var name = $(el).attr("userName");
      $("#modal-detailLabel").html('Detail Corporate Competencies <b>('+name+')</b>')
      $('#table-detail-corporate').DataTable().destroy();
      var dtJson = $('#table-detail-corporate').DataTable({
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
          columnDefs: [
                { "width": "150px", "targets": 9 }
          ],
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
                    data: 'ket'
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
  function corporateDatatable() {
      var dtJson = $('#table-corporate').DataTable({
          ajax: "{{ route('member.corporate.Json') }}",
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

  function whiteTagDataTableRoleMember(){
    var dtJson = $('#table-role-member').DataTable({
          ajax: "{{ route('whiteTagRoleMember') }}",
          autoWidth: false,
          serverSide: true,
          processing: true,
          aaSorting: [
              [0, "desc"]
          ],
          searching: true,
          dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
          displayLength: 20,
          lengthMenu: [20, 30, 50],
          language: {
              paginate: {
                  // remove previous & next text from pagination
                  previous: '&nbsp;',
                  next: '&nbsp;'
              }
          },
          scrollX: false,
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
              },
              {
                  data:'ket'
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
          displayLength: 20,
          lengthMenu: [20, 30, 50],
          language: {
              paginate: {
                  // remove previous & next text from pagination
                  previous: '&nbsp;',
                  next: '&nbsp;'
              }
          },
          scrollX: false,
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
              },
              {
                  data:'ket'
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
