@extends('layouts.master')

@section('title', 'CEME')

@section('content')
    <div class="row">
        <div class="col-md-12">
                <ul class="nav nav-pills" style="border-bottom:0px">
                    <li class="nav-item active">
                        <a class="nav-link @if(request('q') !== 'all') btn-primary @else btn-secondary @endif btnDc btn-primary"  href="{{ route('ceme') }}" type="button">CEME CG</a>
                    </li>
                    @if(Auth::user()->peran_pengguna == 1)
                        <li class="nav-item">
                            <a class="nav-link btnDc  @if(request('q') === 'all') btn-primary @else btn-secondary @endif"  href="{{ route('ceme.all') }}" type="button">CEME All </a>
                        </li>
                    @endif
                </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card height-card" >
                <div class="card-body">
                    <h4 class="card-title">CEME</h4>
                    <div class="row">
                        <div class="col-6">
                            <h5>Competent Employee</h4>
                            <canvas id="pieChart"></canvas>
                        </div>
                        <div class="col-6">
                            <h5>Multiskill Employee</h4>
                            <canvas id="pieChart2"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Competent Employee</h4>
                    <span style="font-size: 14px;"><div class="mr-1 mt-1 mb-0 bg-warning" style="display:inline-block; width:15px; height:15px; border-radius: 50%; "></div><i>Indicate as Competent Employee</i></span>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="display expandable-table table table-sm table-striped table-hover mt-1"
                                    id="tblceme" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th style="width:10%">Name</th>
                                            <th style="width:10%">NIK</th>
                                            <th style="width:10%">CG</th>
                                            <th style="width:10%">Department</th>
                                            <th style="text-align:center">B </th>
                                            <th style="text-align:center">I </th>
                                            <th style="text-align:center">A </th>
                                            <th>Avr</th>
                                        </tr>
                                        <!-- <tr>
                                            <th colspan="3">Target</th>
                                            <th style="text-align:center">100% </th>
                                            <th style="text-align:center">85% </th>
                                            <th style="text-align:center">75% </th>
                                            <th style="text-align:center">86.67%</th>
                                        </tr> -->
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

    <div class="row">
    <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title">Multiskill Employee</p>
                    <div class="row">
                        {{-- <div class="col-md mb-2">
                        <a class="btn btn-success float-right" href="javascript:void(0)" id="createNewItem" data-toggle="modal" data-target="#modal-tambah"><i class="icon-plus"></i> Tambah CEME</a>
                    </div> --}}
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="display expandable-table table table-sm table-striped table-hover"
                                    id="table-ceme" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Name</th>
                                            <th>NIK</th>
                                            <th>Job Title</th>
                                            <th>Department</th>
                                            {{-- <th>Level</th> --}}
                                            <th>CG Name</th>
                                            @if(Auth::user()->id_level=='LV-0003'||Auth::user()->peran_pengguna == 1||Auth::user()->peran_pengguna == 4)
                                            <th>Action</th>
                                            @endif
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
                {{-- form add multiple job title --}}
                <div class="modal-body">
                    <form action="javascript:void(0)" method="POST" id="formAddJobTitle">
                        @csrf
                        <input type="number" id="user_id" name="user_id" hidden>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Job Title</label>
                                    <select name="job_title" id="job_title" class="form-control" required>
                                        <option value="#">-- Pilih Job Title --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Level</label>
                                    <select name="level" id="level" class="form-control" required>
                                        <option value="#">-- Pilih Level --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Transfer Periode</label>
                                    <select class="form-control" name="transfer_period" id="transfer_period">
                                        <option value="">-- Pilih Periode --</option>
                                        <option value="1">0 - 2 Tahun</option>
                                        <option value="2">Lebih Dari 2 Tahun</option>
                                </select>
                                </div>
                            </div>
                            <div class="col-md-2 align-self-center">
                                <button class="btn btn-success btnSubmitJobTitle btn-block">Add Job Title</button>
                            </div>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-12">
                            <h5 class="mt-4 mb-2">Job Title</h5>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <th style="width:10px">#</th>
                                        <th>Job Title</th>
                                        <th>Level</th>
                                        <th>Transfer Periode</th>
                                        <th>Action</th>
                                    </thead>
                                    <tbody class="trJob">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalEditJobTitle" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="javascript:void(0)" method="post" id="formUpdateJobTitle">
                        <input type="text" id="id" name="id" hidden>
                        @csrf
                        <div class="form-group">
                            <label for="">Job Title</label>
                            <select name="job_title_edit" id="job_title_edit" class="form-control" required>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Level</label>
                            <select name="level_edit" id="level_edit" class="form-control" required>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="">Transfer Periode</label>
                            <select name="transfer_period_edit" id="" class="form-control" required>
                                <option value="">-- Pilih Periode --</option>
                                <option value="1">0 - 2 Tahun</option>
                                <option value="2">Lebih Dari 2 Tahun</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success btnUpdateJobTitle">Update</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalDetail" tabindex="1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="text-center">
                                    <img src="{{ asset('assets/images/faces/face0.png') }}" alt="" class="img-fluid rounded-circle" style="max-height: 200px;max-width:200px">
                                    <h3 class="mt-3 msName"></h3>
                                    <h5 class="mt-1 msCg"></h5>
                                    <ul class="list-unstyled text-left mt-3">
                                        <li class="list-item d-flex justify-content-between">
                                            <span class="font-weight-bold">Divisi</span>
                                            <span class="msDivisi"></span>
                                        </li>
                                        <li class="list-item d-flex justify-content-between">
                                            <span class="font-weight-bold">Job Title</span>
                                            <span class="msJobTitle"></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <h5 class="mb-3">Multi Skiill Employee</h5>
                                <table class="display dtable expandable-table table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">No.</th>
                                            <th>Job Title</th>
                                            <th>Level</th>
                                            <th>Transfer Periode</th>
                                        </tr>
                                    </thead>
                                    <tbody class="trMs">
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('style')
    {{-- <link rel="stylesheet" href="{{ asset('assets/select2/css/select2.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('assets/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/sweetalert2/sweetalert2.min.css') }}">
    <style>
        .select2-selection__rendered {
            line-height: 50px !important;
        }

        .select2-container .select2-selection--single {
            height: 48px !important;
        }

    </style>
@endpush
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet"  href="{{asset('assets/css/datatables/jquery.dataTables.min.css') }}" type="text/css"/>
    <link href="{{asset('assets/css/datatables/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>
@endpush
@push('script')
    <script src="{{ asset('assets/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{asset('assets/vendors/datatables.net/export-table-data.js')}}"></script>
    <script src="{{ asset('assets/vendors/datatables.net/jszip.min.js') }}" type="text/javascript"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).ready(function() {
            initDatatable();
            cemeTable();
            $('[data-toggle="tooltip"]').tooltip({
                animation: true,
                placement: "top",
                trigger: "hover focus"
            });
        });
        function cemeTable() {
            @if(Auth::user()->peran_pengguna == '1')
            var buttons = [
                'copy', 'csv', 'excel', 'pdf', 'print',
            ];
            @else
            var buttons = [];
            @endif
            var competenJson = $('#tblceme').DataTable({
                ajax: "{{ route('competent.json') }}",
                autoWidth: false,
                serverSide: true,
                processing: true,
                aaSorting: [
                    [0, "desc"]
                ],
                searching: true,
                dom: 'lBfrtip',
                buttons: buttons,
                displayLength: -1,
                lengthMenu: [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
                language: {
                    paginate: {
                        // remove previous & next text from pagination
                        previous: '&nbsp;',
                        next: '&nbsp;'
                    },
                    // loadingRecords: "Please wait - loading..."
                    processing: "Please wait - loading..."
  
                },
                scrollX: true,
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'nama_pengguna', name: 'nama_pengguna' },
                    { data: 'nik', name: 'nik' },
                    { data: 'nama_cg', name: 'nama_cg' },
                    { data: 'nama_department', name: 'nama_department' },
                    { data: 'score_b', name: 'score_b' },
                    { data: 'score_i', name: 'score_i' },
                    { data: 'score_a', name: 'score_a' },
                    { data: 'rata_rata', name: 'rata_rata' },
                ],
                createdRow: function (row, data, dataIndex) {
                if (data.rata_rata.indexOf('badge-warning') !== -1) {
                    $(row).addClass('bg-warning');
                }
            },
            })
        }
        


        function initDatatable() {
            var q = '{{ $q }}';
            if (q != '') {
                var ajaxRoute = '{{ route('ceme.json.all') }}';
            } else {
                var ajaxRoute = '{{ route('ceme.json') }}';
            }
            @if(Auth::user()->peran_pengguna == '1')
            var buttons = [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ];
            @else
            var buttons = [];
            @endif
            var dtJson = $('#table-ceme').DataTable({
                ajax: ajaxRoute,
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
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'nama_pengguna'
                    },
                    {
                        data: 'nik'
                    },
                    {
                        data: 'nama_job_title'
                    },
                    {
                        data: 'nama_department'
                    },
                    // {
                    //     data: 'nama_divisi'
                    // },
                    {
                        data: 'nama_cg'
                    },
                    @if(Auth::user()->id_level=='LV-0003'||Auth::user()->peran_pengguna == 1||Auth::user()->peran_pengguna == 4)
                    {
                        data: 'action'
                    }
                    @endif
                ],
            })
        }

        var modal = $('#myModal');
        var modalTitle = $('#myModal .modal-title');
        $('#job_title').select2({
            theme: 'bootstrap4',
        });
        $('#job_title_edit').select2({
            theme: 'bootstrap4',
        });
        var jobTitle;
        var level;
        var transferPeriod;

        // ketika tombol tambah job title di klik
        $('body').on('click', '.btnAddJobTitle', function() {
            let userId = $(this).data('userid');
            var nama = $(this).data('nama');

            // get dat job title
            $.ajax({
                url: '{{ route('ceme.getJobTitle') }}',
                type: 'POST',
                data: {
                    id: userId
                },
                dataType: 'JSON',
                success: function(response) {
                    var i = 1;
                    response.data.forEach(data => {
                        switch (data.value) {
                            case 1:
                                var levelValue = 'On The Job Trainning (OJT)';
                                break;
                            case 2:
                                var levelValue = 'Temporary Back Up';
                                break;
                            case 3:
                                var levelValue = 'Full Back Up';
                                break;
                            case 4:
                                var levelValue = 'Main Job';
                                break;
                            default:
                                var levelValue = 'Tidak Ada';
                        }
                        var transferValue = '';  // Variabel untuk menampung teks nilai transfer
                        switch (data.transfer_period) {
                            case 1:
                                transferValue = '0 - 2 tahun';
                                break;
                            case 2:
                                transferValue = 'Lebih dari 2 tahun';
                                break;
                            default:
                                transferValue = '-';
                        }
                        var xhtml = '';
                        xhtml += '<tr>'
                        xhtml += '<td>' + i++ + '</td>'
                        xhtml += '<td>' + data.job_title
                            .nama_job_title + '</td>'
                        xhtml += '<td>' + levelValue + '</td>'
                        xhtml += '<td>' + transferValue + '</td>'
                        xhtml +=
                            '<td><a href="javascript:void(0)" class="btn btn-info btnEditJobTitle btn-sm" data-id="' +
                            data.id +
                            '" data-jobtitle="' + data.job_title_id + '" data-level="' + data
                            .value +
                            '">Edit</a> <a href="javascript:void(0)" class="btn btn-danger btnHapusJobTitle btn-sm" data-id="' +
                            data.id + '">Hapus</a> </td>';
                        xhtml += '</tr>';
                        $('.trJob').append(xhtml);
                    });
                }

            })

            getJobTitle();
            getLevel();
            // $('#level').empty();
            // $('#job_title').empty();
            jobTitle.forEach(jt => {
                $('#job_title').append('<option value=' + jt['id_job_title'] + '>' + jt['nama_job_title'] +
                    '</option>');
            });
            level.forEach(lv => {
                $('#level').append('<option value=' + lv[0] + '>' + lv[1] + ' ' + '(' + lv[3] + ')' +
                    '</option>');
            });
            $('#user_id').val(userId);
            modalTitle.text('Add Job Title to ' + nama);
            modal.modal({
                backdrop: 'static',
                keyboard: false
            }, 'show');
        })


        $('body').on('click','.btnDetail',function(){
            var id = $(this).data('id');
            var name = $(this).data('name');
            var cg = $(this).data('cg');
            var divisi = $(this).data('divisi');
            var jobtitle = $(this).data('jobtitle');
            var department = $(this).data('department');

            $('.msName').text(name);
            $('.msCg').text(cg);
            $('.msDivisi').text(divisi);
            $('.msJobTitle').text(jobtitle);
            $('.msDepartment').text(department);

            // get dat job title
            $.ajax({
                url: '{{ route('ceme.getJobTitle') }}',
                type: 'POST',
                data: {
                    id: id
                },
                dataType: 'JSON',
                success: function(response) {
                    var i = 1;
                    $('.trMs').empty();
                    response.data.forEach(data => {
                        switch (data.value) {
                            case 1:
                                var levelValue = 'On The Job Trainning (OJT)';
                                break;
                            case 2:
                                var levelValue = 'Temporary Back Up';
                                break;
                            case 3:
                                var levelValue = 'Full Back Up';
                                break;
                            case 4:
                                var levelValue = 'Main Job';
                                break;
                            default:
                                var levelValue = 'Tidak Ada';
                        }
                        switch (data.transfer_period) {
                            case 1:
                                transferValue = '0 - 2 tahun';
                                break;
                            case 2:
                                transferValue = 'Lebih dari 2 tahun';
                                break;
                            default:
                                transferValue = '-';
                        }
                        var xhtml = '';
                        xhtml += '<tr>'
                        xhtml += '<td>' + i++ + '</td>'
                        xhtml += '<td>' + data.job_title
                            .nama_job_title + '</td>'
                        xhtml += '<td>' + levelValue + '</td>'
                        xhtml += '<td>' + transferValue + '</td>'
                        xhtml += '</tr>';
                        $('.trMs').append(xhtml);
                    });
                }
            })
            $('#modalDetail .modal-title').text('Detail Multiskill');
            $('#modalDetail').modal('show');
        })

        // ketika form tambah job title di klik
        $('.btnSubmitJobTitle').on('click', function() {
            var formAddJobTitle = $('#formAddJobTitle').serialize();
            $.ajax({
                url: '{{ route('ceme.addJobTitle') }}',
                type: 'POST',
                dataType: 'JSON',
                data: formAddJobTitle,
                success: function(response) {
                    if (response.status == 'success') {
                        Swal.fire({
                            icon: response.status,
                            text: response.message
                        })

                        // kosongin data user job title
                        $('.trJob').text('');
                        var u_id = response.data.user_id;
                        $.ajax({
                            url: '{{ route('ceme.getJobTitle') }}',
                            type: 'POST',
                            data: {
                                id: u_id
                            },
                            dataType: 'JSON',
                            success: function(response) {
                                var i = 1;
                                response.data.forEach(data => {
                                    switch (data.value) {
                                        case 1:
                                            var levelValue =
                                                'On The Job Trainning (OJT)';
                                            break;
                                        case 2:
                                            var levelValue = 'Temporary Back Up';
                                            break;
                                        case 3:
                                            var levelValue = 'Full Back Up';
                                            break;
                                        case 4:
                                            var levelValue = 'Main Job';
                                            break;
                                        default:
                                            var levelValue = 'Tidak Ada';
                                    }
                                    var transferValue = '';  // Variabel untuk menampung teks nilai transfer
                                    switch (data.transfer_period) {
                                        case 1:
                                            transferValue = '0 - 2 tahun';
                                            break;
                                        case 2:
                                            transferValue = 'Lebih dari 2 tahun';
                                            break;
                                        default:
                                            transferValue = '-';
                                    }
                                    var xhtml = '';
                                    xhtml += '<tr>'
                                    xhtml += '<td>' + i++ + '</td>'
                                    xhtml += '<td>' + data.job_title
                                        .nama_job_title + '</td>'
                                    xhtml += '<td>' + levelValue + '</td>'
                                    xhtml += '<td>' + transferValue + '</td>'
                                    xhtml +=
                                        '<td><a href="javascript:void(0)" class="btn btn-info btnEditJobTitle btn-sm" data-id="' +
                                        data.id +
                                        '" data-jobtitle="' + data.job_title_id +
                                        '" data-level="' + data.value +
                                        '" data-level="' + data.transfer_period +
                                        '">Edit</a> <a href="javascript:void(0)" class="btn btn-danger btnHapusJobTitle btn-sm" data-id="' +
                                        data.id + '">Hapus</a> </td>'
                                    xhtml += '</tr>'
                                    $('.trJob').append(xhtml);
                                });
                            }

                        })
                    } else {
                        Swal.fire(
                            'Error',
                            response.message,
                            response.status
                        )
                    }
                }
            })
        })
        // ketika tombol hapus job title ditekan
        $('body').on('click', '.btnHapusJobTitle', function() {
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
                    var id = $(this).data('id');
                    $.ajax({
                        url: '{{ route('ceme.deleteJobTitle') }}',
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
                            // kosongin data user job title
                            $('.trJob').text('');
                            var u_id = response.data.user_id;
                            $.ajax({
                                url: '{{ route('ceme.getJobTitle') }}',
                                type: 'POST',
                                data: {
                                    id: u_id
                                },
                                dataType: 'JSON',
                                success: function(response) {
                                    var i = 1;
                                    response.data.forEach(data => {
                                        switch (data.value) {
                                            case 1:
                                                var levelValue =
                                                    'On The Job Trainning (OJT)';
                                                break;
                                            case 2:
                                                var levelValue =
                                                    'Temporary Back Up';
                                                break;
                                            case 3:
                                                var levelValue =
                                                    'Full Back Up';
                                                break;
                                            case 4:
                                                var levelValue = 'Main Job';
                                                break;
                                            default:
                                                var levelValue =
                                                    'Tidak Ada';
                                        }
                                        var transferValue = '';  // Variabel untuk menampung teks nilai transfer
                                        switch (data.transfer_period) {
                                            case 1:
                                                transferValue = '0 - 2 tahun';
                                                break;
                                            case 2:
                                                transferValue = 'Lebih dari 2 tahun';
                                                break;
                                            default:
                                                transferValue = '-';
                                        }
                                        var xhtml = '';
                                        xhtml += '<tr>'
                                        xhtml += '<td>' + i++ + '</td>'
                                        xhtml += '<td>' + data.job_title
                                            .nama_job_title + '</td>'
                                        xhtml += '<td>' + levelValue +
                                            '</td>'
                                        xhtml += '<td>' + transferValue +
                                            '</td>'
                                        xhtml +=
                                            '<td><a href="javascript:void(0)" class="btn btn-info btnEditJobTitle btn-sm" data-id="' +
                                            data.id +
                                            '" data-jobtitle="' + data
                                            .job_title_id +
                                            '" data-level="' + data.value +
                                            '">Edit</a> <a href="javascript:void(0)" class="btn btn-danger btnHapusJobTitle btn-sm" data-id="' +
                                            data.id + '">Hapus</a> </td>'
                                        xhtml += '</tr>'
                                        $('.trJob').append(xhtml);
                                    });
                                }

                            })
                        }
                    })
                }
            })

        })
        // ketika tombol edit job title ditekan
        $('body').on('click', '.btnEditJobTitle', function() {
            var id = $(this).data('id');
            var jobt = $(this).data('jobtitle');
            var value = $(this).data('level');
            $('#formUpdateJobTitle #id').val(id);
            $('#level_edit').empty();
            $('#job_title_edit').empty();
            jobTitle.forEach(jt => {
                if (jobt == jt.id_job_title) {
                    $('#job_title_edit').append('<option selected value=' + jt.id_job_title + '>' + jt
                        .nama_job_title +
                        '</option>');
                } else {
                    $('#job_title_edit').append('<option value=' + jt.id_job_title + '>' + jt[
                            'nama_job_title'] +
                        '</option>');
                }
            });
            level.forEach(lv => {
                if (value == lv[0]) {
                    $('#level_edit').append('<option selected value=' + lv[0] + '>' + lv[1] + ' ' + '(' +
                        lv[3] + ')' +
                        '</option>');
                } else {
                    $('#level_edit').append('<option value=' + lv[0] + '>' + lv[1] + ' ' + '(' + lv[3] +
                        ')' +
                        '</option>');
                }
            });
            var modalEdit = $('#modalEditJobTitle');
            $('#modalEditJobTitle .modal-title').text('Edit Job Title');
            modalEdit.modal('show');
        })

        // update job title
        $('.btnUpdateJobTitle').on('click', function() {
            var formUpdateJobTitle = $('#formUpdateJobTitle');
            var id = $('#formUpdateJobTitle #id').val();
            $.ajax({
                url: '{{ route('ceme.addJobTitle') }}',
                type: 'POST',
                dataType: 'JSON',
                data: formUpdateJobTitle.serialize(),
                success: function(response) {
                    if (response.status == 'success') {
                        Swal.fire({
                            icon: response.status,
                            text: response.message
                        })

                        $('#modalEditJobTitle').modal('hide');
                        // kosongin data user job title
                        $('.trJob').text('');
                        var u_id = response.data.user_id;
                        $.ajax({
                            url: '{{ route('ceme.getJobTitle') }}',
                            type: 'POST',
                            data: {
                                id: u_id
                            },
                            dataType: 'JSON',
                            success: function(response) {
                                var i = 1;
                                response.data.forEach(data => {
                                    switch (data.value) {
                                        case 1:
                                            var levelValue =
                                                'On The Job Trainning (OJT)';
                                            break;
                                        case 2:
                                            var levelValue =
                                                'Temporary Back Up';
                                            break;
                                        case 3:
                                            var levelValue =
                                                'Full Back Up';
                                            break;
                                        case 4:
                                            var levelValue = 'Main Job';
                                            break;
                                        default:
                                            var levelValue =
                                                'Tidak Ada';
                                    }
                                    var transferValue = '';  // Variabel untuk menampung teks nilai transfer
                                    switch (data.transfer_period) {
                                        case 1:
                                            transferValue = '0 - 2 tahun';
                                            break;
                                        case 2:
                                            transferValue = 'Lebih dari 2 tahun';
                                            break;
                                        default:
                                            transferValue = '-';
                                    }
                                    var xhtml = '';
                                    xhtml += '<tr>'
                                    xhtml += '<td>' + i++ + '</td>'
                                    xhtml += '<td>' + data.job_title
                                        .nama_job_title + '</td>'
                                    xhtml += '<td>' + levelValue +
                                        '</td>'
                                    xhtml += '<td>' + transferValue +
                                        '</td>'
                                    xhtml +=
                                        '<td><a href="javascript:void(0)" class="btn btn-info btnEditJobTitle btn-sm" data-id="' +
                                        data.id +
                                        '" data-jobtitle="' + data
                                        .job_title_id +
                                        '" data-level="' + data.value +
                                        '" data-level="' + data.transfer_period +
                                        '">Edit</a> <a href="javascript:void(0)" class="btn btn-danger btnHapusJobTitle btn-sm" data-id="' +
                                        data.id + '">Hapus</a> </td>'
                                    xhtml += '</tr>'
                                    $('.trJob').append(xhtml);
                                });
                            }

                        })
                    } else {
                        Swal.fire(
                            'Error',
                            response.message,
                            response.status
                        )
                    }
                }
            })
        })

        // ketika modal tertutup
        modal.on('hidden.bs.modal', function() {
            var xhtml = '';
            // xhtml += '<tr>';
            // xhtml += '<td colspan="4" class="text-center">Not Found</td>';
            // xhtml += '</tr>';
            $('.trJob').text('');
            // $('.trJob').append(xhtml);
            location.reload();
        })

        $('#modalEditJobTitle').on('hidden.bs.modal', function() {

        })


        function getJobTitle() {
            $.ajax({
                url: '{{ route('jabatan.get') }}',
                type: 'GET',
                dataType: 'JSON',
                async: false,
                success: function(response) {
                    jobTitle = response;
                }
            })
        }
        function getLevel() {
            level = [
                [
                    '1',
                    'On The Job Trainning (OJT)',
                    'black',
                    ''
                ],
                [
                    '2',
                    'Temporary Back Up',
                    'pink',
                    '50% - 75% by Average Competent Employee'
                ],
                [
                    '3',
                    'Full Back Up',
                    'yellow',
                    '75% - 100% by Average Competent Employee'
                ],
                [
                    '4',
                    'Main Job',
                    'green',
                    '100% by Average Competent Employee'
                ]
            ];
        }
        function getTransferPeriode() {
            periode = [
                [
                    '1',
                    '0 - 2 Tahun',
                ],
                [
                    '2',
                    'Lebih Dari 2 Tahun',
                ]
            ];
        }

        $('.btnAll').on('click', function() {
            var dtJson = $('#table-ceme').DataTable({
                ajax: "{{ route('ceme.json.all') }}",
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
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'nama_pengguna'
                    },
                    {
                        data: 'nama_job_title'
                    },
                    {
                        data: 'nama_department'
                    },
                    {
                        data: 'nama_divisi'
                    },
                    {
                        data: 'nama_cg'
                    },
                    @if(Auth::user()->id_level=='LV-0003'||Auth::user()->peran_pengguna == 1||Auth::user()->peran_pengguna == 4)
                    {
                        data: 'action'
                    }
                    @endif
                ],
            })
        })


        // chart
        let multiSkill;
        let pieLabel;
        let pieTotalScore;
        let ceme = '{{ request('q') }}';
        $.ajax({
            url:'{{ route('ceme.chartCeme') }}',
            type:'POST',
            dataType:'JSON',
            data:{
                ceme
            },
            async:false,
            success: function(response)
            {
                pieLabel = response.label;
                pieTotalScore = response.totalScore;
            }
        })
        $.ajax({
            url:'{{ route('ceme.chartMe') }}',
            type:'POST',
            dataType:'JSON',
            data:{
                ceme
            },
            async:false,
            success: function(response)
            {
                multiSkill = response;
            }
        })

        var nameMultiSkill = [];
        var totalMultiSkill = [];
        var bgMultiSkill = [];
        var bMultiSkill = [];
        var bgCeme = [];
        var bCeme = [];

        function acakBg(opacity)
        {
            var rx = Math.floor(Math.random() * 256);
            var ry = Math.floor(Math.random() * 256);
            var rz = Math.floor(Math.random() * 256);
            return bgColor = "rgba(" + rx + "," + ry + "," + rz + ","+opacity+")";
        }

        multiSkill.forEach(multi => {
            nameMultiSkill.push(multi.nama_pengguna);
            totalMultiSkill.push(multi.totalSkill);
            bgMultiSkill.push(acakBg(0.5));
            bMultiSkill.push(acakBg(0.7));
        });

        pieLabel.forEach(multi => {
            bgCeme.push(acakBg(0.5));
            bCeme.push(acakBg(0.7));
        });
        var meData = {
                datasets: [{
                data: totalMultiSkill,
                backgroundColor: bgMultiSkill,
                borderColor: '#ffffff',
                }],

                labels: nameMultiSkill
            };

            var doughnutPieData = {
                datasets: [{
                data: pieTotalScore,
                backgroundColor: bgCeme,
                borderColor: '#ffffff',
                }],

                // These labels appear in the legend and in the tooltips when hovering different arcs
                labels: pieLabel
            };
            var doughnutPieOptions = {
                responsive: true,
                animation: {
                animateScale: true,
                animateRotate: true
                }
            };

        if ($("#pieChart").length) {
            var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
            var pieChart = new Chart(pieChartCanvas, {
            type: 'pie',
            data: doughnutPieData,
            options: doughnutPieOptions
            });
        }

        if ($("#pieChart2").length) {
            var pieChartCanvas = $("#pieChart2").get(0).getContext("2d");
            var pieChart = new Chart(pieChartCanvas, {
            type: 'pie',
            data: meData,
            options: doughnutPieOptions
            });
        }
        var chart1Height = pieChart1.chartArea.bottom - pieChart1.chartArea.top;

    // Mengukur tinggi pie chart 2
    var chart2Height = pieChart2.chartArea.bottom - pieChart2.chartArea.top;

    // Menentukan tinggi maksimum dari kedua chart
    var maxHeight = Math.max(chart1Height, chart2Height);

    // Mengatur tinggi card sesuai dengan tinggi maksimum chart
    $(".height-card").css("height", maxHeight + "px");
    </script>
@endpush
