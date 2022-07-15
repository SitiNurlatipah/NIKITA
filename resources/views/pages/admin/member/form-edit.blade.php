<style>
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

<input type="hidden" name="id" value="{{$user->id}}">
<input type="hidden" id="base64Edit" name="base64">
<div class="form-row">
    <div class="col-md-4">
        <div class="image_area" style="height: 250px;width:250px">
            <label for="upload_image-edit" class="relative">
                @php
                    $url = "../storage/app/public/".$user->gambar;
                    if ((isset($user->gambar) && $user->gambar != "") && file_exists($url)) {
                        $url = "data:image/jpeg;base64,".base64_encode(file_get_contents($url));
                    }else{
                        $url = asset('assets/images/faces/face0.png');
                    }
                @endphp
                <img src="{{$url}}" id="uploaded_image_edit" class="rounded-circle img-thumbnail" />
                <div class="overlay">
                    <div class="text" style="font-size: 15px">Click to Change Profile Image</div>
                </div>
                <input type="file" name="image" class="image" id="upload_image-edit" style="display:none" />
            </label>
        </div>
    </div>
    <div class="col-md-8 row">
        <div class="col-md-6 mb-3">
            <label>NIK</label>
            <input type="text" id="nik-edit" class="form-control form-control-sm" name="nik" placeholder="Ex:10119912" value="{{$user->nik}}">
            <div class="invalid-feedback" id="feed-back-nik-edit"></div>
        </div>
        <div class="col-md-6 mb-3">
            <label>Role</label>
            <select class="form-control form-control-sm" id="peran-pengguna-edit" name="peran_pengguna">
                <option value="1" {{($user->peran_pengguna == '1') ? 'selected' : ''}} >Admin</option>
                <option value="2" {{($user->peran_pengguna == '2') ? 'selected' : ''}} >CG Leader</option>
                <option value="3" {{($user->peran_pengguna == '3') ? 'selected' : ''}} >Pengguna</option>
            </select>
            <div class="invalid-feedback" id="feed-back-peran-pengguna-edit"></div>
        </div>
        <div class="col-md-6 mb-3">
            <label>Join Date</label>
            <input type="date" id="entry-edit" name="tgl_masuk" class="form-control form-control-sm" value="{{$user->tgl_masuk}}">
            <div class="invalid-feedback" id="feed-back-entry-edit"></div>
        </div>
    </div>
</div>
<div class="form-row">
    <div class="col-md-6 mb-3">
        <label>Employee Name</label>
        <input type="text" id="nama-pengguna-edit" class="form-control form-control-sm" name="nama_pengguna" placeholder="Nama Karyawan" value="{{$user->nama_pengguna}}">
        <div class="invalid-feedback" id="feed-back-nama-pengguna-edit"></div>
    </div>
    <div class="col-md-6 mb-3">
        <label>Email</label>
        <input type="text" id="email-edit" name="email" class="form-control form-control-sm" placeholder="nama@gmail.com" value="{{$user->email}}">
        <div class="invalid-feedback" id="feed-back-email-edit"></div>
    </div>
</div>
<div class="form-row">
    <div class="col-md-4 mb-3">
        <label>Divisi</label>
        <select id="divisi-edit" class="form-control form-control-sm" name="divisi">
            <option value=""> Divisi</option>
            @foreach ($divisi as $item)
                <option {{($user->id_divisi == $item->id_divisi) ? 'selected' : ''}} value="{{$item->id_divisi}}">{{$item->nama_divisi}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback" id="feed-back-divisi-edit"></div>
    </div>
    <div class="col-md-4 mb-3">
        <label>Job Title</label>
        <select id="jabatan-edit" class="form-control form-control-sm" name="job_title">
            <option value="">Job Title</option>
            @foreach ($jabatans as $item)
                <option {{($user->id_job_title == $item->id_job_title) ? 'selected' : ''}} value="{{$item->id_job_title}}">{{$item->nama_job_title}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback" id="feed-back-jabatan-edit"></div>
    </div>
    <div class="col-md-4 mb-3">
        <label>Level</label>
        <select id="level-edit" class="form-control form-control-sm" name="level">
            <option value="">Level</option>
            @foreach ($levels as $item)
                <option value="{{$item->id_level}}" {{($user->id_level == $item->id_level) ? 'selected' : ''}}>{{$item->nama_level}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback" id="feed-back-level-edit"></div>
    </div>
</div>
<div class="form-row">
    <div class="col-md-4 mb-3">
        <label>Department</label>
        <select id="department-edit" class="form-control form-control-sm" name="department">
            <option value="">Department</option>
            @foreach ($departments as $item)
                <option value="{{$item->id_department}}" {{($user->id_department == $item->id_department) ? 'selected' : ''}} >{{$item->nama_department}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback" id="feed-back-department-edit"></div>
    </div>
    <div class="col-md-4 mb-3">
        <label>Sub Department</label>
        <select id="sub-department-edit" class="form-control form-control-sm" name="sub_department">
            <option value="">Pilih Sub Dept</option>
            @foreach ($subDepartments as $item)
                <option value="{{$item->id_subdepartment}}" {{($user->id_sub_department == $item->id_subdepartment) ? 'selected' : ''}} >{{$item->nama_subdepartment}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback" id="feed-back-sub-department-edit"></div>
    </div>
    <div class="col-md-4 mb-3">
        <label>Liga CG</label>
        <select id="cg-edit" class="form-control form-control-sm" name="cg">
            <option value="">Pilih CG Name</option>
            @foreach ($cgMaster as $item)
                <option value="{{$item->id_cg}}" {{($user->id_cg == $item->id_cg) ? 'selected' : ''}} >{{$item->nama_cg}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback" id="feed-back-cg-edit"></div>
    </div>
</div>
<div class="modal fade" id="modal-edit-crop" tabindex="7" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
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
                            <img src="" id="sample_image-edit" style="height: 300px" />
                        </div>
                        <div class="col-md-6">
                            <div class="preview"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="crop-edit" class="btn btn-primary">Crop</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script>
    $("#department-edit").change(function () {
        var value = $(this).val();
        $('#sub-department-edit').html();
        if(value){
            $.ajax({
            type: "GET",
            url: "{{ route('get.sub.department') }}?id_department="+value,
            success: function(res) {
                var option = "";
                for (let i = 0; i < res.data.length; i++) {
                    option += '<option value="'+res.data[i].id_sub_department+'">'+res.data[i].nama_subdepartment+'</option>';
                }
                $('#sub-department-edit').html(option);
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr);
                alert(xhr.status);
                alert(thrownError);
            }
        })
        }
    });

    $(document).ready(function() {
        var $modal = $('#modal-edit-crop');
        var $modalEdit = $('#modal-edit');
        var image = document.getElementById('sample_image-edit');
        var cropper;

        $('#upload_image-edit').change(function(event){
		    var files = event.target.files;
            var done = function(url){
                image.src = url;
                $('#modal-edit-crop').modal('show')
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

        $('#crop-edit').click(function(){
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
                    $('#uploaded_image_edit').attr('src', base64data);
                    $('#base64Edit').attr('value', base64data);
                    $('#modal-edit-crop').modal('hide');
                };
            });
        });
    })
</script>