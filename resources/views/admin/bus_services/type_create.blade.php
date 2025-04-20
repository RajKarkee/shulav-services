@extends('admin.layout.app') <!-- Assuming you have a layout file for the admin -->

@section('s-title')
    <li class="breadcrumb-item"><a href="{{ route('admin.busServices.index') }}">Bus Type</a></li>
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
            <form action="{{ route('admin.busServices.type.add') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class=" col-md-4">
                        <div>
                            <label for="image">Feature Image</label>
                            <input type="file" name="image_1" class="form-control dropify" accept=".jpg,.jpeg,.png"
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
                                    <label for="name">Bus Type</label>
                                    <input type="text" name="bus_type_name" class="form-control" id="name">
                                </div>
                            </div>



                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="short_desc">Short Description</label>
                                    <textarea name="short_desc" class="form-control" id="short_desc" rows="2"></textarea>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="desc">Description</label>
                                    <textarea name="desc" class="form-control" id="desc" rows="3"></textarea>
                                </div>
                            </div>

                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Add Bus type</button>
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
        var lock = false;
        $(function() {
            $('.dropify').dropify();
            $('#desc').summernote({
                placeholder: 'Enter the bus description...',
                tabsize: 2,
                height: 200
            });
        });




    </script>
@endsection
