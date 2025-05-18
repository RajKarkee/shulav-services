@extends('front1.navbar.layout')
@section('content')
    <nav aria-label="breadcrumb" style="margin-left: 20px;">
        <ul class="breadcrumb" style="margin: 0;">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}" style="text-decoration: none; color: black;">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">E-ticketing</li>
        </ul>
    </nav>
    <div class="route-page">
        <div class="container">
            @if ($routes->isEmpty())
                <div class="no-routes-message">
                    <h2>No routes available for the selected locations.</h2>
                </div>
            @endif
            @foreach ($routes as $route)
                <div class="bus-card" data-bus-id="{{ $route->id }}">
                    <div class="bus-details">
                        @php
                            $vehicle = App\Models\Vehicle::where('id', $route->vehicle_id)->first();
                            $vehicleImages = array_filter([
                                $vehicle->image_1,
                                $vehicle->image_2,
                                $vehicle->image_3,
                                $vehicle->image_4,
                                $vehicle->image_5,
                                $vehicle->image_6,
                                $vehicle->image_7,
                            ]);
                        @endphp
                        <input type="hidden" class="vehicle-images" data-route-id="{{ $route->id }}"
                            value="{{ json_encode($vehicleImages) }}">

                        <div class="bus-subtype">{{ $vehicle->name }}</div>

                        <div class="journey-details">
                            <div class="departure">
                                <div class="location">{{ $locations['from_location'] }}</div>
                                <div class="path">From</div>
                            </div>

                            <div class="journey-middle">
                                <div class="journey-duration">{{ $route->estimated_time }} Hours</div>
                                <div class="seats-available">{{ $route->estimated_time }}</div>
                                <div class="journey-line"> </div>
                                <div class="bus-number">{{ $route->description }}</div>
                            </div>

                            <div class="arrival">
                                <div class="location">{{ $locations['to_location'] }}</div>
                                <div class="path">To</div>
                            </div>
                        </div>

                        <div class="tabs">
                            <span class="tab">Amenities</span>
                            <span class="tab-separator">|</span>
                            <span class="tab">Cancellation Terms</span>
                            <span class="tab-separator">|</span>
                            <span class="tab bus-gallery-tab">Vehicle Gallery</span>
                            <span class="tab-separator">|</span>
                            <span class="tab">Boarding & Dropping</span>
                            <span class="tab-separator">|</span>
                            <span class="tab">Reviews</span>
                        </div>
                    </div>

                    <div class="price-section">
                        <div>
                            <div class="price">Rs.{{ $route->fare }}</div>
                        </div>
                        <button class="view-seats-btn">View Seats</button>
                    </div>
                </div>
            @endforeach
        </div>

        <div id="galleryModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">Bus Gallery</div>
                    <button class="close-modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="gallery-container" id="galleryImages"></div>
                </div>
            </div>
        </div>

        <div id="imagePreviewModal" class="image-preview-modal">
            <span class="close-preview">&times;</span>
            <div class="nav-arrow prev-image">&#10094;</div>
            <img class="preview-image" id="previewImage" src="" alt="Preview">
            <div class="nav-arrow next-image">&#10095;</div>
        </div>

        <div class="back-to-top">
            <span>↑</span>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const busImages = {};
            const galleryModal = document.getElementById('galleryModal');
            const imagePreviewModal = document.getElementById('imagePreviewModal');
            const previewImage = document.getElementById('previewImage');
            const galleryContainer = document.getElementById('galleryImages');
            const backToTopButton = document.querySelector('.back-to-top');

            // Load all bus images from hidden inputs
            document.querySelectorAll('.vehicle-images').forEach(input => {
                const routeId = input.dataset.routeId;
                try {
                    // console.log(input.value);
                    busImages[routeId] = JSON.parse(input.value);
                    console.log(busImages[routeId]);
                } catch (e) {
                    console.error('Error parsing JSON for route ID:', routeId, e);
                    busImages[routeId] = [];
                }
            });

            // Variables for image navigation
            let currentBusId = null;
            let currentImageIndex = 0;

            // Back to top functionality
            if (backToTopButton) {
                backToTopButton.addEventListener('click', () => {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            }

            // Open gallery modal when "Bus Gallery" is clicked
            document.querySelectorAll('.bus-gallery-tab').forEach(tab => {
                tab.addEventListener('click', (e) => {
                    const busCard = e.target.closest('.bus-card');
                    if (!busCard) return;

                    const busId = busCard.dataset.busId;
                    if (!busId) return;

                    currentBusId = busId;

                    // Clear previous images
                    galleryContainer.innerHTML = '';

                    // Add images for this bus
                    if (busImages[busId] && busImages[busId].length > 0) {
                        busImages[busId].forEach((src, index) => {
                            if (!src) return; // Skip empty sources

                            // Create image wrapper
                            const wrapper = document.createElement('div');
                            wrapper.className = 'gallery-image-wrapper';
                            wrapper.style.position = 'relative';
                            wrapper.style.width = '100%';
                            wrapper.style.height = '150px';

                            // Create loader
                            const loader = document.createElement('div');
                            loader.className = 'gallery-image-loader';
                            loader.innerHTML =
                                '<span class="loader-spinner"></span> Loading...';

                            // Create image
                            const img = document.createElement('img');
                            img.src = "{{ asset('') }}" + src;
                            console.log('Loading image:', img.src);
                            img.alt = `Bus Image ${index + 1}`;
                            img.className = 'gallery-image';
                            img.dataset.index = index;
                            img.style.opacity = '0';

                            // Image events
                            img.addEventListener('click', () => openImagePreview(busId,
                                index));
                            img.onload = () => {
                                loader.style.display = 'none';
                                img.style.opacity = '1';
                            };
                            img.onerror = () => {
                                loader.innerHTML = 'Failed to load image';
                            };

                            wrapper.appendChild(img);
                            wrapper.appendChild(loader);
                            galleryContainer.appendChild(wrapper);
                        });

                        galleryModal.style.display = 'flex';
                    } else {
                        alert('No gallery images available for this bus.');
                    }
                });
            });

            // Close gallery modal
            document.querySelector('.close-modal').addEventListener('click', () => {
                galleryModal.style.display = 'none';
            });

            // Close when clicking outside
            galleryModal.addEventListener('click', (e) => {
                if (e.target === galleryModal) {
                    galleryModal.style.display = 'none';
                }
            });

            // Open image preview function
            function openImagePreview(busId, imageIndex) {
                if (!busImages[busId] || !busImages[busId][imageIndex]) return;
                currentBusId = busId;
                currentImageIndex = imageIndex;
                previewImage.src = "{{ asset('') }}" + busImages[busId][imageIndex];
                imagePreviewModal.style.display = 'flex';
                // Ensure image is displayed at full width with proper constraints
                previewImage.style.maxWidth = '90%';
                previewImage.style.maxHeight = '90vh';
                previewImage.style.objectFit = 'contain';
                document.body.style.overflow = 'hidden'; // Prevent scrolling when image preview is open
            }

            // Close image preview
            document.querySelector('.close-preview').addEventListener('click', () => {
                imagePreviewModal.style.display = 'none';
            });

            // Navigation arrows
            document.querySelector('.prev-image').addEventListener('click', () => {
                if (!busImages[currentBusId] || busImages[currentBusId].length === 0) return;

                currentImageIndex = (currentImageIndex > 0) ?
                    currentImageIndex - 1 :
                    busImages[currentBusId].length - 1;

                previewImage.src = "{{ asset('') }}" + busImages[currentBusId][currentImageIndex];
            });

            document.querySelector('.next-image').addEventListener('click', () => {
                if (!busImages[currentBusId] || busImages[currentBusId].length === 0) return;

                currentImageIndex = (currentImageIndex < busImages[currentBusId].length - 1) ?
                    currentImageIndex + 1 :
                    0;

                previewImage.src = "{{ asset('') }}" + busImages[currentBusId][currentImageIndex];
            });

            // Close when clicking outside
            imagePreviewModal.addEventListener('click', (e) => {
                if (e.target === imagePreviewModal) {
                    imagePreviewModal.style.display = 'none';
                }
            });

            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (imagePreviewModal.style.display === 'flex') {
                    if (e.key === 'Escape') {
                        imagePreviewModal.style.display = 'none';
                    } else if (e.key === 'ArrowLeft') {
                        document.querySelector('.prev-image').click();
                    } else if (e.key === 'ArrowRight') {
                        document.querySelector('.next-image').click();
                    }
                } else if (galleryModal.style.display === 'flex' && e.key === 'Escape') {
                    galleryModal.style.display = 'none';
                }
            });

            // Other tab functionalities
            document.querySelectorAll('.tab:not(.bus-gallery-tab)').forEach(tab => {
                tab.addEventListener('click', () => {
                    alert(`${tab.textContent.trim()} tab clicked!`);
                });
            });

            // View seats button functionality
            document.querySelectorAll('.view-seats-btn').forEach(button => {
                button.addEventListener('click', (e) => {
                    const busCard = e.target.closest('.bus-card');
                    const busId = busCard.dataset.busId;
                    alert(`Viewing seats for bus ID: ${busId}`);
                });
            });
        });
    </script>
@endsection
