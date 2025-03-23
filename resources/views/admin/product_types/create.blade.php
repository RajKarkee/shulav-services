@extends('admin.layout.app')

@section('content')
    <h2>Add Product Type</h2>

    <form action="{{ route('admin.product_types.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Product Type Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Add Product Type</button>
    </form>
@endsection
