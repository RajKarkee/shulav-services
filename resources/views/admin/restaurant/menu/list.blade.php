@foreach ($menus as $m)
    <tr data-name="{{ $m->name }}" data-restro="{{ $m->restaurant_id }}" data-rate="{{ $m->rate }}" data-deliver="{{ $m->timetodeliver }}" data-desc="{{ $m->desc }}" data-image="{{asset($m->logo)}}" id="menu-{{$m->id}}">
        <td><img src="/{{ $m->logo }}" alt="" style="height: 100px;"></td>
        <td>{{ $m->name }}</td>
        <td>{{ $m->rate }}</td>
        <td>{{ $m->timetodeliver }}</td>
        <td>{{$m->restaurant->name}}</td>
        <td class="btn-table">
            <button class="btn btn-secondary btn-sm" onclick="showEdit({{$m->id}})">
                <i class="material-icons">edit</i>
            </button>
            <button class="btn btn-sm btn-danger text-danger" onclick="delData({{$m->id}})">
                <i class="material-icons">delete</i>
            </button>
        </td>
    </tr>
@endforeach
