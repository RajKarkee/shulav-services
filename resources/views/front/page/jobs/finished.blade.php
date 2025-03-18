@extends('front.page')
@section('css')
    <link rel="stylesheet" href="{{ asset('front/vendor/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('front/vendor/product.css') }}">

@endsection
@section('title', 'Finished Jobs')
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
                <div class="col-md-8">
                    <div class="bg-white shadow mb-3">
                        <div class="card-body " id="jumbotron">
                            <a href="{{ route('vendor.dashboard') }}">Dashboard</a>
                            <span>Finished Jobs</span>
                        </div>
                    </div>

                    <div class="bg-white shadow mb-3 p-2">
                        <div>
                            <a class="job-link {{ Request::is('user/jobs') ? 'text-danger' : '' }}" href="{{ route('user.jobs.index') }}">All Jobs</a> |
                            <a class="job-link {{ Request::is('user/jobs/bid-requested') ? 'text-danger' : '' }}" href="{{ route('user.jobs.requested') }}">Bid Requested Jobs</a> |

                            <a class="job-link {{ Request::is('user/jobs/running') ? 'text-danger' : '' }}" href="{{ route('user.jobs.running')}}">Running Jobs</a> |
                            <a class="job-link {{ Request::is('user/jobs/finished') ? 'text-danger' : '' }}" href="{{ route('user.jobs.finished')}}">Finished Jobs</a>

                            <div style="float: right;">
                                <a href="{{ route('user.jobs.add.page') }}" class="badge badge-primary" style="color:red; font-size:13px;">Add New Job</a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow mb-3" id="products">
                        <div class="card-body ">
                            <div class="row">
                                @foreach ($jobs as $job)
                                @php
                                    $pay = \App\Models\Payment::where('job_id',$job->id)->first();
                                @endphp
                                    <div class="col-md-12">
                                        <div class="bg-white shadow mb-3 p-4">
                                            <img src="{{ $job->image }}" alt="">
                                            <strong><a href="{{ route('user.jobs.detail',$job->id)}}">{{ $job->title }}</a></strong>
                                            <p style="font-size: 13px; margin-left:7px;">{{ $job->desc}}</p>
                                            <div class="status">
                                                <strong>Status : <span class="text-success">Finished</span></strong><br>
                                                <strong>Payment Status : <span class="text-{{ $pay->received==1?'success':'danger'}}">{{ $pay->received==1?'Success':'Pending'}}</span></strong>

                                            </div>
                                            <div class="text-end">
                                                <strong><span class="text-danger" style="font-size: 12px;">{{ $job->updated_at->diffForHumans() }}</span></strong>
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
