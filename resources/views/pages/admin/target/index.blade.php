@extends('layouts.master')

@section('title', 'Target Page')

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
                    <p class="card-title">Target</p>
                    <div class="row">
                        <div class="col-md mb-2">
                            <a class="btn btn-success float-right btnAdd" href="javascript:void(0)" id="createNewItem"><i
                                    class="icon-plus"></i> Tambah
                                Target</a>
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
                                            <th>Job Title</th>
                                            <th>Nama Target</th>
                                            <th>Nilai</th>
                                            <th width="15%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $item)
                                            <tr id="row_{{ $item->id }}">
                                                <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                                                <td>{{ $item->jobtitle->nama_job_title ?? '-' }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->value }}</td>
                                                <td>
                                                    <button data-id="{{ $item->id }}"
                                                        data-jobtitle="{{ $item->id_job_title }}"
                                                        data-target="{{ $item->name }}" data-value="{{ $item->value }}"
                                                        class="btn btn-inverse-success btn-icon delete-button mr-1 mr-1 btnEdit"><i
                                                            class="icon-file menu-icon"></i></button>
                                                    <button data-id="{{ $item->id }}"
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
                                <label>Job Title</label>
                                <select id="job_title" class="form-control form-control-sm" name="job_title">
                                    <option value="">Pilih Job Title</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col mb-3">
                                <label>Nama</label>
                                <input type="text" class="form-control form-control-sm" name="nama_target"
                                    placeholder="Nama target" id="nama_target">
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="col mb-3">
                                <label>Nilai</label>
                                <input type="text" class="form-control form-control-sm" name="value"
                                    placeholder="Nilai" id="value">
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
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush
@push('script')
<script src="{{ asset('assets/select2/js/select2.min.js') }}"></script>
    <script>
        $('#table-skill').DataTable();
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

        });

        var modal = $('#myModal');
        var modalTitle = $('#myModal .modal-title');

        $('.btnAdd').on('click', function() {
            $('#id').val('');
            $('#nama_target').val('');
            $.ajax({
                url: '{{ route('get.jabatan') }}',
                type: 'GET',
                dataType: 'JSON',
                success: function(response) {
                    $('#job_title').empty();
                    $('#job_title').append('<option selected disabled>-- Pilih Job Title --</option>');
                    response.data.forEach(el => {
                        $('#job_title').append('<option value="' + el.id_job_title + '">' + el.nama_job_title + '</option>');
                    });
                }
            })
            modalTitle.text('Tambah target');
            modal.modal('show');
        })

        $('body').on('click', '.btnEdit', function() {
            var id = $(this).data('id');
            var job_title = $(this).data('job_title');
            var value = $(this).data('value');
            $.ajax({
                url: '{{ route('get.jabatan') }}',
                type: 'GET',
                dataType: 'JSON',
                success: function(response) {
                    $('#job_title').empty();
                    response.data.forEach(el => {
                        if (el.id_job_title == job_title) {
                            $('#job_title').append('<option selected value="' + el
                                .id_job_title + '">' + el.nama_job_title + '</option>');
                        } else {
                            $('#job_title').append('<option value="' + el.id_job_title +
                                '">' + el.nama_job_title + '</option>');
                        }
                    });
                }
            })
            modalTitle.text('Edit target');

            var nama_target = $(this).data('target');
            $('#id').val(id);
            $('#nama_target').val(nama_target);
            $('#value').val(value);
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
                        url: '{{ route('target.destroy') }}',
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
                url: '{{ route('target.store') }}',
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
            $('#nama_target').val('');
            $('#value').val('');
            $('#job_title').empty();
        })
    </script>
@endpush
