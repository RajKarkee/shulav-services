@extends('admin.layout.app')

@section('s-title')
    <li class="breadcrumb-item">E-Ticketing</li>
    <li class="breadcrumb-item">Vehicles</li>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('admin/plugins/drophify/css/dropify.min.css') }}">
@endsection

@section('page-option')
    <a type="button" class="btn btn-primary" href="{{ route('admin.busServices.vehicle.add') }}">Add</a>
@endsection

@section('content')
    <div class="card shadow">
        <div class="card-body">
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Capacity</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vehicles as $vehicle)
                        <tr>
                            <td>{{ $vehicle->name }}</td>
                            <td>{{ $vehicle->capacity }}</td>
                            <td>
                                <a href="{{ route('admin.busServices.vehicle.edit', ['vehicle_id' => $vehicle->id]) }}" class="btn btn-primary">Edit</a>
                                <a href="{{ route('admin.busServices.vehicle.delete',['vehicle_id' =>$vehicle->id]) }}" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
