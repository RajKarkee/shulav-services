@extends('front.page')

@section('meta')
    <meta name="description" content="{{ $product->desc }}" />
    <meta property="og:url" content="{{ route('product', ['product' => $product->id]) }}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $product->name }}" />
    <meta property="og:description" content="{{ $product->desc }}" />
    <meta property="og:image" content="{{ asset($product->image) }}" />
   
@endsection
@section('title', $product->name)
@section('jumbotron')
    <li>Product</li>
    <li>{{ $product->name }}</li>
@endsection
@section('css')
    @php
    $shares_show = ['facebook', 'gmail', 'skype', 'whatsapp', 'instagram', 'twitter', 'telegram', 'messenger'];
    @endphp
    <style>
        .jumbotron {
            display: none;
        }

        #st-1,
        .st-logo,
        .st-disclaimer,
        .st-btn {
            display: none !important;
        }

        .opening-hour>td:first-child{
            font-weight: 600;
        }
        .bar{
            width:75px;
            height: 3px;
            background: var(--red-primary);
        }
        .data .title{
            font-weight: 600;
        }
        .data .detail a{
            text-decoration: none;
            color: inherit;
        }

        .gallery .item{

        }
    </style>
    @foreach ($shares_show as $site)
        <style>
            .st-btn[data-network='{{ $site }}'] {
                display: inline-block !important;
            }

        </style>
    @endforeach
@endsection
@section('content')
    <div class="single-product-page">
        <div class="container my-2 my-md-5">

            <div class="bg-white shadow mb-3 mb-md-5">
                <div class="row">
                    <div class="col-md-3 bg-white p-0">
                        <div id="image" class="shadow">
                            <img class="w-100" src="{{asset($product->image)}}" alt="">
                        </div>
                        
                    </div>
                    <div class="col-md-9 bg-white py-2 px-3">
                        <hr class="d-block d-md-none">
                        <div class="d-flex align-items-start  ">

                            <div class="product-name fw-bolder" style="width: calc(100% - 80px);"  >
                                {{$product->name}} 
                            </div> 
                            <div class="share" style="width:80px;" data-network="sharethis" onclick="event.stopPropagation();$('#st-1 .st-btn[data-network=\'sharethis\']')[0].click();">
                                <span>
                                    Share
                                </span>
                                <i class="fas ms-1 fa-share-alt copy"></i>
                            </div>
                        </div>
                        <div class="product-price">
                            Rs. {{$product->price+0}} / {{$product->short_desc}}
                        </div> 
                        <hr>
                        <div class="text-justify">
                            {!! $product->desc !!}
                        </div>
                       
                    </div>
                </div>
               
            </div>

            <div class="bg-white shadow row mb-3"  >
                <div class="card-body">
                    <h5 class="fw-bolder">
                        About Vendor
                    </h5>
                    <div class="bar mb-2"></div>
                    
                    <div class="row m-0">
                        <div class="col-12 col-md-4">
                            <div class="data">

                                <div class="title">
                                    Name
                                </div>
                                <div class="detail">
                                    <i class="fa-solid fa-user-tie me-1"></i>
                                    <span>{{$vendor->name}}</span>
                                </div>
                            </div>

                        </div>
                        @if (Auth::check())
                            
                        @if ($vendor->email)
                        <div class="col-12 col-md-4">
                            <div class="data">

                                <div class="title">
                                    Email
                                </div>
                                <div class="detail">
                                    <i class="far me-1 fa-envelope"></i>
                                    <a href="mailto:{{ $vendor->email }}">{{ $vendor->email }}</a>
                                </div>
                            </div>

                        </div>
                        @endif
                        @if ($vendor->phone)
                        <div class="col-12 col-md-4">
                            <div class="data">

                                <div class="title">
                                    Phone
                                </div>
                                <div class="detail">
                                    <i class="fas me-1 fa-mobile-alt"></i>
                                    <a href="tel:{{ $vendor->phone }}">{{ $vendor->phone }}</a>
                                </div>
                            </div>

                        </div>
                        @endif
                        @endif
                        <div class="col-12 col-md-4">
                            <div class="data">

                                <div class="title">
                                    City
                                </div>
                                <div class="detail">
                                    <i class="fas me-1 fa-map-marker-alt"></i>
                                    <span>{{ $vendor->city }}</span>
                                </div>
                            </div>

                        </div>
                        <div class="col-12 col-md-4">
                            <div class="data">

                                <div class="title">
                                    Street Address
                                </div>
                                <div class="detail">
                                    <i class="far me-1 fa-address-card"></i>
                                    <span>{{ $vendor->address }}</span>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-4 col-12 pt-md-0 pt-2 d-flex align-items-end" >
                            <a class="text-red text-decoration-none" href="{{route('vendor',['username'=>$vendor->username])}}"><i class="fa-solid fa-eye"></i>Contact Vendor</a>
                        </div>
                        <div class="col-md-4 col-12 pt-md-0 pt-2 d-flex align-items-end" >
                            <a class="text-red text-decoration-none" href="{{route('vendor',['username'=>$vendor->username])}}"><i class="fa-solid fa-eye"></i> View Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            @if ($images->count()>0)
            <style>
                .item{
                    width:20%;
                    padding:2.5px;
                }
                .item>img{
                    width:100%;
                }
                @media (max-width:425px){
                    .item{
                        width:33.33%;
                    }
                }
            </style>
            <div id="gallery" class="gallery">
                @php
                    $i=0;
                @endphp
                @foreach ($images as $file)   
                <div class="item" data-index="{{$i++}}">
                  <img data-fancybox="gallery" data-src="{{asset($file->file)}}"  src="{{asset($file->file)}}" alt="">
                </div>
                @endforeach 
              </div>
            @endif
        </div>
    </div>
    <div  class="sharethis-sticky-share-buttons" data-url="{{ route('pshare', ['product' => $product->id]) }}"></div>
    <a href="" id="pop" target="blank"></a>
@endsection
@section('js')
    <script>
        function reImage(ele){
            $(ele).parent().height($(ele).parent().width()*0.6);
        }
    </script>
    <script type="text/javascript"
        src="https://platform-api.sharethis.com/js/sharethis.js#property=61da3087179d600019788988&product=sticky-share-buttons"
        async="async"></script>
    @if ($images->count()>0)
        @include('front.page.product.gallery')
    @endif
        
@endsection
