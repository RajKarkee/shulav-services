@extends('admin.layout.app')

@section('page-option')
@endsection
@section('s-title')
    <li class="breadcrumb-item"><a href="{{route('admin.vendor.index')}}">Vendors</a></li>
    <li class="breadcrumb-item"><a href="{{route('admin.vendor.detail',['vendor'=>$vendor->id])}}">{{$vendor->name}}</a></li>
    <li class="breadcrumb-item">{{$product->type==1?'Products':'Services'}}</li>
    <li class="breadcrumb-item">{{$product->name}}</li>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-4">
            <img src="{{asset($product->image)}}" class="w-100" alt="">
        </div>
        <div class="col-md-8">
            <div class="bg-white shadow mb-3">
                <div class="card-body">
                    <h4>{{$product->name}}</h4>
                    <h6>Rs. {{$product->price}}</h6>
                </div>
            </div>
            <div class="bg-white shadow mb-3">
                <div class="card-body">
                    {!!$product->desc!!}
                </div>
            </div>
            <div class="bg-white shadow">
                <div class="card-body">
                    @if ($product->active==1)
                    <a href="{{route('admin.vendor.pstatus',['product'=>$product->id,'status'=>0])}}" class="text-danger">Deactivate</span>
                    @else
                    <a class="text-success" href="{{route('admin.vendor.pstatus',['product'=>$product->id,'status'=>1])}}">Activate</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

