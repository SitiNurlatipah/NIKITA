@extends('layouts.master')

@section('title', 'Sub Department Page')

@push('style')
    <style>
        .swal2-popup {
            font-size: 2rem;
        }

    </style>
@endpush
@section('content')

    <div class="row">

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title">Sub Department</p>
                    <div class="row">
                        <div class="col-md mb-2">
                            <a class="btn btn-success float-right btnAdd" href="javascript:void(0)" id="createNewItem"><i
                                    class="icon-plus"></i> Tambah
                                Sub Department</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="display expandable-table table table-striped table-hover" id="table-skill"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="10">No.#</th>
                                            <th>Nama Department</th>
                                            <th>Nama Sub Department</th>
                                            <th width="15%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $item)
                                            <tr id="row_{{ $item->id_department }}">
                                                <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                                                <td>{{ $item->department->nama_department ?? '-' }}</td>
                                                <td>{{ $item->nama_subdepartment }}</td>
                                                <td>
                                                    <button data-id="{{ $item->id_subdepartment }}"
                                                        data-department="{{ $item->id_department }}"
                                                        data-namasubdepartment="{{ $item->nama_subdepartment }}"
                                                        class="btn btn-inverse-success btn-icon delete-button mr-1 mr-1 btnEdit"><i
                                                            class="icon-file menu-icon"></i></button>
                                                    <button data-id="{{ $item->id_subdepartment }}"
                                                        class="btn btn-inverse-danger btn-icon mr-1 cr-hapus btnHapus">
                                                        <i class="icon-trash">
                                                        </i></button>
                                                </td>
                                            </tr>
                                        @endforeach
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
                <form action="javascript:void(0)" method="POST" id="form">
                    @csrf
                    <input type="text" name="id" id="id" hidden>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col">
                                <label>Department</label>
                                <select id="department" class="form-control form-control-sm" name="department">
                                    <option value="">Pilih Department</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col mb-3">
                                <label>Nama Sub Department</label>
                                <input type="text" class="form-control form-control-sm" name="nama_subdepartment"
                                    placeholder="Nama Sub Department" id="nama_subdepartment">
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
@endsection
@push('script')
    <script>
        $('#table-skill').DataTable();
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

        });

        var modal = $('#myModal');
        var modalTitle = $('#myModal .modal-title');

        $('.btnAdd').on('click', function() {
            $('#id').val('');
            $('#nama_department').val('');
            $.ajax({
                url: '{{ route('get.department') }}',
                type: 'GET',
                dataType: 'JSON',
                success: function(response) {
                    $('#department').empty();
                    response.data.forEach(el => {
                        if (el.id_department == department) {
                            $('#department').append('<option selected value="' + el
                                .id_department + '">' + el.nama_department + '</option>');
                        } else {
                            $('#department').append('<option value="' + el.id_department +
                                '">' + el.nama_department + '</option>');
                        }
                    });
                }
            })
            modalTitle.text('Tambah Sub Department');
            modal.modal('show');
        })

        $('body').on('click', '.btnEdit', function() {
            var id = $(this).data('id');
            var department = $(this).data('department');
            $.ajax({
                url: '{{ route('get.department') }}',
                type: 'GET',
                dataType: 'JSON',
                success: function(response) {
                    $('#department').empty();
                    console.log(response);
                    response.data.forEach(el => {
                        if (el.id_department == department) {
                            $('#department').append('<option selected value="' + el
                                .id_department + '">' + el.nama_department + '</option>');
                        } else {
                            $('#department').append('<option value="' + el.id_department +
                                '">' + el.nama_department + '</option>');
                        }
                    });
                }
            })
            modalTitle.text('Edit Sub Department');

            var nama_subdepartment = $(this).data('namasubdepartment');
            $('#id').val(id);
            $('#nama_subdepartment').val(nama_subdepartment);
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
                        url: '{{ route('sub-department.destroy') }}',
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

        $('#form').on('submit', function(e) {
            e.preventDefault();
            var form = $('#form').serialize();
            $.ajax({
                url: '{{ route('sub-department.store') }}',
                type: "POST",
                data: form,
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
            $('#nama_subdepartment').val('');
            $('#department').empty();
        })
    </script>
@endpush
