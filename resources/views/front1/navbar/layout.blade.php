<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shulav trades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />


    <link rel="stylesheet" href="{{ asset('front1/index.css') }}">
    @yield('css')
</head>

<body>
    @php
        $serviceCategories = DB::table('categories')
            ->whereNull('parent_id')
            ->get(['id', 'name']);
        $cities = DB::table('cities')
            ->limit(5)
            ->get(['id', 'name']);
        $locations = DB::table('locations')
            ->limit(5)
            ->get(['id', 'name']);

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
                    Location <i class="fas fa-chevron-down"></i>
                </div>
                @if (Auth::check())
                    <div class="user-profile" style="position: relative">
                        <div class="dropdown user-dropdown" style="cursor: pointer">
                            <img src="{{ Auth::user()->profile && Auth::user()->profile->profile_picture ? Auth::user()->profile->profile_picture : asset('media/user.png') }}"
                                class="profile-pic dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown"
                                aria-expanded="false"
                                style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #ccc; cursor: pointer;">
                            <i class="fas fa-chevron-down dropdown-toggle" id="userDropdownIcon"
                                data-bs-toggle="dropdown" aria-expanded="false"
                                style="margin-left: 5px; cursor: pointer;"></i>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdownIcon"
                                style="position: absolute; top: 100%; left: auto; right: 0; margin-top: 5px;">
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        <span class="username">{{ Auth::user()->name }}</span>
                    </div>
                @else
                    <div class="login" data-bs-toggle="modal" data-bs-target="#loginModal">Login</div>
                @endif





            </div>
        </div>
            <div class="categories-bar">
                <div class="all-categories">
                    ALL CATEGORIES <i class="fas fa-chevron-down"></i>
                </div>
                <nav>
                    <ul>
                        @foreach ($serviceCategories as $category)
                            <li><a href="{{ route('product.library', $category->id) }}">{{ $category->name }}</a></li>
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
                        @foreach ($cities as $city)
                            <li><a href="#">{{ $city->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="footer-column">
                    <h5>TRENDING LOCATIONS</h5>
                    <ul>
                        @foreach ($locations as $location)
                            <li><a href="#">{{ $location->name }}</a></li>
                        @endforeach
                        {{-- <li><a href="#">Tarahara</a></li>
                        <li><a href="#">Bhedetar</a></li>
                        <li><a href="#">Hile</a></li>
                        <li><a href="#">Soman</a></li> --}}
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
                        <a href="#"><img src="{{ asset('media/google-play.png') }}"
                                alt="Get it on Google Play"></a>
                        <a href="#"><img src="{{ asset('media/app-store.png') }}"
                                alt="Download on the App Store"></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            {{-- <div class="brand-logos">
                <div class="logo-item"><img src="{{ asset('media/car22.jpg') }}" alt="CarTrade Tech Group"></div>
                <div class="logo-item"><img src="{{ asset('media/bike22.png') }}" alt="Bike"></div>
                <div class="logo-item"><img src="{{ asset('media/electronics22.png') }}" alt="Electronic"></div>
                <div class="logo-item"><img src="{{ asset('media/bikewale.png') }}" alt="Bikewale"></div>
                <div class="logo-item"><img src="{{ asset('media/cartrade.png') }}" alt="CarTrade"></div>
                <div class="logo-item"><img src="{{ asset('media/mobility-outlook.png') }}" alt="Mobility Outlook">
                </div>
            </div> --}}
            <div class="copyright">
                <p>All rights reserved © Needtechnosoft</p>
                <a href="#">Help - Sitemap</a>
            </div>
        </div>
    </footer>

    <!-- Location Modal -->
    <div class="modal fade" id="locationModal" tabindex="-1" aria-labelledby="locationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content location-dropdown">
                <div class="modal-header">
                    <h5 class="modal-title" id="locationModalLabel">Select Location</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0">
                    @foreach ($cities as $city)
                        <div class="location-option">
                            <span>{{ $city->name }}</span>
                            <i class="fas fa-check"></i>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>



    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content login-modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4 class="login-title text-center">Close deals from the comfort of your home.</h4>
                    <div class="login-form-container">
                        <form class="login-form" method="post" action="{{ route('User.login') }}">
                            @csrf
                            @if (session('message'))
                                <div class="alert alert-success">

                                    {{ session('message') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <script>
                                    $(document).ready(function() {
                                        var loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
                                        loginModal.show();
                                    });
                                </script>
                                <div class="alert alert-danger">

                                    {{ session('error') }}
                                </div>
                            @endif
                            <div class="mb-3">
                                <input type="email" name="email" class="form-control" placeholder="Email"
                                    required>
                            </div>
                            <div class="mb-3">
                                <input type="password" name="password" class="form-control" placeholder="Password"
                                    required>
                            </div>
                            <button type="submit" class="btn btn-login w-100">Login with Email</button>
                        </form>
                        <div class="or-divider"><span>OR</span></div>
                        <a href="{{ route('loginPhone') }}"class="btn btn-phone w-100 mb-3">
                            <i class="fas fa-phone-alt"></i> Continue with phone
                        </a>
                        <a href="{{ route('loginGoogle') }}" class="btn btn-google w-100 mb-3">
                            <i class="fab fa-google me-2"></i> Continue with Google
                        </a>

                        <div class="login-footer text-center mt-3">
                            <p class="small text-muted">All your personal details are safe with us.</p>
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

    <!-- Bootstrap JS Bundle - Required for modals to work -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

    <!-- Your custom JavaScript files -->
    <script src="{{ asset('front1/js/main.js') }}"></script>
    <script src="{{ asset('front1/js/nextpg.js') }}"></script>


    @yield('script')
</body>

</html>
