@extends('front1.navbar.layout')
@section('content')
    <div class="main-aa">
        <div class="container-fluid">
            <div class="row">
                <div class="heading">
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Library</li>

                        </ul>
                    </nav>
                    <h1>{{ $category->name }}</h1>
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
                            @foreach ($allcategories as $allcategory)
                                <li>
                                    <a href="{{route('product.library',$allcategory->id)}}" class="main-category" onclick="toggleSubCategories(event, this)">
                                        {{ $allcategory->name }}
                                        <i class="fas fa-chevron-down"></i>
                                    </a>
                                    <ul class="sub-categories">
                                        @foreach ($subcategories as $subcategory)
                                            @if ($subcategory->parent_id == $allcategory->id)
                                                <li>
                                                    <a href="#" onclick="selectCategory(event, this)">{{ $subcategory->name }}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
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
                                <input type="range" min="0" max="1000000" value="500000" class="slider"
                                    id="priceRange" aria-label="Price range slider" title="Drag to set price range">
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
                            @foreach ($products as $product)
                                <div class="card">

                                    <a href="#" class="card-link">
                                        <div class="card">
                                            <div class="card-image">
                                                <img src="{{ asset($product->image) }}" alt="Product" loading="lazy">
                                                <span class="image-count"><i class="fas fa-camera"></i>       {{ 
                                                    (isset($product->image) && !empty($product->image) ? 1 : 0) +
                                                    (isset($product->image1) && !empty($product->image1) ? 1 : 0) +
                                                    (isset($product->image2) && !empty($product->image2) ? 1 : 0) +
                                                    (isset($product->image3) && !empty($product->image3) ? 1 : 0) +
                                                    (isset($product->image4) && !empty($product->image4) ? 1 : 0) +
                                                    (isset($product->image5) && !empty($product->image5) ? 1 : 0) +
                                                    (isset($product->image6) && !empty($product->image6) ? 1 : 0)
                                                }}</span>
                                            </div>
                                            <div class="card-body">
                                                <div class="category">
                                                    <i class="fas fa-car"></i>{{ $product->short_desc }}
                                                </div>
                                                <h5>{{ $product->name }}</h5>
                                                <p class="price">{{ $product->price }}Rs</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach

                      
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('front1/js/nextpg.js') }}"></script>
@endsection
