<input type="hidden" name="id_curriculum_champion" value="{{ $curriculum->id_curriculum_champion }}">
<div class="row">
    <div class="col-4">
        <div class="form-group">
            <label for="skillCategory">Group Champion</label>
            <select id="id_skill_categorys" class="form-control form-control-sm" name="id_group_champion">
                <option value="">-Pilih Skill Category </option>
                @foreach ($skills as $skill)
                <option {{ $skill->id_group_champion == $curriculum->id_group_champion ? 'selected' : '' }}
                    value="{{ $skill->id_group_champion }}">{{ $skill->nama_group_champion }}</option>
                @endforeach
            </select>
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
    </div>
    <div class="col-4">
        <div class="form-group">
            <label for="curriculum_groups">Sub Group Champion</label>
            <select id="curriculum_groups" class="form-control form-control-sm"
                name="id_sub_group_champion">
                <option value="#">Pilih Sub Group</option>
            </select>
        </div>
        <div class="form-group">
            <label for="noModule">Target</label>
            <select class="form-control form-control-sm" name="target" required>
            <option value="">Pilih Target</option>
            <option {{ $curriculum->target == '0' ? 'selected' : '' }} value="0">0</option>
            <option {{ $curriculum->target == '1' ? 'selected' : '' }} value="1">1</option>
            <option {{ $curriculum->target == '2' ? 'selected' : '' }} value="2">2</option>
            <option {{ $curriculum->target == '3' ? 'selected' : '' }} value="3">3</option>
            <option {{ $curriculum->target == '4' ? 'selected' : '' }} value="4">4</option>
            <option {{ $curriculum->target == '5' ? 'selected' : '' }} value="5">5</option>
        </select>
        </div>
    </div>
    <div class="col-4">
        <div class="form-group">
        <label for="id_users">Champion Member <small>(Bisa pilih lebih dari 1)</small></label>
            <select id="id_users" class="selectpicker form-control form-control-sm"
                name="id_user[]" data-live-search="true" data-hide-disabled="true" multiple
                data-actions-box="true">
                @foreach ($users as $user)
                    <option {{ $user->sts == 1 ? 'selected' : '' }} value="{{ $user->id }}">
                        {{ $user->nama_pengguna }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="curriculum_champion">Trainer</label>
            <input type="text" class="form-control" id="trainer" name="trainer"
                placeholder="Masukan Plot Trainer" value="{{ $curriculum->trainer }}">
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
    <div class="form-group">
            <label for="curriculum_champion">Competency Champion</label>
            <input type="text" class="form-control" id="curriculum_champion" name="curriculum_champion"
                placeholder="Masukan Competency Name" value="{{ $curriculum->curriculum_champion }}">
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
        var id_group_champion = '{{ $curriculum->id_group_champion }}';
        var group = '{{ $curriculum->id_sub_group_champion }}';
        $.ajax({
            url: "{{ route('champion.group.sub') }}",
            type: 'GET',
            dataType: 'JSON',
            data: {
                id: id_group_champion
            },
            success: function(response) {
                $('#curriculum_groups').empty();
                response.forEach(el => {
                    if (el.group == group) {
                        $('#curriculum_groups').append('<option selected value="' + el.id_sub_group_champion + '">' + el.name + '</option>');
                    } else {
                        $('#curriculum_groups').append('<option value="' + el.id_sub_group_champion + '">' + el.name + '</option>');
                    }
                });
            }
        })
        $('#id_skill_categorys').on('change', function() {
            var id_group_champion = $(this).val();
            $.ajax({
                url: "{{ route('champion.group.sub') }}",
                type: 'GET',
                dataType: 'JSON',
                data: {
                    id: id_group_champion
                },
                success: function(response) {
                    $('#curriculum_groups').empty();
                    var option = "";
                    for (let i = 0; i < response.length; i++) {
                        option += '<option value="' + response[i].id_sub_group_champion + '">' +
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