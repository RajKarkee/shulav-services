@extends('admin.layout.app')
@section('s-title')
    <li class="breadcrumb-item"><a href="{{ route('admin.product.index') }}">Product</a></li>
    <li class="breadcrumb-item">Edit</li>
@endsection

@section('content')
    <div class="container">
        <h2>Edit Product: {{ $product->name }}</h2>
        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="short_desc">Short Description</label>
                <textarea class="form-control @error('short_desc') is-invalid @enderror" id="short_desc" name="short_desc" rows="3" required>{{ old('short_desc', $product->short_desc) }}</textarea>
                @error('short_desc')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="desc">Description</label>
                <textarea class="form-control @error('desc') is-invalid @enderror" id="desc" name="desc" rows="5" required>{{ old('desc', $product->desc) }}</textarea>
                @error('desc')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $product->price) }}" required>
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="image">Product Image</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                @if($product->image)
                    <img src="{{ asset($product->image) }}" alt="Product Image" width="150">
                @endif
            </div>

            <div class="form-group">
                <label for="vendor_id">Vendor</label>
                <select class="form-control @error('vendor_id') is-invalid @enderror" id="vendor_id" name="vendor_id" required>
                    @foreach($vendors as $vendor)
                        <option value="{{ $vendor->id }}" {{ old('vendor_id', $product->vendor_id) == $vendor->id ? 'selected' : '' }}>{{ $vendor->name }}</option>
                    @endforeach
                </select>
                @error('vendor_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="cityid">City</label>
                <select class="form-control @error('cityid') is-invalid @enderror" id="cityid" name="cityid" required>
                    @foreach($cities as $city)
                        <option value="{{ $city->id }}" {{ old('cityid', $product->cityid) == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                    @endforeach
                </select>
                @error('cityid')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
    </div>
@endsection
