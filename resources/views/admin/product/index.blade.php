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
            <form action="{{ route('admin.products.loadData') }}" method="POST" class="row" onSubmit="loadData(this,event)">
                @csrf
                <div class="col-md-4 mb-2">
                    <label for="category_id" class="form-label">Service Category</label>
                    <select name="category_id" id="category_id" class="form-control">
                        <option value="">All Categories</option>

                    </select>
                </div>

                <div class="col-md-4 mb-2">
                    <label for="city_id" class="form-label">City</label>
                    <select name="city_id" id="city_id" class="form-control">
                        <option value="">All Cities</option>

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
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="product-list">

                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('script')
    <script>
        const cities = @json(\App\Helper::getCitiesMini());
        const categories = @json(\App\Helper::getCategories());
        var cityMap = {};
        var categoryMap = {};
        $(document).ready(function() {
            $('#category_id').append(categories.filter(category => category.type != 3).map(category => {
                return `<option value="${category.id}">${category.name}</option>`;
            }));
            $('#city_id').append(cities.map(city => {
                return `<option value="${city.id}">${city.name}</option>`;
            }));
            cities.forEach(city => {
                cityMap[city.id] = city.name;
            });
            categories.forEach(category => {
                categoryMap[category.id] = category.name;
            })
        });


        function loadData(form, event) {
            event.preventDefault();
            const editURL = "{{ route('admin.products.edit', ['product_id' => 'xxx_id']) }}";
            const deleteURL = "{{ route('admin.products.del', ['product_id' => 'xxx_id']) }}";
            const formData = new FormData(form);
            axios.post(form.action, formData)
                .then(response => {
                    $('#product-list').html(
                        response.data.map(data => {
                            return `<tr id="product-${data.id}">
                                <td>${data.name}</td>
                                <td>${data.short_desc}</td>
                                <td>${data.price}</td>
                                <td>${cityMap[data.city_id]}</td>
                                <td>${categoryMap[data.category_id]}</td>
                                <td>
                                    <a href="${editURL.replace('xxx_id',data.id)}" class="btn btn-sm btn-info">Edit</a>
                                    <a href="${deleteURL.replace('xxx_id',data.id)}" class="btn btn-sm btn-danger">Del</a>
                                </td>
                            </tr>`;
                        }).join('')
                    );
                })
                .catch(error => {
                    console.error(error);
                });
        }
    </script>
@endsection
