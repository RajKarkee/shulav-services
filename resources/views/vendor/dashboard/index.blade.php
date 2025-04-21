@extends('front.page')
@section('css')
    <link rel="stylesheet" href="{{ asset('front/vendor/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('front/rcrop.min.css') }}">

@endsection
@section('title', 'Vendor Dashboard ')
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
                <div class="col-md-8   ">
                    <div class="bg-white shadow mb-3">
                        <div class="card-body " id="jumbotron">
                            <a href="{{ route('user.dashboard') }}">Dashboard</a>

                        </div>
                    </div>

                    <div class="bg-white shadow mb-3 p-2">
                        <div>
                            <a class="job-link {{ Request::is('vendor/dashboard/skill.*') ? 'text-danger' : '' }}" href="{{ route('vendor.skill.index') }}">My Skills</a> |
                            <a class="job-link {{ Request::is('vendor/dashboard/certificate.*') ? 'text-danger' : '' }}" href="{{ route('vendor.certificate.index') }}">My Certificate</a> |
                            <a class="job-link {{ Request::is('vendor/dashboard/job-search.*') ? 'text-danger' : '' }}" href="{{ route('vendor.job-search.index') }}"> Search Jobs</a>

                            <div style="float: right;">
                                <a href="#" class="badge badge-primary" style="color:red; font-size:13px;">Some Things</a>
                            </div>
                        </div>
                    </div>

                    <div id="infos">
                        <div class="row">
                            <div class="col-md-4 col-6 ">
                                <a class="box shadow" href="{{route('vendor.reviews')}}">
                                    <div class="icon ">
                                        <img src="{{asset('front/review.svg')}}" alt="">
                                    </div>
                                    <div class="text">
                                        <div class="number">
                                            {{$info->reviews}}
                                        </div>
                                         Reviews
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4 col-6 ">
                                <a class="box shadow">
                                    <div class="icon ">
                                        <img src="{{asset('front/profile_views.svg')}}" alt="">
                                    </div>
                                    <div class="text">
                                        <div class="number">
                                            {{$user->vendor->count}}
                                        </div>
                                         Profile Views
                                    </div>
                                </a>
                            </div>

                            <div class="col-md-4 col-6 ">
                                <a class="box shadow"  href="{{route('vendor.product.index',['type'=>1])}}">
                                    <div class="icon ">
                                        <img src="{{asset('front/product.svg')}}" alt="">
                                    </div>
                                    <div class="text">
                                        <div class="number">
                                            {{$info->products}}
                                        </div>
                                        Products
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4 col-6 " >
                                <a class="box shadow" href="{{route('vendor.bills')}}">
                                    <div class="icon ">
                                        <img src="{{asset('front/invoice.svg')}}" alt="">
                                    </div>
                                    <div class="text">
                                        <div class="number">
                                            {{$info->invoices}}
                                        </div>
                                        Invoices
                                    </div>
                                </a>
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
