@extends('admin.layout.app')
@section('css')
    <link rel="stylesheet" href="{{ asset('admin/plugins/drophify/css/dropify.min.css') }}">
@endsection

@section('s-title')
    <li class="breadcrumb-item">Realstate Details</li>
@endsection
@section('content')
    <div class="card shadow">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 text">
                    <h4>{{ $realstate->name }}</h4>
                    <div>{{ $realstate->contacts }}</div>
                    <p>{{ $realstate->desc }}</p>
                    <img src="/{{ $realstate->image }}" class="img img-thumbnail" alt="" style="height: 200px;">
                </div>
                @php
                    $gallery = App\Models\RealstateImage::where('realstate_id', $realstate->id)->get();
                @endphp
                <div class="col-md-6 text-center">

                    <div class="gallery">
                        <div class="row">
                            @foreach ($gallery as $item)
                                <div class="col-md-4">
                                    <img src="/{{ $item->image }}" alt="" class="img img-thumbnail">
                                    <a href="{{route('admin.realstates.imagedelete',$item->id)}}" class="text-danger" onclick="return confirm('Are you sure?');">
                                       Delete
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <form action="{{ route('admin.realstates.gallery')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="id" value="{{ $realstate->id }}">
                            <div class="col-md-12" id="addimage">
                                <label for="Gallery">Gallery Image</label>
                                <input type="file" class="dropify" name="gallery[]" multiple id="gallery" data-default="" required>
                            </div>
                            <div class="p-3">
                                <button class="btn btn-primary">Upload</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('admin.realstate.add')
    @include('admin.realstate.edit')
@endsection

@section('script')
    <script src="{{ asset('admin/plugins/drophify/js/dropify.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js"
        integrity="sha512-u9akINsQsAkG9xjc1cnGF4zw5TFDwkxuc9vUp5dltDWYCSmyd0meygbvgXrlc/z7/o4a19Fb5V0OUE58J7dcyw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        var state = 1;
        $(document).ready(function() {
            $('.dropify').dropify();
        });
    </script>
@endsection
