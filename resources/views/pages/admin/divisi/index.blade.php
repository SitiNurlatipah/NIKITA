@extends('layouts.master')

@section('title', 'Divisi Page')

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
                    <p class="card-title">Divisi</p>
                    <div class="row">
                        <div class="col-md mb-2">
                            <a class="btn btn-success float-right btnAdd" href="javascript:void(0)" id="createNewItem"><i
                                    class="icon-plus"></i> Tambah
                                Divisi</a>
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
                                            <th>Nama Divisi</th>
                                            <th width="15%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($items as $item)
                                            <tr id="row_{{ $item->id_divisi }}">
                                                <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                                                <td>{{ $item->nama_divisi }}</td>
                                                <td>
                                                    <button data-id="{{ $item->id_divisi }}"
                                                        data-divisi="{{ $item->nama_divisi }}"
                                                        class="btn btn-inverse-success btn-icon delete-button mr-1 mr-1 btnEdit"><i
                                                            class="icon-file menu-icon"></i></button>
                                                    <button data-id="{{ $item->id_divisi }}"
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
                        <div class="form-row mt-3">
                            <div class="col mb-3">
                                <label>Nama Divisi</label>
                                <input type="text" class="form-control form-control-sm" name="nama_divisi"
                                    placeholder="Nama Divisi" id="nama_divisi">
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
            $('#nama_divisi').val('');
            modalTitle.text('Tambah Divisi');
            modal.modal('show');
        })

        $('body').on('click', '.btnEdit', function() {
            modalTitle.text('Edit Divisi');
            var id = $(this).data('id');

            var nama_divisi = $(this).data('divisi');
            $('#id').val(id);
            $('#nama_divisi').val(nama_divisi);
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
                        url: '{{ route('divisi.destroy') }}',
                        type: 'POST',
                        dataType: 'JSON',
                        data: {
                            id
                        },
                        success: function(response) {
                            Swal.fire(
                                'Success',
                                response.message,
                                response.status
                            )
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
                url: '{{ route('divisi.store') }}',
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
            $('#nama_divisi').val('');
        })
    </script>
@endpush
