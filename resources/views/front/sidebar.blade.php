@php
$h_u = Auth::check();
$u = Auth::user();
@endphp
<div class="mobile-head" id="mobile-head">
    <div class="d-flex justify-content-between">
        <div class="show-menu">
            <button data-role="open-sidebar">
                <span class="fas fa-bars">

                </span>
            </button>
        </div>
        <div class="logo">
            <img src="{{ asset('front/logo.png') }}" alt="" class="logo">
        </div>
        <div class="noti">
            <button>
                <span class="fas fa-bell">

                </span>
            </button>
            <button class="user {{ $h_u ? 'p-0' : '' }} ">
                <a
                    href="{{ $h_u ? ($u->role == 3 ? route('user.dashboard') : route('vendor.dashboard')) : route('loginFirst') }}">
                    @if ($h_u)
                        <img src="{{ asset($u->vendor?->image) }}" alt="">
                    @else
                        <span class="fas fa-user">
                        </span>
                    @endif
                </a>
            </button>

        </div>
    </div>
</div>

<div id="sidebar" class="">
    <div class="overlay">
        <div class="sidebar-menu-holder">

            <div class="sidebar-menu">
                <div class="back-bar" data-role='close-sidebar'>
                    <button>
                        <span class="fas fa-arrow-left">

                        </span>
                    </button>
                </div>
                <a class="user-bar"
                    href="{{ $h_u? ($u->role == 3? route('user.dashboard'): ($u->role == 2? route('vendor.dashboard'): route('admin.dashboard'))): route('loginFirst') }}">

                    <div class="user-image">
                        <img src="{{ $h_u? ($u->role < 2? asset('admin/img/user.svg'): asset($u->vendor?->image)): 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/12/User_icon_2.svg/2048px-User_icon_2.svg.png' }}"
                            alt="">
                    </div>
                    <div class="user-name">{{ $h_u ? $u->name : 'Sign In' }}</div>
                </a>
                <div class="bar"></div>
                <div class="menu-bar">
                    <span class="fas fa-home">

                    </span>
                    <a href="/" class="sidebar-link">Home</a>
                </div>
                @if ($h_u)
                    <div class="menu-bar">
                        <i class="fas fa-user"></i>
                        <a class="sidebar-link"
                            href="{{ $h_u? ($u->role == 3? route('user.dashboard'): ($u->role == 2? route('vendor.dashboard'): route('admin.dashboard'))): route('loginFirst') }}">My Account</a>
                    </div>
                    @if ($u->vendor!=null)
                        
                        @if ($u->vendor->type == 1)
                            <div class="menu-bar">
                                <i class="fas fa-hourglass"></i>
                                <a class="sidebar-link" href="{{ route('vendor.openingHour') }}">Opening Hours</a>
                            </div>
                            <div class="menu-bar">
                                <i class="fas fa-star-half-alt"></i>
                                <a class="sidebar-link" href="{{ route('vendor.reviews') }}">Reviews</a>
                            </div>

                            <div class="menu-bar">
                                <i class="fas fa-tools"></i>
                                <a class="sidebar-link"
                                    href="{{ route('vendor.product.index', ['type' => 2]) }}">Services</a>
                            </div>
                            <div class="menu-bar">
                                <i class="fas fa-box-open"></i>
                                <a class="sidebar-link"
                                    href="{{ route('vendor.product.index', ['type' => 1]) }}">Products</a>
                            </div>
                            <div class="menu-bar">
                                <i class="fas fa-file-invoice-dollar"></i>
                                <a class="sidebar-link" href="{{ route('vendor.bills') }}">Invoices</a>
                            </div>
                        @endif
                    @endif
                @endif

                <div class="menu-bar">
                    <span class="fas fa-briefcase ">

                    </span>
                    <a class="sidebar-link" href="{{ route('services') }}">Categories</a>
                </div>
                <div class="menu-bar">
                    <span class="fas fa-map-marker-alt">

                    </span>
                    <a class="sidebar-link" href="{{ route('cities') }}">Locations</a>
                </div>

                <div class="menu-bar">
                    <i class="fas fa-mobile-alt"></i>
                    <a class="sidebar-link" href="{{ route('contact') }}">Contact </a>
                </div>
                <div class="menu-bar">
                    <span class="fas fa-info-circle">

                    </span>
                    <a class="sidebar-link" href="{{ route('services') }}">About</a>
                </div>
                @if ($h_u)
                    <div class="menu-bar">
                        <i class="fas fa-sign-out-alt"></i>
                        <a class="sidebar-link" href="{{ route('logout') }}">Logout</a>
                    </div>
                @else
                   
                    <div class="menu-bar">
                        <i class="fas fa-sign-in-alt"></i>
                        <a class="sidebar-link" href="{{ route('loginFirst') }}">Sign In</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if ($h_u)
    <div class="offcanvas offcanvas-end" tabindex="-1" id="sidebar-desktop" aria-labelledby="offcanvasExampleLabel">
        <div class="offcanvas-header justify-content-end">
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
                <div class="menu-bar">
                    <i class="fas fa-user"></i>
                    <a class="sidebar-link"
                        href="{{ $h_u? ($u->role == 3? route('user.dashboard'): ($u->role == 2? route('vendor.dashboard'): route('admin.dashboard'))): route('loginFirst') }}">My Account</a>
                </div>
                @if ($u->vendor)
                    
                    @if ($u->vendor->type == 1)
                        <div class="menu-bar">
                            <i class="fas fa-hourglass"></i>
                            <a class="sidebar-link" href="{{ route('vendor.openingHour') }}">Opening Hours</a>
                        </div>
                        <div class="menu-bar">
                            <i class="fas fa-star-half-alt"></i>
                            <a class="sidebar-link" href="{{ route('vendor.reviews') }}">Reviews</a>
                        </div>

                        <div class="menu-bar">
                            <i class="fas fa-tools"></i>
                            <a class="sidebar-link"
                                href="{{ route('vendor.product.index', ['type' => 2]) }}">Services</a>
                        </div>
                        <div class="menu-bar">
                            <i class="fas fa-box-open"></i>
                            <a class="sidebar-link"
                                href="{{ route('vendor.product.index', ['type' => 1]) }}">Products</a>
                        </div>
                        <div class="menu-bar">
                            <i class="fas fa-file-invoice-dollar"></i>
                            <a class="sidebar-link" href="{{ route('vendor.bills') }}">Invoices</a>
                        </div>
                    @endif
                @endif
                
                <div class="menu-bar">
                    <i class="fas fa-sign-out-alt"></i>
                    <a class="sidebar-link" href="{{ route('logout') }}">Logout</a>
                </div>
        </div>
    </div>
@endif
