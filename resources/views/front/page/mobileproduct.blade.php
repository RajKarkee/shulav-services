<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $product->name }}</title>
    <link rel="stylesheet" href="{{asset('front/mobileproduct.css')}}">
    <meta name="description" content="{{ strip_tags($product->desc) }}" />
    <meta property="og:url" content="{{ route('pshare', ['product' => $product->id]) }}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $product->name }}" />
    <meta property="og:description" content="{{ strip_tags($product->desc) }}" />
    <meta property="og:image" content="{{ asset($product->image) }}" />
    @php
        $shares_show = ['facebook', 'gmail', 'skype', 'whatsapp', 'instagram', 'twitter', 'telegram', 'messenger'];
    @endphp
   
    @foreach ($shares_show as $site)
        <style>
            .st-btn[data-network='{{ $site }}'] {
                display: inline-block !important;
            }

        </style>
    @endforeach
</head>

<body>
    
    <a class="back" onclick="back()">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="white" d="M257.5 445.1l-22.2 22.2c-9.4 9.4-24.6 9.4-33.9 0L7 273c-9.4-9.4-9.4-24.6 0-33.9L201.4 44.7c9.4-9.4 24.6-9.4 33.9 0l22.2 22.2c9.5 9.5 9.3 25-.4 34.3L136.6 216H424c13.3 0 24 10.7 24 24v32c0 13.3-10.7 24-24 24H136.6l120.5 114.8c9.8 9.3 10 24.8.4 34.3z"/></svg>
    </a>
    <span class="share" data-network="sharethis"
        onclick="event.stopPropagation();document.querySelector('#st-1 .st-btn[data-network=\'sharethis\']').click();">
        <span>
            Share
        </span>    
    </span>
    <div class="mobile-product-page">
        <div class="image">
            <img src="{{asset($product->image)}}" class="w-100" alt="">
        </div>
        <div class="p-3">
            <div class="name">
                {{$product->name}}
            </div>
            <div class="price">
                Rs {{$product->price}} / {{$product->short_desc}}
            </div>
            <hr class="m-1">
            <div class="desc">
                {!! $product->desc !!}
            </div>

        </div>
    </div>
    <div class="sharethis-sticky-share-buttons" data-url="{{ route('pshare', ['product' => $product->id]) }}"></div>
    <script type="text/javascript"
        src="https://platform-api.sharethis.com/js/sharethis.js#property=61da3087179d600019788988&product=sticky-share-buttons"
        async="async"></script>
    <script>
        function back() {
            window.location.href="{{asset('single-vendor')}}/"+localStorage.getItem('uname');
        }
    </script>
</body>

</html>
