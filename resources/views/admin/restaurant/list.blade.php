@foreach ($rests as $r)
    <tr data-name="{{ $r->name }}" data-desc="{{ $r->desc }}" data-image="{{asset($r->logo)}}" id="restaurant-{{$r->id}}">
        <td><img src="/{{ $r->logo }}" alt="" style="height: 100px;"></td>
        <td>{{ $r->name }}</td>
        <td>{{ $r->desc }}</td>
        <td class="btn-table">
            <button class="btn btn-secondary btn-sm" onclick="showEdit({{$r->id}})">
                <i class="material-icons">edit</i>
            </button>
            <button class="btn btn-sm btn-danger text-danger" onclick="delData({{$r->id}})">
                <i class="material-icons">delete</i>
            </button>
        </td>
    </tr>
@endforeach
