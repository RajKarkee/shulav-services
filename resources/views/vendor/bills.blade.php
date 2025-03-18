@extends('front.page')
@section('css')
    <link rel="stylesheet" href="{{ asset('front/vendor/dashboard.css') }}">

@endsection
@section('title', 'Vendor Invoices ')

@section('content')

    <div id="vendor-dashboard-page">
        <div>
            <div class="row">
                @include('vendor.dashboard.sidebar')
                <div class="col-md-8   ">
                    <div class="bg-white shadow mb-3">
                        <div class="card-body " id="jumbotron">
                            <a href="{{ route('vendor.dashboard') }}">Dashboard</a>
                            <span>Invoices</span>
                        </div>
                    </div>
                    <div class="p-2 text-start text-md-center shadow mb-3"
                        style="background:#ff5a5f33;;">
                        You Can pay Invoices Via <br>
                        @php
                            $payment = getSetting('payment');
                        @endphp
                        @foreach ($payment as $item)
                            {{ $item->title }}: {{ $item->id }} <br>
                        @endforeach
                        put {#REF ID} in remarks
                    </div>
                    
                    <div class="bg-white shadow mb-3">
                        <div class="card-body ">
                            <div id="bills">
                               
                                <table class="table  d-none d-md-block">
                                    <tr>

                                        <th>
                                            #REF ID
                                        </th>
                                        <th>
                                            Date
                                        </th>
                                        <th >
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
                                    @foreach ($user->vendor->bills->sortByDesc('id') as $bill)
                                        <tr>
                                            <th>
                                                {{ $bill->id }}
                                            </th>
                                            <td>
                                                {{ $bill->date->toDateString() }}
                                            </td>
                                            <td >
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
                                                <a target="_blank" href="{{ route('vendor.bill', ['bill' => $bill->id]) }}">
                                                    View
                                                </a>
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
                                                        <div>#{{ $bill->id }}</div>
                                                    </div>
                                                    <div class="col-6 pb-2">
                                                        <strong>Date</strong>
                                                        <div>{{ $bill->date->toDateString() }}</div>
                                                    </div>
                                                    <div class="col-12 pb-2">
                                                        <strong>Particular</strong>
                                                        <div>{{ $bill->particular }}</div>
                                                    </div>
                                                    <div class="col-6 pb-2">
                                                        <strong>Status</strong>
                                                        <div class="{{ $bill->paid ? 'text-success' : 'text-warning' }}">
                                                            {{ $bill->paid ? 'Paid' : 'Unpaid' }}
                                                        </div>
                                                    </div>
                                                    <div class="col-6 pb-2">
                                                        <strong>Amount</strong>
                                                        <div>Rs. {{ $bill->amount }}</div>
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
        </div>
    </div>
</div>

@endsection
@section('js')
        @include('vendor.dashboard.imagejs')
        @include('vendor.dashboard.namejs')
        @include('vendor.dashboard.descjs')
       
@endsection
