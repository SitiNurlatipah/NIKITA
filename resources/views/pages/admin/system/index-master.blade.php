@extends('layouts.master')

@section('title', 'Master Certification')

@push('style')
@endpush
@section('content')

    <div class="row">

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <p class="card-title ml-4">Data Certification</p>
                        <div class="col-md mb-2">
                            <a class="btn btn-success btn-sm float-right btnAdd ml-2" href="javascript:void(0)" id="createNewItem"><i
                                    class="icon-plus"></i> Add Data Certification</a>
                            <a class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#modal_import" data-whatever="@mdo"><i
                                    class="icon-plus"></i> Import Certification</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="display expandable-table table-striped table-hover" id="table-system"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="10">No.#</th>
                                            <th>Certification</th>
                                            <th>Target</th>
                                            <th>Description</th>
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
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modal-tambahLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header p-3">
                    <h5 class="modal-title" id="modal-tambahLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="javascript:void(0)" method="POST" id="form-system">
                    @csrf
                    <input type="text" name="id" id="id" hidden>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col">
                                <label>Certification</label>
                                <input type="text" class="form-control form-control-sm" name="nama_system"
                                    placeholder="Certification Name" id="nama_system">
                            </div>
                        </div>
                        <div class="form-row mt-2">
                            <div class="col">
                                <label for="target">Target</label>
                                <select class="form-control form-control-sm" name="target" id="target" required>
                                    <option value="">Pilih Target</option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row mt-2">
                            <div class="col mb-3">
                                <label>Description</label>
                                <textarea class="form-control" placeholder="Input decsription" rows="3" name="description" id="description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_import" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-medium">
            <div class="modal-content">
                <div class="modal-header p-3">
                    <h5 class="modal-title" id="">Import Management System</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-import" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="file" name="file" class="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush
@push('script')
<script src="{{ asset('assets/select2/js/select2.min.js') }}"></script>
<script>
        // $('#table-skill').DataTable();
        $('#job_title').select2({
            theme:'bootstrap4'
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip({
                animation: true,
                plaGradent: "top",
                trigger: "hover focus"
            });
            initDatatable();
        });

        var modal = $('#myModal');
        var modalTitle = $('#myModal .modal-title');

        $('.btnAdd').on('click', function() {
            $('#id').val('');
            $('#nama_system').val('');
            $('#description').val('');
            modalTitle.text('Add Data Certification');
            modal.modal('show');
        })

        $('body').on('click', '.btnEdit', function() {
            var id = $(this).data('id');
            var nama_system = $(this).data('nama_system');
            var description = $(this).data('description');
            var target = $(this).data('target');
            modalTitle.text('Edit Data Certification');
            $('#id').val(id);
            $('#nama_system').val(nama_system);
            $('#description').val(description);
            $('#target').val(target);
            modal.modal('show');
        })

        $('body').on('click', '.btnHapus', function() {
            var id = $(this).data('id');
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
                        url: "{{ route('master.system.destroy') }}",
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

        $('#form-system').on('submit', function(e) {
            e.preventDefault();
            var form = $('#form-system').serialize();
            $.ajax({
                url: "{{ route('master.system.store') }}",
                type: "POST",
                data: form,
                success: function(response) {
                    Swal.fire({
                        icon: response.status,
                        text: response.message,
                        position: 'center',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    modal.modal('hide');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                },
                error: function(err) {
                    console.log(err)
                    Swal.fire({
                        icon: 'error',
                        text: err.responseJSON.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            });
        })
        $('#form-import').on('submit', function(e) {
            e.preventDefault();
            var form = new FormData($('#form-import')[0]);
            $.ajax({
                url: "{{ route('master.system.import') }}",
                type: "POST",
                data: form,
                contentType: false,
                processData: false,
                success: function(response) {
                    Swal.fire({
                        icon: response.status,
                        text: response.message
                    })
                    modal.modal('hide');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                },
                error: function(err) {
                    console.log(err)
                    Swal.fire({
                        icon: 'error',
                        text: err.responseJSON.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            });
        })
        $('#myModal').on('hidden.bs.modal', function() {
            $('#id').val('');
            $('#nama_system').val('');
            $('#description').val('');
        })
        function initDatatable() {
            @if(Auth::user()->peran_pengguna == '1')
            var buttons = [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ];
            @else
            var buttons = [];
            @endif
            var dtJson = $('#table-system').DataTable({
            ajax: "{{ route('member.system.json') }}",
            autoWidth: false,
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
                data: 'DT_RowIndex', name: 'DT_RowIndex'
                },
                {
                    data: 'nama_system'
                },
                {
                    data: 'target'
                },
                {
                    data: 'description'
                },
                {
                    data: 'action'
                }
            ],
            });
        }
    </script>
@endpush
