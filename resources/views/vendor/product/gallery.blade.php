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

        .single-image{
            /* height: 100%; */
            border:1px solid gray;
        }
        .single-image>button{
            border-radius: 0px;
        }

        
    </style>
@endsection
@section('title', 'Vendor Edit Products')

@section('content')
    @php
        $user=Auth::user();
    @endphp
    <div id="vendor-dashboard-page">
        <div>
            <div class="row">
                @include('vendor.dashboard.sidebar')
                <div class="col-md-8   ">
                    <div class="bg-white shadow mb-3">
                        <div class="card-body " id="jumbotron">
                            <a href="{{ route('vendor.dashboard') }}">Dashboard</a>
                            <a href="{{ route('vendor.product.index',['type'=>1]) }}">Products</a>
                            <span>{{$product->name}}</span>
                            <span>Gallery</span>
                        </div>
                    </div>
                    <form id="add-images" action="{{route('vendor.product.gallery',['product'=>$product->id])}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="type" value="1">
                        <div class="bg-white shadow mb-3">
                            <div class="card-body ">
                                <div class="row m-0">
                                    <div class=" col-12 p-0">
                                        <input type="file" name="image" class="images" required>
                                    </div>
                                    
                                    <div class="col-md-12 p-0 pt-2">
                                        <button class="btn btn-red">Add Images</button>
                                       
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </form>
                   
                    <div class="bg-white shadow mb-3">
                        <div class="card-body " >
                            <div class="row m-0" id="images">
                                @include('vendor.product.gallerylist')
                            </div>
                        </div>
                    </div>
                  
                   
                   
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
    <script>
        var data;
        const url="{{route('vendor.product.gallery',['product'=>$product->id])}}";
        $(document).ready(function() {
          
            $('.images').dropify({});
            $('#add-images').submit(function (e) { 
                e.preventDefault();
                axios.post(this.action,new FormData(this))
                .then((res)=>{
                    $('#images').append(res.data);
                    $('.dropify-clear').click();
                    this.reset();
                })
            });
        });

        function removeImage(id){
            if(confirm('Delete Image')){

                axios.post(url,{'id':id,'type':2})
                    .then((res)=>{
                        $('#image-'+id).remove();    
                    });
                }
        }
    </script>
    @include('vendor.dashboard.imagejs')
    @include('vendor.dashboard.namejs')
    @include('vendor.dashboard.descjs')
@endsection
