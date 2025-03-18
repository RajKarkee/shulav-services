@extends('front.page')
@section('css')
    <link rel="stylesheet" href="{{ asset('front/vendor/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('front/vendor/product.css') }}">

@endsection
@section('title', 'Restaurant')

<style>
    .job-link{
        font-size: 14px;
        font-weight: 800;
        text-decoration: none;
    }
</style>
@section('content')

    <div id="vendor-dashboard-page">
        <div>
            <div class="row">
                @include('vendor.dashboard.sidebar')
                <div class="col-md-8">
                    <div class="bg-white shadow mb-3">
                        <div class="card-body " id="jumbotron">
                            <a href="{{ route('vendor.dashboard') }}">Dashboard</a>
                            <a href="{{ route('user.restaurant.index') }}">Restaurant</a>
                            <span>{{$restro->name}} - Menus</span>
                        </div>
                    </div>

                    <div class="bg-white shadow mb-3" id="products">
                        <div class="card-body ">
                            <div class="row text-center">
                                @foreach ($menus as $menu)
                                    <div class="col-md-3">
                                        <div class="bg-white shadow mb-3 p-4">
                                            <div class="p-1">
                                                <img src="/{{ $menu->logo }}" alt="" style="height: 100px; width:100px; border-radius: 50%;">
                                            </div>
                                            <strong><a href="{{ route('user.restaurant.menusDetail',$menu->id) }}">{{ $menu->name }}</a></strong>
                                            <br>
                                            <small>Rs. {{$menu->rate}}</small>
                                        </div>
                                    </div>
                                @endforeach
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
