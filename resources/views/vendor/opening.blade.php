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
                            <span>Opening Hour</span>
                        </div>
                    </div>

                    <div class="bg-white shadow mb-3">
                        <div class="card-body">
                            <form id="week-holder" action="{{route('vendor.openingHour')}}" method="POST">
                               @csrf
                                <strong>
                                    <div class="row">
                                        <div class="col-4">
                                            Day
                                        </div>
                                        <div class="col-4">Opening Time</div>
                                        <div class="col-4">Closing Time</div>
                                    </div>
                                </strong>
                                @foreach (\App\Extra\Opening::options as $key => $option)
                                    <hr class="my-1">
                                    <div class="row">
                                        <div class="col-4 pe-0 d-flex align-items-center">
                                            <input type="checkbox" name="open_{{ $key }}"
                                                id="open_{{ $key }}" class="me-1"
                                                {{ $data[$key]['isopen'] ? 'checked' : '' }}>
                                            <label for="open_{{ $key }}">
                                                <strong>
                                                    {{ $option }}
                                                </strong>
                                            </label>
                                        </div>
                                        <div class="col-4 pe-0">
                                            <input type="text" name="start_{{ $key }}"
                                                id="start_{{ $key }}" class="form-control" value="{{$data[$key]['start']}}">
                                        </div>
                                        <div class="col-4 ps-1">
                                            <input type="text" name="end_{{ $key }}" id="end_{{ $key }}"
                                                class="form-control" value="{{$data[$key]['end']}}">
                                        </div>
                                    </div>
                                @endforeach
                                <div class="d-flex justify-content-end mt-2">
                                    <button class="btn btn-red" id="next">
                                        Update Hours
                                    </button>
                                </div>
                            </form>
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
