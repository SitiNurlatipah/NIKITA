@extends('layouts.master')

@section('title', 'Member')

@section('content')
<style>
    .myk-btn img{width: 50%; margin-top: 15px; margin-left: 15px;}
    .myk-wa-icon{
        margin: 0 auto;
    }
    .image_area {
        position: relative;
        margin: auto
    }

    img {
        display: block;
        max-width: 100%;
    }

    .preview {
        overflow: hidden;
        width: 250px;
        height: 250px;
        margin: 10px;
        border: 1px solid red;
    }

    .modal-lg{
        max-width: 1000px !important;
    }
    .overlay {
    position: absolute;
    bottom: 5px;
    left: 0;
    right: 0;
    background-color: rgba(255, 255, 255, 0.5);
    overflow: hidden;
    height: 0;
    transition: .5s ease;
    width: 100%;
    }
    .image_area:hover .overlay {
    height: 40%;
    cursor: pointer;
    }
    .text {
    color: #333;
    font-size: 20px;
    position: absolute;
    top: 50%;
    left: 50%;
    -webkit-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
    transform: translate(-50%, -50%);
    text-align: center;
    }
</style>
@push('style')
    <link href="https://unpkg.com/cropperjs/dist/cropper.css" rel="stylesheet"/>
@endpush
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <p class="card-title ml-4">Employee Data</p>
                    <div class="col-md mb-2">
                        <a class="btn btn-sm btn-success float-right ml-2" href="javascript:void(0)" id="createNewItem" data-toggle="modal" data-target="#modal-tambah"><i class="icon-plus"></i> Add User</a>
                        <a class="btn btn-sm btn-success float-right btnRotation" href="javascript:void(0)" id="btnRotation" data-toggle="modal" data-target="#modal-rotation"><i class="icon-repeat"></i> Rotation User</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="display expandable-table table-striped table-hover" id="table-cg" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>Employee Name</th>
                                        <th>Join Date
                                            {{-- <small>(Berdasarkan job level terakhir)</small> --}}
                                        </th>
                                        <th>Department</th>
                                        <th>Job Title</th>
                                        <th>Circle Group</th>
                                        <th>Action</th>
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
<div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="modal-tambahLabel" aria-hidden="true" style="overflow: auto !important">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header p-3">
              <h5 class="modal-title" id="modal-tambahLabel">Add New User</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('EmployeeMember.post') }}" method="POST" enctype="multipart/form-data" id="formPost">
                @csrf
                <input type="hidden" id="base64" name="base64">
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-md-4">
                            <div class="image_area" style="height: 250px;width:250px">
                                <label for="upload_image" class="relative">
                                    <img src="{{asset('assets/images/faces/face0.png' )}}" id="uploaded_image" class="rounded-circle img-thumbnail" />
                                    <div class="overlay">
                                        <div class="text" style="font-size: 15px">Click to Change Profile Image</div>
                                    </div>
                                    <input type="file" name="image" class="image" id="upload_image" style="display:none" />
                                </label>
                            </div>
                        </div>
                        <div class="col-md-8 row">
                            <div class="col-md-6 mb-3">
                                <label>NIK</label>
                                <input type="text" id="nik" class="form-control form-control-sm" name="nik" placeholder="10119912">
                                <div class="invalid-feedback" id="feed-back-nik"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Password</label>
                                <input type="password" id="password" class="form-control form-control-sm"  name="password" placeholder="Masukan Password">
                                <div class="invalid-feedback" id="feed-back-password"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Role</label>
                                <select class="form-control form-control-sm" name="peran_pengguna" id="peran_pengguna">
                                    <option value="1">Admin</option>
                                    <option value="2">CG Leader</option>
                                    <option value="3">Pengguna</option>
                                    <option value="4">Atasan</option>
                                </select>
                                <div class="invalid-feedback" id="feed-back-peran-pengguna"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Join Date</label>
                                <input type="date" id="entry" name="tgl_masuk" class="form-control form-control-sm">
                                <div class="invalid-feedback" id="feed-back-entry"></div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label>Employee Name</label>
                            <input type="text" id="nama-pengguna" class="form-control form-control-sm" name="nama_pengguna" placeholder="Nama Karyawan">
                            <div class="invalid-feedback" id="feed-back-nama-pengguna"></div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>Email</label>
                            <input type="text" id="email" name="email" class="form-control form-control-sm" placeholder="nama@gmail.com">
                            <div class="invalid-feedback" id="feed-back-email"></div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label>Divisi</label>
                            <select id="divisi" class="form-control form-control-sm" name="divisi">
                                <option value="">Pilih Divisi</option>
                            </select>
                            <div class="invalid-feedback" id="feed-back-divisi"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Job Title</label>
                            <select id="jabatan" class="form-control form-control-sm" name="job_title">
                                <option value="">Pilih Jabatan</option>
                            </select>
                            <div class="invalid-feedback" id="feed-back-jabatan"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Level</label>
                            <select id="level" class="form-control form-control-sm" name="level">
                                <option value="">Pilih Level</option>
                            </select>
                            <div class="invalid-feedback" id="feed-back-level"></div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label>Department</label>
                            <select id="department" class="form-control form-control-sm" name="department">
                                <option value="">Pilih Department</option>
                            </select>
                            <div class="invalid-feedback" id="feed-back-department"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Sub Department</label>
                            <select id="sub-department" class="form-control form-control-sm" name="sub_department">
                                <option value="">Pilih Sub Dept</option>
                            </select>
                            <div class="invalid-feedback" id="feed-back-sub-department"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>Liga CG</label>
                            <select id="cg" class="form-control form-control-sm" name="cg">
                                <option value="">Pilih CG Name</option>
                            </select>
                            <div class="invalid-feedback" id="feed-back-cg"></div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label>CG Tambahan 1</label>
                            <select id="cgtambahan" class="form-control form-control-sm" name="tambahancg">
                                <option value="">Pilih CG Name</option>
                            </select>
                            <!-- <div class="invalid-feedback" id="feed-back-cg"></div> -->
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>CG Tambahan 2</label>
                            <select id="cgtambahan2" class="form-control form-control-sm" name="tambahancg2">
                                <option value="">Pilih CG Name</option>
                            </select>
                            <!-- <div class="invalid-feedback" id="feed-back-cg"></div> -->
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>CG Tambahan 3</label>
                            <select id="cgtambahan3" class="form-control form-control-sm" name="tambahancg3">
                                <option value="">Pilih CG Name</option>
                            </select>
                            <!-- <div class="invalid-feedback" id="feed-back-cg"></div> -->
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>CG Tambahan 4</label>
                            <select id="cgtambahan4" class="form-control form-control-sm" name="tambahancg4">
                                <option value="">Pilih CG Name</option>
                            </select>
                            <!-- <div class="invalid-feedback" id="feed-back-cg"></div> -->
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>CG Tambahan 5</label>
                            <select id="cgtambahan5" class="form-control form-control-sm" name="tambahancg5">
                                <option value="">Pilih CG Name</option>
                            </select>
                            <!-- <div class="invalid-feedback" id="feed-back-cg"></div> -->
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

