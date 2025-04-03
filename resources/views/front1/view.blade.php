@extends('front1.navbar.layout')
@section('content')
    <div class="main-aa">
        <div class="container-fluid">
            <div class="row">
                <div class="heading">
                    <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Library</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>

                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="homepage">

    </div>
    <div class="image">
        <div class="image-gallery">

            <div class="navigation-arrows">
                <button class="nav-arrow left" title="Previous image" id="prevImage">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="nav-arrow right" title="Next image" id="nextImage">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>

            <div class="image-container">
                <div class="image-slider">
                    <!-- Add multiple images here -->
                    <img src="{{ asset($product->image) }}" alt="Product" class="product-image active">

                    @for ($i = 1; $i <= 6; $i++)
                        @php $imageNo= "image{$i}"; @endphp
                        @if ($product->$imageNo)
                            <img src="{{ asset($product->$imageNo) }}" alt="Product" class="product-image">
                        @endif
                    @endfor

                </div>
                <div class="image-actions">
                    <button class="action-btn share" title="Share">
                        <i class="fas fa-share-nodes"></i>
                    </button>
                    <button class="action-btn favorite" title="Add to favorites">
                        <i class="far fa-heart"></i>
                    </button>
                </div>

            </div>

            <!-- Add thumbnail navigation -->
            <div class="thumbnail-nav">
                @php $index=1; @endphp
                <div class="thumbnail active" data-index="0">
                    <img src="{{ asset($product->image) }}" alt="Thumbnail 1">
                </div>
                @for ($i = 1; $i <= 6; $i++)
                    @php $imageNo= "image{$i}"; @endphp
                    @if ($product->$imageNo)
                        <div class="thumbnail" data-index="{{ $index }}">
                            <img src="{{ asset($product->$imageNo) }}" alt="Thumbnail {{ $index }}">
                        </div>
                        @php $index++; @endphp
                    @endif
                @endfor

            </div>
        </div>
    </div>
    <div class="view-container">
        <hr>
        <div class="product-details">
            <div class="row mb-3">
                <div class="col-md-8">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge bg-warning text-dark p-2">FEATURED</span>
                        <div class="d-flex align-items-center">

                            <span class="ms-2 text-success fw-bold">APPROVED DEALER</span>
                        </div>
                    </div>
                    <h1 class="fs-2 fw-bold mb-1">{{ $product->name }}</h1>
                    <p class="mb-2">SV MT I-DTEC</p>

                    <div class="d-flex align-items-center mt-3 gap-3">
                        <span class="d-inline-flex align-items-center">
                            <i class="fas fa-gas-pump me-1"></i>
                            <span class="badge bg-primary text-white">DIESEL</span>
                        </span>
                        <span class="d-inline-flex align-items-center">
                            <i class="fas fa-road me-1"></i>
                            <span>97,000 KM</span>
                        </span>
                        <span class="d-inline-flex align-items-center">
                            <i class="fas fa-cogs me-1"></i>
                            <span>MANUAL</span>
                        </span>
                    </div>
                </div>
                <div class="col-md-4 text-end">
                    <h2 class="fs-1 fw-bold mb-3" style="display: flex">{{ $product->price }}</h2>
                    <button class="btn btn-dark w-100 py-2">Make offer</button>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-4 d-flex align-items-center">
                                    <i class="fas fa-user-circle me-3 fs-4"></i>
                                    <div>
                                        <small class="text-muted">Owner</small>
                                        <p class="mb-0 fw-bold">3rd</p>
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <i class="fas fa-map-marker-alt me-3 fs-4"></i>
                                    <div>
                                        <small class="text-muted">Location</small>
                                        <p class="mb-0 fw-bold">{{ $product->city_name }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4 d-flex align-items-center">
                                    <i class="fas fa-calendar-alt me-3 fs-4"></i>
                                    <div>
                                        <small class="text-muted">Posting date</small>
                                        <p class="mb-0 fw-bold">09-OCT-24</p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-8">
                    <h4 class="mb-3">Description</h4>
                    <p>{{ $product->short_desc }}</p>
                    <h4 class='mb-3'>ADDITIONAL INFORMATION:</h4>
                    <p>{{ $product->desc }}</p>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body text-center">
                            <div class="rounded-circle bg-primary bg-opacity-25 mx-auto mb-3 d-flex align-items-center justify-content-center"
                                style="width: 80px; height: 80px;">
                                <span class="fs-1 fw-bold">M</span>
                            </div>
                            <h5 class="mb-3">Rajesh hamal</h5>
                            <button class="btn btn-outline-dark w-100 mb-3">Chat with seller</button>
                            <div class="d-flex align-items-center justify-content-center">
                                <i class="fas fa-phone me-2"></i>
                                <span>** *** ***</span>
                                <a href="#" class="ms-2 text-primary">Show number</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('front1/js/imageSlider.js') }}"></script>
@endsection
