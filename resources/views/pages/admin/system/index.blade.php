@extends('layouts.master')

@section('title', 'Certification')

@push('style')
@endpush
@section('content')

    <div class="row">

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <div class="row">
                        <p class="card-title ml-4">Manage Certification</p>
                        <div class="col-md mb-2">
                        <a class="btn btn-success btn-sm float-right btnAdd ml-2" href="javascript:void(0)" id="createNewItem"><i
                                    class="icon-plus"></i> Sertifikasi User</a>
                        <a class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#modal_import" data-whatever="@mdo"><i
                                    class="icon-plus"></i> Import User</a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="display expandable-table table table-striped table-hover" id="table-skill"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Kayawan</th>
                                            <th>Certification</th>
                                            <th>Nomor Sertifikat</th>
                                            <th>Akhir Masa Berlaku Sertifikat</th>
                                            <th>Nomor Surat Lisensi</th>
                                            <th>Akhir Masa Berlaku Lisensi</th>
                                            <th>Start</th>
                                            <th>Actual</th>
                                            <th>Target</th>
                                            <!-- <th>Katerangan</th> -->
                                            <!-- <th>Description</th> -->
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
        <div class="modal-dialog modal-xl" style="max-width:750px;" role="document">
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
                        <div class="row">
                            <div class="col-6">
                                <div class="form-row mb-3">
                                    <div class="col">
                                        <label>Pilih Karyawan</label>
                                        <select id="user" class="form-control form-control-sm" name="user">
                                            <option value="">Pilih User</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-row mb-3">
                                    <div class="col">
                                        <label>Pilih Certification Module</label>
                                        <select id="system" class="form-control form-control-sm" name="system">
                                            <option value="">Pilih System Module</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row p-0">
                            <div class="col-4 p-0">
                                <div class="form-group">
                                    <div class="col">
                                        <label for="start">Start</label>
                                        <select class="form-control form-control-sm" name="start" id="start" required>
                                            <option value="">Pilih Start</option>
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 p-0">
                                <div class="form-group">
                                    <div class="col">
                                        <label for="actual">Actual</label>
                                        <select class="form-control form-control-sm" name="actual" id="actual" required>
                                            <option value="">Pilih Actual</option>
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 p-0">
                                <div class="form-group">
                                    <div class="col">
                                        <label for="target">Target</label>
                                        <input type="text" class="form-control form-control-sm" name="target" id="target" value="" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row p-0">
                            <div class="col-6 p-0">
                                <div class="form-group">
                                    <div class="col">
                                        <label for="start">Nomor Sertifikat</label>
                                        <input type="text" class="form-control form-control-sm" name="no_sertifikat" id="no_sertifikat" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 p-0">
                                <div class="form-group">
                                    <div class="col">
                                        <label for="start">Akhir Masa Berlaku Sertifikat</label>
                                        <input type="date" class="form-control form-control-sm" name="masa_berlaku_sertif" id="masa_berlaku_sertif">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 p-0">
                                <div class="form-group">
                                    <div class="col">
                                        <label for="start">Nomor Surat Lisensi</label>
                                        <input type="text" class="form-control form-control-sm" name="no_surat_lisensi" id="no_surat_lisensi">
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 p-0">
                                <div class="form-group">
                                    <div class="col">
                                        <label for="start">Akhir Masa Berlaku Lisensi</label>
                                        <input type="date" class="form-control form-control-sm" name="masa_berlaku_lisensi" id="masa_berlaku_lisensi">
                                    </div>
                                </div>
                            </div>
                            
                            
                        </div>
                        <div class="row">
                            <div class="col-12">
                            <label for="keterangan">Keterangan</label>
                                <textarea class="form-control form-control-sm" name="keterangan" id="keterangan"></textarea>
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
                    <h5 class="modal-title" id="">Import User Management System</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-import-member" method="POST" enctype="multipart/form-data">
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
            initDatatable();
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

            modalTitle.text('Certification User');
            modal.modal('show');
        })

        $('body').on('click', '.btnEdit', function() {
            var id = $(this).data('id');
            var user = $(this).data('nama');
            var system = $(this).data('system');
            var target = $(this).data('value');
            var actual = $(this).data('actual');
            var no_sertifikat = $(this).data('sertif');
            var keterangan = $(this).data('keterangan');
            var actual = $(this).data('actual');
            var no_surat_lisensi = $(this).data('surat');
            var masa_lisensi = $(this).data('masa-lisensi');
            var masa_sertif = $(this).data('masa-sertif');
            var start = $(this).data('start');
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
            $('#target').val(target);
            $('#actual').val(actual);
            $('#no_sertifikat').val(no_sertifikat);
            $('#keterangan').val(keterangan);
            $('#target').val(target);
            $('#masa_berlaku_lisensi').val(masa_lisensi);
            $('#masa_berlaku_sertif').val(masa_sertif);
            $('#no_surat_lisensi').val(no_surat_lisensi);
            $('#start').val(start);
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
        $('#form-import-member').on('submit', function(e) {
            e.preventDefault();
            var form = new FormData($('#form-import-member')[0]);
            $.ajax({
                url: "{{ route('member.system.import') }}",
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
            $('#user').empty();
            $('#system').empty();
        })

        $(function() {
            $('#system').on('change', function() {
                var system = $(this).val();
                $.ajax({
                    url: "{{ route('system.get.target') }}",
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        id: system
                    },
                    success: function(res) {
                        $('#target').empty();
                        var val_target = res[0].target;
                        $('#target').val(val_target);
                    }
                })
            })
        })
        function initDatatable() {
            @if(Auth::user()->peran_pengguna == '1')
            var buttons = [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ];
            @else
            var buttons = [];
            @endif
            var dtJson = $('#table-skill').DataTable({
            ajax: "{{ route('master.system.json') }}",
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
                    data: 'nama_pengguna'
                },
                {
                    data: 'nama_system'
                },
                {
                    data: 'no_sertifikat'
                },
                {
                    data: 'masa_berlaku_sertif', 
                    render: function(data) {
                        if (data) {
                            return new Date(data).toLocaleDateString('en-GB');
                        } else {
                            return '';
                        }
                    }
                },
                {
                    data: 'no_surat_lisensi'
                },
                {
                    data: 'masa_berlaku_lisensi', 
                    render: function(data) {
                        if (data) {
                            return new Date(data).toLocaleDateString('en-GB');
                        } else {
                            return '';
                        }
                    }
                },
                {
                    data: 'start'
                },
                {
                    data: 'actual'
                },
                {
                    data: 'target'
                },
                // {
                //     data: 'keterangan'
                // },
                {
                    data: 'action'
                }
            ],
        });
    }
    </script>
@endpush
