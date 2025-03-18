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
                    <div class="bg-white shadow mb-3">
                        <div class="card-body " id="jumbotron">
                            <a href="{{ route('vendor.dashboard') }}">Dashboard</a>

                        </div>
                    </div>
                    @include('vendor.dashboard.due')
                    <div class="bg-white shadow sticky-selector">
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

                                    @foreach ($otherServices as $otherService)
                                        <div class="col-md-3 col-6 pb-3 mobile-sm">
                                            <a href="{{ route('search', ['ser_id' => $otherService->id]) }}"
                                                class="service h-100">
                                                <img src="{{ asset($otherService->image) }}" alt="">
                                                <div class="name">
                                                    {{ $otherService->name }}
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach

                                </div>
                                <div class="py-3 text-center">
                                    <a href="{{ route('vendor.subscribe') }}" class="btn btn-success">Manage Services</a>
                                </div>

                            </div>
                            <div class="choice" id="reviews">
                                <div id="reviews-inner"></div>
                                <div class="py-2 text-center">
                                    <a href="{{ route('vendor.reviews') }}" class="btn btn-red">View All</a>
                                </div>
                            </div>
                            <div class="choice" id="bills">
                                <div class="p-2 text-start text-md-center mb-3"
                                    style="background:rgba(255, 90, 95, 0.2);border-radius:5px;">
                                    You Can pay Bill Via Esewa / Khalti, <br>
                                    @php
                                        $payment = getSetting('payment');
                                    @endphp
                                    @foreach ($payment as $item)

                                        {{ $item->title }}: {{ $item->id }} <br>
                                    @endforeach
                                    put {#REF ID} in remarks
                                            </div>
                                            <table class="table d-none d-md-block">
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
                                                            {{ $bill->id }}
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
                                                            <a target="_blank" href="{{ route('vendor.bill', ['bill' => $bill->id]) }}">View Bill</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                            <div class="d-block d-md-none">
                                                @foreach ($user->vendor->bills as $bill)
                                                    <div class="mb-3 " style="border-radius: 5px;border:1px var(--black-secondary) solid;">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-6 pb-2">
                                                                    <strong>REF ID</strong>
                                                                    <div>#{{$bill->id}}</div>
                                                                </div>
                                                                <div class="col-6 pb-2">
                                                                    <strong>Date</strong>
                                                                    <div>{{ $bill->date->toDateString() }}</div>
                                                                </div>
                                                                <div class="col-12 pb-2">
                                                                    <strong>Particular</strong>
                                                                    <div>{{$bill->particular}}</div>
                                                                </div>
                                                                <div class="col-6 pb-2">
                                                                    <strong>Status</strong>
                                                                    <div class="{{ $bill->paid ? 'text-success' : 'text-warning' }}">
                                                                        {{ $bill->paid ? 'Paid' : 'Unpaid' }}
                                                                    </div>
                                                                </div>
                                                                <div class="col-6 pb-2">
                                                                    <strong>Amount</strong>
                                                                    <div>Rs. {{$bill->amount}}</div>
                                                                </div>
                                                                <hr>
                                                                <div class="col-12">
                                                                    <a  class="btn btn-success w-100" target="_blank" href="{{ route('vendor.bill', ['bill' => $bill->id]) }}">View Bill</a>
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

                @include('front.page.vendor.review_single_template')
@endsection
@section('js')
                @include('vendor.dashboard.imagejs')
                @include('vendor.dashboard.namejs')
                @include('vendor.dashboard.descjs')
                <script>
                    const reviews = {!! json_encode($reviews) !!};
                    const asset = "{{ asset('') }}";
                    const $template = $('#single-review-template').html();
                    var $tot = 0;
                    var $count = 0;
                    var $avg = 0;
                    $(document).ready(function() {
                        let $html = "";
                        reviews.forEach(review => {
                            $tot += review.r;
                            $count += 1;
                            review.i = asset + review.i;
                            review.ago = (time_ago(review.c));
                            $html += template($template, review)
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
