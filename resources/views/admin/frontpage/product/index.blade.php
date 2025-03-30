@extends('admin.layout.app')
@section('s-title')
    <li class="breadcrumb-item"><a href="{{ route('admin.frontPageSection.index') }}">Front Page Section</a></li>
    <li class="breadcrumb-item">Section Product</li>
@endsection
@section('content')
    <div class="p-4 bg-white shadow">
        <form action="{{ route('admin.frontPageSection.product.index', ['section_id' => $section_id]) }}" method="POST">
            <div class="row">
                @csrf
                <div class="col-md-4">
                    <label for="Product_id">Select Product</label>
                    <select name="product_id" id="product_id" class="form-control">
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-primary">Add Product</button>
                </div>
            </div>
        </form>
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="product-list">
                @foreach ($sectionProducts as $sectionProduct)
                    @php
                        $product = \App\Models\Product::find($sectionProduct->product_id);
                    @endphp
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>
                            <a href="{{ route('admin.frontPageSection.product.del', ['sectionProduct_id' => $sectionProduct->id]) }}"
                                class="btn btn-sm btn-danger">Remove</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
