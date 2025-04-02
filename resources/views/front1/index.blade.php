@extends('front1.navbar.layout')
@section('content')
    <div class="homepage">


        <div class="banner">
            <div class="owl-carousel">
                @foreach ($sliders as $slider)
                    <img src="{{ asset($slider->image) }}" alt="Color Your Way to Epic Rewards" class="full-width-banner">
                @endforeach
            </div>
            <div class="custom-nav">
                <button class="custom-prev"><i class="fas fa-chevron-left"></i></button>
                <button class="custom-next"><i class="fas fa-chevron-right"></i></button>
            </div>

        </div>
        <div class="container">
            <section class="categories">
                @foreach ($serviceCategories as $category)
                    <a href="" class="category">
                        <div class="pic"><img src="{{ asset($category->image) }}" alt="Cars"></div>
                        {{ $category->name }}
                    </a>
                @endforeach
            </section>

        </div>
        @foreach ($sections as $section)
            @if ($section->design_type == '1')
                <div class="container" id="section-{{ $section->position }}">
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
                                <!-- Card 1 -->
                                @foreach ($section->products as $product)
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="user-info">
                                                <div class="avatar">
                                                    <img src="media/avatar.jpg" alt="User">
                                                </div>
                                                <div class="details">
                                                    <div class="username">Ramesh</div>
                                                    <div class="time">Time</div>
                                                </div>
                                            </div>
                                            <div class="premium-tag">
                                                <i class="fas fa-star"></i> Premium
                                            </div>
                                        </div>
                                        <a href="product-details.html" class="card-link">
                                            <div class="card">
                                                <div class="card-image">
                                                    <img src="{{ asset($product->image) }}" alt="Product">
                                                    <span class="image-count"><i class="fas fa-camera"></i> 15</span>
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
        @endforeach


        {{-- <!-- Card 2 -->
        <div class="card">
            <div class="card-header">
                <div class="user-info">
                    <div class="avatar">
                        <img src="media/naruto.jpg" alt="User">
                    </div>
                    <div class="details">
                        <div class="username">Hari</div>
                        <div class="time">29 minutes</div>
                    </div>
                </div>
                <div class="premium-tag">
                    <i class="fas fa-star"></i> Premium
                </div>
            </div>
            <a href="product-details.html" class="card-link">
                <div class="card">
                    <div class="card-image">
                        <img src="media/gym.jpg" alt="Product">
                        <span class="image-count"><i class="fas fa-camera"></i> 4</span>
                    </div>
                    <div class="card-body">
                        <div class="category">
                            <i class="fas fa-dumbbell"></i> gym is good
                        </div>
                        <h5>TOP GYM</h5>
                        <p class="price">4000000 Rs</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Card 3 -->
        <div class="card">
            <div class="card-header">
                <div class="user-info">
                    <div class="avatar">
                        <img src="media/L.jpg" alt="User">
                    </div>
                    <div class="details">
                        <div class="username">Shyam</div>
                        <div class="time">20hrs</div>
                    </div>
                </div>
                <div class="premium-tag">
                    <i class="fas fa-star"></i> Premium
                </div>
            </div>
            <a href="product-details.html" class="card-link">
                <div class="card">
                    <div class="card-image">
                        <img src="media/pokhara.jpg" alt="Product">
                        <span class="image-count"><i class="fas fa-camera"></i> 1</span>
                    </div>
                    <div class="card-body">
                        <div class="category">
                            <i class="fas fa-car-parts"></i> makingg progreess
                        </div>
                        <h5>visit nepal 2025</h5>
                        <p class="price">930000Rs</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Additional cards -->
        <div class="card">
            <div class="card-header">
                <div class="user-info">
                    <div class="avatar">
                        <img src="media/naruto.jpg" alt="User">
                    </div>
                    <div class="details">
                        <div class="username">CarDealer</div>
                        <div class="time">3hrs </div>
                    </div>
                </div>
                <div class="premium-tag">
                    <i class="fas fa-star"></i> Premium
                </div>
            </div>
            <a href="product-details.html" class="card-link">
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
    </div>
    </div>
    </div>
    </div> --}}




        <div class="container">
            @foreach ($sections as $section)
                @if ($section->design_type == '2')
                    <h4>{{ $section->section_name }}</h4>
                    <div class="row row-cols-4"> <!-- Move row outside the loop -->
                        @foreach ($section->products as $product)
                            <div class="col">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="user-info">
                                            <div class="avatar">
                                                <img src="media/avatar1.jpg" alt="User">
                                            </div>
                                            <div class="details">
                                                <div class="username">Ramesh</div>
                                                <div class="time">Time</div>
                                            </div>
                                        </div>
                                    </div>
                                    <a href="product-details.html" class="card-link">
                                        <div class="card">
                                            <div class="card-image">
                                                <img src="{{ asset($product->image) }}" alt="Product">
                                                <span class="image-count"><i class="fas fa-camera"></i> 15</span>
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
                    </div> <!-- Close row after the loop -->
                @endif
            @endforeach

            {{-- <div class="col">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="user-info">
                                            <div class="avatar">
                                                <img src="media/avatar2.jpg" alt="User">
                                            </div>
                                            <div class="details">
                                                <div class="username">Hari</div>
                                                <div class="time">29 minutes</div>
                                            </div>
                                        </div>

                                    </div>
                                    <a href="product-details.html" class="card-link">
                                        <div class="card">
                                            <div class="card-image">
                                                <img src="media/product2.jpg" alt="Product">
                                                <span class="image-count"><i class="fas fa-camera"></i> 4</span>
                                            </div>
                                            <div class="card-body">
                                                <div class="category">
                                                    <i class="fas fa-dumbbell"></i> New very very new
                                                </div>
                                                <h5>top 3 GYM</h5>
                                                <p class="price">Price not fixed</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div class="col">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="user-info">
                                            <div class="avatar">
                                                <img src="media/avatar3.jpg" alt="User">
                                            </div>
                                            <div class="details">
                                                <div class="username">Shyam</div>
                                                <div class="time">20hrs</div>
                                            </div>
                                        </div>

                                    </div>
                                    <a href="product-details.html" class="card-link">
                                        <div class="card">
                                            <div class="card-image">
                                                <img src="media/product3.jpg" alt="Product">
                                                <span class="image-count"><i class="fas fa-camera"></i> 1</span>
                                            </div>
                                            <div class="card-body">
                                                <div class="category">
                                                    <i class="fas fa-car-parts"></i> makingg progreess
                                                </div>
                                                <h5>visit nepal 2025</h5>
                                                <p class="price">930000Rs</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col">
                                <!-- Additional cards -->
                                <div class="card">
                                    <div class="card-header">
                                        <div class="user-info">
                                            <div class="avatar">
                                                <img src="media/avatar4.jpg" alt="User">
                                            </div>
                                            <div class="details">
                                                <div class="username">CarDealer</div>
                                                <div class="time">3hrs </div>
                                            </div>
                                        </div>

                                    </div>
                                    <a href="product-details.html" class="card-link">
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
                            </div>




                            <div class="col">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="user-info">
                                            <div class="avatar">
                                                <img src="media/avatar1.jpg" alt="User">
                                            </div>
                                            <div class="details">
                                                <div class="username">Ramesh</div>
                                                <div class="time">Time</div>
                                            </div>
                                        </div>

                                    </div>
                                    <a href="product-details.html" class="card-link">
                                        <div class="card">
                                            <div class="card-image">
                                                <img src="media/product1.jpg" alt="Product">
                                                <span class="image-count"><i class="fas fa-camera"></i> 15</span>
                                            </div>
                                            <div class="card-body">
                                                <div class="category">
                                                    <i class="fas fa-tools"></i> making renovation
                                                </div>
                                                <h5>New furniture</h5>
                                                <p class="price">Negotiable</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                            </div>

                            <div class="col">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="user-info">
                                            <div class="avatar">
                                                <img src="media/avatar2.jpg" alt="User">
                                            </div>
                                            <div class="details">
                                                <div class="username">Hari</div>
                                                <div class="time">29 minutes</div>
                                            </div>
                                        </div>

                                    </div>
                                    <a href="product-details.html" class="card-link">
                                        <div class="card">
                                            <div class="card-image">
                                                <img src="media/product2.jpg" alt="Product">
                                                <span class="image-count"><i class="fas fa-camera"></i> 4</span>
                                            </div>
                                            <div class="card-body">
                                                <div class="category">
                                                    <i class="fas fa-dumbbell"></i> New very very new
                                                </div>
                                                <h5>top 3 GYM</h5>
                                                <p class="price">Price not fixed</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div class="col">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="user-info">
                                            <div class="avatar">
                                                <img src="media/avatar3.jpg" alt="User">
                                            </div>
                                            <div class="details">
                                                <div class="username">Shyam</div>
                                                <div class="time">20hrs</div>
                                            </div>
                                        </div>

                                    </div>
                                    <a href="product-details.html" class="card-link">
                                        <div class="card">
                                            <div class="card-image">
                                                <img src="media/product3.jpg" alt="Product">
                                                <span class="image-count"><i class="fas fa-camera"></i> 1</span>
                                            </div>
                                            <div class="card-body">
                                                <div class="category">
                                                    <i class="fas fa-car-parts"></i> makingg progreess
                                                </div>
                                                <h5>visit nepal 2025</h5>
                                                <p class="price">930000Rs</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col">
                                <!-- Additional cards -->
                                <div class="card">
                                    <div class="card-header">
                                        <div class="user-info">
                                            <div class="avatar">
                                                <img src="media/avatar4.jpg" alt="User">
                                            </div>
                                            <div class="details">
                                                <div class="username">CarDealer</div>
                                                <div class="time">3hrs </div>
                                            </div>
                                        </div>

                                    </div>
                                    <a href="product-details.html" class="card-link">
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
                            </div>
                        </div> --}}
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('front1/js/main.js') }}"></script>
    <script>
        $(document).ready(function() {

            var owl = $('.owl-carousel').owlCarousel({
                loop: true,
                margin: 10,
                // nav: true,
                dots: true,
                autoplay: true,
                autoplayTimeout: 10000,
                animateIn: 'fadeIn',
                animateOut: 'fadeOut',
                autoplayHoverPause: true,
                cc
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 1
                    },
                    1000: {
                        items: 1
                    }
                }
            });

            $('.owl-carousel .owl-prev, .owl-carousel .owl-next').click(function() {
                owl.trigger('stop.owl.autoplay');
                owl.trigger('play.owl.autoplay', [10000]);
            });


            $('.custom-prev').click(function() {
                owl.trigger('prev.owl.carousel');
                owl.trigger('stop.owl.autoplay');
                owl.trigger('play.owl.autoplay', [10000]);
            });

            $('.custom-next').click(function() {
                owl.trigger('next.owl.carousel');
                owl.trigger('stop.owl.autoplay');
                owl.trigger('play.owl.autoplay', [10000]);
            });


            $('.slider-prev').click(function() {
                $('.slider-wrapper').animate({
                    scrollLeft: '-=300'
                }, 500);
            });

            $('.slider-next').click(function() {
                $('.slider-wrapper').animate({
                    scrollLeft: '+=300'
                }, 500);
            });
        });
    </script>
@endsection
