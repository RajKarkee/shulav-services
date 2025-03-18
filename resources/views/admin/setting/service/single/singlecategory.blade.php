<div class="card shadow mb-2 cat" data-id="{{$cat->id}}" data-name="{{$cat->name}}" data-desc="{{$cat->desc}}" data-image="{{asset($cat->image)}}" id="cat-{{$cat->id}}">
    <div class="card-body">
        <h5 class="card-title  d-flex justify-content-between align-items-center">
            <div title="{{$cat->desc}}" >

                {{$cat->name}}
                <button class="btn btn-sm" onclick="showEdit(1,{{$cat->id}})">
                    <i class="material-icons">edit</i>
                </button>
                <button class="btn btn-sm text-danger" onclick="del(1,{{$cat->id}})">
                    <i class="material-icons">delete</i>
                </button>
            </div>
            <div>
                <button class="btn btn-secondary bt " onclick="showAdd(2,{{$cat->id}})">Add Service</button>
            </div>
        </h5>
        {{-- <hr>
        <div class="services">
            <div class="row"  id="services-{{$cat->id}}">
                @foreach ($cat->services as $service)
                    @include('admin.setting.service.singleservice',['service'=>$service])
                @endforeach
            </div>
        </div> --}}
    </div>
</div>
