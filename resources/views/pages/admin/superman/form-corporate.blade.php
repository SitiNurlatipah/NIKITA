@forelse ($comps as $key => $comp)
<tr>
    <td>{{$key+1}}</td>
    <td>{{$comp->no_curriculum}}</td>
    <td>{{$comp->skill_category}}</td>
    <td>{{$comp->curriculum_superman}}</td>
    <td>{{$comp->compGroupName}}</td>
    <td>
        <input class="form-control pr-0" style="width: 50px;" type="text" value="{{$comp->before}}" disabled>
    </td>
    <input type="hidden" class="form-control" value="{{$comp->before}}" name="data[{{$key.time()}}][start]">
    <input type="hidden" name="data[{{$key.time()}}][id]" value="{{$comp->id_dictionary_superman}}">
    
        <td>
            @if($comp->cntTagingReason > 0)
                <input type="text" class="form-control" value="{{$comp->actual}}" disabled>
            @else
                <select class="form-control" name="data[{{$key.time()}}][actual]" id="selectActual{{$key.time()}}">
                    <option value=""  {{($comp->start == null || $comp->tagingStatus == 'Belum diatur') ? 'selected' : ''}}>Pilih Level</option>
                    <option value="0" {{$comp->actual  == '0' ? 'selected' : ''}}>0</option>
                    <option value="1" {{$comp->actual  == '1' ? 'selected' : ''}}>1</option>
                    <option value="2" {{$comp->actual  == '2' ? 'selected' : ''}}>2</option>
                    <option value="3" {{$comp->actual  == '3' ? 'selected' : ''}}>3</option>
                    <option value="4" {{$comp->actual  == '4' ? 'selected' : ''}}>4</option>
                    <option value="5" {{$comp->actual  == '5' ? 'selected' : ''}}>5</option>
                </select>
            @endif
        </td>
        <td>
            <input class="form-control pr-0" style="width: 50px;" type="text" value="{{$comp->target}}" disabled>
        </td>
        <td>
            <input class="form-control" name="data[{{$key.time()}}][ket]" type="text" value="{{$comp->ket}}" placeholder="keterangan">
        </td>
        <td>
            @if ($comp->tagingStatus == 'Close')
                <span class="badge badge-success">{{$comp->tagingStatus}}</span>
            @elseif($comp->tagingStatus == 'Open')
            <span class="badge badge-danger text-white">{{$comp->tagingStatus}}</span>
            @else
                <span class="badge badge-secondary text-white">{{$comp->tagingStatus}}</span>
            @endif
        </td>
</tr>
@empty
@endforelse