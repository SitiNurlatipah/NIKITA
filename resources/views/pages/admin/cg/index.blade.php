@extends('layouts.master')

@section('title', 'Master Grade Page ')

@section('content')
    <div class="row">
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title">Liga Circle Group</p>
                    <div class="row">
                        <div class="col-md mb-2">
                            <a class="btn btn-success float-right" href="javascript:void(0)" id="createNewItem"><i
                                    class="icon-plus"></i> Tambah CG</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="display expandable-table table table-sm table-striped table-hover"
                                    id="table-grade" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width="10">No.</th>
                                            <th>Circle Group</th>
                                            <th>Department</th>
                                            <th width="15%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $data)
                                            <tr id="row_{{ $data->id_cg }}">
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $data->nama_cg }}</td>
                                                <td>{{ $data->department->nama_department }}</td>
                                                <td>
                                                    <button data-id="{{ $data->id_cg }}"
                                                        data-nama="{{ $data->nama_cg }}"
                                                        data-department="{{ $data->id_department }}"
                                                        class="btn btn-inverse-success btn-icon mr-1 mr-1 btnEdit"><i
                                                            class="icon-file menu-icon"></i></button>
                                                    <button data-id="{{ $data->id_cg }}"
                                                        class="btn btn-inverse-danger btnHapus btn-icon mr-1 cr-hapus">
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
    <div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="modal-tambahLabel"
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
                            <div class="col mb-3">
                                <label>Nama CG</label>
                                <input type="text" class="form-control form-control-sm" name="nama_cg"
                                    placeholder="Nama Circle Group" id="nama_cg">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <label>Department</label>
                                <select id="department" class="form-control form-control-sm" name="department">
                                    <option value="">Pilih Department</option>
                                </select>
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

            getDepartment();
        });


        $('#table-grade').DataTable();
        var modal = $('#modal-tambah');
        var modalTitle = $('#modal-tambah .modal-title');

        $('#createNewItem').on('click', function() {
            modalTitle.text('Tambah Data CG');
            modal.modal('show');
        })

        $('body').on('click', '.btnEdit', function() {
            modalTitle.text('Edit Data CG');
            var id = $(this).data('id');
            var nama = $(this).data('nama');
            var department = $(this).data('department');

            $('#id').val(id);
            $('#nama_cg').val(nama);
            // get department
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
                        url: '{{ route('CG.destroy') }}',
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
                url: '{{ route('CG.post') }}',
                type: "POST",
                data: form,
                success: function(response) {
                    if (response.code == 200) {
                        Swal.fire({
                            icon: response.status,
                            text: response.message
                        })
                    }
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


        function getDepartment() {
            $.ajax({
                type: "GET",
                url: "{{ route('get.department') }}",
                success: function(res) {
                    var option = "";
                    for (let i = 0; i < res.data.length; i++) {
                        option += '<option value="' + res.data[i].id_department + '">' + res.data[i]
                            .nama_department + '</option>';
                    }
                    $('#department').html();
                    $('#department').append(option);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(xhr);
                    alert(xhr.status);
                    alert(thrownError);
                }
            })
        }
    </script>
@endpush
