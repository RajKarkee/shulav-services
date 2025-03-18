@foreach ($data as $r)
    <tr data-name="{{ $r->name }}" data-rate="{{ $r->rate}}" data-city="{{ $r->city_id }}" data-location="{{ $r->location_id }}" data-contact="{{ $r->contacts }}" data-desc="{{ $r->desc }}" data-image="{{asset($r->logo)}}" id="restaurant-{{$r->id}}">
        <td><img src="/{{ $r->image }}" alt="" style="height: 100px;"></td>
        <td>{{ $r->name }}</td>
        <td>{{ $r->contacts }}</td>
        <td>{{ $r->rate }}</td>
        <td class="btn-table">
            <button class="btn btn-secondary btn-sm" onclick="showEdit({{$r->id}})">
                <i class="material-icons">edit</i>
            </button>
            <button class="btn btn-sm btn-danger text-danger" onclick="delData({{$r->id}})">
                <i class="material-icons">delete</i>
            </button>
            <a href="{{ route('admin.realstates.detail',$r->id) }}" class="btn mt-1 btn-success btn-sm">
                <i class="material-icons">list</i>
            </a>
        </td>
    </tr>
@endforeach
