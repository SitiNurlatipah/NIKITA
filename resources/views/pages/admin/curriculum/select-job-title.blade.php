@push('style')
  <link rel="stylesheet" href="{{asset ('assets/select/css/bootstrap-select.css')}}">
@endpush
<label for="noModule">Job Title CG</label>
<select id="id_job_title" class="selectpicker form-control form-control-sm" name="id_job_title[]" multiple>
  @foreach($datas as $data)
    <option value="">asa</option>
  @endforeach
</select>
@push('script')
  <script src="{{ asset ('assets/select/js/bootstrap-select.js')}}"></script>
@endpush
