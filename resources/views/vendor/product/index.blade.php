@extends('front.page')
@section('css')
    <link rel="stylesheet" href="{{ asset('front/vendor/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('front/vendor/product.css') }}">

@endsection
@section('title', 'Vendor ' . ($type == 1 ? 'Products' : 'Services'))

@section('content')

    <div id="vendor-dashboard-page">
        <div>
            <div class="row">
                @include('vendor.dashboard.sidebar')
                <div class="col-md-8   ">
                    <div class="bg-white shadow mb-3">
                        <div class="card-body " id="jumbotron">
                            <a href="{{ route('vendor.dashboard') }}">Dashboard</a>
                            <span>{{ $type == 1 ? 'Products' : 'Services' }}</span>
                        </div>
                    </div>
                    <div class="bg-white shadow mb-3" id="products">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-7 order-1 order-md-0 ">
                                    <input type="search" placeholder="Search Your {{ $type == 1 ? 'Products' : 'Services' }}"
                                        id="search" class="form-control">
                                </div>
                                <div class="col-md-5 order-0 order-md-1 mb-3 mb-md-0 text-end">
                                    <a href="{{ route('vendor.product.add', ['type' => $type]) }}" class="btn btn-primary">Add
                                        {{ $type == 1 ? 'Product' : 'Service' }}</a>
                                </div>
                            </div>
                            @if ($products->count() > 0)

                                @foreach ($products as $product)
                                    <div class="product">
                                        <div class="row m-0">
                                            <div class="col-md-3 p-0">

                                                <div class="image">
                                                    <img src="{{ asset($product->image) }}" alt="">
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="single-desc">
                                                    <div class="title">
                                                        {{ $product->name }}
                                                    </div>
                                                    <div>
                                                        <span class="me-1">Listing From</span> 
                                                        <strong>
                                                            {{$product->start}}
                                                        </strong>
                                                         <span class="mx-1">to</span>
                                                        <strong>
                                                            {{$product->end}}
                                                        </strong>
                                                    </div>
                                                    {{-- <div class="short-desc">
                                                       
                                                    </div> --}}
                                                    <hr class="m-0 mb-2">
                                                    @if(isset($product->paid))
                                                        
                                                        @if ($product->paid == 0 )
                                                            <div class="text-warning">
                                                                Please Pay Bill To Enable the listing.
                                                                <a href="{{ route('vendor.bill', ['bill' => $product->bill_id ?? 0]) }}"
                                                                    target="blac" class="text-success d-inline-block">View
                                                                    Bill</a> 
                                                                <hr>
                                                                <a  class="btn-sm btn btn-blue" href="{{ route('vendor.product.edit', ['product' => $product->id]) }}">Edit Product</a>
                                                                   
                                                                

                                                            </div>
                                                        @else
                                                            <div class="links">
                                                                <a class="btn-sm btn btn-blue"
                                                                    href="{{ route('vendor.product.edit', ['product' => $product->id]) }}">Edit</a>
                                                                <a class="btn-sm btn btn-blue"
                                                                    href="{{ route('vendor.product.gallery', ['product' => $product->id]) }}">Gallery</a>
                                                                <a class="btn-sm btn btn-red"
                                                                    href="{{ route('vendor.product.del', ['product' => $product->id]) }}"
                                                                    onclick="return confirm('Do you want to delete product');"
                                                                    href="">Delete</a>
                                                            </div>
                                                        @endif
                                                    @else
                                                    <div class="links">
                                                        <a class="btn-sm btn btn-blue"
                                                            href="{{ route('vendor.product.edit', ['product' => $product->id]) }}">Edit</a>
                                                            <a class="btn-sm btn btn-blue"
                                                            href="{{ route('vendor.product.gallery', ['product' => $product->id]) }}">Gallery</a>
                                                            <a class="btn-sm btn btn-red"
                                                            href="{{ route('vendor.product.del', ['product' => $product->id]) }}"
                                                            onclick="return confirm('Do you want to delete product');"
                                                            href="">Delete</a>
                                                    </div>
                                                    @endif
                                                    {{-- @if ($product->active == 0)
                                                    <a class="btn btn-sm btn-success" href="{{route('vendor.product.status',['product'=>$product->id,'status'=>1])}}">Activate</a>
                                                    @else
                                                    <a class="btn btn-sm btn-red" href="{{route('vendor.product.status',['product'=>$product->id,'status'=>0])}}">Deactivate</a>
                                                    @endif --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>



    </div>
    </div>
    </div>
    </div>

@endsection
@section('js')
    @include('vendor.dashboard.imagejs')
    @include('vendor.dashboard.namejs')
    @include('vendor.dashboard.descjs')

@endsection
