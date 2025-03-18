@extends('admin.layout.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/plugins/drophify/css/dropify.min.css') }}">
    <style>
        .dropify-wrapper {
            height: 100% !important;
        }
    </style>
@endsection

@section('s-title')
    <li class="breadcrumb-item">Setting</li>
    <li class="breadcrumb-item"><a href="{{ route('admin.setting.city.index') }}">Cities</a></li>
    <li class="breadcrumb-item">{{ $location->city->name }}</li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.setting.city.location.index', ['id' => $location->city->id]) }}">
            Locations
        </a>
    </li>
    <li  class="breadcrumb-item">{{$location->name}}</li>
    <li class="breadcrumb-item">Edit</li>
@endsection
@section('content')
    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('admin.setting.city.add') }}" method="post" id="edit-location">
                @csrf
                <div class="row">
                    <div class="col-md-5">
                        <input type="file" name="image" id="image" class="dropify" accept="image/*" data-default-file="{{asset($location->image)}}">
                    </div>
                    <div class="col-md-7">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{$location->name}}">
                            </div>
                            <div class="col-md-6">
                                <label for="lat">Latitude</label>
                                <input type="text" name="lat" id="lat" class="form-control" value="{{$location->lat}}">
                            </div>
                            <div class="col-md-6">
                                <label for="lan">Longitude</label>
                                <input type="text" name="lan" id="lan" class="form-control" value="{{$location->lan}}">
                            </div>
                            <div class="col-md-12">
                                <label for="desc">Description</label>
                                <textarea name="desc" id="desc" cols="30" rows="4" class="form-control">{{$location->desc}}</textarea>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-12 py-2">
                        <button class="btn btn-primary">Update Location</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('admin/plugins/drophify/js/dropify.min.js') }}"></script>
    <script>
        var state = 1;
        $(document).ready(function() {
            $('.dropify').dropify();
            $('#edit-location').submit(function(e) {
                e.preventDefault();
                block('#edit-location');
                var fd = new FormData(this);
                axios.post("{{ route('admin.setting.city.location.edit', ['location' => $location->id]) }}", fd)
                    .then((res) => {
                        unblock('#edit-location');

                        if (res.data.status) {
                            toastr.success('Location updated sucessfully.')
                            $('#edit-location')[0].reset();
                            $('#edit-location .dropify-clear')[0].click();
                        } else {
                            toastr.error('Location cannot be updated, Please Try Again.')

                        }
                    })
                    .catch((err) => {
                        unblock('#edit-location');
                        toastr.error('Location cannot be updated, Please Try Again.')
                    });
            });
        });
    </script>
@endsection
