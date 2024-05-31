@extends('layouts.master')

@section('title', 'Tagging List')
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
            White Tag
            </div>
            @if(Auth::user()->peran_pengguna == '1')
                <div id="white-tag-show" class="card-body collapse show pb-1" data-parent="#accordion-white" aria-expanded="true">
                        <div class="row mb-2">
                            <label class="col-sm-2 col-form-label pr-0">Circle Group</label>
                            <div class="col-sm-4 pl-0 m-auto">
                                <select name="" id="get-cg" class="float-right form-control form-control-sm">
                                    <option value="all">-- Filter By Cirle Group --</option>
                                </select>
                            </div>
                            <div class="col-sm-6"></div>
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
                <!-- <div class="row">
                    <p class="card-title ml-4">White Tag</p>
                </div> -->
                
                    <ul class="nav nav-pills pb-0">
                        <li class="nav-item active">
                            <a class="nav-link active btn-primary" data-toggle="tab" href="#pills-home" type="button">Follow Up</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn-primary" data-toggle="tab" href="#pills-finish" type="button">Finish</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn-primary" data-toggle="tab" href="#finish-last" type="button">Finish Last Year</a>
                        </li>
                    </ul>
                    <div class="row">
                        <div class="col-12 flex">
                                <div class="tab-pane container fade in active show" id="pills-home">
                                    @if(Auth::user()->peran_pengguna == '1')
                                        <!-- <button class="btn btn-inverse-success mb-2 btn-sm float-right" data-toggle="modal" data-target="#modal-export"><i class="icon-file"></i> Export to Excel</button> -->
                                    @endif
                                    <div class="table-responsive mt-2">
                                            <table class="display expandable-table table-striped table-hover" id="table-taging-list" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>NIK</th>
                                                        <th>Employee Name</th>
                                                        <th>Circle Group</th>
                                                        <th>Skill Category</th>
                                                        <th>Competency</th>
                                                        <th>Level</th>
                                                        <th>Actual</th>
                                                        <th>Target</th>
                                                        <th>Gap</th>
                                                        <th style="width: max-content" class="text-center">Tagging Status</th>
                                                        @if(Auth::user()->peran_pengguna != '3')
                                                        <th style="width: max-content" class="text-center">Action</th>
                                                        @endif
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                    </div>
                                </div>
                                <div class="tab-pane container fade" id="pills-finish">
                                    @if(Auth::user()->peran_pengguna == '1')
                                        <!-- <button class="btn btn-inverse-success mb-2 btn-sm float-right" data-toggle="modal" data-target="#modal-export-cg"><i class="icon-file"></i> Export to Excel</button> -->
                                    @endif
                                    <div class="table-responsive mt-2">
                                        <table class="display expandable-table table-striped table-hover" id="table-taging-finish" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No Taging</th>
                                                    <th>Date Verified</th>
                                                    <th>NIK</th>
                                                    <th>Employee Name</th>
                                                    <th>Skill Category</th>
                                                    <th>Competency</th>
                                                    <th>Level</th>
                                                    <th>Actual</th>
                                                    <th>Target</th>
                                                    <th style="width: max-content" class="text-center">Tagging Status</th>
                                                    @if(Auth::user()->peran_pengguna != '3')
                                                    <th style="width: max-content" class="text-center">Action</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane container fade" id="finish-last">
                                    <div class="table-responsive mt-2">
                                        <table class="display expandable-table table-striped table-hover" id="last-year-finish" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No Taging</th>
                                                    <th>Date Verified</th>
                                                    <th>NIK</th>
                                                    <th>Employee Name</th>
                                                    <th>Skill Category</th>
                                                    <th>Competency</th>
                                                    <th>Year</th>
                                                    <th>Level</th>
                                                    <th>Actual</th>
                                                    <th>Target</th>
                                                    <th style="width: max-content" class="text-center">Tagging Status</th>
                                                    @if(Auth::user()->peran_pengguna != '3')
                                                    <th style="width: max-content" class="text-center">Action</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                        </div>
                    </div>
                {{--
                @if(Auth::user()->peran_pengguna == '1')
                <ul class="nav nav-pills pb-0">
                </ul>
                @elseif(Auth::user()->peran_pengguna == '2')
                    <div class="container" id="pills-profile">
                        <div class="table-responsive">
                            <table class="display expandable-table table-striped table-hover" id="table-taging-cg" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No Taging</th>
                                        <th>NIK</th>
                                        <th>Employee Name</th>
                                        <th>Skill Category</th>
                                        <th width="100px">Competency</th>
                                        <th>Level</th>
                                        <!-- <th>Competenc Group</th> -->
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
                @elseif(Auth::user()->peran_pengguna == '3')
                    <div class="table-responsive">
                        <table class="display expandable-table table-striped table-hover" id="tbl-tag-member" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No Taging</th>
                                    <th>NIK</th>
                                    <th>Employee Name</th>
                                    <th>Skill Category</th>
                                    <th>Competency</th>
                                    <th>Level</th>
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
                                    <th>Level</th>
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
                @elseif(Auth::user()->id_level == 'LV-0004')
                    <div class="table-responsive">
                        <table class="display expandable-table table-striped table-hover" id="tabel-tag-spv" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No Taging</th>
                                    <th>NIK</th>
                                    <th>Employee Name</th>
                                    <th>Skill Category</th>
                                    <th>Competency</th>
                                    <th>Level</th>
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
                --}}
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
            <form action="{!!route('actionTagingList')!!}" method="post" enctype="multipart/form-data" id="formTaging">
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
            <div class="modal-body" id="body-detail" style="padding : 10px 10px !important; background-color: #eee;">
            </div>
            <div class="modal-footer p-1">
                <button type="button" class="btn btn-sm btn-secondary text-white" data-dismiss="modal">Close</button>
                <button type="button" id="btn-print" onclick="printCompetencyTag(this)" data-id="" class="btn btn-sm btn-primary">Print</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet"  href="{{asset('assets/css/datatables/jquery.dataTables.min.css') }}" type="text/css"/>
    <link href="{{asset('assets/css/datatables/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush

