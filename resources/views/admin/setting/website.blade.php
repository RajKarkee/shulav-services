@extends('admin.layout.app')
@section('css')
    <style>
        .sm-title {
            font-weight: 600;
            font-size: 1.2rem;

        }

        .form-control {
            border-radius: 0px;
        }

    </style>
    <link rel="stylesheet" href="{{ asset('admin/plugins/drophify/css/dropify.min.css') }}">

@endsection
@section('page-option')
@endsection
@section('s-title')


    <li class="breadcrumb-item ">
        Website
    </li>
    <li class="breadcrumb-item active">
        Settings
    </li>
@endsection
@section('content')

    <div class="card shadow mb-3">
        <div class="card-body">

            <form action="{{ route('admin.setting.front.website') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 pb-2">
                        <label for="meta_banner">Share Banner</label>
                        <input type="file" name="meta_banner" id="meta_banner" class="form-control photo" accept="image/*"
                            data-default-file="{{ asset($data->meta_banner) }}">
                    </div>
                    <div class="col-md-6 pb-2">
                        <label for="meta_description">Share Description</label>
                        <textarea required name="meta_description" id="meta_description"
                            class="form-control  ">{{ $data->meta_description }}</textarea>
                    </div>

                    <div class=" col-md-6 pb-2">
                        <label for="type">Pricing</label>
                        <select name="type" id="type" class="form-control  ">
                            <option value="0" {{ $data->type == 0 ? 'selected' : '' }}>Single Price Lifetime</option>
                            <option value="1" {{ $data->type == 1 ? 'selected' : '' }}>Single Price Yearly</option>
                            <option value="2" {{ $data->type == 2 ? 'selected' : '' }}>Per Servie Price Lifetime</option>
                            <option value="3" {{ $data->type == 3 ? 'selected' : '' }}>Per Servie Price yearly</option>
                        </select>
                    </div>
                    <div class=" col-md-6 pb-2">
                        <label for="type">Lifetime Single Price </label>
                        <input type="number" min="0" required name="price" id="price" class="form-control  "
                            value="{{ $data->price }}" />
                    </div>

                    <div class="py-2">
                        <button class="btn btn-primary">Save</button>
                    </div>
            </form>
        </div>
    </div>


@endsection
@section('script')
    <script src="{{ asset('admin/plugins/drophify/js/dropify.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.photo').dropify();

        });
    </script>
@endsection
