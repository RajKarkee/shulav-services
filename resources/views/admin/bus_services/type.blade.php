@extends('admin.layout.app')

@section('s-title')
    <li class="breadcrumb-item">Bus</li>
    <li class="breadcrumb-item">Bus Types</li>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('admin/plugins/drophify/css/dropify.min.css') }}">
@endsection

@section('page-option')
    <a type="button" class="btn btn-primary" href="{{ route('admin.busServices.type.add') }}">Add Bus type</a>
@endsection

@section('content')
    <div class="card shadow">
        <div class="card-body">
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($busTypes as $busType)
                        <tr>
                            <td>{{ $busType->bus_type_name }}</td>
                            <td>{{ $busType->created_at->format('d-m-Y') }}</td>
                            <td>
                                <a href="{{ route('admin.busServices.type.delete', ['id' => $busType->id]) }}"
                                    class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
@endsection