@push('script')
<script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/vendors/datatables.net/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/vendors/datatables.net/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/vendors/datatables.net/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
<script src="{{asset('assets/vendors/datatables.net/export-table-data.js')}}"></script>
<script src="{{ asset('assets/vendors/datatables.net/jszip.min.js') }}" type="text/javascript"></script>

<script type="text/javascript">
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    $(document).ready(function () {
        $(".nav-pills a").click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    });

    $('.nav-pills a').on('shown.bs.tab', function (e) {
        var target = $(e.target).attr("href"); // Get the target tab content
        $('.tab-pane').hide(); // Hide all tab content
        $(target).show(); // Show the active tab content
    });
    });
    $(document).ready(function () {
        iniDatatable();
        tagingCgDataTable();
        tagingLastDataTable();
        getCg();
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
                    url: '{{ route('tagging.destroy') }}',
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
        var currentDate = new Date();
            @if(Auth::user()->peran_pengguna == '1' || Auth::user()->peran_pengguna == '2')
            var buttons = [
                // 'copy', 'csv', 'excel', 'pdf', 'print'
                {
                extend: 'copy',
                },
                {
                extend: 'csv',
                title: 'Follow Up_' + currentDate.getDate() + '-' + (currentDate.getMonth() + 1) + '-' + currentDate.getFullYear()
                },
                {
                extend: 'excel',
                title: 'Follow Up_' + currentDate.getDate() + '-' + (currentDate.getMonth() + 1) + '-' + currentDate.getFullYear()
                },
            ];
            @else
            var buttons = [];
            @endif
        var dtJson = $('#table-taging-list').DataTable({
            ajax: "{{ route('taggingJson') }}",
            responsive:true,
            serverSide: true,
            processing: true,
            aaSorting: [
                [0, "desc"]
            ],
            searching: true,
            dom: 'lBfrtip',
            buttons: buttons,
            displayLength: 10,
            lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
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
                    data: 'training_module'
                },
                {
                    data: 'level'
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
                @if(Auth::user()->peran_pengguna != '3')
                {
                    data: 'action'
                }
                @endif
            ]
        });
    }
      
    function tagingCgDataTable() {
        var currentDate = new Date();
        @if(Auth::user()->peran_pengguna == '1' || Auth::user()->peran_pengguna == '2')
        var buttons = [
            // 'copy', 'csv', 'excel', 'pdf', 'print'
            {
            extend: 'copy',
            },
            {
            extend: 'csv',
            title: 'Finish Taging_' + currentDate.getDate() + '-' + (currentDate.getMonth() + 1) + '-' + currentDate.getFullYear()
            },
          {
            extend: 'excel',
            title: 'Finish Taging_' + currentDate.getDate() + '-' + (currentDate.getMonth() + 1) + '-' + currentDate.getFullYear()
            },
        ];
        @else
        var buttons = [];
        @endif
        
        var dtJson = $('#table-taging-finish').DataTable({
          ajax: "{{ route('taggingFinishJson') }}",
          responsive:true,
          serverSide: true,
          processing: true,
          aaSorting: [
              [0, "desc"]
          ],
          searching: true,
          dom: 'lBfrtip',
          buttons: buttons,
          displayLength: 10,
          lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
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
                  data: 'date_verified',
                  render: function(data) { return new Date(data).toLocaleDateString('en-GB'); }
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
                  data: 'training_module'
              },
              {
                  data: 'level'
              },
              {
                  data: 'actual'
              },
              {
                  data: 'note_target'
              },
              {
                 data: 'tagingStatus'
              },
              @if(Auth::user()->peran_pengguna != '3')
              {
                 data: 'action'
              }
              @endif
          ]
      });
    }
    function tagingLastDataTable() {
        var currentDate = new Date();
        @if(Auth::user()->peran_pengguna == '1' || Auth::user()->peran_pengguna == '2')
        var buttons = [
            // 'copy', 'csv', 'excel', 'pdf', 'print'
            {
            extend: 'copy',
            },
            {
            extend: 'csv',
            title: 'Finish Taging_' + currentDate.getDate() + '-' + (currentDate.getMonth() + 1) + '-' + currentDate.getFullYear()
            },
          {
            extend: 'excel',
            title: 'Finish Taging_' + currentDate.getDate() + '-' + (currentDate.getMonth() + 1) + '-' + currentDate.getFullYear()
            },
        ];
        @else
        var buttons = [];
        @endif
        
        var dtJson = $('#last-year-finish').DataTable({
          ajax: "{{ route('taggingLastJson') }}",
          responsive:true,
          serverSide: true,
          processing: true,
          aaSorting: [
              [0, "desc"]
          ],
          searching: true,
          dom: 'lBfrtip',
          buttons: buttons,
          displayLength: 10,
          lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
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
                  data: 'date_verified',
                  render: function(data) { return new Date(data).toLocaleDateString('en-GB'); }
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
                  data: 'training_module'
              },
              {
                  data: 'year'
              },
              {
                  data: 'level'
              },
              {
                  data: 'actual'
              },
              {
                  data: 'note_target'
              },
              {
                 data: 'tagingStatus'
              },
              @if(Auth::user()->peran_pengguna != '3')
              {
                 data: 'action'
              }
              @endif
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
