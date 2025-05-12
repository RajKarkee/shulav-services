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

        $data =
            App\Helper::getSetting('minor') ??
            (object) [
                'logo' => '',
                'footer_logo' => '',
            ];
        $products = DB::table('products')->orderBy('created_at', 'desc')->get();
    @endphp

    <header>
        <div class="main-header">
            <div class="logo">
                <a href="{{ route('index') }}">
                    <picture>
                        <source media="(min-width: 768px)" srcset="{{ $data->logo }}">
                        <source media="(max-width: 767px)" srcset="{{ $data->footer_logo }}">
                        <img src="{{ $data->logo ? asset($data->logo) : asset('default-logo.png') }}" alt="Logo12">

                    </picture>
                </a>
            </div>
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
                    @php
                        $user = Auth::user();
                        $userRole = $user->getRole();
                    @endphp
                    @if ($userRole !== 1)
                        <div class="user-profile" style="position: relative">
                            <div class="dropdown user-dropdown" style="cursor: pointer">
                                <img src="{{ Auth::user()->profile && Auth::user()->profile->profile_picture ? Auth::user()->profile->profile_picture : asset('media/user.png') }}"
                                    class="profile-pic dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown"
                                    aria-expanded="false"
                                    style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid #ccc; cursor: pointer;">
                                <i class="fas fa-chevron-down dropdown-toggle" id="userDropdownIcon"
                                    data-bs-toggle="dropdown" aria-expanded="false"
                                    style="margin-left: 5px; cursor: pointer;"></i>
                                <ul class="dropdown-menu dropdown-menu-end" aria-label="userDropdownIcon"
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
                    @endif
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
                        {{-- <form class="login-form" method="post" action="{{ route('User.login') }}">
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
                        <div class="or-divider"><span>OR</span></div> --}}
                        <button class="btn btn-phone w-100 mb-3" data-bs-toggle="modal" data-bs-target="#phoneModal">
                            <i class="fas fa-phone-alt"></i> Continue with phone
                        </button>
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

    <div class="modal fade" id="phoneModal" tabindex="-1" aria-labelledby="phoneModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content phone-modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="phoneModalLabel">Login with Phone</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4 class="login-title text-center">Close deals from the comfort of your home.</h4>
                    <div id="page-login">
                        <div class="holder">

                            <div class="login-form">
                                <div class="controls px-3">
                                    <div class="control mb-3">
                                        <span class="icon">
                                            <i class="fas fa-phone"></i>
                                        </span>
                                        <input type="phone" name="phone" id="phone"
                                            placeholder="Enter Phone No" aria-label="Phone" aria-describedby="Email">
                                    </div>
                                    <div class="control mb-3" id="otp-holder">
                                        <span class="icon">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                        <input type="number" name="otp" placeholder="Enter Otp"
                                            aria-label="Otp" aria-describedby="otp" id="otp">

                                    </div>
                                    <div class="text-end" id="request_otp">
                                        <button class="btn btn-danger" onclick="requestOTP()">
                                            Request OTP
                                        </button>
                                    </div>
                                    <div class="text-end" id="login_opt">
                                        <button class="btn btn-danger" id="finish" onclick="login()">
                                            Login
                                        </button>
                                    </div>
                                    <div id="OTPForm">
                                        <div class="control mb-3">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" id="name" aria-label="Name"
                                                aria-describedby="Name">
                                        </div>
                                        <div class="control mb-3">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" id="email" aria-label="Email"
                                                aria-describedby="Email">
                                        </div>
                                        <div class="control mb-3">
                                            <label for="address">Address</label>
                                            <input type="text" name="address" id="address" aria-label="Address"
                                                aria-describedby="Address">
                                        </div>
                                        <div class="control mb-3">
                                            <label for="city_id">City</label>
                                            <select name="city_id" id="city_id" aria-label="City"
                                                aria-describedby="City">
                                                @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <button class="btn btn-primary" onclick="login()">
                                                Save
                                            </button>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.8.4/axios.min.js"
        integrity="sha512-2A1+/TAny5loNGk3RBbk11FwoKXYOMfAK6R7r4CpQH7Luz4pezqEGcfphoNzB7SM4dixUoJsKkBsB6kg+dNE2g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="{{ asset('front1/js/main.js') }}"></script>
    <script src="{{ asset('front1/js/nextpg.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#OTPForm').hide();
            $('#login_opt').hide();
            $('#finish').on('click', function(e) {
                e.preventDefault();
                const step = $(this).data('step');

                if (step == 1) {
                    const phone = $('#phone').val();
                    const pattern = /9[7-8][0-6][0-9]{7}/;

                    if (phone.length != 10 || !pattern.test(phone)) {
                        alert('Please Enter Valid Phone No');
                        return;
                    }

                    $(this).hide();
                    requestOTP(phone);
                } else {
                    $(this).hide();
                    login();
                }
            });
        });

        function requestOTP() {
            const phone = $('#phone').val();
            axios.post("{{ route('loginPhone') }}", {
                    phone: phone
                })
                .then((res) => {
                    if (res.data.status === true && res.data.user === false) {
                        $('#OTPForm').show();
                        $('#request_otp').hide();
                    } else if (res.data.status === true && res.data.user === true) {
                        $('#login_opt').show();
                        $('#request_otp').hide();
                    }
                })
                .catch((err) => {
                    console.log(err.response);
                    if (err.response) {
                        alert(err.response.data.message);
                    } else {
                        alert('Some error occurred. Please try again.');
                    }
                    $('#request_otp button').show();
                });
        }


        function login() {
            const otp = $('#otp').val();
            const name = $('#name').val();
            const email = $('#email').val();
            const address = $('#address').val();
            const city_id = $('#city_id').val();

            axios.post('{{ route('loginOTP') }}', {
                    otp: otp,
                    name: name,
                    email: email,
                    address: address,
                    city_id: city_id
                })
                .then((res) => {
                    if (res.data.status === true) {
                        window.location.href = "{{ route('setupUser') }}";
                    } else {
                        alert(res.data.message);
                    }
                })
                .catch((err) => {
                    console.log(err.response);
                    if (err.response) {
                        alert(err.response.data.message);
                    } else {
                        alert('Some error occurred. Please try again.');
                    }
                    $('#login_opt button').show();
                });
        }

        function showPhoneModal() {
            $('#loginModal').modal('hide');
            $('#phoneModal').modal('show');
        }
    </script>

    @yield('script')
</body>

</html>
