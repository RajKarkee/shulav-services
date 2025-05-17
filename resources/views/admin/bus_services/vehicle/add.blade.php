@extends('admin.layout.app')

@section('s-title')
    <li class="breadcrumb-item">E-Ticketing</li>
    <li class="breadcrumb-item"><a href="{{ route('admin.busServices.vehicle.index') }}">Vehicles</a></li>
    <li class="breadcrumb-item">Add</li>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('admin/plugins/drophify/css/dropify.min.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">
    <style>
        #mass-image .dropify-wrapper {
            height: 150px;
        }
    </style>
@endsection

@section('content')
    <div class="card shadow">
        <div class="card-body">
            <form action="{{ route('admin.busServices.vehicle.add') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div>
                            <label for="image">Featured Vehicle Image</label>
                            <input type="file" name="image1" class="form-control dropify" accept=".jpg,.jpeg,.png"
                                id="image" required>
                        </div>
                        <hr>
                        <div class="row" id="mass-image">
                            @for ($index = 2; $index <= 7; $index++)
                                <div class="col-md-6">
                                    <label for="image_{{ $index }}">Image {{ $index }}</label>
                                    <input type="file" name="image_{{ $index }}" class="form-control dropify"
                                        accept=".jpg,.jpeg,.png" id="image_{{ $index }}">
                                </div>
                            @endfor
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">Vehicle Name</label>
                                    <input type="text" name="name" class="form-control" id="name" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="bus_type_id">Vehicle Type</label>
                                    <select name="bus_type_id" class="form-control" id="bus_type_id" required>
                                        <option value="">Select Vehicle Type</option>
                                        @foreach ($busTypes as $type)
                                            <option value="{{ $type->id }}">{{ $type->bus_type_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="capacity">Capacity</label>
                                    <input type="number" name="capacity" class="form-control" id="capacity" min="1"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Add Vehicle</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('admin/plugins/drophify/js/dropify.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>

    <script>
        $(function() {
            $('.dropify').dropify();
            $('#description').summernote({
                placeholder: 'Enter the vehicle description...',
                tabsize: 2,
                height: 200
            });
        });
    </script>
@endsection
