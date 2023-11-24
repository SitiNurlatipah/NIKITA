<td>
  <select class='selectpicker selectNew form-control form-control-sm' name='datas[{{$time}}][id_user]' data-live-search="true" data-hide-disabled="true"
  data-actions-box="true">
      <option value=''>Pilih Member</option>
      @foreach($users as $user)
        <option value="{{$user->id_user}}">{{$user->nama_pengguna}}</option>
      @endforeach
  </select>
  </td>
  <td>
      <select class='form-control form-control-sm' name='datas[{{$time}}][data][0][target]'>
          <option value=''>Pilih Target</option>
          <option value='0'>0</option>
          <option value='1'>1</option>
          <option value='2'>2</option>
          <option value='3'>3</option>
          <option value='4'>4</option>
          
      </select>
  </td>
  
  @if(Auth::user()->peran_pengguna == 1)
  <td style='text-align:center'>
      <button class='btn btn-inverse-danger btn-icon mr-1' onclick="delRow(this)">
        <i class='icon-trash'></i>
      </button>
  </td>
  @endif