<div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modal-editLabel" aria-hidden="true" style="overflow: auto !important">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content" id="content-edit">
          <div class="modal-header p-3">
              <h5 class="modal-title" id="modal-editLabel">Edit Data Karyawan</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('EmployeeMember.update') }}" id="formEdit" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body" id="form-edit">

                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
      </div>
    </div>
</div>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crop Image Before Upload</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="" id="sample_image" style="height: 300px" />
                        </div>
                        <div class="col-md-6">
                            <div class="preview"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="crop" class="btn btn-primary">Crop</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-hapus" tabindex="-1" role="dialog" aria-labelledby="modal-delete" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">Hapus Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Yakin ingin menghapus data ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-danger" type="button" id="btnHapus" onclick="deleteMember(this)" data-id="">Hapus</a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modal-detail" tabindex="-1" role="dialog" aria-labelledby="modal-detail" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header p-3">
                    <h4 class="modal-title" id="myModalLabel17">Detail Employee</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pb-0 pt-0" id="bodyDetail">

                </div>
                <div class="modal-footer p-2">
                    <button type="button" class="btn text-white btn-secondary" data-dismiss="modal">Close</button>
                    {{-- <a href="" class="btn btn-danger">Hapus</a> --}}
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modal-rotation" tabindex="-1" role="dialog" aria-labelledby="modal-tambahLabel" aria-hidden="true" style="overflow: auto !important">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
          <div class="modal-header p-3">
              <h5 class="modal-title" id="modal-tambahLabel">User Rotation</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('EmployeeMember.rotation') }}" method="POST" id="formRotation">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col">
                            <label>Pilih Karyawan</label>
                            <select id="user_rotation" class="form-control form-control-sm" name="user_rotation">
                                <option value="">Pilih User</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="col">
                            <label>Pilih Job Title Baru</label>
                            <select id="jabatan_rotation" class="form-control form-control-sm" name="jabatan_rotation">
                                <option value="">Pilih Jabatan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row mt-3">
                        <div class="col">
                            <label>Pilih CG Baru</label>
                            <select id="cg_rotation" class="form-control form-control-sm" name="cg_rotation">
                                <option value="">Pilih Cirle Group</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Rotate</button>
                </div>
            </form>
      </div>
    </div>
