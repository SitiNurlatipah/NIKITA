@extends('layouts.master')

@section('title', 'Management System')

@push('style')
@endpush
@section('content')

    <div class="row">

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <div class="row">
                        <p class="card-title ml-4">Management System</p>
                        <div class="col-md mb-2">
                        <a class="btn btn-success btn-sm float-right btnAdd" href="javascript:void(0)" id="createNewItem"><i
                                    class="icon-plus"></i> Tambah User</a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="expandable-table table table-striped table-hover" id="table-skill"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="10">No.#</th>
                                            <th>Nama Kayawan</th>
                                            <th>Management System</th>
                                            <th>Tingkat</th>
                                            <th>Description</th>
                                            <th width="15%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $item)
                                            <tr id="row_{{ $item->id }}">
                                                <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                                                <td>{{ $item->nama_pengguna}}</td>
                                                <td>{{ $item->nama_system }}</td>
                                                <td>{{ $item->value }}</td>
                                                <td>{{ $item->description }}</td>
                                                <td>
                                                    <button data-id="{{ $item->id_mstu }}"
                                                        data-nama="{{ $item->id }}"
                                                        data-system="{{ $item->id_system }}" data-value="{{ $item->value }}"
                                                        class="btn btn-inverse-success btn-icon delete-button mr-1 mr-1 btnEdit"><i
                                                            class="icon-file menu-icon"></i></button>
                                                    <button data-id="{{ $item->id_mstu }}" class="btn btn-inverse-danger btn-icon mr-1 btnHapus">
                                                        <i class="icon-trash"></i></button>
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
                                <label>Pilih Karyawan</label>
                                <select id="user" class="form-control form-control-sm" name="user">
                                    <option value="">Pilih User</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col">
                                <label>Pilih System Management Module</label>
                                <select id="system" class="form-control form-control-sm" name="system">
                                    <option value="">Pilih System Module</option>
                                </select>
                            </div>
                        </div>
                        <!-- <div class="form-row mt-3">
                            <div class="col mb-3">
                                <label>Nilai</label>
                                <input type="text" class="form-control form-control-sm" name="value"
                                    placeholder="Nilai" id="value">
                            </div>
                        </div> -->
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
        $('#table-skill').DataTable();
        $('#user').select2({
            theme:'bootstrap4'
        });
        $('#system').select2({
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

        });

        var modal = $('#myModal');
        var modalTitle = $('#myModal .modal-title');

        $('.btnAdd').on('click', function() {
            $('#id').val('');
            $('#user').val('');
            $('#system').val('');
            $.ajax({
                url: '{{ route("Member.get") }}',
                type: 'GET',
                dataType: 'JSON',
                success: function(response) {
                    // console.log(response);
                    $('#user').empty();
                    $('#user').append('<option selected disabled>-- Pilih Karyawan --</option>');
                    response.data.forEach(el => {
                        $('#user').append('<option value="' + el.id + '">' + el.nama_pengguna + ' - ' + el.nama_department + '</option>');
                    });
                }
            })
            $.ajax({
                url: '{{ route("master.system.get") }}',
                type: 'GET',
                dataType: 'JSON',
                success: function(response) {
                    // console.log(response);
                    $('#system').empty();
                    $('#system').append('<option selected disabled>-- Pilih System Module --</option>');
                    response.data.forEach(el => {
                        $('#system').append('<option value="' + el.id_system + '">' + el.nama_system + '</option>');
                    });
                }
            })

            modalTitle.text('Add User');
            modal.modal('show');
        })

        $('body').on('click', '.btnEdit', function() {
            var id = $(this).data('id');
            var user = $(this).data('nama');
            var system = $(this).data('system');
            modalTitle.text('Edit target');
            $.ajax({
                url: "{{ route('Member.get') }}",
                type: 'GET',
                dataType: 'JSON',
                success: function(response) {
                    $('#user').empty();
                    response.data.forEach(el => {
                        if (el.id == user) {
                            $('#user').append('<option selected value="' + el.id + '">' + el.nama_pengguna + '</option>');
                        } else {
                            $('#user').append('<option value="' + el.id +
                                '">' + el.nama_pengguna + '</option>');
                        }
                    });
                }
            })
            $.ajax({
                url: "{{ route('master.system.get') }}",
                type: 'GET',
                dataType: 'JSON',
                success: function(response) {
                    $('#system').empty();
                    response.data.forEach(el => {
                        if (el.id_system == system) {
                            $('#system').append('<option selected value="' + el.id_system + '">' + el.nama_system + '</option>');
                        } else {
                            $('#system').append('<option value="' + el.id_system + '">' + el.nama_system + '</option>');
                        }
                    });
                }
            })
            $('#id').val(id);
            $('#user').val(user);
            $('#system').val(system);
            modal.modal('show');
        })

        $('body').on('click', '.btnHapus', function() {
            var id_mstu = $(this).data('id');
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
                        url: "{{ route('system.destroy') }}",
                        type: 'POST',
                        dataType: 'JSON',
                        data: {
                            id_mstu
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
                url: "{{ route('system.store') }}",
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
            $('#user').empty();
            $('#system').empty();
        })
    </script>
@endpush
