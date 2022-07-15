@extends('layouts.master')

@section('title', 'Competencies Directory')

@push('style')
<style>

    .accordion {
        width: 100%;
    }

    .img-accordion {
        width: 100%;
    }

    .card-header {
        padding: 1.2rem !important;
        border-radius: 40px !important;
    }
</style>
@endpush
@section('content')
 {{-- <div class="row">
    <div class="col-md-6 grid-margin stretch-card mb-0">
    <div id="accordion" class="accordion ">
        <div class="card">
            <div class="card-header card-title" data-toggle="collapse" href="#collapseOne">
            Key Point General
            </div>
            <div id="collapseOne" class="card-body collapse show" data-parent="#accordion" aria-expanded="true">
                <img src="{{ asset('assets/images/general.png') }}" alt="General" class="img-accordion mt-4">
            </div>
        </div>
    </div>
    </div>
    <div class="col-md-6 grid-margin stretch-card mb-0 pl-0">
        <div id="accordion" class="accordion">
            <div class="card">
                <div class="card-header card-title" data-toggle="collapse" href="#collapseOne">
                Key Point Functional
                </div>
                <div id="collapseOne" class="card-body collapse show" data-parent="#accordion" aria-expanded="true">
                    <img src="{{ asset('assets/images/functional.png') }}" alt="General" class="img-accordion mt-4">
                </div>
            </div>
        </div>
        </div>
 </div> --}}
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <p class="card-title">Competencies Directory</p>
                {{-- <div class="row">
                    <div class="col-md mb-2">
                        <a class="btn btn-success float-right" href="javascript:void(0)" id="createNewItem" data-toggle="modal" data-target="#modal-tambah"><i class="icon-plus"></i> Add Competencies Directory</a>
                    </div>
                </div> --}}
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="display expandable-table table-striped table-hover table-sm" id="table-cg" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No Training Module#</th>
                                        <th>Skill Category</th>
                                        <th>Training Module</th>
                                        <th>Year Between</th>
                                        <th>Target</th>
                                        <th>Action</th>
                                    </tr> 
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>001/KMI/HRD-RT/SAL/001</td>
                                        <td>Company Strategy</td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <button data-toggle="modal" data-target="#modal-tambah" class="btn btn-inverse-success btn-icon mr-1"><i class="icon-file menu-icon"></i></button>
                                            <button data-toggle="modal" data-target="#modal-detail"  class="btn btn-inverse-info btn-icon"><i class="icon-eye"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>002/KMI/HRD-RT/SAL/002</td>
                                        <td>Orientation Department</td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <button data-toggle="modal" data-target="#modal-tambah" class="btn btn-inverse-success btn-icon mr-1"><i class="icon-file menu-icon"></i></button>
                                            <button data-toggle="modal" data-target="#modal-detail"  class="btn btn-inverse-info btn-icon"><i class="icon-eye"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>003/KMI/HRD-RT/SAL/003</td>
                                        <td>KALBE Business Ethic</td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <button data-toggle="modal" data-target="#modal-tambah" class="btn btn-inverse-success btn-icon mr-1"><i class="icon-file menu-icon"></i></button>
                                            <button data-toggle="modal" data-target="#modal-detail"  class="btn btn-inverse-info btn-icon"><i class="icon-eye"></i></button>
                                        </td>
                                    </tr>
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
<div class="modal fade" id="modal-tambah" tabindex="-1" role="dialog" aria-labelledby="modal-tambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
          <div class="modal-header p-3">
              <h5 class="modal-title" id="modal-tambahLabel">Tambah Data Karyawan</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group col-sm">
                            <label for="yearduration">Job Title</label>
                            <select id="id_job_title" class="form-control form-control-sm" name="id_job_title">
                                <option value="">Pilih Job Title</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group col-sm">
                            <label for="yearduration">Year Duration</label>
                            <select id="year_duration" class="form-control form-control-sm" name="year_duration">
                                <option value="">Pilih Year Duration</option>
                                <option value="Y0-Y1">Y0-Y1</option>
                                <option value="Y2-Y3">Y2-Y3</option>
                                <option value="Y4-Y5">Y4-Y5</option>
                                <option value="Y6-Y7">Y6-Y7</option>
                                <option value="Y8-Y9">Y8-Y9</option>
                                <option value="YN">YN</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group col-sm">
                            <label for="yearduration">Target</label>
                            <input type="number">
                            {{-- <select id="id_job_title" class="form-control form-control-sm" name="id_job_title">
                                <option value="">Pilih Job Title</option>
                            </select> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </form>
      </div>
    </div>
</div>

<div class="modal fade" id="modal-hapus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel17" aria-hidden="true">
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
                <a href="" class="btn btn-danger">Hapus</a>
            </div>
        </div>
        </form>
    </div>
</div>

@endsection
@push('script')
<script>
     
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
            error: function (response) {
                Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: response.responseJSON.errors,
                        showConfirmButton: false,
                        timer: 1500
                })
            }
        })
    }

    $(document).ready(function() {
        // initDatatable();
        getJabatan();

        // $('#table-competencies-directory').on('click','.delete-button', function () {
        //     $('.modal-footer a').attr('href',"{{ route('Member.delete') }}/"+$(this).data('id'));
        // })

        $('.delete-button').on('click',function () {
            $('#modal-hapus').modal('show');
        })

        // $('.btn-tambah').on('click',function () {
        //     $('.modal-dialog form').attr('action',"{{ route('Member.post') }}");
        //     // $('input[name="_method"]').remove();
        //     $('.modal-dialog form')[0].reset();
        // })
    });
</script>
@endpush