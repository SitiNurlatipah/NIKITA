@extends('layouts.master')

@section('title', 'Master Grade Page ')

@section('content')
<div class="row">
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <p class="card-title">Grade</p>
                <div class="row">
                    <div class="col-md mb-2">
                        <a class="btn btn-success float-right btnAdd" href="javascript:void(0)" ><i class="icon-plus"></i> Tambah Grade</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="display expandable-table table table-sm table-striped table-hover" id="table-grade" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="10">No.</th>
                                        <th>Name Grade</th>
                                        <th>Tingkatan</th>
                                        <th>Level</th>
                                        <th>Persen</th>
                                        <th  width="15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $data)
                                    <tr id="row_{{$data->id_grade}}">
                                        <th scope="row" class="text-center">{{ $loop->iteration }}</th>
                                        <td>
                                            <span class="{{ $data->bg_color }}">{{ $data->grade }}</span>
                                        </td>
                                        <td>{{ $data->tingkatan }}</td>
                                        <td>{{ $data->level }}</td>
                                        <td>{{ $data->persen }}</td>
                                        <td>
                                            <button data-id="{{ $data->id_grade }}" data-grade="{{ $data->grade }}" data-level="{{ $data->level }}" data-tingkatan="{{ $data->tingkatan }}" data-persen="{{ $data->persen }}" data-bgcolor="{{ $data->bg_color }}" class="btn btn-inverse-success btn-icon delete-button mr-1 mr-1 Edit-button btnEdit"><i class="icon-file menu-icon"></i></button>
                                            <button data-id="{{ $data->id_grade }}" class="btn btn-inverse-danger btn-icon mr-1 cr-hapus btnHapus">
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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modal-tambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
          <div class="modal-header p-3">
              <h5 class="modal-title" id="modal-tambahLabel">Tambah Data Grade</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="javascript:void(0)" id="myForm" method="post">
                @csrf
                <input type="number" name="id" id="id" hidden>
            <div class="modal-body">
                <div class="form-row">
                    <div class="col mb-3">
                        <label>Grade Name</label>
                        <input type="text" class="form-control form-control-sm" id="grade" name="grade" placeholder="Masukan nama grade">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col mb-3">
                        <label>Tingkatan</label>
                        <input type="text" class="form-control form-control-sm" id="tingkatan" name="tingkatan" placeholder="Masukan Tingkatan">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col mb-3">
                        <label>Level</label>
                        <input type="text" class="form-control form-control-sm" id="level" name="level" placeholder="Masukan level">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col mb-3">
                        <label>Persen</label>
                        <input type="number" class="form-control form-control-sm" id="persen" name="persen" placeholder="1-100" min="1" max="100">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col mb-3">
                        <label>Bg Color</label>
                        <input type="text" class="form-control form-control-sm" id="bg_color" name="bg_color" placeholder="badge badge-success">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btnSave">Save changes</button>
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
   $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip({
            animation: true,
            plaGradent: "top",
            trigger: "hover focus"
        });
        $('#table-grade').DataTable();

        var modal = $('#myModal');
        var modalTitle = $('#myModal .modal-title');
        $('.btnAdd').on('click', function(){
            modalTitle.text('Tambah Data Grade');
            modal.modal('show');
        })

        $('body').on('click','.btnEdit', function(){
            var grade = $(this).data('grade');
            var tingkatan = $(this).data('tingkatan');
            var level = $(this).data('level');
            var persen = $(this).data('persen');
            var bgcolor = $(this).data('bgcolor');
            var id =  $(this).data('id');
            modalTitle.text('Edit Data Grade');
            $('#id').val(id);
            $('#grade').val(grade);
            $('#tingkatan').val(tingkatan);
            $('#level').val(level);
            $('#persen').val(persen);
            $('#bg_color').val(bgcolor);
            modal.modal('show');
        })


        $('.btnSave').on('click', function(){
            var form = $('#myForm');
            $.ajax({
                url: '{{ route('grade.store') }}',
                type: 'POST',
                dataType: 'JSON',
                data: form.serialize(),
                success: function(response){
                    Swal.fire({
                        icon: response.status,
                        text: response.message
                    })
                    modal.modal('hide');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                }
            })
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
                        url: '{{ route('grade.destroy') }}',
                        type: 'POST',
                        dataType: 'JSON',
                        data: {
                            id
                        },
                        success: function(response) {
                            Swal.fire(
                                'Success',
                                response.message,
                                response.status
                            )
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                    })
                }
            })
        })

        $('#myModal').on('hidden.bs.modal', function() {
            $('#id').val('');
            $('#grade').val('');
            $('#tingkatan').val('');
            $('#level').val('');
            $('#persen').val('');
            $('#bg_color').val('');
        })
    });


</script>
@endpush
