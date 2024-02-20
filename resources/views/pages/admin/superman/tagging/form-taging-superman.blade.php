<div class="form-row">
  <div class="col-md-12 mb-2">
      <b>Due Date</b>
  </div>
  <input type="hidden" name="id_competency_superman" value="{{$id_competencies_superman}}">
  @if(isset($taging->id_taging_reason))
    <input type="hidden" name="id_taging_superman" value="{{$taging->id_taging_superman}}">
  @endif
  <div class="col-md-4 mb-3">
      <label for="year">Tahun</label>
      <input type="text" class="form-control form-control-sm year" name="tahun" placeholder="Tahun" id="year" value="{{$taging->year ?? ''}}" required >
      <div class="invalid-feedback" id="feed-back-year"></div>
  </div>
  <div class="col-md-4 mb-3">
      <label for="period">Periode</label>
      <input type="text" class="form-control form-control-sm" name="periode" placeholder="Masukan Periode" id="period" value="{{$taging->period ?? ''}}" required readonly style="background-color: unset">
      <div class="invalid-feedback" id="feed-back-period"></div>
    </div>
    <div class="col-md-4 mb-3">
        <label for="date_plan_implementation">Tanggal Implementasi</label>
        <input type="text" name="date_plan_implementation" class="form-control form-control-sm" id="date_plan_implementation" value="{{$taging->date_plan_implementation ?? ''}}" placeholder="dd-mm-yyyy" required>
        <div class="invalid-feedback" id="feed-back-date-plan-implementation"></div>
        <script>
            $("#date_plan_implementation").datepicker({
                language: "en",
                dateFormat: "dd-mm-yyyy",
                toggleSelected: true,
                position:'bottom left'
            });
        </script>
    </div>
    <div class="col-md-4 mb-3">
        <label for="learning_method">Learning Method</label>
        <select name="learning_method" id="learning_method" class="form-control form-control-sm" required>
            <option value="">Pilih Learning Method</option>
            <option {{(isset($taging) && $taging->learning_method == '0') ? 'selected' : ''}} value="0">Internal Training</option>
            <option {{(isset($taging) && $taging->learning_method == '1') ? 'selected' : ''}} value="1">External Training</option>
            <option {{(isset($taging) && $taging->learning_method == '2') ? 'selected' : ''}} value="2">In House Training</option>
            <option {{(isset($taging) && $taging->learning_method == '3') ? 'selected' : ''}} value="3">Learn From Expertise</option>
            <option {{(isset($taging) && $taging->learning_method == '4') ? 'selected' : ''}} value="4">Learn From Book</option>
            <option {{(isset($taging) && $taging->learning_method == '5') ? 'selected' : ''}} value="5">On the-Job Training</option>
            <option {{(isset($taging) && $taging->learning_method == '6') ? 'selected' : ''}} value="6">Sharing</option>
        </select>
        <div class="invalid-feedback" id="feed-back-learning-method"></div>
    </div>
    <div class="col-md-4 mb-3">
        <label for="trainer">Pelatih</label>
        <input type="text" name="trainer" class="form-control form-control-sm" placeholder="Masukan Pelatih" id="trainer" value="{{$taging->trainer ?? ''}}" required>
        <div class="invalid-feedback" id="feed-back-trainer"></div>
    </div>
    
</div>
<div class="form-row">
    <div class="col-md-12 mb-2">
        <b>Result</b>
    </div>
    <div class="col-md-4 mb-3">
        <label for="date_verified">Tanggal Verifikasi</label>
        <input type="text" class="form-control form-control-sm" name="date_verified" id="date_verified" value="{{$taging->date_verified ?? ''}}" placeholder="dd-mm-yyyy" required>
        <div class="invalid-feedback" id="feed-back-date-verified"></div>
        <script>
            $("#date_verified").datepicker({
                language: "en",
                dateFormat: "dd-mm-yyyy",
                toggleSelected: true,
                position:'bottom left'
            });
        </script>
    </div>
    <div class="col-md-4 mb-3">
        <label for="result_score">Nilai</label>
        <select class="form-control form-control-sm" name="result_score" id="result_score" required>
            <option value="">Pilih Score</option>
            @php
                $man = $competencies_superman->actual;
                $min = $man;
                $max = 4;
            @endphp
            @while ($min <= $max)
                <option {{(($taging->result_score ?? 0) == $min) ? 'selected' : ''}} value="{{$min}}">{{$min}}</option>
                @php
                    $min++;
                @endphp
            @endwhile
        </select>
        <div class="invalid-feedback" id="feed-back-result-score"></div>
    </div>
    <div class="col-md-4 mb-3">
        <label for="notes_for_result">Catatan Nilai</label>
        <textarea class="form-control form-control-sm" name="notes_for_result" id="notes_for_result" cols="10" rows="5">{!!$taging->notes_for_result ?? ''!!}</textarea>
        <div class="invalid-feedback" id="feed-back-notes-for-result"></div>
    </div>
</div>

<script>
    $(function() {
        $("#year").datepicker({
            language: "en",
            dateFormat: "yyyy",
            view: "years",
            minView: "years",
            toggleSelected: true,
            position:'bottom left'
        });
        $("#period").datepicker({
            language: "en",
            dateFormat: "MM",
            view: "months",
            minView: "months",
            changeYear:false,
            toggleSelected: false,
            position:'bottom left',
            showOn: "button",
            buttonImage: "images/calendar.gif",
            buttonImageOnly: true
        });
    })


    $(document).ready(function () {

        $('.start-time,.finish-time').change(function (el) {
            const start = $('.start-time')[0].value;
            const finish = $('.finish-time')[0].value;
            var diff = 0 ;
            if (start && finish) {
                smon = ConvertToSeconds(start);
                fmon = ConvertToSeconds(finish);
                diff = Math.abs( fmon - smon );
                $("#duration")[0].value = secondsTohhmmss(diff);
            }
        })

        function ConvertToSeconds(time) {
            var splitTime = time.split(":");
            return splitTime[0] * 3600 + splitTime[1] * 60;
        }
        function secondsTohhmmss(secs) {
            var hours = parseInt(secs / 3600);
            var seconds = parseInt(secs % 3600);
            var minutes = parseInt(seconds / 60) ;
            return hours + " Jam : " + minutes + " Menit ";
        }
    })

</script>