<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')
    @yield('facebook')
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('front/head.css') }}">
    <script src="{{asset('admin/js/custom.js')}}"></script>
    @yield('css')
    <meta name="theme-color" content="#FF5A5F" />
    <title>{{ env('APP_NAME', '') }} - @yield('title')</title>
</head>

<body>


    @if (Auth::check())
       @include('front.sidebar')
    @endif
   <div  id="page-holder" data-role="close-sidebar">
   <div class="head page">

   @if (Auth::check())
       @include('front.menu')
   @endif

    </div>
    <div>
        <div class="jumbotron hide-on-menu" >
            <img src="{{asset('front/page/jumbotron.jpg')}}" alt="">
            <div class="jumbotron-overlay">
                <div class="row m-0 w-100">
                    <div class="col-md-9">
                        <ul class="pages">
                            <li> <a href="{{route('index')}}">Home</a></li>
                            @yield('jumbotron')
                        </ul>
                    </div>
                    <div class="col-md-3 text-end jumbotron-title">
                        @yield('title')
                    </div>
                </div>
            </div>
        </div>
    </div>

    @yield('content')

    {{-- @include('front.index.footer') --}}
    </div>
    <button onclick="goToTop()" class="go-to-top" >
        <i class="fas fa-arrow-up"></i>
    </button>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://kit.fontawesome.com/43f4dfae9c.js" crossorigin="anonymous"></script>

    <script src="{{asset('front/js/page.js')}}"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-analytics.js"></script>

    {{-- <script src="{{asset('front/js/firebase.js')}}" ></script> --}}
    <script>
        axios.defaults.headers.common = {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN' : document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        };
    </script>
    @yield('js')
    <script>

    </script>

    @include('share.citychooserjs')

</body>

</html>
