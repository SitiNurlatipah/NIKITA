@extends('layouts.master')

@section('title', 'Curriculum')
@section('content')

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <div class="row">
                    <p class="card-title ml-4">Kelola Champion</p>
                    <!-- <div class="col-md mb-2">
                        <a class="btn btn-sm btn-success float-right" href="javascript:void(0)" id="createNewItem"
                            data-toggle="modal" data-target="#modal-tambah"><i class="icon-plus"></i> Enroll Champion</a>
                    </div> -->
                </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="nowrap expandable-table table-striped table-hover" id="table-kelola-champion" width="100%">
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

    {{-- Modal --}}
    <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modal-edit"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header p-3">
                    <h5 class="modal-title" id="modal-edit-title">Manage Mapping Competencies Champion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{!!route('action.champion')!!}" id="formChampion" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="user_id" name="user_id" value="">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="display expandable-table table-striped table-hover" id="table-edit-champion" style="width:100%">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="text-center">No</th>
                                    <th rowspan="2">No. Competency</th>
                                    <th rowspan="2">Skill Category</th>
                                    <th rowspan="2">Competency 4.0</th>
                                    <th rowspan="2">Competency Group</th>
                                    <th class="text-center" colspan="4">Action</th>
                                    <th class="text-center" rowspan="2">Status</th>
                                    <tr>
                                        <th class="text-center" style="min-width:90px">Start</th>
                                        <th class="text-center" style="min-width:90px">Actual</th>
                                        <th class="text-center" style="min-width:50px">Target</th>
                                        <th class="text-center" style="min-width:90px">Keterangan</th>
                                    </tr>
                                </tr> 
                            </thead>
                            <tbody id="formMapComp">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="submitChampion" class="btn btn-primary">Save changes</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="modal-detailLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header p-3">
                    <h5 class="modal-title" id="modal-detailLabel">Detail Champion</h5>
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

    function initDatatable() {
        var dtJson = $('#table-kelola-champion').DataTable({
            ajax: "{{ route('champion.json') }}",
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
            // scrollX: true,
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

    function getCompChampion(id, el) {
        $("#user_id").val(id);
        var nama = $(el).attr("userName")
        $("#modal-edit-title").html('Champion Competencies <b>('+nama+')</b>')
        const url = "{!! route('form.champion') !!}?id="+id+"&type=general";
        $.ajax({
            url:url,
            cache:false,
            success: function(html) {
                // console.log(html);  
                $("#formMapComp").show();
                if($.fn.DataTable.isDataTable('#table-edit-champion')){
                    $('#table-edit-champion').DataTable().destroy()
                }
                $("#formMapComp").html(html);
                $('#table-edit-champion').DataTable({
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

    $("#submitChampion").click(function (e) {
        var tableEdit = $('#table-edit-champion').DataTable();
        e.preventDefault()
        var form = $("#formChampion")
        const url = form.attr("action");
        var formSerialize = $("#formChampion > input[name=user_id], input[name=_token]").serialize()
        var serializeDatatable = tableEdit.$('input,select,textarea').serialize()
        var formData = formSerialize+'&'+serializeDatatable
        console.log(formSerialize)   
        $.ajax({
            url:url,
            type:"post",
            cache:false,
            data:formData,
            success:function(data){
                console.log(data);
                $("#modal-edit").modal('hide');
                $('#table-kelola-champion').DataTable().destroy();
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

    function detailMapcomChampion(id, el) {
        const url = "{{ route('detail.kelola.champion') }}?id="+id+"&type=general";
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
                    data: 'curriculum_champion'
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

    $(document).ready(function() {
        initDatatable();
    });
    </script>
@endpush
