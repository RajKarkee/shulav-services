
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('front/head.css')}}">
    <title>{{env('APP_NAME','')}} - @yield('title')</title>
  </head>
  <body>
    <div class="mobile-head">
        <div class="show-menu"></div>
        <div class="logo">
            <img src="{{asset('front/logo.png')}}" alt="" class="logo">
        </div>
        <div class="noti"></div>
    </div>
    <div class="head">
        <div class="menu">
            <div class="menu-section">
                <img src="logo.png" alt="" class="logo">
            </div>
            <div class="menu-section">
                <ul>
                    <li>
                        <a href="" class="active">Home</a>
                    </li>
                    <li>
                        <a href="" >Services</a>
                    </li>
                    <li>
                        <a href="" class="">Become a Seller</a>
                    </li>
                    <li>
                        <a href="" class="">Sign In</a>
                    </li>
                    <li>
                        <a href="" class="btn-menu">Join</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="desc">
            <div class="large">
                Discover
            </div>
            <div class="small">
                your amazing city
            </div>
            <div class="search">
                <div class="row">
                    <div class="col-md-5">
                        <div class="search-item">
                            <div class="text">
                                What
                            </div>
                            <input type="text" placeholder="Ex: Electric Repair, Ac Repair, Tuiton Teacher">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="search-item">
                            <div class="text">
                                Where
                            </div>
                            <input type="text" placeholder="Ex: Kathmandu, Biratnagar">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button>Search</button>
                    </div>
                </div>
            </div>
            <div id="rec">
                <div class="rec-title">
                    or, browse one of our recomendation
                </div>
                <div class="row m-0 justify-content-start">
                        <div class=" rec-item ">
                            <div class="logo">
                                <img src="location.svg" alt="" srcset="">
                            </div>
                            <div class="d-flex justify-content-center">

                                <div class="line">

                                </div>
                            </div>
                            <div class="text">
                                Ac Repair asdfasd asdfsd
                            </div>
                        </div>
                        <div class=" rec-item ">
                            <div class="logo">
                                <img src="location.svg" alt="" srcset="">
                            </div>
                            <div class="d-flex justify-content-center">

                                <div class="line">

                                </div>
                            </div>
                            <div class="text">
                                Ac Repair asdfasd asdfsd
                            </div>
                        </div>
                        <div class=" rec-item ">
                            <div class="logo">
                                <img src="location.svg" alt="" srcset="">
                            </div>
                            <div class="d-flex justify-content-center">

                                <div class="line">

                                </div>
                            </div>
                            <div class="text">
                                Ac Repair asdfasd asdfsd
                            </div>
                        </div>
                        <div class=" rec-item ">
                            <div class="logo">
                                <img src="location.svg" alt="" srcset="">
                            </div>
                            <div class="d-flex justify-content-center">

                                <div class="line">

                                </div>
                            </div>
                            <div class="text">
                                Ac Repair asdfasd asdfsd
                            </div>
                        </div>
                        <div class=" rec-item ">
                            <div class="logo">
                                <img src="location.svg" alt="" srcset="">
                            </div>
                            <div class="d-flex justify-content-center">

                                <div class="line">

                                </div>
                            </div>
                            <div class="text">
                                Ac Repair asdfasd asdfsd
                            </div>
                        </div>
                        <div class=" rec-item ">
                            <div class="logo">
                                <img src="location.svg" alt="" srcset="">
                            </div>
                            <div class="d-flex justify-content-center">

                                <div class="line">

                                </div>
                            </div>
                            <div class="text">
                                Ac Repair asdfasd asdfsd
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="second" >
        <div class="title">
            <strong>See</strong> How it works?
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="how">
                    <div class="title">
                        <div>
                            1
                        </div>
                    </div>
                    <div class="text">
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ullam ratione voluptatum saepe quae laborum excepturi esse assumenda, consequatur cumque iusto accusantium a qui. Dolor, possimus nisi aut molestiae rerum autem?
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/43f4dfae9c.js" crossorigin="anonymous"></script>
    @include('share.citychooserjs')

  </body>
</html>
