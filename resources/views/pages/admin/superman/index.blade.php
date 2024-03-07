@extends('layouts.master')

@section('title', 'Mapping Competency Superman')
@section('content')

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <div class="row">
                    <p class="card-title ml-4">Mapping Competency Superman</p>
                </div>
                <ul class="nav nav-pills nav-home">
                    <li class="nav-item active">
                        <a class="nav-link active btn-primary" data-toggle="tab" href="#pills-home" type="button" data-toggle="tooltip" data-placement="top" title="All Competencies">All</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-primary" data-toggle="tab" href="#pills-profile" type="button" data-toggle="tooltip" data-placement="top" title="General Corporate Competencies">General Corporate</a>
                    </li>
                </ul>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tab-pane container fade in active show tab-all" id="pills-home">
                                <div class="table-responsive">
                                    <table class="nowrap expandable-table table-striped table-hover" id="table-kelola-superman" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Department</th>
                                                <th>Jabatan</th>
                                                <th>Level</th>
                                                <th width="15%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane container fade tab-all" id="pills-profile">
                                <div class="table-responsive">
                                    <table class="nowrap expandable-table table-striped table-hover" id="table-general-corporate" width="100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Department</th>
                                                <th>Jabatan</th>
                                                <th>Level</th>
                                                <th width="15%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
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

    <!-- All -->
    <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modal-edit"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header p-3">
                    <h5 class="modal-title" id="modal-edit-title">Manage Mapping Competencies Superman</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{!! route('action.superman') !!}" id="formSuperman" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="user_id" name="user_id" value="">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="display expandable-table table-striped table-hover" id="table-edit-superman" style="width:100%">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="text-center">No</th>
                                    <th rowspan="2">No. Competency</th>
                                    <th rowspan="2">Skill Category</th>
                                    <th rowspan="2">Competency</th>
                                    <th rowspan="2">Competency Group</th>
                                    <th colspan="4" class="text-center">Action</th>
                                    <th class="text-center" rowspan="2">Status</th>
                                </tr> 
                                <tr>
                                    <th class="text-center" style="min-width:90px">Start</th>
                                    <th class="text-center" style="min-width:90px">Actual</th>
                                    <th class="text-center" style="min-width:50px">Target</th>
                                    <th class="text-center" style="min-width:90px">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody id="formMapComp">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="submitSuperman" class="btn btn-primary">Save changes</button>
                </div>
            </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="modal-editLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header p-3">
                    <h5 class="modal-title" id="modal-detailLabel">Detail Superman</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="display expandable-table table-striped table-hover" id="table-detail">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>No Competency</th>
                                    <th>Skill Category</th>
                                    <th>Competency</th>
                                    <th>Competency Group</th>
                                    <th>Start</th>
                                    <th>Actual</th>
                                    <th>Target</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
                                </tr> 
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Corporate -->
    <div class="modal fade" id="modal-edit-corporate" tabindex="-1" role="dialog" aria-labelledby="modal-edit"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header p-3">
                    <h5 class="modal-title" id="modal-edit-title-corporate">Manage Mapping Competencies Superman</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{!! route('action.corporate.superman') !!}" id="formCorporate" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="id_user" name="id_user" value="">
                <div class="modal-body">
                <ul class="nav nav-pills nav-corporate">
                    <li class="nav-item active">
                        <a class="nav-link active btn-outline-primary" data-toggle="tab" href="#tab-home" type="button" data-toggle="tooltip" data-placement="top" title="All Competencies">Pengisian</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-outline-primary" data-toggle="tab" href="#tab-content" type="button" data-toggle="tooltip" data-placement="top" title="General Corporate Competencies">Keterangan Skala</a>
                    </li>
                </ul>
                <div class="row">
                    <div class="col-md-12">
                        <div class="tab-pane container fade in active show tab-corporate" id="tab-home">
                            <div class="row mb-1">
                                <div class="col-md-6">
                                    <div class="form-group ml-1 mb-1 mt-1">
                                        <label for="id_depthead" class="col-sm-5">Asesor</label>
                                        <div class="col-sm-12">
                                            <select id="id_depthead" class="selectpicker form-control form-control-sm"
                                                name="id_depthead" data-live-search="true" data-hide-disabled="true"
                                                data-actions-box="true">
                                                <option class="select-cr" value="{{Auth::user()->id}}">{{Auth::user()->nama_pengguna}}</option>
                                                @foreach($head as $depthead)
                                                <option class="select-cr" value="{{$depthead->id}}">{{$depthead->nama_pengguna}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="display expandable-table table-striped table-hover" id="table-edit-corporate" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" class="text-center">No</th>
                                            <th rowspan="2">No. Competency</th>
                                            <th rowspan="2">Skill Category</th>
                                            <th rowspan="2">Competency</th>
                                            <th rowspan="2">Competency Group</th>
                                            <th colspan="4" class="text-center">Action</th>
                                            <th class="text-center" rowspan="2">Status</th>
                                        </tr> 
                                        <tr>
                                            <th class="text-center" style="min-width:50px">Start</th>
                                            <th class="text-center" style="min-width:90px">Actual</th>
                                            <th class="text-center" style="min-width:50px">Target</th>
                                            <th class="text-center" style="min-width:90px">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody id="formMapCompCorporate">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane container fade tab-corporate" id="tab-content">
                            <div class="table-responsive">
                                <table class="display expandable-table table-striped table-hover" id="table-scale"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" class="text-center">No</th>
                                            <th rowspan="2" class="text-center">Nama Curriculum</th>
                                            <th colspan="5" class="text-center">Scale</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center">1</th>
                                            <th class="text-center">2</th>
                                            <th class="text-center">3</th>
                                            <th class="text-center">4</th>
                                            <th class="text-center">5</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
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
    <div class="modal fade" id="modal-detail-corporate" tabindex="-1" role="dialog" aria-labelledby="modal-editLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header p-3">
                    <h5 class="modal-title" id="modal-detailCorporate">Detail Superman</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="display expandable-table table-striped table-hover" id="table-detail-corporate">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>No Competency</th>
                                    <th>Skill Category</th>
                                    <th>Competency</th>
                                    <th>Competency Group</th>
                                    <th>Start</th>
                                    <th>Actual</th>
                                    <th>Target</th>
                                    <th>Keterangan</th>
                                    <th>Asesor</th>
                                    <th>Status</th>
                                </tr> 
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
        $(document).ready(function() {
            initDatatable();
            generalCorporateDatatable();
            scaleDatatable();
            $(".nav-home a").click(function(){
                $(this).tab('show');
            });

            $('.nav-home a').on('show.bs.tab', function(){
                $('.tab-all').each(function(i,obj){
                    if(!$(this).hasClass("active")){
                        $(this).show()
                    }else{
                        $(this).hide()
                    }
                });
            })
            $(".nav-corporate a").click(function(){
                $(this).tab('show');
            });

            $('.nav-corporate a').on('show.bs.tab', function(){
                $('.tab-corporate').each(function(i,obj){
                    if(!$(this).hasClass("active")){
                        $(this).show()
                    }else{
                        $(this).hide()
                    }
                });
            })
        });
    $("#submitSuperman").click(function (e) {
        var tableEdit = $('#table-edit-superman').DataTable();
        e.preventDefault()
        var form = $("#formSuperman")
        const url = form.attr("action");
        var formSerialize = $("#formSuperman > input[name=user_id], input[name=_token]").serialize()
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
                $("#modal-edit").modal('hide');
                $('#table-kelola-superman').DataTable().destroy();
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
        var tableEdit = $('#table-edit-corporate').DataTable();
        e.preventDefault()
        var form = $("#formCorporate")
        const url = form.attr("action");
        var formSerialize = $("#formCorporate > input[name=id_user], select[name=id_depthead], input[name=_token]").serialize()
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
                $("#modal-edit-corporate").modal('hide');
                $('#table-general-corporate').DataTable().destroy();
                generalCorporateDatatable();
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
    function initDatatable() {
        var dtJson = $('#table-kelola-superman').DataTable({
            ajax: "{{ route('superman.json') }}",
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
                    data: 'nama_department'
                },
                {
                    data: 'nama_job_title'
                },
                {
                    data: 'nama_level'
                },
                {
                    data: 'action'
                }
            ],
        })
    }
    function generalCorporateDatatable() {
        var dtJson = $('#table-general-corporate').DataTable({
            ajax: "{{ route('corporate.json') }}",
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
                    data: 'nama_department'
                },
                {
                    data: 'nama_job_title'
                },
                {
                    data: 'nama_level'
                },
                {
                    data: 'action'
                }
            ],
        })
    }

    function getCompSuperman(id, el) {
        $("#user_id").val(id);
        var nama = $(el).attr("userName")

        $("#modal-edit-title").html('Superman Competencies <b>('+nama+')</b>')
        const url = "{{ route('form.superman') }}?id="+id+"&type=general";
        $.ajax({
            url:url,
            cache:false,
            success: function(html) {
                // console.log(html);
                $("#formMapComp").show();
                if($.fn.DataTable.isDataTable('#table-edit-superman')){
                    $('#table-edit-superman').DataTable().destroy()
                }
                $("#formMapComp").html(html);
                $('#table-edit-superman').DataTable({
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

    function detailMapcomSuperman(id, el) {
        const url = "{{ route('detail.kelola.superman') }}?id="+id+"&type=general";
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
                    data: 'no_curriculum'
                },
                {
                    data: 'skill_category'
                },
                {
                    data: 'curriculum_superman'
                },
                {
                    data: 'curriculum_group'
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

    function getCorporateSuperman(id, el) {
        $("#id_user").val(id);
        var nama = $(el).attr("userName")

        $("#modal-edit-title-corporate").html('General Competencies Corporate <b>('+nama+')</b>')
        const url = "{{ route('form.corporate.superman') }}?id="+id+"&type=general";
        $.ajax({
            url:url,
            cache:false,
            success: function(html) {
                // console.log(html);
                $("#formMapCompCorporate").show();
                if($.fn.DataTable.isDataTable('#table-edit-corporate')){
                    $('#table-edit-corporate').DataTable().destroy()
                }
                $("#formMapCompCorporate").html(html);
                $('#table-edit-corporate').DataTable({
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
    function detailMapCorporateSuperman(id, el) {
        const url = "{{ route('detail.corporate.superman') }}?id="+id+"&type=general";
        var name = $(el).attr("userName");
        $("#modal-detailCorporate").html('Detail Mapping Competencies <b>('+name+')</b>')
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
                    data: 'no_curriculum'
                },
                {
                    data: 'skill_category'
                },
                {
                    data: 'curriculum_superman'
                },
                {
                    data: 'curriculum_group'
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
                    data: 'nama_pengguna'
                },
                {
                    data: 'tagingStatus'
                },
            ]
        });

    }
    function scaleDatatable() {
        var dtJson = $('#table-scale').DataTable({
            ajax: "{{ route('scale.corporate.superman') }}",
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
            scrollX: false,
            columns: [
                {
                data: 'DT_RowIndex', name: 'DT_RowIndex'
                },
                {
                    data: 'curriculum_corporate'
                },
                {
                    data: 'scale_1'
                },
                {
                    data: 'scale_2'
                },
                {
                    data: 'scale_3'
                },
                {
                    data: 'scale_4'
                },
                {
                    data: 'scale_5'
                },
            ],
        });
    }
    </script>
@endpush
