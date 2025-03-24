@extends('admin.layout.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/plugins/drophify/css/dropify.min.css') }}">
@endsection
@section('page-option')
<a type="button" class="btn btn-primary" href="{{route('admin.service.create')}}">Add Service</a>
@endsection
@section('s-title')
    <li class="breadcrumb-item">Services</li>
@endsection
@section('content')
    <div class="container">
        <h1>Services</h1>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Rate</th>
                    <th>Type</th>
                    <th>Active</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $service)
                    <tr>
                        <td>{{ $service->name }}</td>
                        <td>{{ $service->rate ?? 'N/A' }}</td>
                        <td>
                            @switch($service->type)
                                @case(1) Normal Service @break
                                @case(2) Hotel & Restaurants @break
                                @case(3) Bus Ticket @break
                                @case(4) Plane Ticket @break
                                @case(5) Vehicle Rent @break
                                @default N/A
                            @endswitch
                        </td>
                        <td>{{ $service->active ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <a href="{{ route('admin.service.edit', $service->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('admin.service.destroy', $service->id) }}" method="POST" style="display: inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