</div>

@endsection
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet"  href="{{asset('assets/css/datatables/jquery.dataTables.min.css') }}" type="text/css"/>
    <link href="{{asset('assets/css/datatables/buttons.dataTables.min.css') }}" rel="stylesheet" type="text/css"/>

@endpush
@push('script')
<script src="{{asset('assets/js/cropper-v2.js')}}"></script>
<script src="{{ asset('assets/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/vendors/datatables.net/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/vendors/datatables.net/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/vendors/datatables.net/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
<script src="{{asset('assets/vendors/datatables.net/export-table-data.js')}}"></script>
<script src="{{ asset('assets/vendors/datatables.net/jszip.min.js') }}" type="text/javascript"></script>

<script type="text/javascript">
     $('#user_rotation').select2({
            theme:'bootstrap4'
     });
     $('#jabatan_rotation').select2({
            theme:'bootstrap4'
     });
     $('#jabatan').select2({
            theme:'bootstrap4'
     });
     $('#cg_rotation').select2({
            theme:'bootstrap4'
     });
     $('#divisi').select2({
            theme:'bootstrap4'
     });
     $('#level').select2({
            theme:'bootstrap4'
     });
     $('#department').select2({
            theme:'bootstrap4'
     });
     $('#sub-department').select2({
            theme:'bootstrap4'
     });
     $('#cg').select2({
            theme:'bootstrap4'
     });
     $('#cgtambahan').select2({
            theme:'bootstrap4'
     });
     $('#cgtambahan2').select2({
            theme:'bootstrap4'
     });
     $('#cgtambahan3').select2({
            theme:'bootstrap4'
     });
     $('#cgtambahan4').select2({
            theme:'bootstrap4'
     });
     $('#cgtambahan5').select2({
            theme:'bootstrap4'
     });


    var role = '{{ Auth::user()->peran_pengguna}}';

    function initDatatable() {
        @if(Auth::user()->peran_pengguna == '1')
        var buttons = [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ];
        @else
        var buttons = [];
        @endif
        var dtJson = $('#table-cg').DataTable({
            ajax: "{{ route('EmployeeMember.get') }}",
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
                    data: 'nik'
                },
                {
                    data: 'nama_pengguna'
                },
                {
                    data: 'tgl_masuk'
                },
                {
                    data: 'nama_department'
                },
                {
                    data: 'nama_job_title'
                },
                {
                    data: 'nama_cg'
                },
                {
                    data: 'action'
                }
            ],
        });
    }

    $('#table-cg').on('click','.member-hapus', function () {
        var id = $(this).attr('data-id');
        $('#btnHapus').attr('data-id',id);
    })

    function deleteMember(el) {
        var id = $(el).attr("data-id");
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            url:"employeemember/employeemember-delete/"+id,
            mehtod:"delete",
            data: {
                "id": id,
                "_token": token,
            },
            success:function(res)
            {
                $('#table-cg').DataTable().destroy();
                initDatatable();
                $("#modal-hapus").modal('hide');
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Data Berhasil Dihapus',
                    showConfirmButton: false,
                    timer: 1500
                })
            }
        })
    }

    function getDivisi(){
        $.ajax({
            type: "GET",
            url: "{{ route('get.divisi') }}",
            success: function(res) {
                var option = "";
                for (let i = 0; i < res.data.length; i++) {
                    option += '<option value="'+res.data[i].id_divisi+'">'+res.data[i].nama_divisi+'</option>';
                }
                $('#divisi').html();
                $('#divisi').append(option);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr);
                alert(xhr.status);
                alert(thrownError);
            }
        })
    }

    function getJabatan(){
        $.ajax({
            type: "GET",
            url: "{{ route('get.jabatan') }}",
            success: function(res) {
                var option = "";
                for (let i = 0; i < res.data.length; i++) {
                    option += '<option value="'+res.data[i].id_job_title+'">'+res.data[i].nama_job_title+'</option>';
                }
                $('#jabatan').html();
                $('#jabatan').append(option);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr);
                alert(xhr.status);
                alert(thrownError);
            }
        })
    }

    function getLevel(){
        $.ajax({
            type: "GET",
            url: "{{ route('get.level') }}",
            success: function(res) {
                var option = "";
                for (let i = 0; i < res.data.length; i++) {
                    option += '<option value="'+res.data[i].id_level+'">'+res.data[i].nama_level+'</option>';
                }
                $('#level').html();
                $('#level').append(option);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr);
                alert(xhr.status);
                alert(thrownError);
            }
        })
    }

    function getDepartment(){
        $.ajax({
            type: "GET",
            url: "{{ route('get.department') }}",
            success: function(res) {
                var option = "";
                for (let i = 0; i < res.data.length; i++) {
                    option += '<option value="'+res.data[i].id_department+'">'+res.data[i].nama_department+'</option>';
                }
                $('#department').html();
                $('#department').append(option);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr);
                alert(xhr.status);
                alert(thrownError);
            }
        })
    }

    function getSubDepartment(){
        $.ajax({
            type: "GET",
            url: "{{ route('get.sub.department') }}",
            success: function(res) {
                var option = "";
                for (let i = 0; i < res.data.length; i++) {
                    option += '<option value="'+res.data[i].id_subdepartment+'">'+res.data[i].nama_subdepartment+'</option>';
                }
                $('#sub-department').html();
                $('#sub-department').append(option);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr);
                alert(xhr.status);
                alert(thrownError);
            }
        })
    }

    function getCG(){
        $.ajax({
            type: "GET",
            url: "{{ route('get.cg') }}",
            success: function(res) {
                var option = "";
                for (let i = 0; i < res.data.length; i++) {
                    option += '<option value="'+res.data[i].id_cg+'">'+res.data[i].nama_cg+'</option>';
                }
                $('#cg').html();
                $('#cg').append(option);
                $('#cgtambahan').html();
                $('#cgtambahan').append(option);
                $('#cgtambahan2').html();
                $('#cgtambahan2').append(option);
                $('#cgtambahan3').html();
                $('#cgtambahan3').append(option);
                $('#cgtambahan4').html();
                $('#cgtambahan4').append(option);
                $('#cgtambahan5').html();
                $('#cgtambahan5').append(option);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr);
                alert(xhr.status);
                alert(thrownError);
            }
        })
    }

    function formEdit(id){
        const url = "{!! route('EmployeeMember.edit') !!}?id="+id;
        $.ajax({
            cache:false,
            url:url,
            type:"get",
            success: function(html) {
                $("#form-edit").html(html);
            }
        })
    }

    function detail(id) {
        const url = "{!! route('EmployeeMember.detail') !!}?id="+id;
        $.ajax({
            type:"get",
            url:url,
            cache:false,
            success:function(html){
                $("#bodyDetail").html(html);
            }
        })
    }

    $("#formPost").submit(function (e) {
        e.preventDefault();
        var form = $("#formPost")
        const url = form.attr("action");
        const formData = form.serialize();
        $('#feed-back-nik').html('')
        $('#feed-back-password').html('')
        $('#feed-back-peran-pengguna').html('')
        $('#feed-back-entry').html('')
        $('#feed-back-nama-pengguna').html('')
        $('#feed-back-email').html('')
        $('#feed-back-divisi').html('')
        $('#feed-back-jabatan').html('')
        $('#feed-back-level').html('')
        $('#feed-back-department').html('')
        $('#feed-back-sub-department').html('')
        $('#feed-back-cg').html('')

        $('#nik').removeClass('is-invalid')
        $('#password').removeClass('is-invalid')
        $('#peran-pengguna').removeClass('is-invalid')
        $('#entry').removeClass('is-invalid')
        $('#nama-pengguna').removeClass('is-invalid')
        $('#email').removeClass('is-invalid')
        $('#divisi').removeClass('is-invalid')
        $('#jabatan').removeClass('is-invalid')
        $('#level').removeClass('is-invalid')
        $('#department').removeClass('is-invalid')
        $('#sub-department').removeClass('is-invalid')
        $('#cg').removeClass('is-invalid')
        $.ajax({
            url:url,
            type:"POST",
            cache:false,
            data:formData,
            success:function (data) {
                $("#formPost")[0].reset();
                $("#uploaded_image").attr("src","{{asset('assets/images/faces/face0.png')}}")
                $("#modal-tambah").modal('hide');
                $('#table-cg').DataTable().destroy();
                initDatatable();
                Swal.fire({
                    position:'center',
                    icon:'success',
                    title:data.message,
                    showConfirmButton:false,
                    timer:1500
                });
            },
            error:function (request,status,error) {
                var errors = request.responseJSON.errors;
                var message = request.responseJSON.message;
                if(message == "The given data was invalid."){
                    if(errors.nik){
                        $( '#feed-back-nik' ).html(errors.nik[0]);
                        $( '#feed-back-nik' ).show();
                        $( '#nik' ).addClass('is-invalid');
                    }
                    if(errors.password){
                        $( '#feed-back-password' ).html(errors.password[0]);
                        $( '#feed-back-password' ).show();
                        $( '#password' ).addClass('is-invalid');
                    }
                    if(errors.peran_pengguna){
                        $( '#feed-back-peran-pengguna' ).html(errors.peran_pengguna[0]);
                        $( '#feed-back-peran-pengguna' ).show();
                        $( '#peran-pengguna' ).addClass('is-invalid');
                    }
                    if(errors.tgl_masuk){
                        $( '#feed-back-entry' ).html(errors.tgl_masuk[0]);
                        $( '#feed-back-entry' ).show();
                        $( '#entry' ).addClass('is-invalid');
                    }
                    if(errors.nama_pengguna){
                        $( '#feed-back-nama-pengguna' ).html(errors.nama_pengguna[0]);
                        $( '#feed-back-nama-pengguna' ).show();
                        $( '#nama-pengguna' ).addClass('is-invalid');
                    }
                    if(errors.email){
                        $( '#feed-back-email' ).html(errors.email[0]);
                        $( '#feed-back-email' ).show();
                        $( '#email' ).addClass('is-invalid');
                    }
                    if(errors.divisi){
                        $( '#feed-back-divisi' ).html(errors.divisi[0]);
                        $( '#feed-back-divisi' ).show();
                        $( '#divisi' ).addClass('is-invalid');
                    }
                    if(errors.job_title){
                        $( '#feed-back-jabatan' ).html(errors.job_title[0]);
                        $( '#feed-back-jabatan' ).show();
                        $( '#jabatan' ).addClass('is-invalid');
                    }
                    if(errors.level){
                        $( '#feed-back-level' ).html(errors.level[0]);
                        $( '#feed-back-level' ).show();
                        $( '#level' ).addClass('is-invalid');
                    }
                    if(errors.department){
                        $( '#feed-back-department' ).html(errors.department[0]);
                        $( '#feed-back-department' ).show();
                        $( '#department' ).addClass('is-invalid');
                    }
                    if(errors.sub_department){
                        $( '#feed-back-sub-department' ).html(errors.sub_department[0]);
                        $( '#feed-back-sub-department' ).show();
                        $( '#sub-department' ).addClass('is-invalid');
                    }
                    if(errors.cg){
                        $( '#feed-back-cg' ).html(errors.cg[0]);
                        $( '#feed-back-cg' ).show();
                        $( '#cg' ).addClass('is-invalid');
                    }
                }else{
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Terjadi kesalahan saat penyimpanan data',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            }
        });
    })

    $("#formEdit").submit(function (e) {
        e.preventDefault();
        var form = $("#formEdit")
        const url = form.attr("action");
        var formData = form.serialize();
        $('#feed-back-nik-edit').html('')
        $('#feed-back-peran-pengguna-edit').html('')
        $('#feed-back-entry-edit').html('')
        $('#feed-back-nama-pengguna-edit').html('')
        $('#feed-back-email-edit').html('')
        $('#feed-back-divisi-edit').html('')
        $('#feed-back-jabatan-edit').html('')
        $('#feed-back-level-edit').html('')
        $('#feed-back-department-edit').html('')
        $('#feed-back-sub-department-edit').html('')
        $('#feed-back-cg-edit').html('')

        $('#nik-edit').removeClass('is-invalid')
        $('#peran-pengguna-edit').removeClass('is-invalid')
        $('#entry-edit').removeClass('is-invalid')
        $('#nama-pengguna-edit').removeClass('is-invalid')
        $('#email-edit').removeClass('is-invalid')
        $('#divisi-edit').removeClass('is-invalid')
        $('#jabatan-edit').removeClass('is-invalid')
        $('#level-edit').removeClass('is-invalid')
        $('#department-edit').removeClass('is-invalid')
        $('#sub-department-edit').removeClass('is-invalid')
        $('#cg-edit').removeClass('is-invalid')
        $.ajax({
            url:url,
            type:"post",
            cache:false,
            data:formData,
            success:function (data) {
                $("#modal-edit").modal('hide');
                $('#table-cg').DataTable().destroy();
                initDatatable();
                Swal.fire({
                    position:'center',
                    icon:'success',
                    title:data.message,
                    showConfirmButton:false,
                    timer:1500
                });
            },
            error:function (request,status,error) {
                if(request.responseJSON.message == "The given data was invalid."){
                    if(request.responseJSON.errors.nik){
                        $( '#feed-back-nik-edit' ).html(request.responseJSON.errors.nik[0]);
                        $( '#feed-back-nik-edit' ).show();
                        $( '#nik-edit' ).addClass('is-invalid');
                    }
                    if(request.responseJSON.errors.peran_pengguna){
                        $( '#feed-back-peran-pengguna-edit' ).html(request.responseJSON.errors.peran_pengguna-edit[0]);
                        $( '#feed-back-peran-pengguna-edit' ).show();
                        $( '#peran-pengguna-edit' ).addClass('is-invalid');
                    }
                    if(request.responseJSON.errors.tgl_masuk){
                        $( '#feed-back-entry-edit' ).html(request.responseJSON.errors.tgl_masuk[0]);
                        $( '#feed-back-entry-edit' ).show();
                        $( '#entry-edit' ).addClass('is-invalid');
                    }
                    if(request.responseJSON.errors.nama_pengguna){
                        $( '#feed-back-nama-pengguna-edit' ).html(request.responseJSON.errors.nama_pengguna[0]);
                        $( '#feed-back-nama-pengguna-edit' ).show();
                        $( '#nama-pengguna-edit' ).addClass('is-invalid');
                    }
                    if(request.responseJSON.errors.email){
                        $( '#feed-back-email-edit' ).html(request.responseJSON.errors.email[0]);
                        $( '#feed-back-email-edit' ).show();
                        $( '#email-edit' ).addClass('is-invalid');
                    }
                    if(request.responseJSON.errors.divisi){
                        $( '#feed-back-divisi-edit' ).html(request.responseJSON.errors.divisi[0]);
                        $( '#feed-back-divisi-edit' ).show();
                        $( '#divisi-edit' ).addClass('is-invalid');
                    }
                    if(request.responseJSON.errors.job_title){
                        $( '#feed-back-jabatan-edit' ).html(request.responseJSON.errors.job_title[0]);
                        $( '#feed-back-jabatan-edit' ).show();
                        $( '#jabatan-edit' ).addClass('is-invalid');
                    }
                    if(request.responseJSON.errors.level){
                        $( '#feed-back-level-edit' ).html(request.responseJSON.errors.level[0]);
                        $( '#feed-back-level-edit' ).show();
                        $( '#level-edit' ).addClass('is-invalid');
                    }
                    if(request.responseJSON.errors.department){
                        $( '#feed-back-department-edit' ).html(request.responseJSON.errors.department[0]);
                        $( '#feed-back-department-edit' ).show();
                        $( '#department-edit' ).addClass('is-invalid');
                    }
                    if(request.responseJSON.errors.sub_department){
                        $( '#feed-back-sub-department-edit' ).html(request.responseJSON.errors.sub_department[0]);
                        $( '#feed-back-sub-department-edit' ).show();
                        $( '#sub-department-edit' ).addClass('is-invalid');
                    }
                    if(request.responseJSON.errors.cg){
                        $( '#feed-back-cg-edit' ).html(request.responseJSON.errors.cg[0]);
                        $( '#feed-back-cg-edit' ).show();
                        $( '#cg-edit' ).addClass('is-invalid');
                    }
                }else{
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Terjadi kesalahan saat penyimpanan data',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            }
        })
    })

    $("#department").change(function () {
        var value = $(this).val();
        $('#sub-department').html();
        if(value){
            $.ajax({
            type: "GET",
            url: "{{ route('get.sub.department') }}?id_department="+value,
            success: function(res) {
                var option = "";
                for (let i = 0; i < res.data.length; i++) {
                    option += '<option value="'+res.data[i].id_subdepartment+'">'+res.data[i].nama_subdepartment+'</option>';
                }
                $('#sub-department').html(option);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr);
                alert(xhr.status);
                alert(thrownError);
            }
        })
        }
    });

    $('#btnRotation').on('click', function() {
            $('#id').val('');
            $('#user_rotation').val('');
            $('#jabatan_rotation').val('');
            $('#cg_rotation').val('');
            $.get("{{ route('EmployeeMember.get') }}", function( response ) {
                $('#user_rotation').empty();
                $('#user_rotation').append('<option selected disabled>-- Pilih Karyawan --</option>');
                response.data.forEach(el => {
                    $('#user_rotation').append('<option value="' + el.id + '">' + el.nama_pengguna + ' - ' + el.nama_department + '</option>');
                });
            });
            $.get("{{ route('get.jabatan') }}", function( response ) {
                $('#jabatan_rotation').empty();
                $('#jabatan_rotation').append('<option selected disabled>-- Pilih Jabatan --</option>');
                response.data.forEach(el => {
                    $('#jabatan_rotation').append('<option value="' + el.id_job_title + '">' + el.nama_job_title + '</option>');
                });
            });
            $.get("{{ route('get.cg') }}", function( response ) {
                $('#cg_rotation').empty();
                $('#cg_rotation').append('<option selected disabled>-- Pilih Circle Group --</option>');
                response.data.forEach(el => {
                    $('#cg_rotation').append('<option value="' + el.id_cg + '">' + el.nama_cg + '</option>');
                });
            });
            // $modal.modal('show');
    })

    $("#formRotation").submit(function (e) {
        e.preventDefault();
        var form = $("#formRotation")
        const url = form.attr("action");
        var formData = form.serialize();
        $.ajax({
            url:url,
            type:"post",
            cache: false,
            data:formData,
            success:function (data) {
                $("#modal-rotation").modal('hide');
                $('#table-cg').DataTable().destroy();
                initDatatable();
                Swal.fire({
                    position:'center',
                    icon:'success',
                    title:data.message,
                    showConfirmButton:false,
                    timer:1500
                });
            },
            error:function (request,status,error) {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: 'Terjadi kesalahan saat penyimpanan data',
                        showConfirmButton: false,
                        timer: 1500
                    })
            }
        })
    })

    $(document).ready(function() {
        var $modal = $('#modal');
        var image = document.getElementById('sample_image');
        var cropper;
        $('#upload_image').change(function(event){
		    var files = event.target.files;
            var done = function(url){
                image.src = url;
                $modal.modal('show');
            };

            if(files && files.length > 0){
                reader = new FileReader();
                reader.onload = function(event)
                {
                    done(reader.result);
                };
                reader.readAsDataURL(files[0]);
            }
	    });

        $modal.on('shown.bs.modal', function() {
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 2,
                preview:'.preview'
            });
        }).on('hidden.bs.modal', function(){
            cropper.destroy();
            cropper = null;
        });

        $('#crop').click(function(){
            canvas = cropper.getCroppedCanvas({
                width:400,
                height:400
		    });

            canvas.toBlob(function(blob){
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function(){
                    var base64data = reader.result;
                    var fileInput = document.getElementById('#myInputID');
                    $('#uploaded_image').attr('src', base64data);
                    $('#base64').attr('value', base64data);
                    $modal.modal('hide');
                    // alert()
                    // $.ajax({
                    //     url:'upload.php',
                    //     method:'POST',
                    //     data:{image:base64data},
                    //     success:function(data)
                    //     {
                    //     }
                    // });
                };
            });
        });

        initDatatable();
        getDivisi();
        getJabatan();
        getLevel();
        getDepartment();
        // getSubDepartment();
        getCG();


        $('.delete-button').on('click',function () {
            $('#modal-hapus').modal('show');
        })

        $('.btn-tambah').on('click',function () {
            $('.modal-dialog form').attr('action',"{{ route('EmployeeMember.post') }}");
            // $('input[name="_method"]').remove();
            $('.modal-dialog form')[0].reset();
        })

        $('.btnRotation').on('click',function () {

        })
    });

</script>
@endpush
