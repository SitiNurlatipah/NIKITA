@extends('layouts.master')

@section('title', 'White Tag Superman')
@push('style')
<style>
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
    <div class="col-12 grid-margin mb-0">
        <div id="accordion-white" class="accordion">
        <div class="card">
            <div class="card-header card-title" data-toggle="collapse" href="#white-tag-show">
            Tagging Superman
            </div>
        </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <!-- <div class="row">
                    <p class="card-title ml-4">White Tag</p>
                </div> -->
                @if(Auth::user()->peran_pengguna == '1')
                    <div class="row">
                        <div class="col-12 flex">
                                <div class="tab-pane container fade in active show" id="pills-home">
                                @if(Auth::user()->peran_pengguna == '1')
                                    <button class="btn btn-inverse-success mb-2 btn-sm float-right" data-toggle="modal" data-target="#modal-export"><i class="icon-file"></i> Export to Excel</button>
                                @endif
                                    <div class="table-responsive">
                                            <table class="display expandable-table table-striped table-hover" id="table-taging-list" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No Taging</th>
                                                        <th>NIK</th>
                                                        <th>Employee Name</th>
                                                        <th>Circle Group</th>
                                                        <th>Skill Category</th>
                                                        <th>Competency</th>
                                                        <th>Actual</th>
                                                        <th>Target</th>
                                                        <th>Gap</th>
                                                        <th style="width: max-content" class="text-center">Tagging Status</th>
                                                        <th style="width: max-content" class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                    </div>
                                </div>
                        </div>
                    </div>
                @elseif(Auth::user()->id_level == 'LV-0004')
                    <div class="table-responsive">
                        <table class="display expandable-table table-striped table-hover" id="tbl-tag-member" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No Taging</th>
                                    <th>NIK</th>
                                    <th>Employee Name</th>
                                    <th>Skill Category</th>
                                    <th>Competency</th>
                                    <th>Actual</th>
                                    <th>Target</th>
                                    <th>Gap</th>
                                    <th style="width: max-content" class="text-center">Tagging Status</th>
                                    <th style="width: max-content" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                @elseif(Auth::user()->id_level == 'LV-0003')
                    <div class="table-responsive">
                        <table class="display expandable-table table-striped table-hover" id="tabel-tag-atasan" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No Taging</th>
                                    <th>NIK</th>
                                    <th>Employee Name</th>
                                    <th>Skill Category</th>
                                    <th>Competency</th>
                                    <th>Actual</th>
                                    <th>Target</th>
                                    <th>Gap</th>
                                    <th style="width: max-content" class="text-center">Tagging Status</th>
                                    <th style="width: max-content" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Modal --}}
