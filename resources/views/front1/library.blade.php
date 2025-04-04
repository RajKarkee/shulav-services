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
                    <h1 id="category_name">{{ $category->name }}</h1>
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
                                    <a href="{{ route('product.library.filter', ['category_id' => $allcategory->id]) }}"
                                        class="main-category" onclick="selectCategory(event, this)">
                                        {{ $allcategory->name }}
                                        <i class="fas fa-chevron-down"></i>
                                    </a>
                                    <ul class="sub-categories">
                                        @foreach ($subcategories as $subcategory)
                                            @if ($subcategory->parent_id == $allcategory->id)
                                                <li>
                                                    <a href="{{ route('product.library.filter', ['subcategory_id' => $subcategory->id]) }}"
                                                        class="sub-category" onclick="selectCategory(event, this)">
                                                        {{ $subcategory->name }}
                                                    </a>
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
                            @foreach ($cities as $city)
                                <li>
                                    <a href="{{ route('product.library.filter', ['city_id' => $city->id]) }}"
                                        onclick="selectLocation(event, this)">
                                        {{ $city->name }}
                                        <i class="fas fa-check location-check"></i>
                                    </a>
                                </li>
                            @endforeach
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

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('front1/js/nextpg.js') }}"></script>
    <script>
        const csrfToken = '{{ csrf_token() }}';

        document.addEventListener('DOMContentLoaded', function() {
            const categoryLinks = document.querySelectorAll('.main-category, .sub-category');
            const locationLinks = document.querySelectorAll('.location-list a');
            const priceSlider = document.getElementById('priceRange');
            const minPriceInput = document.getElementById('minPrice');
            const maxPriceInput = document.getElementById('maxPrice');
            const productContainer = document.querySelector('.content .col');

            let filterData = {
                category_id: null,
                subcategory_id: null,
                min_price: 0,
                max_price: 1000000,
                city_id: null
            };

            // Handle category & subcategory clicks
            categoryLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = new URL(this.href);
                    filterData.category_id = url.searchParams.get("category_id");
                    filterData.subcategory_id = url.searchParams.get("subcategory_id");
                    applyFilter();
                });
            });

            // Handle location clicks
            locationLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = new URL(this.href);
                    filterData.city_id = url.searchParams.get("city_id");
                    locationLinks.forEach(l => l.querySelector('.location-check').style.display =
                        'none');
                    this.querySelector('.location-check').style.display = 'inline-block';

                    applyFilter();
                });
            });

            // Handle price range slider
            priceSlider.addEventListener('input', function() {
                document.getElementById('currentRange').textContent = `₨ ${this.value}`;
                filterData.max_price = parseInt(this.value);
                applyFilter();
            });

            // Handle manual price inputs
            minPriceInput.addEventListener('change', function() {
                filterData.min_price = parseInt(this.value || 0);
                applyFilter();
            });

            maxPriceInput.addEventListener('change', function() {
                filterData.max_price = parseInt(this.value || 1000000);
                applyFilter();
            });

            function applyFilter() {
                fetch("{{ route('product.library.filter') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify(filterData)
                    })
                    .then(res => res.json())
                    .then(data => {
                        productContainer.innerHTML = '';
                        if(data.category){
                            document.getElementById('category_name').innerHTML = data.category.name;
                        }
                        if (data.success) {
                            data.products.forEach(product => {
                                productContainer.innerHTML += `
                                <div class="card">
                                    <a href="#" class="card-link">
                                        <div class="card">
                                            <div class="card-image">
                                                <img src="/${product.image}" alt="Product" loading="lazy">
                                            </div>
                                            <div class="card-body">
                                                <div class="category">
                                                    <i class="fas fa-car"></i> ${product.short_desc}
                                                </div>
                                                <h5>${product.name}</h5>
                                                <p class="price">${product.price}Rs</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            `;
                            });
                        } else {
                            productContainer.innerHTML = `<p>${data.message}</p>`;
                        }
                    });
            }
        });
    </script>
@endsection
