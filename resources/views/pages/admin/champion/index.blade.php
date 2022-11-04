@extends('layouts.master')

@section('title', 'Curriculum')
@section('content')

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <div class="row">
                    <p class="card-title ml-4">Kelola Champion</p>
                    <div class="col-md mb-2">
                        <a class="btn btn-sm btn-success float-right" href="javascript:void(0)" id="createNewItem"
                            data-toggle="modal" data-target="#modal-tambah"><i class="icon-plus"></i> Enroll Champion</a>
                    </div>
                </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="nowrap expandable-table table-striped table-hover" id="table-kelola-Champion" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Department</th>
                                            <th>Jabatan</th>
                                            <th>Level</th>
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
    <!-- <div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="modal-tambahLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" style="max-width: 1000px;" role="document">
            <div class="modal-content">
                <div class="modal-header p-3">
                    <h5 class="modal-title" id="modal-tambahLabel">Add New Curriculum</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{!!route('actionWhiteTag')!!}" id="formWhiteTag" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="user_id" name="user_id" value="">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="display expandable-table table-striped table-hover" id="tableEdit" style="width:100%">
                            <thead>
                                <tr>
                                    <th rowspan="2" class="text-center">No</th>
                                    <th rowspan="2">No. Competency</th>
                                    <th rowspan="2">Skill Category</th>
                                    <th rowspan="2">Competency</th>
                                    <th rowspan="2">Level</th>
                                    <th rowspan="2">Competency Group</th>
                                    <th colspan="4" class="text-center">Action</th>
                                    <th class="text-center" rowspan="2">Status</th>
                                </tr> 
                                <tr>
                                    <th class="text-center" style="min-width:90px">Start</th>
                                    <th class="text-center" style="min-width:90px">Actual</th>
                                    <th class="text-center" style="min-width:50px">Target</th>
                                    <th class="text-center" style="min-width:90px">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody id="formMapComp">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="submitWhiteTag" class="btn btn-primary">Save changes</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modal-editLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" style="max-width: 1000px;" role="document">
            <div class="modal-content">
                <div class="modal-header p-3">
                    <h5 class="modal-title" id="modal-editLabel">Edit Curriculum Champion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="formEdit" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body" id="form-edit">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="editPost()">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-hapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17"
        aria-hidden="true">
        <div class="modal-dialog">
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
                    <button id="btnHapus" onclick="deleteCurriculum(this)" data-id="" class="btn btn-danger">Hapus</button>
                </div>
            </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modal-detail-user" tabindex="-1" role="dialog" aria-labelledby="modal-editLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header p-3">
                    <h5 class="modal-title" id="modal-editLabel">Detail User Asign</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <ul id="tampil-user">
                    </ul> 
                </div>
            </div>
        </div>
    </div> -->

