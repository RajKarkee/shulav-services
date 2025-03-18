<tr data-id="{{$cat->id}}" data-rate="{{$cat->rate}}" data-name="{{$cat->name}}" data-desc="{{$cat->desc}}" data-image="{{asset($cat->image)}}" id="service-{{$cat->id}}">
    <td >
        <img src="{{asset($cat->image)}}" style="max-width: 100px" alt="">
    </td>
    <td>
        {{$cat->name}}
    </td>
    <td>
        {{$cat->rate}}
    </td>
    <td style="width: 35%">
        {{$cat->desc}}
    </td>
    <td class="btn-table">
        <button class="btn btn-secondary btn-sm" onclick="showEdit(2,{{$cat->id}})">
            <i class="material-icons">edit</i>
        </button>
        <button class="btn btn-sm btn-danger text-danger" onclick="del(2,{{$cat->id}})">
            <i class="material-icons">delete</i>
        </button>
    </td>
</tr>
