@extends('front.page')
@section('css')
    <link rel="stylesheet" href="{{ asset('front/vendor/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('front/vendor/product.css') }}">

    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('rating/css/simple-rating.css') }}"> --}}
    <link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


@endsection
@section('title', 'Running Jobs')
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
                <div class="col-md-8">
                    <div class="bg-white shadow mb-3">
                        <div class="card-body " id="jumbotron">
                            <a href="{{ route('vendor.dashboard') }}">Dashboard</a>
                            <span>Running Jobs</span>
                        </div>
                    </div>

                    <div class="bg-white shadow mb-3 p-2">
                        <div>
                            <a class="job-link {{ Request::is('user/jobs') ? 'text-danger' : '' }}"
                                href="{{ route('user.jobs.index') }}">All Jobs</a> |
                            <a class="job-link {{ Request::is('user/jobs/bid-requested') ? 'text-danger' : '' }}"
                                href="{{ route('user.jobs.requested') }}">Bid Requested Jobs</a> |

                            <a class="job-link {{ Request::is('user/jobs/running') ? 'text-danger' : '' }}"
                                href="{{ route('user.jobs.running') }}">Running Jobs</a> |
                            <a class="job-link {{ Request::is('user/jobs/finished') ? 'text-danger' : '' }}"
                                href="{{ route('user.jobs.finished') }}">Finished Jobs</a>

                            <div style="float: right;">
                                <a href="{{ route('user.jobs.add.page') }}" class="badge badge-primary"
                                    style="color:red; font-size:13px;">Add New Job</a>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white shadow mb-3" id="products">
                        <div class="card-body ">
                            <div class="row">
                                @foreach ($jobs as $job)
                                    @php
                                        $bid = \App\Models\JobBid::where('job_id', $job->id)
                                            ->where('status', 1)
                                            ->first();
                                    @endphp
                                    <div class="col-md-12">
                                        <div class="bg-white shadow mb-3 p-4">
                                            <img src="{{ $job->image }}" alt="">
                                            <strong><a
                                                    href="{{ route('user.jobs.detail', $job->id) }}">{{ $job->title }}</a></strong>
                                            <p style="font-size: 13px;">{{ $job->desc }}</p>
                                            <div class="status mb-3">
                                                @if ($job->status == 2)
                                                    <strong class="text-success" style="font-size: 11px;">
                                                        Your task has been finished successfully
                                                    </strong>

                                                @endif
                                            </div>
                                            <div class="text-end">
                                                <strong><span class="text-danger"
                                                        style="font-size: 12px;">{{ $job->updated_at->diffForHumans() }}</span></strong>
                                            </div>

                                            <style>
                                                .tt {
                                                    background: #0C7CE6;
                                                    color: white;

                                                }

                                            </style>
                                            @if ($job->status == 2)
                                                <hr>
                                                <div class="mt-4 mb-4">
                                                    <Strong style="font-size: 15px;">Payment Detail</Strong>
                                                    <form action="{{ route('user.jobs.acceptFinishedJob') }}"
                                                        method="post" class="mt-4">
                                                        @csrf
                                                        <div class="form-group mb-3 mt-4">
                                                            <div class="row">
                                                                <div class="col md 6">
                                                                    <Strong>Payment Type</Strong>
                                                                    <select name="type" id="type" class="form-control">
                                                                        <option value="0">Cash</option>
                                                                        <option value="1">Online</option>
                                                                    </select>
                                                                    <div class="reference d-none">
                                                                        <small>Please enter the following reference id</small><br>
                                                                        <strong>Reference Id = #{{ $job->id }}</strong>
                                                                    </div>
                                                                </div>
                                                                <div class="col md 6">
                                                                    <Strong>Payment Amount</Strong>
                                                                    <input type="number" name="amt" class="form-control"
                                                                        value="{{ $bid->amount }}" readonly>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="vendor_id"
                                                                value="{{ $bid->vendor_id }}">
                                                            <input type="hidden" name="job_id" value="{{ $job->id }}">

                                                        </div>
                                                </div>

                                                <div class="mt-4">
                                                    <Strong style="font-size: 15px;">Add Your Review </Strong>

                                                    <div class="form-group mt-4 mb-3">
                                                        <Strong class="mb-4">Your Ratings <span
                                                                class="text-red">*</span></Strong>
                                                        <div class="d-flex mt-3">
                                                            @foreach (['Bad', 'Good', 'Moderade', 'Very Good', 'Exellent'] as $key => $item)
                                                                <div style="flex:1;cursor: pointer;padding:10px;border-radius:5px;"
                                                                    class="rating-inner text-center"
                                                                    onclick="$('#rating-{{ $key }}')[0].checked=true;$('.rating-inner').removeClass('tt');$(this).addClass('tt')"
                                                                    style="">
                                                                    <input type="radio" name="rating"
                                                                        id="rating-{{ $key }}"
                                                                        value="{{ $key }}" required> <br>
                                                                    {{ $item }}
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-3">
                                                        <Strong>Your Review <span class="text-red">*</span></Strong>
                                                        <textarea name="desc" id="" rows="5" class="form-control"
                                                            required></textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <button class="btn btn-primary btn-sm">Save & Accetp
                                                            Request</button>
                                                    </div>
                                                    </form>
                                                </div>

                                            @endif

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
    {{-- <script src="{{ asset('rating/js/simple-rating.js') }}"></script> --}}


    {{-- <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js"></script> --}}
    {{-- <script src="{{ asset('rating/js/jquery.star-rating.js')}}"></script>
    <script>
        $('.rating').starRating({
            starSize: 1.5,
            showInfo: false
        });

        $(document).on('change', '.rating',
            function(e, stars, index) {
                alert(`Thx for ${stars} stars!`);
            });

    </script> --}}

    <script>
        $('#type').on('change', function() {
            // alert(this.value);
            if(this.value == 1){
                $('.reference').removeClass('d-none');
                $('.reference').addClass('d-block');

            }else{
                $('.reference').addClass('d-none');
                $('.reference').removeClass('d-block');

            }

        });


    </script>

@endsection
