@extends('layouts.master')

@section('title', 'Curriculum Champion')
@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                <div class="row">
                    <p class="card-title ml-4">Curriculum Champion</p>
                    <div class="col-md mb-2">
                            <a class="btn btn-sm btn-success float-right" href="javascript:void(0)" id="createNewItem"
                                data-toggle="modal" data-target="#modal-tambah"><i class="icon-plus"></i> Add
                                Curriculum</a>
                        </div>
                </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="display expandable-table table-striped table-hover" id="table-cr-champion">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID Competency</th>
                                            <th>Group Champion</th>
                                            <th>Competency Champion</th>
                                            <th>Trainer</th>
                                            <th>Level</th>
                                            <th>Sub Group Champion</th>
                                            <th>Target</th>
                                            <th>Competency Description</th>
                                            <th width="15%">Detail</th>
                                            <th width="15%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($data as $data)
                                            <tr id="row_{{ $data->id_curriculum_superman }}">
                                                <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                                                <td>{{ $data->no_curriculum_champion }}</td>
                                                <td>{{ $data->nama_group_champion }}</td>
                                                <td>{{ $data->curriculum_champion }}</td>
                                                <td>{{ $data->trainer }}</td>
                                                <td>{{ $data->level }}</td>
                                                <td>{{ $data->compGroupName }}</td>
                                                <td>
                                                    @php
                                                        switch($data->target){
                                                        case 0:
                                                            $target = asset('assets/images/point/0.png');
                                                        break;
                                                        case 1:
                                                            $target = asset('assets/images/point/1.png');
                                                        break;
                                                        case 2:
                                                            $target = asset('assets/images/point/2.png');
                                                        break;
                                                        case 3:
                                                            $target = asset('assets/images/point/3.png');
                                                        break;
                                                        case 4:
                                                            $target = asset('assets/images/point/4.png');
                                                        break;
                                                        case 5:
                                                            $target = asset('assets/images/point/5.png');
                                                        break;
                                                        default:
                                                            $target = "";
                                                        break;
                                                        }
                                                    @endphp
                                                        <img src="{{$target}}" title="{{$data->target}}" style="width:30px;height:30px" alt="">
                                                </td>
                                                <td>{{ $data->curriculum_desc }}</td>
                                                <td>
                                                    <button class="btn btn-inverse-info btn-icon btn-detail-user" data-users="{{ $data->users }}" data-toggle="modal" data-target="#modal-detail-user"><i class="icon-eye"></i> </button>
                                                </td>
                                                <td>
                                                    <button data-id="{{ $data->id_curriculum_champion }}" onclick="getFormEdit(this)"
                                                        class="btn btn-inverse-success btn-icon delete-button mr-1 Edit-button"
                                                        data-toggle="modal" data-target="#modal-edit" data-toggle="tooltip" data-placement="top" title="Edit Data"><i
                                                            class="icon-file menu-icon"></i></button>

                                                    <button data-id="{{ $data->id_curriculum_champion }}"
                                                        class="btn btn-inverse-danger btn-icon mr-1 btnHapus"
                                                        >
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

    {{-- Modal Tambah--}}
    <div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="modal-tambahLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" style="max-width: 1000px;" role="document">
            <div class="modal-content">
                <div class="modal-header p-3">
                    <h5 class="modal-title" id="modal-tambahLabel">Add New Curriculum Champion</h5>
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
                                    <select id="id_skill_category" class="form-control form-control-sm" name="id_group_champion">
                                        <option value="">- Pilih Skill Category -</option>
                                    </select>
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
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="curriculum_group">Competency Group</label>
                                    <select id="curriculum_group" class="form-control form-control-sm"
                                        name="id_sub_group_champion">
                                        <option value="#">Pilih Competencie Group</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="target">Target</label>
                                    <select class="form-control form-control-sm" name="target" required>
                                    <option value="">Pilih Target</option>
                                    <option value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                <label for="noModule">Champion Member <small>(Bisa pilih lebih dari 1)</small></label>
                                    <select id="id_user" class="selectpicker form-control form-control-sm"
                                        name="id_user[]" data-live-search="true" data-hide-disabled="true" multiple
                                        data-actions-box="true">
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="curriculum_champion">Trainer</label>
                                    <input type="text" class="form-control" id="trainer" name="trainer"
                                        placeholder="Masukan Plot Trainer">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                            <div class="form-group">
                                <label for="curriculum_champion">Competency</label>
                                <input type="text" class="form-control" id="curriculum_champion" name="curriculum_champion"
                                    placeholder="Masukan Competency Name">
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
    
    {{-- Modal Edit--}}
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

    <!-- <div class="modal fade" id="modal-hapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17"
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
                    <button id="btnHapus" onclick="deleteCurriculum(this)" data-id="" class="btn btn-danger btnHapus">Hapus</button>
                </div>
            </div>
            </form>
        </div>
    </div> -->

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
        $('#table-cr-champion').DataTable();

        function createPost() {
            let _url = "{{ route('champion.store') }}";
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
                    $('#no_curriculum_champion').val(''),
                    $('#id_skill_category').val(''),
                    $('#curriculum_champion').val(''),
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
            let _url = "{!! route('champion.update') !!}";
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
                url: "{!! route('champion.get.form') !!}?id=" + id,
                mehtod: "get",
                success: function(html) {
                    // console.log(html, id)
                    $("#form-edit").html(html);
                }
            })
        }

        $('body').on('click', '.btnHapus', function() {
            var id = $(this).attr('data-id');
            console.log("ID:", id);
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
                        url: "{{ route('champion.curriculum.destroy') }}",
                        type: 'POST',
                        dataType: 'JSON',
                        data: {
                            id
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: response.status,
                                text: response.message
                            });
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        },
                    })
                }
            })
        })
        // $('#table-cr-champion').on('click', '.cr-hapus', function() {
        //     var id = $(this).data('id');
        //     $('#btnHapus').attr('data-id', id);
        // })

        // function deleteCurriculum(el) {
        //     var id = $(el).attr("data-id");
            
        //     var token = $("meta[name='csrf-token']").attr("content");
        //     $.ajax({
        //         url: "champion/delete/" + id,
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

        function getSkill() {
            $.ajax({
                type: "GET",
                url: "{{ route('champion.group') }}",
                success: function(res) {
                    var option = "";
                    for (let i = 0; i < res.data.length; i++) {
                        option += '<option value="' + res.data[i].id_group_champion + '">' +
                            res.data[i].nama_group_champion + '</option>';
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
                url: "{{ route('champion.get') }}",
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
                var id_group_champion = $(this).val();
                $.ajax({
                    url: "{{ route('champion.group.sub') }}",
                    type: 'GET',
                    dataType: 'JSON',
                    data: {
                        id: id_group_champion
                    },
                    success: function(response) {
                        $('#curriculum_group').empty();
                        var option = "";
                        for (let i = 0; i < response.length; i++) {
                            option += '<option value="' + response[i].id_sub_group_champion + '">' +
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
