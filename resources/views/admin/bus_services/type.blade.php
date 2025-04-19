@extends('admin.layout.app')

@section('s-title')
<li class="breadcrumb-item">Bus</li>
<li class="breadcrumb-item">Bus Services</li>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('admin/plugins/drophify/css/dropify.min.css') }}">
@endsection

@section('page-option')

{{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addBusTypeModal">
    Add Bus Type
</button> --}}

<a type="button" class="btn btn-primary" href="{{ route('admin.busServices.type.add') }}">Add Bus type</a>
@endsection

@section('content')
<h3>Bus Type</h3>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="container">
    <table class="table mt-3">
        <thead>
            <tr>
                <th>Name</th>
                <th>Image</th>
                <th>Description</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
         @foreach($busTypes as $busType)
            <tr>
                <td>{{ $busType->bus_type_name }}</td>
               <td> <img src="{{ Storage::url($busType->image_1) }}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;" alt="Bus Type Image"></td>

                <td>{{ $busType->short_description }}</td>
                <td>{{ $busType->created_at->format('d-m-Y') }}</td>
                <td>
              
                    <form action="{{ route('admin.busServices.type.delete', $busType->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE') 
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                            Delete
                        </button>
                    </form>
             
                    
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal: Add Bus Type (Bootstrap 4) -->
<!-- Modal: Add Bus Type (Bootstrap 4) -->

@endsection

@section('js')
{{-- Bootstrap 4 dependencies (include if not already loaded in layout) --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
@endsection
