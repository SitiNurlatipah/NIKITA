@extends('layouts.master')

@section('title', 'Tagging List')

@section('content')
 
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <p class="card-title">Tagging List</p>
                <ul class="nav nav-pills mb-3">
                    <li class="nav-item active">
                        <a class="nav-link active btn-primary" data-toggle="tab" href="#pills-home" type="button">Tagging All</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-primary" data-toggle="tab" href="#pills-profile" type="button">Tagging CG</a>
                    </li>
                </ul>
                <div class="row">
                    <div class="col-12 flex">
                        <div class="tab-pane container fade in active show" id="pills-home">
                            @if(Auth::user()->peran_pengguna == '1')
                                <button class="btn btn-inverse-success float-left mb-2" data-toggle="modal" data-target="#modal-export">Export to Excel</button>
                            @endif
                            <div class="table-responsive">
                                <table class="display nowrap expandable-table table-striped table-hover" id="table-taging-list" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No Taging</th>
                                            <th>Employee Name</th>
                                            <th>Skill Category</th>
                                            <th>Competency</th>
                                            <th>Level</th>
                                            <th>Competenc Group</th>
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
                        <div class="tab-pane container fade" id="pills-profile">
                            @if(Auth::user()->peran_pengguna == '1')
                                <button class="btn btn-inverse-success float-left mb-2" data-toggle="modal" data-target="#modal-export-cg">Export to Excel</button>
                            @endif
                            <div class="table-responsive">
                                <table class="display nowrap expandable-table table-striped table-hover" id="table-taging-list-cg" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No Taging</th>
                                            <th>Employee Name</th>
                                            <th>Skill Category</th>
                                            <th>Competency</th>
                                            <th>Level</th>
                                            <th>Competenc Group</th>
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
            </div>
        </div>
    </div>
</div>

{{-- Modal --}}
<div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="modal-tambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header p-3">
                <h5 class="modal-title" id="modal-tambahLabel">Taging Reason</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{!!route("actionTagingList")!!}" method="post" enctype="multipart/form-data" id="formTaging">
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
            <form action="{!!route("exportTaggingList")!!}" method="get">
                <input type="hidden" name="all" value="1">
                <div class="modal-body">
                    <div class="form-row">
                        <label for="category">Kategori Export</label>
                        <select name="category" id="category" class="form-control form-control-sm" required>
                            <option value="">Pilih Kateori Export</option>
                            <option value="0">Semua</option>
                            <option value="1">Belum Finish</option>
                            <option value="2">Finish</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Export to Excel</button>
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
                            <option value="1">Belum Finish</option>
                            <option value="2">Finish</option>
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
    <div class="modal-lg modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header p-3">
                <h5 class="modal-title m-auto text-center" id="modal-detailLabel">COMPETENCY TAG</h5>
                <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="body-detail" style="padding : 5px 25px !important;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="btn-print" onclick="printCompetencyTag(this)" data-id="" class="btn btn-primary">Print</button>
            </div>
        </div>
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

      iniDatatable();
      tagingCgDataTable();
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
      const url = "{!! route('tagingForm') !!}?white_tag_id="+whiteTagId+"&reasonTagId="+reasonTagId;
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
          url:"{!!route('tagingDetail')!!}?id="+id,
          cache:false,
          success:function (html) {
              $("#body-detail").html(html);
          }
      })
  }

  function printCompetencyTag(el) {
    const id = $(el).attr("data-id");
    window.open(
        '{!!route("taggingPrint")!!}?id='+id,
        '_blank'
    );
  }
      
  function iniDatatable() {
      var dtJson = $('#table-taging-list').DataTable({
          ajax: "{{ route('taggingJson') }}",
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
                  data: 'employee_name'
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

    function tagingCgDataTable() {
        var dtJson = $('#table-taging-list-cg').DataTable({
          ajax: "{{ route('taggingJson') }}?type=cg",
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
                  data: 'employee_name'
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
</script>
@endpush