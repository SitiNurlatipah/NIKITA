@extends('layouts.master')

@section('title', 'Curriculum')
@section('content')

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <div class="row">
                    <p class="card-title ml-4">Kelola Superman</p>
                    <div class="col-md mb-2">
                        <a class="btn btn-sm btn-success float-right" href="javascript:void(0)" id="createNewItem"
                            data-toggle="modal" data-target="#modal-tambah"><i class="icon-plus"></i> Enroll Superman</a>
                    </div>
                </div>
                    <div class="row">
                        <div class="col-md-12">
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
                                    <th rowspan="2">Level</th>
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
    <!-- 
    <div class="modal fade" id="modal-detail-user" tabindex="-1" role="dialog" aria-labelledby="modal-editLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header p-3">
                    <h5 class="modal-title" id="modal-editLabel">Detail User Asign</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul id="tampil-user">
                    </ul> 
                </div>
            </div>
        </div>
    </div> -->

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
        });

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

    function getCompSuperman(id, el) {
        $("#user_id").val(id);
        var nama = $(el).attr("userName")

        $("#modal-edit-title").html('Superman Competencies <b>('+nama+')</b>')
        const url = "{{ route('form.superman') }}?id="+id+"&type=general";
        $.ajax({
            url:url,
            cache:false,
            success: function(html) {
                console.log(html);
                $("#formMapComp").show();
                // if($.fn.DataTable.isDataTable('#table-edit-superman')){
                //     $('#table-edit-superman').DataTable().destroy()
                // }
                $("#formMapComp").html(html);
                // table-edit-superman = $('#table-edit-superman').DataTable({
                //     searching: true,
                //     retrieve: true,
                //     paging: true,
                //     columnDefs: [
                //         {
                //             orderable: false,
                //             targets: [6, 7, 8],
                //         },
                //         { 
                //             width: "200px", 
                //             targets: 9 
                //         }
                //     ]
                // });
            },
            error: function(req, sts, err) {
                console.log(err);
            }

        });
}
    </script>
@endpush
