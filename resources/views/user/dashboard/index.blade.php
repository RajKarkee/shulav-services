@extends('front.page')
@section('css')
    <link rel="stylesheet" href="{{ asset('front/vendor/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('front/rcrop.min.css') }}">

@endsection
@section('title', 'Vendor Dashboard ')

@section('content')
    <div id="vendor-dashboard-page">
        <div>
            <div class="row">
                @include('vendor.dashboard.sidebar')
                <div class="col-md-8   ">
                    <div class="bg-white shadow mb-3" >
                        <div class="card-body " id="jumbotron">
                            <a href="#">Dashboard</a>

                        </div>
                    </div>
                    <div class="bg-white shadow sticky-selector" >
                        <div class="card-body pb-0" id="selector">
                            <span data-select="#services" class="active">Subscribed Services</span>
                            <span data-select="#reviews">Reviews</span>
                            <span data-select="#bills">Bills</span>
                        </div>
                    </div>
                    <div class="bg-white shadow mt-2">
                        <div class="card-body " id="selector-choice">
                            <div class="choice active" id="services">
                                <div class="row">
                                    <div class="col-md-3 col-6 pb-3 mobile-sm">
                                        <a href="{{ route('search', ['ser_id' => $user->vendor->service_id]) }}"
                                            class="service h-100">
                                            <img src="#" alt="">
                                            <div class="name">
                                             Name
                                            </div>
                                        </a>
                                    </div>
                                    {{-- @foreach ($otherServices as $otherService)
                                    <div class="col-md-3 col-6 pb-3 mobile-sm">
                                        <a href="{{ route('search', ['ser_id' => $otherService->id]) }}"
                                            class="service h-100">
                                            <img src="{{ asset($otherService->image) }}" alt="">
                                            <div class="name">
                                                {{ $otherService->name }}
                                            </div>
                                        </a>
                                    </div>
                                    @endforeach --}}
                                    <div class="col-md-3 col-6 pb-3 mobile-sm">
                                        <a href="#"
                                            class="service h-100">
                                            <img src="{{ asset('front/add.svg') }}" alt="">
                                            <div class="name">
                                                Add New Service
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="choice" id="reviews">
                                <div id="reviews-inner"></div>
                                <div class="py-2 text-center">
                                    <a href="#" class="btn btn-red">View All</a>
                                </div>
                            </div>
                            <div class="choice" id="bills">
                                <div class="p-2 text-start text-md-center mb-3" style="background:rgba(255, 90, 95, 0.2);border-radius:5px;">
                                    You Can pay Bill Via Esewa / Khalti, <br>
                                    Mobile No: 9800916365 <br>
                                    put {#REF ID} in remarks
                                </div>
                                <table class="table">
                                    <tr>

                                        <th>
                                            #REF ID
                                        </th>
                                        <th>
                                            Date
                                        </th>
                                        <th>
                                            Particular
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            Amount
                                        </th>
                                        <th>

                                        </th>
                                    </tr>
                                    @foreach ($user->vendor->bills as $bill)
                                        <tr>
                                            <th>
                                                {{$bill->id}}
                                            </th>
                                            <th>
                                                {{ $bill->date->toDateString() }}
                                            </th>
                                            <td>
                                                {{ $bill->particular }}
                                            </td>
                                            <td>
                                                <span class="{{ $bill->paid ? 'text-success' : 'text-warning' }}">
                                                    {{ $bill->paid ? 'Paid' : 'Unpaid' }}
                                                </span>

                                            </td>
                                            <td>
                                                {{ $bill->amount }}
                                            </td>
                                            <td>
                                                <a target="_blank" href="#">View Bill</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('front.page.vendor.review_single_template')
@endsection
@section('js')
    @include('vendor.dashboard.imagejs')
    @include('vendor.dashboard.namejs')
    @include('vendor.dashboard.descjs')
    <script>
   
        const asset = "{{ asset('') }}";
        const $template = $('#single-review-template').html();
        var $tot=0;
            var $count=0;
            var $avg=0;
            $(document).ready(function () {
                let $html="";
                reviews.forEach(review => {
                    $tot+=review.r;
                    $count+=1;
                    review.i=asset+review.i;
                    review.ago=(time_ago(review.c));
                    $html+=template($template,review)
                });
                $('#reviews-inner').html($html);
                console.log($html);
            });
        $('#selector>span').click(function(e) {
            e.preventDefault();
            $('#selector>span').removeClass('active');
            $('.choice').removeClass('active');
            $('.choice' + $(this).data('select')).addClass('active');
            $(this).addClass('active');
        });
    </script>
@endsection
