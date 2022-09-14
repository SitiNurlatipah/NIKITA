<input type="hidden" name="id_curriculum" value="{{ $curriculum->id_curriculum }}">
{{-- <div class="form-group">
    <label for="noModule">No Competency</label>
    <input type="text" class="form-control" id="no_training_module" name="no_training_module"
        placeholder="004/KMI/HRD-RT/SAL/004" value="{{ $curriculum->no_training_module }}">
</div> --}}
<div class="row">
    <div class="col-6">
        <div class="form-group">
            <label for="skillCategory">Skill Category</label>
            <select id="id_skill_category2" class="form-control form-control-sm" name="id_skill_category">
                <option value="">Pilih Skill Category</option>
                @foreach ($skills as $skill)
                    <option {{ $skill->id_skill_category == $curriculum->id_skill_category ? 'selected' : '' }}
                        value="{{ $skill->id_skill_category }}">{{ $skill->skill_category }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <label for="training_module_group2">Competency Group</label>
            <select id="training_module_group2" class="form-control form-control-sm" name="training_module_group">
                <option value="#" disabled>-- Pilih Competencie Group --</option>
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label for="training_module">Competency</label>
            <input type="text" class="form-control" value="{{ $curriculum->training_module }}" id="training_module"
                name="training_module" placeholder="Masukan Competency Name">
        </div>
        <div class="form-group">
            <label for="noModule">Level</label>
            <select class="form-control form-control-sm" id="level" name="level">
                <option value="">Pilih Level</option>
                <option {{ $curriculum->level == 'B' ? 'selected' : '' }} value="B">B (Basic)</option>
                <option {{ $curriculum->level == 'I' ? 'selected' : '' }} value="I">I (Intermediate)</option>
                <option {{ $curriculum->level == 'A' ? 'selected' : '' }} value="A">A (Advance)</option>
            </select>
        </div>
        <div class="form-group">
            <label for="noModule">Competency Description</label>
            <textarea class="form-control" id="training_module_desc" name="training_module_desc"
                rows="3">{!! $curriculum->training_module_desc !!}</textarea>
        </div>
        <div class="form-group">
            <label for="noModule">Job Title</label>
            <select class="form-control selectpicker form-control-sm" id="id_job_titles" name="id_job_title[]"
                data-live-search="true" data-hide-disabled="true" multiple data-actions-box="true">
                <option value="">Pilih Job Title</option>
                @foreach ($jabatans as $jabatan)
                    <option {{ $jabatan->sts == 1 ? 'selected' : '' }} value="{{ $jabatan->id_job_title }}">
                        {{ $jabatan->nama_job_title }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>


<script>
    $(function() {
        var id_skill_category = '{{ $curriculum->id_skill_category }}';
        var name = '{{ $curriculum->training_module_group }}';
        $.ajax({
            url: '{{ route('competencie-groups.getBySkillCategory') }}',
            type: 'POST',
            dataType: 'JSON',
            data: {
                id: id_skill_category
            },
            success: function(response) {
                $('#training_module_group2').empty();
                response.forEach(el => {
                    if (el.name == name) {
                        console.log('sama')
                        $('#training_module_group2').append('<option selected value="' + el
                            .id + '">' + el.name + '</option>');
                    } else {
                        $('#training_module_group2').append('<option value="' + el.id +
                            '">' + el.name + '</option>');
                    }
                });
            }
        })
        $('#id_skill_category2').on('change', function() {
            var id_skill_category = $(this).val();
            $.ajax({
                url: '{{ route('competencie-groups.getBySkillCategory') }}',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    id: id_skill_category
                },
                success: function(response) {
                    $('#training_module_group2').empty();
                    var option = "";
                    for (let i = 0; i < response.length; i++) {
                        option += '<option value="' + response[i].id + '">' +
                            response[i].name + '</option>';
                    }
                    $('#training_module_group2').html();
                    $('#training_module_group2').append(option);
                }
            })
        })
    })
    $(document).ready(function() {
        fetchJobTitle();
    })

    function fetchJobTitle() {
        var option = '<option value="ui">Contoh</option>';
        $("#id_job_titles").selectpicker('refresh');
    }
</script>
