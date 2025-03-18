{{-- <div class="col-md-3 mb-2" id="service-{{$service->id}}">
    <div class="card">
        <img src="{{asset($service->image)}}" alt="Service Image">
        <div class="card-body">
            <h6 class="card-title">{{$service->name}}</h6>
            <div class="d-flex justify-content-between">
                <button class="btn btn-sm">
                    <i class="material-icons">edit</i>
                </button>
                <button class="btn btn-sm text-danger">
                    <i class="material-icons">delete</i>
                </button>

            </div>
        </div>
    </div>
</div> --}}
<div class="col-md-6 mb-3 service service-{{$service->category_id}}" data-id="{{$service->id}}" data-name="{{$service->name}}" data-rate="{{$service->rate}}" data-desc="{{$service->desc}}" data-image="{{asset($service->image)}}" id="service-{{$service->id}}">
    <div class="card shadow " style="overflow: hidden">
            <div class="row ">
                <div class="col-md-2 d-flex align-items-center">
                    <img style="line-height: 0;" class="d-block w-100" src="{{asset($service->image)}}" alt="Service Image">
                </div>
                <div  class=" col-md-6 d-flex align-items-center">{{$service->name}}</div>
                <div class="col-md-3 d-flex justify-content-end">
                    <button class="btn btn-sm" onclick="showEdit(2,{{$service->id}})">
                        <i class="material-icons">edit</i>
                    </button>
                    <button class="btn btn-sm text-danger" onclick="del(2,{{$service->id}})">
                        <i class="material-icons">delete</i>
                    </button>

                </div>
            </div>
    </div>
</div>
