@extends('front1.navbar.layout')
@section('css')
    <style>
        #homepageModal .modal-dialog {
            max-width: 768px;
        }

        @media (max-width: 800px) {
            #homepageModal .modal-dialog {
                margin: 16px;
            }
        }
    </style>
@endsection
@section('content')
    <div id="popup">

    </div>
    <div class="homepage">
        <div class="banner" id="banner">
            <div class="top-banner-slider">
                @foreach ($sliders as $slider)
                    <img src="{{ asset($slider->image) }}" alt="Color Your Way to Epic Rewards" class="full-width-banner"
                        loading="lazy">
                @endforeach
            </div>
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
                                    @foreach ($routes as $route)
                                        <option value="{{ $route->from_location_id }}">{{ $route->fromLocation->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="bus-modal-col swap-icon">
                                <i class="fa fa-exchange-alt"></i>
                            </div>
                            <div class="bus-modal-col">
                                <div class="bus-modal-label"><i class="fa fa-map-marker-alt"></i></div>
                                <select id="toLocation" class="bus-modal-select" style="min-width:200px; width:220px;">
                                    @foreach ($routes as $route)
                                        <option value="{{ $route->to_location_id }}">{{ $route->toLocation->name }}
                                        </option>
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
                nextArrow: '<button class="slick-next custom-next"><i class="fa-solid fa-chevron-right"></i></button>'
            });

            // Implement lazy loading
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

                document.querySelectorAll('img[loading="lazy"]').forEach(img => {
                    imageObserver.observe(img);
                });
            }

            const popups = @json($popups);
            let displayedPopupIndex = 0;
            const activePopups = popups.filter(popup => popup.active === 1);

            function showNextPopup() {
                if (activePopups.length > 0 && displayedPopupIndex < activePopups.length) {
                    const currentPopup = activePopups[displayedPopupIndex];

                    $('#popup').html(`
                        <div class="modal fade" id="homepageModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable ${currentPopup.is_large ? 'modal-lg' : ''}">
                                <div class="modal-content">
                                    <div class="modal-body p-0">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                            style="position:absolute;top:10px;right:10px;border:none;z-index:10;"></button>
                                        <a href="${currentPopup.link || '#'}" ${currentPopup.link ? 'target="_blank"' : ''}>
                                            <img class="w-100" src="{{ asset('') }}${currentPopup.image}" alt="Popup Image">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `);

                    const modal = $('#homepageModal');
                    modal.modal('show');

                    modal.on('hidden.bs.modal', function () {
                        displayedPopupIndex++;
                        showNextPopup();
                    });
                }
            }

            showNextPopup();

        });


        function easeOutCubic(t) {
            return 1 - Math.pow(1 - t, 3);
        }

        function smoothScroll(element, amount) {
            const start = element.scrollLeft;
            const target = start + amount;
            const duration = 300;
            let startTime = null;

            function animation(currentTime) {
                if (startTime === null) startTime = currentTime;
                const timeElapsed = currentTime - startTime;
                const progress = Math.min(timeElapsed / duration, 1);
                element.scrollLeft = start + (target - start) * easeOutCubic(progress);

                if (timeElapsed < duration) {
                    requestAnimationFrame(animation);
                }
            }

            requestAnimationFrame(animation);
        }

        function initializeSlickSlider(section) {
            const $wrapper = $(section).find('.slider-wrapper');

            if ($wrapper.hasClass('slick-initialized')) return;

            const $prev = $(section).find('.slider-prev');
            const $next = $(section).find('.slider-next');

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
                }, {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2
                    }
                }, {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1.2
                    }
                }]
            });

            // Custom navigation buttons
            $prev.on('click', () => $wrapper.slick('slickPrev'));
            $next.on('click', () => $wrapper.slick('slickNext'));

            // Handle button states
            $wrapper.on('afterChange', function(event, slick, currentSlide) {
                const maxSlide = slick.slideCount - slick.options.slidesToShow;
                $prev.prop('disabled', currentSlide === 0);
                $next.prop('disabled', currentSlide >= maxSlide);
            });

            // Initialize button states
            $wrapper.trigger('afterChange', [$wrapper.slick('getSlick'), 0]);
        }

        // Initialize all sliders on page load
        $(document).ready(function() {
            $('.section').each(function() {
                initializeSlickSlider(this);
            });

            // Watch for DOM changes to initialize new sliders
            const observer = new MutationObserver(() => {
                $('.section').each(function() {
                    initializeSlickSlider(this);
                });
            });

            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
        });

        // Bus modal functions
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

        document.head.insertAdjacentHTML('beforeend', `
            <style>
                .bus-modal-overlay {
                    display: none;
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100vw;
                    height: 100vh;
                    background: rgba(0,0,0,0.15);
                    z-index: 9999;
                    justify-content: center;
                    align-items: center;
                }
                .bus-modal {
                    margin-top: 40px;
                    background: #fff;
                    border-radius: 12px;
                    box-shadow: 0 4px 24px rgba(0,0,0,0.1);
                    padding: 24px 32px;
                    min-width: 800px;
                    position: relative;
                }
                .bus-modal-row {
                    display: flex;
                    align-items: center;
                    gap: 16px;
                }
                .bus-modal-col {
                    display: flex;
                    align-items: center;
                }
                .bus-modal-label {
                    margin-right: 8px;
                    color: #666;
                    font-size: 18px;
                }
                .bus-modal-select, .bus-modal-date {
                    padding: 8px 12px;
                    border: 1px solid #ccc;
                    border-radius: 6px;
                    font-size: 16px;
                }
                .bus-modal-search-btn {
                    background: #0071e3;
                    color: #fff;
                    border: none;
                    border-radius: 6px;
                    padding: 10px 24px;
                    font-weight: 600;
                    font-size: 16px;
                    transition: background 0.2s;
                }
                .bus-modal-search-btn:hover {
                    background: #005bb5;
                }
                .bus-modal-close-btn {
                    position: absolute;
                    top: 10px;
                    right: 16px;
                    background: none;
                    border: none;
                    font-size: 26px;
                    color: #888;
                    cursor: pointer;
                }
                .swap-icon {
                    padding: 0 12px;
                    color: #bbb;
                    font-size: 20px;
                }
                .bus-modal-pills {
                    display: flex;
                    gap: 8px;
                    margin-top: 20px;
                }
                .bus-modal-pill {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    padding: 6px 12px;
                    border-radius: 8px;
                    background: #f5f7fa;
                    cursor: pointer;
                    font-size: 14px;
                    color: #333;
                }
                .bus-modal-pill.active {
                    background: #0099ff;
                    color: #fff;
                }
            </style>
        `);
    </script>
@endsection
