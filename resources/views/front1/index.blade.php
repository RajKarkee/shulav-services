@extends('front1.navbar.layout')
@section('content')
    <div class="homepage">
        <div class="banner" id="banner">
            <div class="top-banner-slider">
                @foreach ($sliders as $slider)
                    <img src="{{ asset($slider->image) }}" alt="Color Your Way to Epic Rewards" class="full-width-banner"
                        loading="lazy">
                @endforeach
            </div>
            {{-- <div class="custom-nav">
                <button class="custom-prev"><i class="fas fa-chevron-left"></i></button>
                <button class="custom-next"><i class="fas fa-chevron-right"></i></button>
            </div> --}}
        </div>
        <div class="container">
            <section class="categories">
                @foreach ($serviceCategories as $category)
                    <a href="{{ route('product.library', $category->id) }}" class="category">
                        <div class="pic"><img src="{{ asset($category->image) }}" alt="{{ $category->name }}"
                                loading="lazy" width="100" height="100"></div>
                        {{ $category->name }}
                    </a>
                @endforeach
            </section>
        </div>

        @foreach ($sections as $section)
            @if ($section->design_type == '1')
                <div class="container dynamic-container" id="section-{{ $section->position }}"
                    data-position="{{ $section->position }}">
                    <div class="section">
                        <div class="header">
                            <h4>{{ $section->section_name }}</h4>
                            <div class="slider-controls">
                                <button class="slider-prev" title="Previous slide"><i
                                        class="fas fa-chevron-left"></i></button>
                                <button class="slider-next" title="Next slide"><i class="fas fa-chevron-right"></i></button>
                            </div>
                        </div>

                        <div class="slider">
                            <div class="slider-wrapper">
                                @foreach ($section->products as $product)
                                    <div class="card sectionSlider">
                                        <a href="{{ route('product.show', ['name' => $product->name, 'id' => $product->id]) }}"
                                            class="card-link">
                                            <div class="card">
                                                <div class="card-image">
                                                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                                        loading="lazy" width="200" height="150">
                                                    <span class="image-count"><i class="fas fa-camera"></i>
                                                        {{ (isset($product->image) && !empty($product->image) ? 1 : 0) +
                                                            (isset($product->image1) && !empty($product->image1) ? 1 : 0) +
                                                            (isset($product->image2) && !empty($product->image2) ? 1 : 0) +
                                                            (isset($product->image3) && !empty($product->image3) ? 1 : 0) +
                                                            (isset($product->image4) && !empty($product->image4) ? 1 : 0) +
                                                            (isset($product->image5) && !empty($product->image5) ? 1 : 0) +
                                                            (isset($product->image6) && !empty($product->image6) ? 1 : 0) }}</span>
                                                </div>
                                                <div class="card-body">
                                                    <div class="category">
                                                        <i class="fas fa-tools"></i> {{ $product->short_desc }}
                                                    </div>
                                                    <h5>{{ $product->name }}</h5>
                                                    <p class="price">{{ $product->price }}</p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if ($section->design_type == '2')
                <div class="container dynamic-container" id="section-{{ $section->position }}"
                    data-position="{{ $section->position }}">
                    <h4>{{ $section->section_name }}</h4>
                    <div class="row row-cols-4">
                        @foreach ($section->products as $product)
                            <div class="col">
                                <div class="card">
                                    <a href="{{ route('product.show', ['name' => $product->name, 'id' => $product->id]) }}"
                                        class="card-link">
                                        <div class="card">
                                            <div class="card-image">
                                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}"
                                                    loading="lazy" width="200" height="150">
                                                <span class="image-count"><i class="fas fa-camera"></i>
                                                    {{ (isset($product->image) && !empty($product->image) ? 1 : 0) +
                                                        (isset($product->image1) && !empty($product->image1) ? 1 : 0) +
                                                        (isset($product->image2) && !empty($product->image2) ? 1 : 0) +
                                                        (isset($product->image3) && !empty($product->image3) ? 1 : 0) +
                                                        (isset($product->image4) && !empty($product->image4) ? 1 : 0) +
                                                        (isset($product->image5) && !empty($product->image5) ? 1 : 0) +
                                                        (isset($product->image6) && !empty($product->image6) ? 1 : 0) }}</span>
                                            </div>
                                            <div class="card-body">
                                                <div class="category">
                                                    <i class="fas fa-tools"></i> {{ $product->short_desc }}
                                                </div>
                                                <h5>{{ $product->name }}</h5>
                                                <p class="price">{{ $product->price }}</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('.top-banner-slider').slick({
                infinite: true,
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                dots: true,
                prevArrow: '<button class="slick-prev custom-prev"><i class="fa-solid fa-chevron-left"></i></button>',
                nextArrow: '<button class="slick-next custom-next"><i class="fa-solid fa-chevron-right"></i></button>',
            });

            $('.top-banner-slider').slick({
                infinite: false,
                slidesToShow: 4,
                slidesToScroll: 1,
                arrows: true,
                dots: true,
                prevArrow: '<button class="slick-prev custom-prev"><i class="fa-solid fa-chevron-left"></i></button>',
                nextArrow: '<button class="slick-next custom-next"><i class="fa-solid fa-chevron-right"></i></button>',
            });
           

          

            function smoothScroll(element, amount) {
                const start = element.scrollLeft;
                const target = start + amount;
                const duration = 300;
                let startTime = null;

                function animation(currentTime) {
                    if (startTime === null) startTime = currentTime;
                    const timeElapsed = currentTime - startTime;
                    const progress = Math.min(timeElapsed / duration, 1);
                    const ease = easeOutCubic(progress);

                    element.scrollLeft = start + (target - start) * ease;

                    if (timeElapsed < duration) {
                        requestAnimationFrame(animation);
                    }
                }

                function easeOutCubic(t) {
                    return 1 - Math.pow(1 - t, 3);
                }

                requestAnimationFrame(animation);
            }

            // Lazy load images
            const lazyImages = document.querySelectorAll('img[loading="lazy"]');
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            img.src = img.dataset.src || img.src;
                            imageObserver.unobserve(img);
                        }
                    });
                });

                lazyImages.forEach(img => {
                    imageObserver.observe(img);
                });
            }
        });
    </script>
@endsection
