<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OLX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <link rel="stylesheet" href="{{ asset('front1/index.css') }}">
    @yield('css')
</head>

<body>
    @php
        $serviceCategories = DB::table('categories')->whereNull('parent_id')->get(['id', 'name']);
        $cities = DB::table('cities')->get(['id', 'name']);

    @endphp
    <header>
        <div class="main-header">
            @includeIf('front.index.menu_logo')
            <div class="search-container">
                <input type="text" placeholder="Search 'Cars'" class="search-input" />
                <button class="search-button" aria-label="Search">
                    <i class="fas fa-search"></i>
                </button>
            </div>

            <div class="user-actions">
                <div class="language-selector" data-bs-toggle="modal" data-bs-target="#locationModal">
                    Location
                    <i class="fas fa-chevron-down"></i>
                </div>

            </div>

            <div class="favorites">
                <i class="far fa-heart"></i>
            </div>

            <a href="#" class="login" data-bs-toggle="modal" data-bs-target="#loginModal">
                Login
            </a>


        </div>
        </div>

        <div class="categories-bar">
            <div class="all-categories">
                ALL CATEGORIES
                <i class="fas fa-chevron-down"></i>
            </div>
            <nav>
                <ul>
                    @foreach ($serviceCategories as $category )
                    <li><a href="{{route('product.library',$category->id)}}">  {{ $category->name }}</a></li>
                    @endforeach
                
                </ul>
            </nav>
        </div>
    </header>


    @yield('content')

    <footer>
        <div class="footer-content">
            <div class="footer-top">
                <div class="footer-column">
                    <h5>POPULAR LOCATIONS</h5>
                    <ul>
                        @foreach($cities as $city)
                        <li><a href="#">{{$city->name}}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="footer-column">
                    <h5>TRENDING LOCATIONS</h5>
                    <ul>
                        <li><a href="#">Tarahara</a></li>
                        <li><a href="#">Bhedetar</a></li>
                        <li><a href="#">hile</a></li>
                        <li><a href="#">Soman</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h5>ABOUT US</h5>
                    <ul>
                        <li><a href="#">Sulav rents</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h5>Sulav rents</h5>
                    <ul>
                        <li><a href="#">Blog</a></li>
                        <li><a href="#">Help</a></li>
                        <li><a href="#">Sitemap</a></li>
                        <li><a href="#">Legal & Privacy information</a></li>
                        <li><a href="#">Vulnerability Disclosure Program</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h5>FOLLOW US</h5>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                    <div class="app-downloads">
                        <a href="#"><img src="media/google-play.png" alt="Get it on Google Play"></a>
                        <a href="#"><img src="media/app-store.png" alt="Download on the App Store"></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="brand-logos">
                <div class="logo-item">
                    <img src="media/car22.jpg" alt="CarTrade Tech Group">
                </div>
                <div class="logo-item">
                    <img src="media/bike22.png" alt="Bike">
                </div>
                <div class="logo-item">
                    <img src="media/electronics22.png" alt="electronic">
                </div>
                <div class="logo-item">
                    <img src="media/bikewale.png" alt="Bikewale">
                </div>
                <div class="logo-item">
                    <img src="media/cartrade.png" alt="CarTrade">
                </div>
                <div class="logo-item">
                    <img src="media/mobility-outlook.png" alt="Mobility Outlook">
                </div>
            </div>
            <div class="copyright">
                <p>All rights reserved © Needtechnosoft</p>
                <a href="#">Help - Sitemap</a>
            </div>
        </div>
    </footer>





    <div class="modal fade" id="locationModal" tabindex="-1" aria-labelledby="locationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content location-dropdown">
                <div class="modal-body p-0">
                    @foreach($cities as $city)
                    <div class="location-option selected">
                        <span>{{$city-> name}}</span>
                        <i class="fas fa-check"></i>
                    </div>
                    @endforeach
                    {{-- <div class="location-option">
                        <span>Dharan</span>
                    </div>
                    <div class="location-option">
                        <span>ithari</span>
                    </div>
                    <div class="location-option">
                        <span>jhapa</span>
                    </div>
                    <div class="location-option">
                        <span>Damak</span>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content login-modal">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <h4 class="login-title text-center">Close deals from the comfort of your home.</h4>

                    <div class="login-form-container">

                        <form class="login-form">
                            <div class="mb-3">
                                <input type="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="mb-3">
                                <input type="password" class="form-control" placeholder="Password" required>
                            </div>
                            <button type="submit" class="btn btn-login w-100">Login with Email</button>
                        </form>
                        <div class="or-divider">
                            <span>OR</span>
                        </div>
                        <button class="btn btn-phone w-100 mb-3">
                            <i class="fas fa-phone-alt"></i> Continue with phone
                        </button>

                        <button class="btn btn-google w-100 mb-3">
                            <img src="media/google.png" alt="Google" class="google-icon"> Continue with Google
                        </button>


                        <div class="login-footer text-center mt-3">
                            <p class="small text-muted">
                                All your personal details are safe with us.
                            </p>
                            <p class="small terms-text">
                                If you continue, you are accepting <a href="#">Sulav rents Terms and
                                    Conditions</a> and <a href="#">Privacy Policy</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('front1/js/main.js') }}"></script>
    <script src="{{ asset('front1/js/nextpg.js') }}"></script>
    <script src="{{ asset('front1/js/imageSlider.js') }}"></script>
    @yield('script')

</body>

</html>
