@extends('layouts.master')

@section('title', 'Curriculum')
@section('content')

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <div class="row">
                    <p class="card-title ml-4">Kelola Champion</p>
                    <div class="col-md mb-2">
                        <a class="btn btn-sm btn-success float-right" href="javascript:void(0)" id="createNewItem"
                            data-toggle="modal" data-target="#modal-tambah"><i class="icon-plus"></i> Enroll Champion</a>
                    </div>
                </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="nowrap expandable-table table-striped table-hover" id="table-kelola-Champion" width="100%">
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


@endsection
@push('script')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    function initDatatable() {
        var dtJson = $('#table-kelola-Champion').DataTable({
            ajax: "",
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

        $(document).ready(function() {
            initDatatable();
        });
    </script>
@endpush
