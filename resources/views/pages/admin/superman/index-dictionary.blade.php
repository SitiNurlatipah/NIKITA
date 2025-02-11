@extends('layouts.master')

@section('title', 'Competency Dictionary Superman')

@push('style')
<style>

    .accordion {
        width: 100%;
    }

    .img-accordion {
        width: 70%;
    }

    .card-header {
        padding: 1.2rem !important;
        border-radius: 40px !important;
    }

    table.dataTable.table-sm > thead > tr > th:not(.sorting_disabled) {
    padding-right: 106px;
    }
</style>
@endpush
@section('content')
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
            <div class="row">
                    <p class="card-title ml-4">Competency Dictionary Superman</p>
                    <div class="col-md mb-2">
                        <button class="btn btn-sm btn-success float-right add-directory" data-toggle="modal" data-id="" onclick="formCompetencyDirectory(this)" data-target="#modal-tambah" data-placement="top" title="Tambah Data"><i class="icon-plus"></i> Add Competency Dictionary</button>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="display expandable-table table-striped table-hover table-sm" id="table-cd-superman" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No Competency</th>
                                        <th>Competency</th>
                                        <th>Skill Category</th>
                                        <th>Competency Group</th>
                                        <th class="text-center">Action</th>
                                    </tr> 
                                </thead>
                                <tbody></tbody>
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
              <h5 class="modal-title" id="modal-tambahLabel">Add Competencies Dictionary </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('storeDictionarySuperman') }}" id="formCompetencyDictionarySuperman" method="POST" enctype="multipart/form-data">
                @csrf
            <div class="modal-body pt-3" id="formCompetency"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="submitForm" class="btn btn-primary">Save changes</button>
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
        $(document).ready(function() {
            initDatatable();
            getUser();       
            $('.delete-button').on('click',function () {
                $('#modal-hapus').modal('show');
            });
            
            $("#submitForm").click(function (e) {
                e.preventDefault();
                var form = $("#formCompetencyDictionarySuperman")
                const url = form.attr("action");
                var formData = form.serialize();
                $.ajax({
                    url:url,
                    type:"post",
                    cache:false,
                    data:formData,
                    success:function (data) {
                        $("#modal-tambah").modal('hide');
                        $('#table-cd-superman').DataTable().destroy();
                        initDatatable();
                        Swal.fire({
                            position:'center',
                            icon:'success',
                            title:data.message,
                            showConfirmButton:false,
                            timer:1500
                        });
                    },
                    error:function (err) {
                        console.log(err);
                        Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: err.statusText,
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                })
            })
        });

        function getUser(){
            $.ajax({
                type: "GET",
                url: "{{ route('superman.get') }}",
                success: function(res) {
                    var option = "";
                    for (let i = 0; i < res.data.length; i++) {
                        option += '<option value="'+res.data[i].id+'">'+res.data[i].nama_pengguna+'</option>';
                    }
                    $('#user').html();
                    $('#user').append(option);
                },
                error: function (response) {
                    Swal.fire({
                            position: 'center',
                            icon: 'error',
                            title: response.responseJSON.errors,
                            showConfirmButton: false,
                            timer: 1500
                    })
                }
            })
        }

        function formCompetencyDirectory(el) {
            var id = $(el).attr("data-id");
            if(id == ''){
                var url = "{!!route('formDictionarySuperman')!!}?type=add";
                $("#modal-tambahLabel").html("Add Competencies Dictionary");
            }else{
                var url = "{!!route('formDictionarySuperman')!!}?type=edit&id="+id;
                $("#modal-tambahLabel").html("Update Competencies Dictionary");
            }
            $.ajax({
                url:url,
                cache:false,
                type:"get",
                success:function(html){
                    $("#formCompetency").html(html);
                    
                }
            })
        }

        

        function initDatatable() {
            var dtJson = $('#table-cd-superman').DataTable({
                ajax: "{{ route('jsonDictionarySuperman') }}",
                responsive:true,
                serverSide: true,
                processing: true,
                searching: true,
                scrollX: true,
                displayLength: 10,
                lengthMenu: [10, 15, 20,100],
                language: {
                    paginate: {
                        // remove previous & next text from pagination
                        previous: '&nbsp;',
                        next: '&nbsp;'
                    }
                },
                columns: [
                    {
                        data: 'no_training_module',
                    },
                    {
                        data: 'training_module'
                    },
                    {
                        data: 'skill_category'
                    },
                    {
                        data : 'compGroupName'
                    },
                    {
                        data: 'action'
                    }
                ]
            });
        }

        function confirmDelete(element) {
            swal({
            title: "Konfirmasi",
            text: "Apakah Anda yakin ingin menghapus baris ini?",
            icon: "warning",
            buttons: ["Batal", "Hapus"],
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                delRow(element);
            }
            });
        }
    </script>
@endpush