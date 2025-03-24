@extends('admin.layout.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/plugins/drophify/css/dropify.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
@endsection
@section('s-title')
    <li class="breadcrumb-item"><a href="{{ route('admin.service.index') }}">Service</a></li>
    <li class="breadcrumb-item">Add</li>
@endsection
@section('content')
    <div class="container">
        <h1>Add New Service</h1>
        <form action="{{ route('admin.service.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col md 6">

                    <div class="form-group">
                        <label for="name">Service Name</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="type">Service Type</label>
                        <select name="type" id="type" class="form-control">
                            <option value="1">Normal Service</option>
                            <option value="2">Hotel & Restaurants</option>
                            <option value="3">Bus Ticket</option>
                            <option value="4">Plane Ticket</option>
                            <option value="5">Vehicle Rent</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select name="category_id" id="category_id" class="form-control">
                            <option value="">Select Category</option>
                            {{-- @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach --}}
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="rate">Rate (optional)</label>
                        <input type="number" name="rate" id="rate" class="form-control">
                    </div>


                </div>
                <div class="col md 6">
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control dropify" name="image" id="dropify" data-default="">
                    </div>

                    <div class="form-group">
                        <label for="desc">Description</label>
                        <textarea name="desc" id="desc" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="active">Active</label>
                <input type="checkbox" name="active" id="active" value="1" checked>
            </div>
            <button type="submit" class="btn btn-success">Save</button>
        </form>
    </div>
@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script src="{{ asset('admin/plugins/drophify/js/dropify.min.js') }}"></script>
    <script>
        $(function() {
            $('.dropify').dropify();
          //  $('#long_desc').summernote();
        });
    </script>
@endsection
