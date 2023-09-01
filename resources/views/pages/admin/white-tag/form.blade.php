@forelse ($comps as $key => $comp)
<tr>
    <td>{{$key+1}}</td>
    <td>{{$comp->no_training}}</td>
    <td>{{$comp->skill_category}}</td>
    <td>{{$comp->training_module}}</td>
    <td>{{$comp->level}}</td>
    <td>{{$comp->compGroupName}}</td>
    <td>
        
            <input type="hidden" name="data[{{$key.time()}}][id]" value="{{$comp->id_directory}}">
            <select class="form-control" name="data[{{$key.time()}}][start]" id="selectStart{{$key.time()}}">
                <option value=""  {{($comp->start == null || $comp->tagingStatus == 'Belum diatur') ? 'selected' : ''}}>Pilih Level</option>
                <option value="0" {{$comp->start  == '0' ? 'selected' : ''}}>0</option>
                <option value="1" {{$comp->start  == '1' ? 'selected' : ''}}>1</option>
                <option value="2" {{$comp->start  == '2' ? 'selected' : ''}}>2</option>
                <option value="3" {{$comp->start  == '3' ? 'selected' : ''}}>3</option>
                <option value="4" {{$comp->start  == '4' ? 'selected' : ''}}>4</option>
            </select>
        </td>
        <td>
            
                <select class="form-control" name="data[{{$key.time()}}][actual]" id="selectActual{{$key.time()}}">
                    <option value=""  {{($comp->start == null || $comp->tagingStatus == 'Belum diatur') ? 'selected' : ''}}>Pilih Level</option>
                    <option value="0" {{$comp->actual  == '0' ? 'selected' : ''}}>0</option>
                    <option value="1" {{$comp->actual  == '1' ? 'selected' : ''}}>1</option>
                    <option value="2" {{$comp->actual  == '2' ? 'selected' : ''}}>2</option>
                    <option value="3" {{$comp->actual  == '3' ? 'selected' : ''}}>3</option>
                    <option value="4" {{$comp->actual  == '4' ? 'selected' : ''}}>4</option>
                </select>
        </td>
        <td>
            <input class="form-control pr-0" style="width: 50px;" type="text" value="{{$comp->target}}" disabled>
        </td>
        <td>
            <input class="form-control" name="data[{{$key.time()}}][ket]" type="text" value="{{$comp->ket}}" placeholder="keterangan">
        </td>
        <!-- <td>
            @if($comp->cntTagingReason > 0)
            <input type="text"  class="form-control p-1" value="{{$comp->catatan}}" disabled>
            @else
                @if($comp->catatan == "")
                <textarea class="form-control p-1" rows="3" name="data[{{$key.time()}}][catatan]" placeholder="Keterangan"></textarea>
                @else
                <textarea class="form-control p-1" rows="3" disabled>{{$comp->catatan}}</textarea>
                @endif
            @endif
        </td> -->
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
    <!-- <tr>
        <td colspan="9" class="text-center">
            Data Kompetensi untuk job title terkait tidak tersedia
        </td>
    </tr> -->
@endforelse