<div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="modal-tambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header p-3">
                <h5 class="modal-title" id="modal-tambahLabel">Taging Reason</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{!!route('superman.actionTagingList')!!}" method="POST" enctype="multipart/form-data" id="formTaging">
                @csrf
                <div class="modal-body" id="form-taging"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="formSubmit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-export" tabindex="-1" role="dialog" aria-labelledby="modal-exportLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width:45%">
        <div class="modal-content">
            <div class="modal-header p-3">
                <h5 class="modal-title" id="modal-exportLabel">Export Tagging List</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{!!route("superman.exportTaggingList")!!}" method="get">
                <input type="hidden" name="all" value="1">
                <div class="modal-body">
                    <div class="form-row">
                        <label for="category">Kategori Export</label>
                        <select name="category" id="category" class="form-control form-control-sm" required>
                            <option value="">Pilih Kateori Export</option>
                            <option value="0">All</option>
                            <option value="1">Open</option>
                            <option value="2">Close</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"><i class="icon-file"></i>  Export to Excel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-export-cg" tabindex="-1" role="dialog" aria-labelledby="modal-exportLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="width:45%">
        <div class="modal-content">
            <div class="modal-header p-3">
                <h5 class="modal-title" id="modal-exportLabel">Export Tagging List</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{!!route("exportTaggingList")!!}" method="get">
                <input type="hidden" name="all" value="0">
                <div class="modal-body">
                    <div class="form-row">
                        <label for="category">Kategori Export</label>
                        <select name="category" id="category" class="form-control form-control-sm" required>
                            <option value="">Pilih Kateori Export</option>
                            <option value="0">Semua</option>
                            <option value="1">Open</option>
                            <option value="2">Close</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Export</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade m-auto"  id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="modal-detailLabel" aria-hidden="true">
    <div class="modal-xl modal-dialog" style="max-width: 750px; margin-top: 10px;" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary p-3">
                <h5 class="modal-title text-white" id="modal-detailLabel">White Tag</h5>
                <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="body-detailsuperman" style="padding : 10px 10px !important; background-color: #eee;">
            </div>
            <div class="modal-footer p-1">
                <button type="button" class="btn btn-sm btn-secondary text-white" data-dismiss="modal">Close</button>
                <button type="button" id="btn-print" onclick="printCompetencyTag(this)" data-id="" class="btn btn-sm btn-primary">Print</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script type="text/javascript">
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
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

        iniDatatable();
        getCg();
        tagingDeptDataTable();
        tagMemberDataTable();

        $("#get-cg").change(function(){
            })
    
        $("#formSubmit").click(function (e) {
            e.preventDefault();
            var tagingForm = $("#formTaging");
            const url = tagingForm.attr("action");
            var formData = tagingForm.serialize();
            $( '#feed-back-year' ).html( "" );
            $( '#feed-back-period' ).html( "" );
            $( '#feed-back-date-open' ).html( "" );
            $( '#feed-back-learning-method' ).html( "" );
            $( '#feed-back-date-plan-implementation' ).html( "" );
            $( '#feed-back-date-closed' ).html( "" );
            $( '#feed-back-start' ).html( "" );
            $( '#feed-back-finish' ).html( "" );
            $( '#feed-back-duration' ).html( "" );
            $( '#feed-back-date-verified' ).html( "" );
            $( '#feed-back-verified-by' ).html( "" );
            $( '#feed-back-result-score' ).html( "" );
            $( '#feed-back-notes-for-result' ).html( "" );
            $( '#year' ).removeClass('is-invalid');
            $( '#period' ).removeClass('is-invalid');
            $( '#date_open' ).removeClass('is-invalid');
            $( '#due_date' ).removeClass('is-invalid');
            $( '#learning_method' ).removeClass('is-invalid');
            $( '#date_plan_implementation' ).removeClass('is-invalid');
            $( '#date_closed' ).removeClass('is-invalid');
            $( '#start' ).removeClass('is-invalid');
            $( '#finish' ).removeClass('is-invalid');
            $( '#duration' ).removeClass('is-invalid');
            $( '#date_verified' ).removeClass('is-invalid');
            $( '#verified_by' ).removeClass('is-invalid');
            $( '#result_score' ).removeClass('is-invalid');
            $( '#notes_for_result' ).removeClass('is-invalid');

            $.ajax({
                url:url,
                type:'POST',
                data:formData,
                success:function (data) {
                    $('#table-taging-list').DataTable().destroy();
                    iniDatatable();
                    $("#modal-tambah").modal('hide');
                    Swal.fire({
                        position:'center',
                        icon:'success',
                        title:data.success,
                        showConfirmButton:false,
                        timer:1500
                    });
                },
                error: function (request, status, error) {
                    var errors = request.responseJSON.errors;
                    var message = request.responseJSON.message;
                    if(message == "The given data was invalid."){
                        if(errors.year){
                            $( '#feed-back-year' ).html(errors.year[0]);
                            $( '#feed-back-year' ).show();
                            $( '#year' ).addClass('is-invalid');
                        }
                        if(errors.period){
                            $( '#feed-back-period' ).html(errors.period[0]);
                            $( '#feed-back-period' ).show();
                            $( '#period' ).addClass('is-invalid');
                        }
                        if(errors.date_open){
                            $( '#feed-back-date-open' ).html(errors.date_open[0]);
                            $( '#feed-back-date-open' ).show();
                            $( '#date_open' ).addClass('is-invalid');
                        }
                        if(errors.due_date){
                            $( '#feed-back-due-date' ).html(errors.due_date[0]);
                            $( '#feed-back-due-date' ).show();
                            $( '#due_date' ).addClass('is-invalid');
                        }
                        if(errors.learning_method){
                            $( '#feed-back-learning-method' ).html(errors.learning_method[0]);
                            $( '#feed-back-learning-method' ).show();
                            $( '#learning_method' ).addClass('is-invalid');
                        }
                        if(errors.trainer){
                            $( '#feed-back-trainer' ).html(errors.trainer[0]);
                            $( '#feed-back-trainer' ).show();
                            $( '#trainer' ).addClass('is-invalid');
                        }
                        if(errors.date_plan_implementation){
                            $( '#feed-back-date-plan-implementation' ).html(errors.date_plan_implementation[0]);
                            $( '#feed-back-date-plan-implementation' ).show();
                            $( '#date_plan_implementation' ).addClass('is-invalid');
                        }
                        if(errors.notes_learning_implementation){
                            $( '#feed-back-notes-learning-implementation' ).html(errors.notes_learning_implementation[0]);
                            $( '#feed-back-notes-learning-implementation' ).show();
                            $( '#notes_learning_implementation' ).addClass('is-invalid');
                        }
                        if(errors.date_closed){
                            $( '#feed-back-date-closed' ).html(errors.date_closed[0]);
                            $( '#feed-back-date-closed' ).show();
                            $( '#date_closed' ).addClass('is-invalid');
                        }
                        if(errors.start){
                            $( '#feed-back-start' ).html(errors.start[0]);
                            $( '#feed-back-start' ).show();
                            $( '#start' ).addClass('is-invalid');
                        }
                        if(errors.finish){
                            $( '#feed-back-finish' ).html(errors.finish[0]);
                            $( '#feed-back-finish' ).show();
                            $( '#finish' ).addClass('is-invalid');
                        }
                        if(errors.duration){
                            $( '#feed-back-duration' ).html(errors.duration[0]);
                            $( '#feed-back-duration' ).show();
                            $( '#duration' ).addClass('is-invalid');
                        }
                        if(errors.date_verified){
                            $( '#feed-back-date-verified' ).html(errors.date_verified[0]);
                            $( '#feed-back-date-verified' ).show();
                            $( '#date_verified' ).addClass('is-invalid');
                        }
                        if(errors.verified_by){
                            $( '#feed-back-verified-by' ).html(errors.verified_by[0]);
                            $( '#feed-back-verified-by' ).show();
                            $( '#verified_by' ).addClass('is-invalid');
                        }
                        if(errors.result_score){
                            $( '#feed-back-result-score' ).html(errors.result_score[0]);
                            $( '#feed-back-result-score' ).show();
                            $( '#result_score' ).addClass('is-invalid');
                        }
                        if(errors.notes_for_result){
                            $( '#feed-back-notes-for-result' ).html(errors.notes_for_result[0]);
                            $( '#feed-back-notes-for-result' ).show();
                            $( '#notes_for_result' ).addClass('is-invalid');
                        }
                    }else{
                        Swal.fire({
                            position:'center',
                            icon:'error',
                            title:'Terjadi kesalahan saat penyimpanan data',
                            showConfirmButton:false,
                            timer:1500
                        });
                    }
                }

            });
        })
    });

    function formTaging(el) {
        var whiteTagId = $(el).attr("white-tag-id");
        var reasonTagId = $(el).attr("taging-reason-id");
        const url = "{!! route('superman.tagingForm') !!}?competencies_superman_id="+whiteTagId+"&reasonTagId="+reasonTagId;
        $.ajax({
            url:url,
            cache:false,
            success: function(html) {
                $("#form-taging").html(html);
            },
            error: function(req, sts, err) {
                console.log(err);
            }

        });

    }

    function detailTaging(id) {
        $("#btn-print").attr("data-id",id);
        $.ajax({
            url:"{!!route('superman.tagingDetail')!!}?id="+id,
            cache:false,
            success:function (html) {
                $("#body-detailsuperman").html(html);
            }
        })
    }

    function printCompetencyTag(el) {
        const id = $(el).attr("data-id");
        window.open(
            '{!!route("superman.taggingPrint")!!}?id='+id,
            '_blank'
        );
    }

    $(document).on('click', '.tagging-hapus', function() {
        var id = $(this).attr('data-id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ route('superman.tagging.destroy') }}',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        id
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: response.status,
                            text: response.message
                        })
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }
                })
            }
        })
    })

    function iniDatatable() {
        var dtJson = $('#table-taging-list').DataTable({
            ajax: "{{ route('superman.taggingJson') }}",
            responsive:true,
            serverSide: true,
            processing: true,
            aaSorting: [
                [0, "desc"]
            ],
            searching: true,
            dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            displayLength: 11,
            // lengthMenu: [10, 15, 20],
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
                    data: 'noTaging',
                },
                {
                    data: 'nik',
                },
                {
                    data: 'employee_name'
                },
                {
                    data: 'nama_cg'
                },
                {
                    data: 'skill_category'
                },
                {
                    data: 'curriculum_name'
                },
                {
                    data: 'actual'
                },
                {
                    data: 'target'
                },
                {
                    data: 'actualTarget'
                },
                {
                    data: 'tagingStatus'
                },
                {
                    data: 'action'
                }
            ]
        });
    }

    function tagMemberDataTable() {
        var dtJson = $('#tbl-tag-member').DataTable({
          ajax: "{{ route('superman.taggingJsonMember') }}?type=member",
          responsive:true,
          serverSide: true,
          processing: true,
          aaSorting: [
              [0, "desc"]
          ],
          searching: true,
          dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
          displayLength: 10,
          // lengthMenu: [10, 15, 20],
          language: {
              paginate: {
                  previous: '&nbsp;',
                  next: '&nbsp;'
              }
          },
          scrollX: true,
          columns: [
              {
                  data: 'noTaging',
              },
              {
                  data: 'nik',
              },
              {
                  data: 'employee_name'
              },
              {
                  data: 'skill_category'
              },
              {
                  data: 'curriculum_name'
              },
              {
                  data: 'actual'
              },
              {
                  data: 'target'
              },
              {
                  data: 'actualTarget'
              },
              {
                 data: 'tagingStatus'
              },
              {
                 data: 'action'
              }
          ]
      });
    } 
    
    function tagingDeptDataTable() {
        var dtJson = $('#tabel-tag-atasan').DataTable({
          ajax: "{{ route('superman.taggingJsonAtasan') }}",
          responsive:true,
          serverSide: true,
          processing: true,
          aaSorting: [
              [0, "desc"]
          ],
          searching: true,
          dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
          displayLength: 11,
          // lengthMenu: [10, 15, 20],
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
                  data: 'noTaging',
              },
              {
                  data: 'nik',
              },
              {
                  data: 'employee_name'
              },
              {
                  data: 'skill_category'
              },
              {
                  data: 'curriculum_name'
              },
              {
                  data: 'actual'
              },
              {
                  data: 'target'
              },
              {
                  data: 'actualTarget'
              },
              {
                 data: 'tagingStatus'
              },
              {
                 data: 'action'
              }
          ]
      });
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
                    $('#get-cg').html();
                    $('#get-cg').append(option);
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
