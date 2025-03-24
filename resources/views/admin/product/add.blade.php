@extends('admin.layout.app')  <!-- Assuming you have a layout file for the admin -->

@section('s-title')
    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Product</a></li>
    <li class="breadcrumb-item">Add</li>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('admin/plugins/drophify/css/dropify.min.css') }}">
@endsection

@section('content')
    <div class="container">
        <h1>Add New Product</h1>

        <!-- Display success or error messages -->
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <!-- Product Add Form -->
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Product Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="type">Product Type</label>
                        <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                            <option value="">Select Product Type</option>
                            @foreach($productTypes as $type)
                                <option value="{{ $type->id }}" {{ old('type') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>



                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                    </div>
                    <div class="form-group">
                        <label for="vendor_id">Vendor Id <label>
                            <input type="text" class='form-control' id="vendor_id" value="{{ $vendor->id }}">
                        </div>


                    <div class="form-group">
                        <label for="service_id">Service ID</label>
                        <input type="text" class="form-control @error('service_id') is-invalid @enderror" id="service_id" name="service_id" value="{{ old('service_id') }}" required>
                        @error('service_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="cityid">City</label>
                        <select class="form-control @error('cityid') is-invalid @enderror" id="cityid" name="cityid" required>
                            <option value="">Select a City</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}" {{ old('cityid') == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                            @endforeach
                        </select>
                        @error('cityid')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="count">Product Count</label>
                        <input type="number" class="form-control @error('count') is-invalid @enderror" id="count" name="count" value="{{ old('count') }}" required>
                        @error('count')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="start">Start Date</label>
                        <input type="date" class="form-control @error('start') is-invalid @enderror" id="start" name="start" value="{{ old('start') }}" required>
                        @error('start')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="end">End Date</label>
                        <input type="date" class="form-control @error('end') is-invalid @enderror" id="end" name="end" value="{{ old('end') }}" required>
                        @error('end')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="image">Product Image</label>
                        <input type="file" class="form-control dropify @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" required>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="short_desc">Short Description</label>
                        <textarea class="form-control @error('short_desc') is-invalid @enderror" id="short_desc" name="short_desc" rows="3" required>{{ old('short_desc') }}</textarea>
                        @error('short_desc')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="desc">Description</label>
                        <textarea class="form-control @error('desc') is-invalid @enderror" id="desc" name="desc" rows="5" required>{{ old('desc') }}</textarea>
                        @error('desc')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>



                </div>

                                    <div class="form-group form-check">
                                        <input type="checkbox" class="form-check-input" id="active" name="active" {{ old('active') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="active">Active</label>
                                    </div>
            </div>

            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>
    </div>
@endsection

@section('script')

    <script src="{{ asset('admin/plugins/drophify/js/dropify.min.js') }}"></script>
    <script>
        $(function() {
            $('.dropify').dropify();
            // $('#long_desc').summernote();
        });
    </script>
@endsection
