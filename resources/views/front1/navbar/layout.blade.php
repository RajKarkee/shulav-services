<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OLX</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ asset('front1/index.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    @yield('css')
</head>

<body>
    @php
        $serviceCategories = DB::table('categories')
            ->whereNull('parent_id')
            ->get(['id', 'name']);
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
                    Location <i class="fas fa-chevron-down"></i>
                </div>
            </div>
            {{-- <div class="favorites">
                <i class="far fa-heart"></i>
            </div> --}}
            @if (Auth::check())
                
          
                <div class="user-profile">
                    <div class="dropdown user-dropdown">
                        <img src="{{ asset('media/user.png') }}" class="profile-pic dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #ccc;">
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="#">Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>

                    <style>
                        .user-dropdown .dropdown-menu {
                            min-width: 150px;
                            padding: 10px;
                            border-radius: 8px;
                            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                            background-color: #fff;
                        }

                        .user-dropdown .dropdown-item {
                            font-size: 14px;
                            color: #333;
                            padding: 8px 12px;
                            transition: background-color 0.3s ease;
                        }

                        .user-dropdown .dropdown-item:hover {
                            background-color: #f8f9fa;
                        }

                        .user-dropdown .dropdown-divider {
                            margin: 5px 0;
                        }
                    </style>

                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const dropdownToggle = document.getElementById('userDropdown');
                            dropdownToggle.addEventListener('click', function (e) {
                                e.stopPropagation();
                                this.nextElementSibling.classList.toggle('show');
                            });

                            document.addEventListener('click', function () {
                                const dropdownMenu = document.querySelector('.user-dropdown .dropdown-menu');
                                if (dropdownMenu.classList.contains('show')) {
                                    dropdownMenu.classList.remove('show');
                                }
                            });
                        });
                    </script>
                    <span class="username">{{ Auth::user()->name }}</span>
                </div>
                
            @else

                <a href="#" class="login" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                

            @endif
   


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
                        <li><a href="#">Tarahara</a></li>
                        <li><a href="#">Bhedetar</a></li>
                        <li><a href="#">Hile</a></li>
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
                        <a href="#"><img src="{{ asset('media/google-play.png') }}"
                                alt="Get it on Google Play"></a>
                        <a href="#"><img src="{{ asset('media/app-store.png') }}"
                                alt="Download on the App Store"></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="brand-logos">
                <div class="logo-item"><img src="{{ asset('media/car22.jpg') }}" alt="CarTrade Tech Group"></div>
                <div class="logo-item"><img src="{{ asset('media/bike22.png') }}" alt="Bike"></div>
                <div class="logo-item"><img src="{{ asset('media/electronics22.png') }}" alt="Electronic"></div>
                <div class="logo-item"><img src="{{ asset('media/bikewale.png') }}" alt="Bikewale"></div>
                <div class="logo-item"><img src="{{ asset('media/cartrade.png') }}" alt="CarTrade"></div>
                <div class="logo-item"><img src="{{ asset('media/mobility-outlook.png') }}" alt="Mobility Outlook">
                </div>
            </div>
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
                        <button class="btn btn-phone w-100 mb-3">
                            <i class="fas fa-phone-alt"></i> Continue with phone
                        </button>
                        <button class="btn btn-google w-100 mb-3">
                            <img src="{{ asset('media/google.png') }}" alt="Google" class="google-icon"> Continue
                            with Google
                        </button>
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

    <!-- Your custom JavaScript files -->
    <script src="{{ asset('front1/js/main.js') }}"></script>
    <script src="{{ asset('front1/js/nextpg.js') }}"></script>
    <script src="{{ asset('front1/js/imageSlider.js') }}"></script>

    @yield('script')
</body>

</html>
