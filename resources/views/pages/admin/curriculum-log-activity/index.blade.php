@extends('layouts.master')

@section('title', 'Log HistoryCurriculum')

@push('style')
    <style>
        .swal2-popup {
            font-size: 2rem;
        }
        body {
        overflow-y:hidden;
        }
    </style>
@endpush
@section('content')

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <div class="row">
                    <p class="card-title ml-4">Log History Curriculum</p>
                    
                </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="display expandable-table table-striped table-hover" id="table-log"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Aktor</th>
                                            <th>Aktivitas</th>
                                            <th>Waktu</th>
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
            var dtJson = $('#table-log').DataTable({
                ajax: "{{ route('curriculumActivityLog.get') }}",
                autoWidth: false,
                serverSide: true,
                processing: true,
                aaSorting: [
                    [0, "desc"]
                ],
                searching: true,
                dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
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
                    data: 'DT_RowIndex', name: 'DT_RowIndex'
                    },
                    {
                        data: 'nama_pengguna'
                    },
                    {
                        data: 'action'
                    },
                    {
                        data: 'created_at', name: 'created_at'
                    },
                ],
            });
        }
    </script>
    
@endpush