@endsection
@push('script')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
    function initDatatable() {
        var dtJson = $('#table-kelola-Champion').DataTable({
            ajax: "{{ route('Champion.json') }}",
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
                    data: 'nama_department'
                },
                {
                    data: 'nama_job_title'
                },
                {
                    data: 'nama_level'
                },
                {
                    data: 'action'
                }
            ],
        })
    }

        // $('.btn-detail-user').click(function() {
        //     var data = $(this).data('users');
        //     var data = data.split(",");
        //     let txt = "";
        //     for (x in data) {
        //         txt += '<li>'+ data[x] + '</li>'
        //     }
        //     document.getElementById("tampil-user").innerHTML = txt;
        // })

        // function createPost() {
        //     let _url = "{{ route('Champion.store') }}";
        //     let _token = $('meta[name="csrf-token"]').attr('content');
        //     const data = $("#formCreate").serialize();
        //     $.ajax({
        //         url: _url,
        //         type: "POST",
        //         data: data,
        //         cache: false,
        //         success: function(response) {
        //             if (response.code == 200) {
        //                 Swal.fire({
        //                     icon: 'success',
        //                     title: 'Your work has been saved',
        //                     showConfirmButton: false,
        //                     timer: 1500
        //                 })
        //             }
        //             $('#no_curriculum_superman').val(''),
        //             $('#id_skill_category').val(''),
        //             $('#curriculum_superman').val(''),
        //             $('#curriculum_group').val(''),
        //             $('#curriculum_desc').val(''),
        //             $('#target').val(''),
        //             $('#modal-tambah').modal('hide');
        //             location.reload();
        //         },
        //         error: function(err) {
        //             Swal.fire({
        //                 icon: 'error',
        //                 title: err.responseJSON.message,
        //                 showConfirmButton: false,
        //                 timer: 1500
        //             })
        //         }
        //     });
        // }

        // function editPost(event) {
        //     var id = $(event).data("id");
        //     let _url = "{!! route('Champion.update') !!}";
        //     var curriculumEditForm = $("#formEdit");
        //     var formData = curriculumEditForm.serialize();
        //     $.ajax({
        //         url: _url,
        //         type: "post",
        //         data: formData,
        //         success: function(response) {
        //             if (response.code == 200) {
        //                 Swal.fire({
        //                     icon: 'success',
        //                     title: 'Your work has been saved',
        //                     showConfirmButton: false,
        //                     timer: 3000
        //                 })
        //                 $('#modal-edit').modal('hide');
        //                 location.reload();
        //             }
        //         },
        //         error: function(err) {
        //             Swal.fire({
        //                 position: 'center',
        //                 icon: 'error',
        //                 title: err.responseJSON.message,
        //                 showConfirmButton: false,
        //                 timer: 1500
        //             })
        //         }
        //     });
        // }

        // function getFormEdit(el) {
        //     var id = $(el).attr("data-id");
        //     $.ajax({
        //         url: "{!! route('Champion.get.form') !!}?id=" + id,
        //         mehtod: "get",
        //         success: function(html) {
        //             // console.log(html, id)
        //             $("#form-edit").html(html);
        //         }
        //     })
        // }

        // $('#table-cr-Champion').on('click', '.cr-hapus', function() {
        //     var id = $(this).data('id');
        //     $('#btnHapus').attr('data-id', id);
        // })

        // function deleteCurriculum(el) {
        //     var id = $(el).attr("data-id");
            
        //     var token = $("meta[name='csrf-token']").attr("content");
        //     $.ajax({
        //         url: "Champion/delete/" + id,
        //         mehtod: "delete",
        //         data: {
        //             "id": id,
        //             "_token": token,
        //         },
        //         success: function(res) {
        //             console.log(res)
        //             $("#modal-hapus").modal('hide');
        //             window.location.reload();
        //             Swal.fire({
        //                 icon: 'success',
        //                 title: 'Data berhasil di hapus',
        //                 showConfirmButton: true,
        //                 timer: 1500
        //             })
        //         }, error: function(err) {
        //             console.log(err)
        //             Swal.fire({
        //                 icon: 'error',
        //                 title: err.responseJSON.errors,
        //                 showConfirmButton: false,
        //                 timer: 1500
        //             })
        //         }
        //     })
        // }

        // function getSkill() {
        //     $.ajax({
        //         type: "GET",
        //         url: "{{ route('get.skill') }}",
        //         success: function(res) {
        //             var option = "";
        //             for (let i = 0; i < res.data.length; i++) {
        //                 option += '<option value="' + res.data[i].id_skill_category + '">' +
        //                     res.data[i].skill_category + '</option>';
        //             }
        //             $('#id_skill_category').html();
        //             $('#id_skill_category').append(option);
        //         },
        //         error: function(response) {
        //             Swal.fire({
        //                 icon: 'error',
        //                 title: response.responseJSON.errors,
        //                 showConfirmButton: false,
        //                 timer: 1500
        //             })
        //         }
        //     })
        // }

        // function getSupermanMember() {
        //     $.ajax({
        //         type: "GET",
        //         url: "{{ route('Champion.get') }}",
        //         success: function(res) {
        //             var option = "";
        //             for (let i = 0; i < res.length; i++) {
        //                 option += '<option value="' + res[i].id + '">' + res[i]
        //                     .nama_pengguna  + ' - ' + res[i]
        //                     .nama_job_title  + '</option>';
        //             }
        //             $("#id_user").html(option).selectpicker('refresh');
        //         },
        //         error: function(xhr, ajaxOptions, thrownError) {
        //             Swal.fire({
        //                 icon: 'error',
        //                 title: xhr ,
        //                 showConfirmButton: false,
        //                 timer: 1500
        //             })
        //         }
        //     })
        // }

        // $(function() {
        //     $('#id_skill_category').on('change', function() {
        //         var id_skill_category = $(this).val();
        //         $.ajax({
        //             url: "{{ route('competencie-groups.getBySkillCategory') }}",
        //             type: 'POST',
        //             dataType: 'JSON',
        //             data: {
        //                 id: id_skill_category
        //             },
        //             success: function(response) {
        //                 $('#curriculum_group').empty();
        //                 var option = "";
        //                 for (let i = 0; i < response.length; i++) {
        //                     option += '<option value="' + response[i].id + '">' +
        //                         response[i].name + '</option>';
        //                 }
        //                 $('#curriculum_group').html();
        //                 $('#curriculum_group').append(option);
        //             }
        //         })
        //     })
        // })

        $(document).ready(function() {
            initDatatable();
        });
    </script>
@endpush
