@extends('front.page')
@section('css')
    <link rel="stylesheet" href="{{ asset('front/vendor/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('front/vendor/product.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css" integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .dropify-wrapper .dropify-message p {
            margin: 5px 0 0;
            font-size: 16px;
        }
    </style>
@endsection
@section('title', 'Vendor Edit '.($type==1?'Products':'Services'))

@section('content')

    <div id="vendor-dashboard-page">
        <div>
            <div class="row">
                @include('vendor.dashboard.sidebar')
                <div class="col-md-8   ">
                    <div class="bg-white shadow mb-3">
                        <div class="card-body " id="jumbotron">
                            <a href="{{ route('vendor.dashboard') }}">Dashboard</a>
                            <a href="{{ route('vendor.product.index',['type'=>$type]) }}">{{$type==1?'Products':'Services'}}</a>
                            <span>{{$product->name}}</span>
                            <span>Edit</span>
                        </div>
                    </div>
                    @if($errors->any())
                    <div class="bg-white shadow mb-3">
                        <div class="card-body ">
                            @foreach ($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{$error}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                              </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    <form action="{{route('vendor.product.edit',['product'=>$product->id])}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="bg-white shadow mb-3">
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="file" name="image" id="image" class="form-control" data-default-file="{{asset($product->image)}}">
                                    </div>
                                    <div class="col-12"><hr></div>
                                    <div class="col-md-12">
    
                                        <div class="form-group mb-3">
                                            <label class="fw-bolder" for="name">Name</label>
                                            <input type="text" required id="name" class="form-control" name="name" value="{{$product->name}}" >
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group mb-3">
                                            <label class="fw-bolder" for="price">Price</label>
                                            <input type="number" required min="1" name="price" id="price" class="form-control" value="{{$product->price}}" >
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group mb-3">

                                            <label class="fw-bolder" for="short_desc"> Unit <span class="text-danger">*</span></label>
                                            <input type="text" required name="short_desc" id="short_desc" cols="30" rows="10"
                                                class="form-control" value="{{$product->short_desc}}">
                                        </div>
                                    </div>
                                    {{-- <div class="col-12">
                                        <div class="form-group mb-3">
    
                                        <label class="fw-bolder" for="short_desc">Short Description</label>
                                        <textarea name="short_desc" id="short_desc" cols="30" rows="10" class="form-control" >{{$product->short_desc}}</textarea>
                                        </div>
                                    </div> --}}
                                    <div class="col-12">
                                        <div class="form-group mb-3">
    
                                        <label class="fw-bolder" for="desc">Description</label>
                                        <textarea name="desc" id="desc" cols="30" rows="10" class="form-control">{!!$product->desc!!}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button class="btn btn-red">Update {{$type==1?'Product':'Service'}}</button>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </form>
                   
                </div>
            </div>
        </div>
                    


            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js" integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.tiny.cloud/1/4adq2v7ufdcmebl96o9o9ga7ytomlez18tqixm9cbo46i9dn/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        var data;
        $(document).ready(function() {
            tinymce.init({
                invalid_elements : "script",
                selector: '#fulldesc',
                plugins: 'advlist autolink lists link  charmap  hr anchor pagebreak',
                toolbar_mode: 'floating',
            });
            $('#image').dropify({});
            
        });
    </script>
    @include('vendor.dashboard.imagejs')
    @include('vendor.dashboard.namejs')
    @include('vendor.dashboard.descjs')
@endsection
