@extends('admin.layout.app')
@section('css-include')
    <link href="{{ asset('admin/plugins/DataTables/datatables.min.css') }}" rel="stylesheet">
@endsection
@section('page-option')
    <a type="button" class="btn btn-primary" href="{{ route('admin.products.create') }}">Add Product</a>
@endsection
@section('s-title')
    <li class="breadcrumb-item">Products</li>
@endsection
@section('content')
    <div class="card shadow mb-3">
        <div class="card-body">
            <form action="{{ route('admin.products.loadData') }}" method="POST" class="row">
                @csrf
                <div class="col-md-4 mb-2">
                    <label for="category_id" class="form-label">Service Category</label>
                    <select name="category_id" id="category_id" class="form-control">
                        <option value="">All Categories</option>
                        @foreach ($serviceCategories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-2">
                    <label for="city_id" class="form-label">City</label>
                    <select name="city_id" id="city_id" class="form-control">
                        <option value="">All Cities</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}" {{ request('city_id') == $city->id ? 'selected' : '' }}>
                                {{ $city->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end mb-2">
                    <button type="submit" class="btn btn-primary" style="margin-right: 10px">Filter</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card shadow">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Short Description</th>
                        <th>Price</th>
                        <th>City</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($products) && count($products) > 0)
                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->short_desc }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->city->name ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                        class="btn btn-sm btn-info">Edit</a>
                                    <a href="{{ route('admin.products.del', ['product_id' => $product->id]) }}"
                                        class="btn btn-sm btn-danger">Del</a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center">No products found</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
