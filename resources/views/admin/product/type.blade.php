@extends('admin.layout.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('admin/plugins/drophify/css/dropify.min.css') }}">
@endsection

@section('page-option')
    <button type="button" class="btn btn-primary" data-toggle="modal" onclick="showAdd()">Add New</button>
@endsection

@section('s-title')
    <li class="breadcrumb-item">Products</li>
@endsection
@section('content')


@endsection

@section('script')
    <script src="{{ asset('admin/plugins/drophify/js/dropify.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js"></script>


@endsection
