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
                    @if ($category->type == 3)
                        <a href="javascript:void(0);" class="category" onclick="openBusModal()">
                            <div class="pic">
                                <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" loading="lazy"
                                    width="100" height="100">
                            </div>
                            {{ $category->name }}
                        </a>
                    @else
                        <a href="{{ route('product.library', $category->id) }}" class="category">
                            <div class="pic">
                                <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" loading="lazy"
                                    width="100" height="100">
                            </div>
                            {{ $category->name }}
                        </a>
                    @endif
                @endforeach
                <div id="busModal" class="bus-modal-overlay">
                    <div class="bus-modal">
                        <div class="bus-modal-row">
                            <div class="bus-modal-col">
                                <div class="bus-modal-label"><i class="fa fa-bus"></i></div>
                                <select id="fromLocation" class="bus-modal-select" style="min-width:200px; width:220px;">
                                    <option value="" disabled selected>Start your adventure at?</option>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}">{{ $location->location_name }}</option>  
                                    @endforeach
                                </select>
                            </div>
                            <div class="bus-modal-col swap-icon">
                                <i class="fa fa-exchange-alt"></i>
                            </div>
                            <div class="bus-modal-col">
                                <div class="bus-modal-label"><i class="fa fa-map-marker-alt"></i></div>
                                <select id="toLocation" class="bus-modal-select" style="min-width:200px; width:220px;">
                                    <option value="" disabled selected>Your destination awaits at?</option>
                                    @foreach ($locations as $location)
                                        <option value="{{ $location->id }}">{{ $location->location_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="bus-modal-col">
                                <button class="bus-modal-search-btn" onclick="searchBus()">Search</button>
                            </div>
                        </div>
                        <button onclick="closeBusModal()" class="bus-modal-close-btn">&times;</button>
                    </div>
                </div>


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
                                                    <img data-lazy="{{ asset($product->image) }}"
                                                        alt="{{ $product->name }}" width="200" height="150">
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
    <script>
        (function(){
            var link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = 'https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css';
            document.head.appendChild(link);

            var script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js';
            script.onload = function () {
                new Choices('#fromLocation', { searchEnabled: true, itemSelectText: '', shouldSort: false });
                new Choices('#toLocation', { searchEnabled: true, itemSelectText: '', shouldSort: false });
            };
            document.body.appendChild(script);
        })();
    </script>
    <script>
        function initializeSlickSlider(section) {
            const $wrapper = $(section).find('.slider-wrapper');
            const $prev = $(section).find('.slider-prev');
            const $next = $(section).find('.slider-next');

            if ($wrapper.hasClass('slick-initialized')) return;

            $wrapper.slick({
                slidesToShow: 3.5,
                slidesToScroll: 1,
                arrows: false,
                infinite: false,
                lazyLoad: 'ondemand',
                swipeToSlide: true,
                responsive: [{
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 1.2
                        }
                    }
                ]
            });

            // Custom Prev/Next Buttons
            $prev.on('click', () => $wrapper.slick('slickPrev'));
            $next.on('click', () => $wrapper.slick('slickNext'));

            // Handle enabling/disabling buttons
            $wrapper.on('afterChange', function(event, slick, currentSlide) {
                const maxSlide = slick.slideCount - slick.options.slidesToShow;
                $prev.prop('disabled', currentSlide === 0);
                $next.prop('disabled', currentSlide >= maxSlide);
            });

            // Trigger once to set initial button state
            $wrapper.trigger('afterChange', [$wrapper.slick('getSlick'), 0]);
        }

        function initializeAllSliders() {
            $('.section').each(function() {
                initializeSlickSlider(this);
            });
        }

        function observeSliders() {
            const observer = new MutationObserver(() => {
                initializeAllSliders();
            });
            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
        }

        $(document).ready(function() {
            initializeAllSliders();
            observeSliders();
        });
    </script>
    <style>
        .bus-modal-overlay {
            display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh;
            background: rgba(0,0,0,0.15); z-index: 9999; justify-content: center; align-items: center;
        }
        .bus-modal {
            margin-top: 40px;
            background: #fff; border-radius: 12px; box-shadow: 0 4px 24px rgba(0,0,0,0.10);
            padding: 24px 32px; min-width: 800px; position: relative;
        }
        .bus-modal-row {
            display: flex; align-items: center; gap: 16px;
        }
        .bus-modal-col { display: flex; align-items: center; }
        .bus-modal-label { margin-right: 8px; color: #666; font-size: 18px; }
        .bus-modal-select, .bus-modal-date {
            padding: 8px 12px; border: 1px solid #ccc; border-radius: 6px; font-size: 16px;
        }
        .bus-modal-search-btn {
            background: #0071e3; color: #fff; border: none; border-radius: 6px; padding: 10px 24px; font-weight: 600; font-size: 16px;
            transition: background 0.2s;
        }
        .bus-modal-search-btn:hover { background: #005bb5; }
        .bus-modal-close-btn {
            position: absolute; top: 10px; right: 16px; background: none; border: none; font-size: 26px; color: #888; cursor: pointer;
        }
        .swap-icon { padding: 0 12px; color: #bbb; font-size: 20px; }
        .bus-modal-pills { display: flex; gap: 8px; margin-top: 20px; }
        .bus-modal-pill {
            display: flex; flex-direction: column; align-items: center; padding: 6px 12px; border-radius: 8px; background: #f5f7fa;
            cursor: pointer; font-size: 14px; color: #333;
        }
        .bus-modal-pill.active { background: #0099ff; color: #fff; }
    </style>
    <script>
        function openBusModal() {
            document.getElementById('busModal').style.display = 'flex';
        }
        function closeBusModal() {
            document.getElementById('busModal').style.display = 'none';
        }
        function searchBus() {
            const fromId = document.getElementById('fromLocation').value;
            const toId = document.getElementById('toLocation').value;
            window.location.href = `/bus/search?from=${fromId}&to=${toId}`;
        }
    </script>
@endsection
