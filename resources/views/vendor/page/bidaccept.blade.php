@extends('front.page')
@section('css')
    <link rel="stylesheet" href="{{ asset('front/vendor/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('front/rcrop.min.css') }}">

@endsection
@section('title', 'Bid Accepted Job')
<style>
    .job-link{
        font-size: 14px;
        font-weight: 800;
        text-decoration: none;
    }
    strong{
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
                            <span>Bid Accepted Jobs</span>
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
                            <div class="row">
                                @foreach ($jobs as $job)
                                @php

                                        $bid = $bids->where('job_id',$job->id)->first();


                                @endphp
                                    <div class="col-md-12">
                                        <div class="bg-white shadow mb-3 p-4">
                                            <strong><a href="{{ route('vendor.job-search.details',$job->id)}}">{{ $job->title }}</a></strong>
                                            <p style="font-size: 13px;">{{ $job->desc}}</p>
                                            <div>
                                                <div class="text-start">
                                                    <strong>Bid Amount : <span class="text-danger">Rs.
                                                        @if ($bid != null)
                                                          Rs.{{ $bid->amount }}
                                                        @endif
                                                    </span></strong><br>
                                                    <strong>Status : <span class="text-success">Accepted</span></strong>
                                                    <div class="text-center mt-3">
                                                        @if ($job->status==2)
                                                          <strong>Finished request has been sent !</strong>
                                                        @else
                                                          <strong><a href="{{ route('vendor.finishedJobReq',$job->id)}}" onclick="return confirm('Are you finished this job?');">Request Finished Job</a></strong>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    <strong><span class="text-danger" style="font-size: 12px;">{{ $job->updated_at->diffForHumans() }}</span></strong>
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

            @endsection
            @section('js')
                @include('vendor.dashboard.imagejs')
                @include('vendor.dashboard.namejs')
                @include('vendor.dashboard.descjs')

            @endsection
