@extends('front.page')
@section('css')
    <link rel="stylesheet" href="{{ asset('front/vendor/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('front/rcrop.min.css') }}">

@endsection
@section('title', 'My Skills')
    <style>
        .job-link {
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
                            <span>Skills</span>
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

                            <div style="float: right;">
                                <a href="{{ route('vendor.skill.add') }}" class="badge badge-primary"
                                    style="color:red; font-size:13px;">Add Skill</a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow mb-3 p-3" id="products">
                        <div class="card-body ">
                            <div class="certificate">
                                <div class="row mt-2">
                                    @foreach ($skills as $skill)
                                        <div class="col-md-4">
                                            <ul>
                                                <li><strong>{{ $skill->title }}</strong></li>
                                                <strong class="text-danger">
                                                    @if ($skill->type == 1)
                                                        Lavel One
                                                    @elseif ($skill->type == 2)
                                                        Lavel Two
                                                    @elseif ($skill->type == 3)
                                                        Lavel Three
                                                    @elseif ($skill->type == 4)
                                                        Lavel Four
                                                    @else
                                                        Lavel Five
                                                    @endif
                                                </strong>
                                                <div>
                                                    <a href="{{ route('vendor.skill.delete',$skill->id)}}" onclick="return confirm('Are you sure?');"><strong>Delete</strong> </a>
                                                </div>
                                            </ul>
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
