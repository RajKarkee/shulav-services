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
                <div class="container dynamic-container" id="section-{{ $section->position }}" data-position="{{ $section->position }}">
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
                                        <a href="{{route('product.show',['name'=>$product->name,'id' =>$product->id])}}" class="card-link">
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
            @if ($section->design_type == '2')
            <div class="container dynamic-container" id="section-{{ $section->position }}" data-position="{{ $section->position }}">
                    <h4>{{ $section->section_name }}</h4>
                    <div class="row row-cols-4"> 
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
                                    <a href="{{route('product.show',['name'=>$product->name,'id' =>$product->id])}}" class="card-link">
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
                    </div>
                </div>
                @endif
        @endforeach
      

    </div>
@endsection
@section('script')
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
