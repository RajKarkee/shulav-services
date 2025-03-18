@extends('front.page')
@section('css')
    <link rel="stylesheet" href="{{ asset('front/vendor/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('front/rcrop.min.css') }}">

@endsection
@section('title', 'My Certificates')
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
                            <a href="{{ route('vendor.dashboard') }}">Dashboard</a>
                            <span>Certificates</span>
                        </div>
                    </div>

                    <div class="bg-white shadow mb-3 p-2">
                        <div>
                            <a class="job-link {{ Request::is('vendor/dashboard/skill*') ? 'text-danger' : '' }}" href="{{ route('vendor.skill.index') }}">My Skills</a> |
                            <a class="job-link {{ Request::is('vendor/dashboard/certificate*') ? 'text-danger' : '' }}" href="{{ route('vendor.certificate.index') }}">My Certificate</a> |
                            <a class="job-link {{ Request::is('vendor/dashboard/job-search*') ? 'text-danger' : '' }}" href="{{ route('vendor.job-search.index') }}"> Search Jobs</a>

                            <div style="float: right;">
                                <a href="{{ route('vendor.certificate.add')}}" class="badge badge-primary" style="color:red; font-size:13px;">Add Certificate</a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow mb-3" id="products">
                        <div class="card-body ">
                            <div class="certificate">
                                <div class="row mt-2">
                                    @foreach ($certificates as $certificate)
                                        <div class="col-md-4">
                                            <div class="card">
                                                    <img class="card-img-top" src="/{{$certificate->image}}"
                                                        alt="Card image cap" style="height:100px; overflow: hidden;">
                                                <div class="card-body">
                                                    <p class="card-text"><strong>{{ $certificate->title }}</strong></p>
                                                    <hr>
                                                    <div class="text-center">
                                                       <strong><a onclick="return confirm('Are you sure?s');" href="{{ route('vendor.certificate.delete',$certificate->id) }}" style="font-size: 13px;">Delete</a></strong>
                                                    </div>
                                                </div>
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
    </div>

            @endsection
            @section('js')
                @include('vendor.dashboard.imagejs')
                @include('vendor.dashboard.namejs')
                @include('vendor.dashboard.descjs')

            @endsection
