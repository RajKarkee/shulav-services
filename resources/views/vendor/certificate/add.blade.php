@extends('front.page')
@section('css')
    <link rel="stylesheet" href="{{ asset('front/vendor/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('front/rcrop.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">

@endsection
@section('title', 'Add Certificate')
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
                            <span>Add Certificates</span>
                        </div>
                    </div>

                    <div class="bg-white shadow mb-3 p-2">
                        <div>
                            <a class="job-link {{ Request::is('vendor/dashboard/skill*') ? 'text-danger' : '' }}" href="{{ route('vendor.skill.index') }}">My Skills</a> |
                            <a class="job-link {{ Request::is('vendor/dashboard/certificate*') ? 'text-danger' : '' }}" href="{{ route('vendor.certificate.index') }}">My Certificate</a> |
                            <a class="job-link {{ Request::is('vendor/dashboard/job-search*') ? 'text-danger' : '' }}" href="{{ route('vendor.job-search.index') }}"> Search Jobs</a>

                        </div>
                    </div>

                    <div class="bg-white shadow mb-3" id="products">
                        <div class="card-body ">
                            <form action="{{ route('vendor.certificate.store') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-md-12 mt-1">
                                        <label> Title </label>
                                        <input type="text" class="form-control" name="title" required>
                                    </div>

                                    <div class="col-md-12 mt-1">
                                        <label> image </label>
                                        <input name="image" type="file" class="dropify" data-height="145" />
                                    </div>

                                    <div class="col-md-12 mt-3">
                                       <button class="btn btn-primary">Save Data</button>
                                    </div>

                                </div>
                            </form>
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
                <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
                <script>
                    $('.dropify').dropify();
                </script>
            @endsection
