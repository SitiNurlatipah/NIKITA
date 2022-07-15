<td>
  <select class='selectpicker selectNew form-control form-control-sm' name='datas[{{$time}}][id_job_title]' data-live-search="true" data-hide-disabled="true"
  data-actions-box="true">
      <option value=''>Pilih Job Title</option>
      @foreach($jobTitles as $job)
        <option value="{{$job->id_job_title}}">{{$job->nama_job_title}}</option>
      @endforeach
  </select>
  </td>
  <td>
      <input type="hidden" name="datas[{{$time}}][data][0][between]" value="0">
      <select class='form-control form-control-sm' name='datas[{{$time}}][data][0][target]'>
          <option value=''>Pilih Target</option>
          <option value='0'>0</option>
          <option value='1'>1</option>
          <option value='2'>2</option>
          <option value='3'>3</option>
          <option value='4'>4</option>
          <option value='5'>5</option>
      </select>
  </td>
  <td>
      <input type="hidden" name="datas[{{$time}}][data][1][between]" value="1">
      <select class='form-control form-control-sm' name='datas[{{$time}}][data][1][target]'>
          <option value=''>Pilih Target</option>
          <option value='0'>0</option>
          <option value='1'>1</option>
          <option value='2'>2</option>
          <option value='3'>3</option>
          <option value='4'>4</option>
          <option value='5'>5</option>
      </select>
  </td>
  <td>
      <input type="hidden" name="datas[{{$time}}][data][2][between]" value="2">
      <select class='form-control form-control-sm' name='datas[{{$time}}][data][2][target]'>
          <option value=''>Pilih Target</option>
          <option value='0'>0</option>
          <option value='1'>1</option>
          <option value='2'>2</option>
          <option value='3'>3</option>
          <option value='4'>4</option>
          <option value='5'>5</option>
      </select>
  </td>
  <td>
      <input type="hidden" name="datas[{{$time}}][data][3][between]" value="3">
      <select class='form-control form-control-sm' name='datas[{{$time}}][data][3][target]'>
          <option value=''>Pilih Target</option>
          <option value='0'>0</option>
          <option value='1'>1</option>
          <option value='2'>2</option>
          <option value='3'>3</option>
          <option value='4'>4</option>
          <option value='5'>5</option>
      </select>
  </td>
  <td>
      <input type="hidden" name="datas[{{$time}}][data][4][between]" value="4">
      <select class='form-control form-control-sm' name='datas[{{$time}}][data][4][target]'>
          <option value=''>Pilih Target</option>
          <option value='0'>0</option>
          <option value='1'>1</option>
          <option value='2'>2</option>
          <option value='3'>3</option>
          <option value='4'>4</option>
          <option value='5'>5</option>
      </select>
  </td>
  <td>
      <input type="hidden" name="datas[{{$time}}][data][5][between]" value="5">
      <select class='form-control form-control-sm' name='datas[{{$time}}][data][5][target]'>
          <option value=''>Pilih Target</option>
          <option value='0'>0</option>
          <option value='1'>1</option>
          <option value='2'>2</option>
          <option value='3'>3</option>
          <option value='4'>4</option>
          <option value='5'>5</option>
      </select>
  </td>
  <td style='text-align:center'>
      <button class='btn btn-inverse-danger btn-icon mr-1' onclick="delRow(this)">
        <i class='icon-trash'></i>
      </button>
  </td