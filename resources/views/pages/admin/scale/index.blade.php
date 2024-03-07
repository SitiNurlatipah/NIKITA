@extends('layouts.master')

@section('title', 'Scale Corporate Competency  Page')

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
                    <p class="card-title">Scale Corporate Competency</p>
                    <div class="row">
                        <div class="col-md mb-2">
                            <a class="btn btn-success float-right btnAdd" href="javascript:void(0)" id="createNewItem"><i
                                    class="icon-plus"></i> Tambah
                                Skala</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="display expandable-table table-striped table-hover table-bordered" id="table-scale"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" width="10" class="text-center">No</th>
                                            <th rowspan="2" class="text-center">Nama Curriculum</th>
                                            <th rowspan="2" class="text-center">Golongan</th>
                                            <th colspan="5" class="text-center">Scale</th>
                                            <th rowspan="2" class="text-center">Action</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center">1</th>
                                            <th class="text-center">2</th>
                                            <th class="text-center">3</th>
                                            <th class="text-center">4</th>
                                            <th class="text-center">5</th>
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
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header p-3">
                    <h5 class="modal-title" id="modal-tambahLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="javascript:void(0)" method="POST" id="form">
                    @csrf
                    <input type="hidden" name="id_scale" id="id_scale">
                    <div class="modal-body">
                        <div class="form-row mt-3">
                            <div class="col-md-8 mb-3">
                                <label>Nama Kompetensi Corporate</label>
                                <input type="text" class="form-control form-control-sm" name="nama_kompetensi"
                                    placeholder="Nama kompetensi" id="nama_kompetensi">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Golongan</label>
                                <select class="form-control form-control-sm" name="golongan" id="golongan">
                                    <option value="">Pilih Golongan</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label>Skala 1</label>
                                <textarea class="form-control" name="scale_1" id="scale_1" cols="30" rows="12"></textarea>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label>Skala 2</label>
                                <textarea class="form-control" name="scale_2" id="scale_2" cols="30" rows="12"></textarea>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label>Skala 3</label>
                                <textarea class="form-control" name="scale_3" id="scale_3" cols="30" rows="12"></textarea>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Skala 4</label>
                                <textarea class="form-control" name="scale_4" id="scale_4" cols="30" rows="12"></textarea>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label>Skala 5</label>
                                <textarea class="form-control" name="scale_5" id="scale_5" cols="30" rows="12"></textarea>
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
        // $('#table-skill').DataTable();
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
            $('#id_scale').val('');
            $('#nama_kompetensi').val('');
            $('#golongan').val('');
            $('#scale_1').val('');
            $('#scale_2').val('');
            $('#scale_3').val('');
            $('#scale_4').val('');
            $('#scale_5').val('');
            modalTitle.text('Tambah Skala');
            modal.modal('show');
        })

        $('body').on('click', '.btnEdit', function() {
            modalTitle.text('Edit Skala');
            var id = $(this).data('id');
            var nama_kompetensi = $(this).data('kompetensi');
            var golongan = $(this).data('golongan');
            var scale_1 = $(this).data('scale-satu');
            var scale_2 = $(this).data('scale-dua');
            var scale_3 = $(this).data('scale-tiga');
            var scale_4 = $(this).data('scale-empat');
            var scale_5 = $(this).data('scale-lima');
            $('#id_scale').val(id);
            $('#nama_kompetensi').val(nama_kompetensi);
            $('#golongan').val(golongan);
            $('#scale_1').val(scale_1);
            $('#scale_2').val(scale_2);
            $('#scale_3').val(scale_3);
            $('#scale_4').val(scale_4);
            $('#scale_5').val(scale_5);
            modal.modal('show');
        })

        $('body').on('click', '.btnHapus', function() {
            var id_scale = $(this).data('id');
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
                        url: '{{ route('scale.destroy') }}',
                        type: 'POST',
                        dataType: 'JSON',
                        data: {
                            id_scale
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
                url: '{{ route('scale.store') }}',
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
            $('#id_scale').val('');
            $('#nama_level').val('');
        })
        function initDatatable() {
            var dtJson = $('#table-scale').DataTable({
                ajax: "{{ route('scale.corporate.get') }}",
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
                        data: 'curriculum_corporate'
                    },
                    {
                        data: 'golongan'
                    },
                    {
                        data: 'scale_1'
                    },
                    {
                        data: 'scale_2'
                    },
                    {
                        data: 'scale_3'
                    },
                    {
                        data: 'scale_4'
                    },
                    {
                        data: 'scale_5'
                    },
                    {
                        data: 'action'
                    }
                ],
            });
        }
    </script>
@endpush
