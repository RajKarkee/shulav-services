@extends('front1.navbar.layout')
@section('content')
    <div class="homepage">
        <div class="container">
            <div class="banner">
                @foreach ($sliders as $slider)
                <img src="{{ asset($slider->image) }}" alt="Color Your Way to Epic Rewards" class="full-width-banner">
                @endforeach
            </div>
            <section class="categories">
                <a href="{{route('front1.menu')}}" class="category">
                    <div class="pic"><img src="{{ asset('media/car.jpg') }}" alt="Cars"></div>Cars
                </a>
                <a href="properties.html" class="category">
                    <div class="pic"><img src="media/property.jpg" alt="Properties"></div>Properties
                </a>
                <a href="mobiles.html" class="category">
                    <div class="pic"><img src="{{asset('media/mobile.png')}}" alt="Mobiles"></div>Mobiles
                </a>
                <a href="jobs.html" class="category">
                    <div class="pic"><img src="media/jobs.png" alt="Jobs"></div>Jobs
                </a>
                <a href="travel.html" class="category">
                    <div class="pic"><img src="media/travel.png" alt="Travel"></div>Travel
                </a>
                <a href="bikes.html" class="category">
                    <div class="pic"><img src="media/bike.png" alt="Bikes"></div>Bikes
                </a>
                <a href="electronics.html" class="category">
                    <div class="pic"><img src="media/electronics.png" alt="Electronics"></div>Electronics
                </a>
                <a href="commercial.html" class="category">
                    <div class="pic"><img src="media/commercial.png" alt="Commercial"></div>Commercial
                </a>
                <a href="furniture.html" class="category">
                    <div class="pic"><img src="media/furniture.png" alt="Furniture"></div>Furniture
                </a>
                <a href="fashion.html" class="category">
                    <div class="pic"><img src="media/fashon.png" alt="Fashion"></div>Fashion
                </a>
            </section>

        </div>
        <div class="container">
            <div class="section">
                <div class="header">
                    <h4>Premium Section</h4>
                    <div class="slider-controls">
                        <button class="slider-prev" title="Previous slide"><i class="fas fa-chevron-left"></i></button>
                        <button class="slider-next" title="Next slide"><i class="fas fa-chevron-right"></i></button>
                    </div>
                </div>

                <div class="slider">
                    <div class="slider-wrapper">
                        <!-- Card 1 -->
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
                                        <img src="media/furniture1.jpg" alt="Product">
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

                        <!-- Card 2 -->
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
        </div>




        <div class="container">

            <h4>Fresh recommendations</h4>
            <div class="row row-cols-4">
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
            </div>
        </div>
    </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('front1/js/main.js') }}"></script>
    @endsection

