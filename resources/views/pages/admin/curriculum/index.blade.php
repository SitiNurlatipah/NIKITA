@extends('layouts.master')

@section('title', 'Curriculum')

@push('style')
    <style>
        .swal2-popup {
            font-size: 2rem;
        }
        body {
        overflow-y:hidden;
        }

        .modal-open .modal {
            overflow-x: auto;
            overflow-y: hidden;
        }

        body.modal-open, .modal-open .navbar-fixed-top, .modal-open .navbar-fixed-bottom { 	margin: 0; }
    </style>
@endpush
@section('content')

    <div class="row">

        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <p class="card-title">Curriculum</p>
                    <div class="row">
                        <div class="col-md mb-2">
                            <a class="btn btn-success float-right" href="javascript:void(0)" id="createNewItem"
                                data-toggle="modal" data-target="#modal-tambah"><i class="icon-plus"></i> Add
                                Curriculum</a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="display expandable-table table-striped table-hover" id="table-cr"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>No Competency</th>
                                            <th>Skill Category</th>
                                            <th>Competency</th>
                                            <th>Level</th>
                                            <th>Competency Group</th>
                                            <th>Competency Description</th>
                                            <th style="min-width: 650px">Job Title</th>
                                            <th width="15%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $data)
                                            <tr id="row_{{ $data->id_curriculum }}">
                                                <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                                                <td>{{ $data->no_training_module }}</td>
                                                <td>{{ $data->skill_category }}</td>
                                                <td>{{ $data->training_module }}</td>
                                                <td>{{ $data->level }}</td>
                                                <td>{{ $data->compGroupName }}</td>
                                                <td>{{ $data->training_module_desc }}</td>
                                                <td>
                                                    @php
                                                        $jobs = explode(",",$data->job_title);
                                                    @endphp
                                                    <ul>
                                                        @foreach ($jobs as $job)
                                                           {{ $job.', '}}
                                                        @endforeach
                                                        {{-- @php
                                                            $string = strip_tags(implode($jobs));
                                                            if (strlen($string) > 500) {

                                                                // truncate string
                                                                $stringCut = substr($string, 0, 500);
                                                                $endPoint = strrpos($stringCut, ' ');

                                                                //if the string doesn't contain any space then it will cut without word basis.
                                                                $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                                                $string .= '... <a href="/this/story">Read More</a>';
                                                            }
                                                            echo $string;
                                                        @endphp --}}
                                                    </ul>
                                                </td>
                                                <td>
                                                    <button data-id="{{ $data->id_curriculum }}" onclick="editdata(this)"
                                                        class="btn btn-inverse-success btn-icon delete-button mr-1 Edit-button"
                                                        data-toggle="modal" data-target="#modal-edit" data-toggle="tooltip" data-placement="top" title="Edit Data"><i
                                                            class="icon-file menu-icon"></i></button>
                                                    <button data-id="{{ $data->id_curriculum }}"
                                                        class="btn btn-inverse-danger btn-icon mr-1 cr-hapus"
                                                        data-toggle="modal" data-target="#modal-cr-hapus" data-toggle="tooltip" data-placement="top" title="Delete Data">
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
                    <h5 class="modal-title" id="modal-tambahLabel">Add New Curriculum</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="formCreate" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="skillCategory">Skill Category</label>
                                    <select id="id_skill_category" class="form-control form-control-sm" name="id_skill_category">
                                        {{-- <option value="">Pilih Skill Category</option> --}}
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="training_module_group">Competency Group</label>
                                    <select id="training_module_group" class="form-control form-control-sm"
                                        name="training_module_group">
                                        {{-- <option value="#">-- Pilih Competencie Group --</option> --}}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="training_module">Competency</label>
                                    <input type="text" class="form-control" id="training_module" name="training_module"
                                        placeholder="Masukan Competency Name">
                                </div>
                                <div class="form-group">
                                    <label for="noModule">Level</label>
                                    <select class="form-control form-control-sm" id="level" name="level">
                                        <option value="">Pilih Level</option>
                                        <option value="B">B (Basic)</option>
                                        <option value="I">I (Intermediate)</option>
                                        <option value="A">A (Advance)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="noModule">Competency Description</label>
                                    <textarea class="form-control" id="training_module_desc" name="training_module_desc" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="noModule">Job Title</label>
                                    <select id="id_job_title" class="selectpicker form-control form-control-sm"
                                        name="id_job_title[]" data-live-search="true" data-hide-disabled="true" multiple
                                        data-actions-box="true">
                                    </select>
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
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header p-3">
                    <h5 class="modal-title" id="modal-editLabel">Edit Data Kurikulum</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="formEditCurriculum" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body" id="form-edit"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="editPost()">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-cr-hapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17"
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
        $('#table-cr').DataTable();

        function editPost(event) {
            var id = $(event).data("id");
            let _url = "{!! route('editCurriculum') !!}";
            var curriculumEditForm = $("#formEditCurriculum");
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
                            timer: 1500
                        })
                        $('#modal-edit').modal('hide');
                        location.reload();
                    }
                },
                error: function(err) {
                    console.log(err)
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: err.responseJSON.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            });
        }

        function editdata(el) {
            var id = $(el).attr("data-id");
            $.ajax({
                url: "{!! route('getFormEditCurriculum') !!}?id=" + id,
                mehtod: "get",
                success: function(html) {
                    $("#form-edit").html(html);
                }
            })
        }

        function createPost() {
            let _url = `{{ route('Curriculum.post') }}`;
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
                    $('#no_training_module').val(''),
                        $('#id_skill_category').val(''),
                        $('#training_module').val(''),
                        $('#level').val(''),
                        $('#training_module_group').val(''),
                        $('#training_module_desc').val(''),
                        $('#id_job_title').val(''),
                        $('#title').val('');
                    $('#description').val('');
                    $('#modal-tambah').modal('hide');
                    location.reload();
                },
                error: function(err) {
                    console.log(err)
                    Swal.fire({
                        icon: 'error',
                        title: err.responseJSON.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            });
        }

        $('#table-cr').on('click', '.cr-hapus', function() {
            var id = $(this).data('id');
            $('#btnHapus').attr('data-id', id);
        })

        function deleteCurriculum(el) {
            var id = $(el).attr("data-id");
            var token = $("meta[name='csrf-token']").attr("content");
            $.ajax({
                url: "curriculum/curriculum-delete/" + id,
                mehtod: "delete",
                data: {
                    "id": id,
                    "_token": token,
                },
                success: function(res) {
                    $("#modal-cr-hapus").modal('hide');
                    window.location.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Data berhasil di hapus',
                        showConfirmButton: true,
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

        function getJabatan() {
            $.ajax({
                type: "GET",
                url: "{{ route('get.jabatan') }}",
                success: function(res) {
                    var option = "";
                    for (let i = 0; i < res.data.length; i++) {
                        option += '<option value="' + res.data[i].id_job_title + '">' + res.data[i]
                            .nama_job_title + '</option>';
                    }
                    $("#id_job_title").html(option).selectpicker('refresh');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    Swal.fire({
                        icon: 'error',
                        title: response.responseJSON.errors,
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
                    url: '{{ route('competencie-groups.getBySkillCategory') }}',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        id: id_skill_category
                    },
                    success: function(response) {
                        $('#training_module_group').empty();
                        var option = "";
                        for (let i = 0; i < response.length; i++) {
                            option += '<option value="' + response[i].id + '">' +
                                response[i].name + '</option>';
                        }
                        $('#training_module_group').html();
                        $('#training_module_group').append(option);
                    }
                })
            })
        })

        $(document).ready(function() {
            getJabatan();
            getSkill();
        });
    </script>
@endpush
