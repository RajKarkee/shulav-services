@extends('admin.layout.app')
@section('content')
    <div class="container">
        <h2>Products</h2>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary mb-3">Add New Product</a>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Short Description</th>
                    <th>Price</th>
                    <th>Vendor</th>
                    <th>City</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->short_desc }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->vendor->name }}</td>
                        <td>{{ $product->city->name }}</td>
                        <td>
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
