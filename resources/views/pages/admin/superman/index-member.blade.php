@extends('layouts.master')

@section('title', 'Superman Member')

@section('content')
@push('style')
<style>

</style>
@endpush
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <p class="card-title ml-4">Superman Member</p>
                    <div class="col-md mb-2">
                        <a class="btn btn-sm btn-success float-right ml-2" href="javascript:void(0)" id="createNewItem" data-toggle="modal" data-target="#modal-tambah"><i class="icon-plus"></i> Enroll Superman</a>
                        <a class="btn btn-sm btn-success float-right btnRotation" href="javascript:void(0)" id="btnRotation" data-toggle="modal" data-target="#modal-rotation"><i class="icon-repeat"></i> Rotation User</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="display expandable-table table-striped table-hover" id="tbl-superman" style="width:100%">
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
    <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <div class="modal-header p-3">
            <h5 class="modal-title" id="modal-tambahLabel">Enroll Superman Member</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('post.member.superman') }}" method="POST" enctype="multipart/form-data" id="formPost">
                @csrf
                <div class="modal-body">
                    <div class="form-row">
                        <div class="col-12">
                        <div class="form-group">
                                <label for="noModule">Superman Member <small>(Bisa pilih lebih dari 1)</small></label>
                                    <select id="id_user" class="selectpicker form-control form-control-sm"
                                        name="id_user[]" data-live-search="true" data-hide-disabled="true" multiple
                                        data-actions-box="true">
                                    </select>
                                </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="id_level">Pilih Level</label>
                                <select id="id_level" class="form-control form-control-sm" name="id_level">
                                <option value="LV-0004">SPV</option>
                                <option value="LV-0003">DEPT HEAD</option>
                                <option value="LV-0002">Division Head</option>
                                </select>
                            </div>
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

<div class="modal fade" id="modal-hapus" tabindex="-1" role="dialog" aria-labelledby="modal-delete" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">Unroll Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Unroll data sebagai Superman?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-danger" type="button" id="btnHapus" onclick="unrollMember(this)" data-id="">Unrolls</a>
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
@endpush
@push('script')
<script src="{{ asset('assets/select2/js/select2.min.js') }}"></script>
<script type="text/javascript">

    var role = '{{ Auth::user()->peran_pengguna}}';

    function initDatatable() {
        var dtJson = $('#tbl-superman').DataTable({
            ajax: "{{ route('get.member.superman') }}",
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
                    data: 'action'
                }
            ],
        });
    }

    $('#tbl-superman').on('click','.member-hapus', function () {
        var id = $(this).attr('data-id');
        $('#btnHapus').attr('data-id',id);
    })

    function unrollMember(el) {
        var id = $(el).attr("data-id");
        var token = $("meta[name='csrf-token']").attr("content");
        $.ajax({
            url:"member-superman-delete/"+id,
            mehtod:"delete",
            data: {
                "id": id,
                "_token": token,
            },
            success:function(res)
            {
                console.log(res)
                $('#tbl-superman').DataTable().destroy();
                initDatatable();
                $("#modal-hapus").modal('hide');
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'Data Berhasil Dihapus',
                    showConfirmButton: false,
                    timer: 1500
                })
            },
            error:function(err){
                console.log(err)
                Swal.fire({
                    position: 'center',
                    icon: 'error',
                    title: err.responseJson.message,
                    showConfirmButton: false,
                    timer: 1500
                })
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

    function getSupermanMember() {
            $.ajax({
                type: "GET",
                url: "{{ route('EmployeeMember.getJson') }}",
                success: function(res) {
                    var option = "";
                    for (let i = 0; i < res.length; i++) {
                        option += '<option value="' + res[i].id + '">' + res[i]
                            .nama_pengguna + '</option>';
                    }
                    $("#id_user").html(option).selectpicker('refresh');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.fire({
                        icon: 'error',
                        title: xhr ,
                        showConfirmButton: false,
                        timer: 1500
                    })
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
        $('#feed-back-id_user').html('')
        $('#feed-back-id_level').html('')

        $('#id_user').removeClass('is-invalid')
        $('#id_level').removeClass('is-invalid')
        $.ajax({
            url:url,
            type:"POST",
            cache:false,
            data:formData,
            success:function (data) {
                $("#formPost")[0].reset();
                $("#modal-tambah").modal('hide');
                $('#tbl-superman').DataTable().destroy();
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
                    if(errors.id_user){
                        $( '#feed-back-id_user' ).html(errors.id_user[0]);
                        $( '#feed-back-id_user' ).show();
                        $( '#id_user' ).addClass('is-invalid');
                    }
                    if(errors.id_level){
                        $( '#feed-back-id_level' ).html(errors.id_level[0]);
                        $( '#feed-back-id_level' ).show();
                        $( '#id_level' ).addClass('is-invalid');
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
                $('#tbl-superman').DataTable().destroy();
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
                $('#tbl-superman').DataTable().destroy();
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
                viewMode: 3,
                preview:'.preview'
            });
        }).on('hidden.bs.modal', function(){
            cropper.destroy();
            cropper = null;
        });

        initDatatable();
        getLevel();
        getSupermanMember();


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
