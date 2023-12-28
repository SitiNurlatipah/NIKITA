<input type="hidden" name="id_curriculum_superman" value="{{ $curriculum->id_curriculum_superman }}">
<div class="row">
    <div class="col-4">
        <div class="form-group">
            <label for="skillCategory">Skill Category</label>
            <select id="id_skill_categorys" class="form-control form-control-sm" name="id_skill_category">
                <option value="">-Pilih Skill Category </option>
                @foreach ($skills as $skill)
                <option {{ $skill->id_skill_category == $curriculum->id_skill_category ? 'selected' : '' }}
                    value="{{ $skill->id_skill_category }}">{{ $skill->skill_category }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="curriculum_superman">Competency Superman</label>
            <input type="text" class="form-control" id="curriculum_superman" name="curriculum_superman"
                placeholder="Masukan Competency Name" value="{{ $curriculum->curriculum_superman }}">
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
            <label for="curriculum_groups">Competency Group</label>
            <select id="curriculum_groups" class="form-control form-control-sm"
                name="curriculum_group">
                <option value="#">Pilih Competencie Group</option>
            </select>
        </div>
        {{--<div class="form-group">
            <label for="noModule">Target</label>
            <select class="form-control form-control-sm" name="target" required>
            <option value="">Pilih Target</option>
            <option {{ $curriculum->target == '0' ? 'selected' : '' }} value="0">0</option>
            <option {{ $curriculum->target == '1' ? 'selected' : '' }} value="1">1</option>
            <option {{ $curriculum->target == '2' ? 'selected' : '' }} value="2">2</option>
            <option {{ $curriculum->target == '3' ? 'selected' : '' }} value="3">3</option>
            <option {{ $curriculum->target == '4' ? 'selected' : '' }} value="4">4</option>
        </select>
        </div>--}}
    </div>
    <div class="col-4">
        <div class="form-group">
        <label for="id_users">Superman Member <small>(Bisa pilih lebih dari 1)</small></label>
            <select id="id_users" class="selectpicker form-control form-control-sm"
                name="id_user[]" data-live-search="true" data-hide-disabled="true" multiple
                data-actions-box="true">
                @foreach ($users as $user)
                    <option {{ $user->sts == 1 ? 'selected' : '' }} value="{{ $user->id }}">
                        {{ $user->nama_pengguna }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
    <div class="form-group">
            <label for="noModule">Competency Description</label>
            <textarea class="form-control" id="curriculum_desc" name="curriculum_desc" rows="3">{!! $curriculum->curriculum_desc !!}</textarea>
        </div>
    </div>
</div>

<script>
    $(function() {
        var id_skill_category = '{{ $curriculum->id_skill_category }}';
        var group = '{{ $curriculum->curriculum_group }}';
        $.ajax({
            url: "{{ route('competencie-groups.getBySkillCategory') }}",
            type: 'POST',
            dataType: 'JSON',
            data: {
                id: id_skill_category
            },
            success: function(response) {
                $('#curriculum_groups').empty();
                response.forEach(el => {
                    if (el.group == group) {
                        $('#curriculum_groups').append('<option selected value="' + el.id + '">' + el.name + '</option>');
                    } else {
                        $('#curriculum_groups').append('<option value="' + el.id + '">' + el.name + '</option>');
                    }
                });
            }
        })
        $('#id_skill_categorys').on('change', function() {
            var id_skill_category = $(this).val();
            $.ajax({
                url: "{{ route('competencie-groups.getBySkillCategory') }}",
                type: 'POST',
                dataType: 'JSON',
                data: {
                    id: id_skill_category
                },
                success: function(response) {
                    $('#curriculum_groups').empty();
                    var option = "";
                    for (let i = 0; i < response.length; i++) {
                        option += '<option value="' + response[i].id + '">' +
                            response[i].name + '</option>';
                    }
                    $('#curriculum_groups').html();
                    $('#curriculum_groups').append(option);
                }
            })
        })
    })
    $(document).ready(function() {
        fetchJobTitle();
    })

    function fetchJobTitle() {
        $("#id_users").selectpicker('refresh');
    }
</script>