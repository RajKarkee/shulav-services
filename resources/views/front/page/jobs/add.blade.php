@extends('front.page')
@section('css')
    <link rel="stylesheet" href="{{ asset('front/vendor/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('front/vendor/product.css') }}">
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">

@endsection
@section('title', 'Jobs Add'))

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
                            <span>Job Add</span>
                        </div>
                    </div>
                    <div class="bg-white shadow mb-3">
                        <div class="card-body ">
                            <form action="{{ route('user.jobs.add') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                    <div class="col-md-12">
                                        <label>Services</label>
                                        <select class="form-control" name="service_id" id="" required>
                                            <option>----select service ----</option>
                                            @foreach ($services as $service)
                                                <option value="{{ $service->id}}">{{ $service->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mt-1">
                                        <label> Title </label>
                                        <input type="text" class="form-control" name="title" required>
                                    </div>

                                    <div class="col-md-6 mt-1">
                                        <label> Bid Range </label>
                                        <input type="number" min="1" class="form-control" name="bid_range" required>
                                    </div>

                                    <div class="col-md-6 mt-1">
                                        <label> Detail </label>
                                        <textarea name="desc" id="" rows="6" class="form-control"></textarea>
                                    </div>

                                    <div class="col-md-6 mt-1">
                                        <label> image </label>
                                        <input name="image" type="file" class="dropify" data-height="145" />
                                    </div>

                                    <div class="col-md-12 mt-3">
                                       <button class="btn btn-primary">Save Data</button>
                                    </div>

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
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
    <script>
        $('.dropify').dropify();
    </script>
@endsection
