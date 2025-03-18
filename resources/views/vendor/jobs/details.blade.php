@extends('front.page')
@section('css')
    <link rel="stylesheet" href="{{ asset('front/vendor/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('front/rcrop.min.css') }}">

@endsection
@section('title', 'Job Details')
    <style>
        .job-link {
            font-size: 14px;
            font-weight: 800;
            text-decoration: none;
        }

        strong {
            font-size: 13px;
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
                            <span>Job Detail</span>
                        </div>
                    </div>

                    <div class="bg-white shadow mb-3 p-2">
                        <div>
                            <a class="job-link {{ Request::is('vendor/dashboard/skill*') ? 'text-danger' : '' }}"
                                href="{{ route('vendor.skill.index') }}">My Skills</a> |
                            <a class="job-link {{ Request::is('vendor/dashboard/certificate*') ? 'text-danger' : '' }}"
                                href="{{ route('vendor.certificate.index') }}">My Certificate</a> |
                            <a class="job-link {{ Request::is('vendor/dashboard/job-search*') ? 'text-danger' : '' }}"
                                href="{{ route('vendor.job-search.index') }}"> Search Jobs</a>

                        </div>
                    </div>

                    <div class="bg-white shadow mb-3" id="products">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="bg-white shadow mb-3 p-4">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>{{ $job->title }}</strong>
                                                <p style="font-size: 13px; margin-left:7px;">{{ $job->desc }}</p>
                                                <div style="justify-content: center">
                                                    <strong><span class="text-danger"
                                                            style="font-size: 12px;">{{ $job->created_at->diffForHumans() }}</span></strong>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <img src="/{{ $job->image }}" alt="" style="height: 200px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                @if ($job->status==0)
                                <div class="col-md-12">
                                    <div class="bg-white shadow mb-3 p-4">
                                        <strong><u> Add Your Bid </u></strong>
                                            <form action="{{ route('vendor.job-search.bid') }}" class="mt-3">
                                                @csrf
                                                @if ($bidCount != null)
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="number" min="0" value="{{ $bidCount->amount }}" placeholder="Enter Amount"
                                                                    name="bidamt" class="form-control">
                                                            </div>
                                                        </div>
                                                        <input type="hidden" value="{{ $job->id }}" name="job_id">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <button class="btn btn-primary"
                                                                    onclick="return confirm('Are you sure?');">Update</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <input type="number" min="0" placeholder="Enter Amount"
                                                                    name="bidamt" class="form-control">
                                                            </div>
                                                        </div>
                                                        <input type="hidden" value="{{ $job->id }}" name="job_id">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <button class="btn btn-primary"
                                                                    onclick="return confirm('Are you sure?');">Save</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                            </form>

                                    </div>
                                </div>
                                @endif

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
