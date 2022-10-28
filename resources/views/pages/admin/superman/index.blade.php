@extends('layouts.master')

@section('title', 'Curriculum')
@section('content')

    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <div class="row">
                    <p class="card-title ml-4">Kelola Superman</p>
                    <div class="col-md mb-2">
                            <a class="btn btn-sm btn-success float-right" href="javascript:void(0)" id="createNewItem"
                                data-toggle="modal" data-target="#modal-tambah"><i class="icon-plus"></i> Enroll Superman</a>
                        </div>
                </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="display expandable-table table-striped table-hover" id="table-cr-superman">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID Competency</th>
                                            <th>Skill Category</th>
                                            <th>Competency Superman</th>
                                            <th>Competency Group</th>
                                            <th>Target</th>
                                            <th>Competency Description</th>
                                            <th width="15%">Detail</th>
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
    <div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="modal-tambahLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" style="max-width: 1000px;" role="document">
            <div class="modal-content">
                <div class="modal-header p-3">
                    <h5 class="modal-title" id="modal-tambahLabel">Add New Curriculum</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="formCreate" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body pt-3 pb-0">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="skillCategory">Skill Category</label>
                                    <select id="id_skill_category" class="form-control form-control-sm" name="id_skill_category">
                                        <option value="">- Pilih Skill Category -</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="curriculum_superman">Competency</label>
                                    <input type="text" class="form-control" id="curriculum_superman" name="curriculum_superman"
                                        placeholder="Masukan Competency Name">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="curriculum_group">Competency Group</label>
                                    <select id="curriculum_group" class="form-control form-control-sm"
                                        name="curriculum_group">
                                        <option value="#">Pilih Competencie Group</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="noModule">Target</label>
                                    <select class="form-control form-control-sm" name="target" required>
                                    <option value="">Pilih Target</option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                <label for="noModule">Superman Member <small>(Bisa pilih lebih dari 1)</small></label>
                                    <select id="id_user" class="selectpicker form-control form-control-sm"
                                        name="id_user[]" data-live-search="true" data-hide-disabled="true" multiple
                                        data-actions-box="true">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                            <div class="form-group">
                                    <label for="noModule">Competency Description</label>
                                    <textarea class="form-control" id="curriculum_desc" name="curriculum_desc" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="createPost()">Save</button>
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
                    <h5 class="modal-title" id="modal-editLabel">Edit Curriculum Superman</h5>
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
    </div>

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
        $('.btn-detail-user').click(function() {
            var data = $(this).data('users');
            var data = data.split(",");
            let txt = "";
            for (x in data) {
                txt += '<li>'+ data[x] + '</li>'
            }
            document.getElementById("tampil-user").innerHTML = txt;
        })
        $('#table-cr-superman').DataTable();

        function createPost() {
            let _url = "{{ route('superman.store') }}";
            let _token = $('meta[name="csrf-token"]').attr('content');
            const data = $("#formCreate").serialize();
            $.ajax({
                url: _url,
                type: "POST",
                data: data,
                cache: false,
                success: function(response) {
                    if (response.code == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Your work has been saved',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                    $('#no_curriculum_superman').val(''),
                    $('#id_skill_category').val(''),
                    $('#curriculum_superman').val(''),
                    $('#curriculum_group').val(''),
                    $('#curriculum_desc').val(''),
                    $('#target').val(''),
                    $('#modal-tambah').modal('hide');
                    location.reload();
                },
                error: function(err) {
                    Swal.fire({
                        icon: 'error',
                        title: err.responseJSON.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            });
        }

        function editPost(event) {
            var id = $(event).data("id");
            let _url = "{!! route('superman.update') !!}";
            var curriculumEditForm = $("#formEdit");
            var formData = curriculumEditForm.serialize();
            $.ajax({
                url: _url,
                type: "post",
                data: formData,
                success: function(response) {
                    if (response.code == 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Your work has been saved',
                            showConfirmButton: false,
                            timer: 3000
                        })
                        $('#modal-edit').modal('hide');
                        location.reload();
                    }
                },
                error: function(err) {
                    Swal.fire({
                        position: 'center',
                        icon: 'error',
                        title: err.responseJSON.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            });
        }

        function getFormEdit(el) {
            var id = $(el).attr("data-id");
            $.ajax({
                url: "{!! route('superman.get.form') !!}?id=" + id,
                mehtod: "get",
                success: function(html) {
                    // console.log(html, id)
                    $("#form-edit").html(html);
                }
            })
        }

        $('#table-cr-superman').on('click', '.cr-hapus', function() {
            var id = $(this).data('id');
            $('#btnHapus').attr('data-id', id);
        })

        function deleteCurriculum(el) {
            var id = $(el).attr("data-id");
            
            var token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                url: "superman/delete/" + id,
                mehtod: "delete",
                data: {
                    "id": id,
                    "_token": token,
                },
                success: function(res) {
                    console.log(res)
                    $("#modal-hapus").modal('hide');
                    window.location.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Data berhasil di hapus',
                        showConfirmButton: true,
                        timer: 1500
                    })
                }, error: function(err) {
                    console.log(err)
                    Swal.fire({
                        icon: 'error',
                        title: err.responseJSON.errors,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            })
        }

        function getSkill() {
            $.ajax({
                type: "GET",
                url: "{{ route('get.skill') }}",
                success: function(res) {
                    var option = "";
                    for (let i = 0; i < res.data.length; i++) {
                        option += '<option value="' + res.data[i].id_skill_category + '">' +
                            res.data[i].skill_category + '</option>';
                    }
                    $('#id_skill_category').html();
                    $('#id_skill_category').append(option);
                },
                error: function(response) {
                    Swal.fire({
                        icon: 'error',
                        title: response.responseJSON.errors,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            })
        }

        function getSupermanMember() {
            $.ajax({
                type: "GET",
                url: "{{ route('superman.get') }}",
                success: function(res) {
                    var option = "";
                    for (let i = 0; i < res.length; i++) {
                        option += '<option value="' + res[i].id + '">' + res[i]
                            .nama_pengguna  + ' - ' + res[i]
                            .nama_job_title  + '</option>';
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

        $(function() {
            $('#id_skill_category').on('change', function() {
                var id_skill_category = $(this).val();
                $.ajax({
                    url: "{{ route('competencie-groups.getBySkillCategory') }}",
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        id: id_skill_category
                    },
                    success: function(response) {
                        $('#curriculum_group').empty();
                        var option = "";
                        for (let i = 0; i < response.length; i++) {
                            option += '<option value="' + response[i].id + '">' +
                                response[i].name + '</option>';
                        }
                        $('#curriculum_group').html();
                        $('#curriculum_group').append(option);
                    }
                })
            })
        })

        $(document).ready(function() {
            getSupermanMember();
            getSkill();


            // Data retrieved from https://netmarketshare.com/

        });
    </script>
@endpush
