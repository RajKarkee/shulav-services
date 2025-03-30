@extends('front1.navbar.layout')
@section('content')

    <div class="main-aa">
        <div class="container-fluid">
            <div class="row">
                <div class="heading">
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('index')}}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Library</li>

                        </ul>
                    </nav>
                    <h1>Cars</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="categories-wrapper">
                        <div class="category-title" onclick="toggleCategoryList()">
                            CATEGORIES
                            <i class="fas fa-chevron-up"></i>
                        </div>
                        <ul class="category-list">
                            <li>
                                <a href="#" class="main-category">
                                    All Categories
                                </a>
                            </li>
                            <li>
                                <a href="#" class="main-category" onclick="toggleSubCategories(event, this)">
                                    Properties
                                    <i class="fas fa-chevron-down"></i>
                                </a>
                                <ul class="sub-categories">
                                    <li>
                                        <a href="#" onclick="selectCategory(event, this)">For Sale: Houses &
                                            Apartments</a>
                                    </li>
                                    <li>
                                        <a href="#" onclick="selectCategory(event, this)">For Rent: Houses &
                                            Apartments</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" class="main-category active-category"
                                    onclick="toggleSubCategories(event, this)">
                                    Cars & Bikes
                                    <i class="fas fa-chevron-down"></i>
                                </a>
                                <ul class="sub-categories show">
                                    <li>
                                        <a href="#" class="active-category"
                                            onclick="selectCategory(event, this)">Cars</a>
                                    </li>
                                    <li>
                                        <a href="#" onclick="selectCategory(event, this)">Bikes</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                    <div class="locations-wrapper">
                        <div class="location-title" onclick="toggleLocationList()">
                            LOCATIONS
                            <i class="fas fa-chevron-up"></i>
                        </div>
                        <ul class="location-list">
                            <li>
                                <a href="#" onclick="selectLocation(event, this)">
                                    Kathmandu
                                    <i class="fas fa-check location-check"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" onclick="selectLocation(event, this)">
                                    Bhaktapur
                                    <i class="fas fa-check location-check"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" onclick="selectLocation(event, this)">
                                    Lalitpur
                                    <i class="fas fa-check location-check"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" onclick="selectLocation(event, this)">
                                    Pokhara
                                    <i class="fas fa-check location-check"></i>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="filters-wrapper">
                        <div class="filters-title">
                            Filters
                        </div>
                        <div class="price-filter">
                            <div class="price-label">Price Range</div>
                            <div class="price-range">
                                <span id="currentRange">₨ 500,000</span>
                            </div>
                            <div class="range-slider">
                                <input type="range" min="0" max="1000000" value="500000" class="slider" id="priceRange"
                                    aria-label="Price range slider" title="Drag to set price range">
                            </div>
                            <div class="price-inputs">
                                <input type="number" class="price-input" id="minPrice" placeholder="Min"
                                    aria-label="Minimum price">
                                <span class="separator">-</span>
                                <input type="number" class="price-input" id="maxPrice" placeholder="Max"
                                    aria-label="Maximum price">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="content">
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <div class="user-info">
                                        <div class="avatar">
                                            <img src="media/avatar.jpg" alt="User">
                                        </div>
                                        <div class="details">
                                            <div class="username">CarDealer</div>
                                            <div class="time">3hrs </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="{{route('front1.view')}}" class="card-link">
                                    <div class="card">
                                        <div class="card-image">
                                            <img src="media/carimage.jpeg" alt="Product">
                                            <span class="image-count"><i class="fas fa-camera"></i> 8</span>
                                        </div>
                                        <div class="card-body">
                                            <div class="category">
                                                <i class="fas fa-car"></i>Buy this car
                                            </div>
                                            <h5>Toyota Corolla 2020</h5>
                                            <p class="price">185 000 Rs</p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <div class="user-info">
                                        <div class="avatar">
                                            <img src="media/avatar2.jpg" alt="User">
                                        </div>
                                        <div class="details">
                                            <div class="username">AutoSales</div>
                                            <div class="time">5hrs </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="product-details.html" class="card-link">
                                    <div class="card">
                                        <div class="card-image">
                                            <img src="media/car.jpg" alt="Product">
                                            <span class="image-count"><i class="fas fa-camera"></i> 6</span>
                                        </div>
                                        <div class="card-body">
                                            <div class="category">
                                                <i class="fas fa-car"></i>Premium Car
                                            </div>
                                            <h5>Honda Civic 2021</h5>
                                            <p class="price">250 000 Rs</p>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="card">
                                <div class="card-header">
                                    <div class="user-info">
                                        <div class="avatar">
                                            <img src="media/avatar3.jpg" alt="User">
                                        </div>
                                        <div class="details">
                                            <div class="username">CarWorld</div>
                                            <div class="time">8hrs </div>
                                        </div>
                                    </div>
                                </div>
                                <a href="product-details.html" class="card-link">
                                    <div class="card">
                                        <div class="card-image">
                                            <img src="media/car.jpg" alt="Product">
                                            <span class="image-count"><i class="fas fa-camera"></i> 5</span>
                                        </div>
                                        <div class="card-body">
                                            <div class="category">
                                                <i class="fas fa-car"></i>Luxury Vehicle
                                            </div>
                                            <h5>BMW 3 Series 2022</h5>
                                            <p class="price">450 000 Rs</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('front1/js/nextpg.js') }}"></script>

@endsection
