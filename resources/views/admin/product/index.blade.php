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
    <div class="card shadow">
        <div class="card-body">
            <table class="table">
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

                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('script')
    <script>
        const cities = @json(\App\Helper::getCitiesMini());
        const categories = @json(\App\Helper::getCategoriesMini());
        function render(product) {
            return `
                <tr>
                    <td>${product.name}</td>
                    <td>${product.short_description}</td>
                    <td>${product.price}</td>
                    <td>${product.vendor.name}</td>
                    <td>${product.city.name}</td>
                    <td>
                        <a href="/admin/products/${product.id}/edit" class="btn btn-primary">Edit</a>
                        <button class="btn btn-danger" onclick="deleteProduct(${product.id})">Delete</button>
                    </td>
                </tr>
            `;
        }
    </script>
@endsection
