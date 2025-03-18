@extends('front.page')
@section('css')
    <link rel="stylesheet" href="{{ asset('front/vendor/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('front/vendor/product.css') }}">



@endsection
@section('title', 'Job Details')
    <style>
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
                            <a href="{{ route('user.jobs.index') }}">Job List</a>
                            <span>Details</span>
                        </div>
                    </div>

                    <div class="bg-white shadow mb-3" id="products">
                        <div class="card-body ">
                            <div class="row">

                                <div class="col-md-12">
                                    <div class="bg-white shadow mb-3 p-4">
                                        <img src="{{ $job->image }}" alt="">
                                        <strong>{{ $job->title }}</strong>
                                        <p style="font-size: 13px; margin-left:5px;">{{ $job->desc }}</p>
                                        <div style="justify-content: center">
                                            <strong><span class="text-danger"
                                                    style="font-size: 12px; margin-left:5px;">{{ $job->created_at->diffForHumans() }}</span></strong>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow mb-3" id="products">
                        <div class="card-body ">
                            <div class="card-title"> <strong> Bids </strong></div>
                            <div class="row">
                                @foreach ($bids as $bid)

                                    <div class="col-md-12">
                                        <div class="bg-white shadow mb-3 p-4">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <strong>{{ $bid->name }}</strong>
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Rs.{{ $bid->amount }}</strong>
                                                    <span style="margin-left:30px;">
                                                        @if ($job->status == 0)
                                                            <a href="{{ route('user.jobs.acceptBid', [$job->id, $bid->id]) }}"
                                                                onclick="return confirm('Are you sure?');"
                                                                class="btn btn-primary btn-sm">Accept Bid</a>
                                                        @endif


                                                    </span>
                                                </div>
                                            </div>
                                            <hr>
                                            <h5> <u>Details Of Bider</u> </h5>
                                            <div>
                                                <strong>{{ $bid->name }} <br> {{ $bid->phone }}</strong>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-6">
                                                    <div class="details">
                                                        <div class="skills">
                                                            <strong><u>Skills</u></strong>
                                                            @foreach ($bid->skills as $skill)
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
                                                                </ul>

                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="details">

                                                        <div class="certificate">
                                                            <strong><u>Certificates</u></strong>
                                                            <div class="row mt-2">
                                                                @foreach ($bid->certificates as $certificate)
                                                                    <div class="col-md-6">
                                                                        <div class="card">
                                                                            <img class="card-img-top"
                                                                                src="/{{ $certificate->image }}"
                                                                                alt="Card image cap">
                                                                            <div class="card-body">
                                                                                <p class="card-text">
                                                                                    <strong>{{ $certificate->title }}</strong>
                                                                                </p>
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
