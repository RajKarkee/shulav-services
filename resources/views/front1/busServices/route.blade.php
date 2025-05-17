@extends('front1.navbar.layout')
@section('content')
    <nav aria-label="breadcrumb" style="margin-right: 20px;">
        <ul class="breadcrumb" style="margin: 0;">
            <li class="breadcrumb-item">
                <a href="{{ route('index') }}" style="text-decoration: none; color: black;">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">E-ticketing</li>
        </ul>
    </nav>
    <div class="route-page">
        <div class="container">
            @if($routes->isEmpty())
                <div class="no-routes-message">
                    <h2>No routes available for the selected locations.</h2>
                </div>
            @endif
            @foreach ($routes as $route)
                <div class="bus-card" data-bus-id="{{ $route->id }}">
                    <div class="bus-details">
                        <div class="bus-title">
                            {{ $route->short_description }}
                            {{-- <span class="night-badge">Night</span> --}}
                        </div>
                        <div class="bus-subtype">{{ $route->bus_type_name }}</div>

                        <div class="journey-details">
                            <div class="departure">
                                <div class="location">{{ $locations['from_location'] }}</div>
                                <div class="path">From</div>
                            </div>

                            <div class="journey-middle">

                                <div class="journey-duration">{{ $route->estimated_time }} Hours</div>
                                <div class="seats-available">{{$route->estimated_time}}</div>
                                <div class="journey-line"> </div>

                                <div class="bus-number">{{ $route->description }}</div>
                            </div>

                            <div class="arrival">
                                <div class="location">{{ $locations['to_location'] }}</div>
                                <div class="path">To</div>
                            </div>
                        </div>

                        {{-- <div class="bus-features">
                            <div class="feature-icon">
                                <span>🔌</span>
                            </div>
                            <div class="feature-icon">
                                <span>🚻</span>
                            </div>
                        </div> --}}

                        <div class="tabs">
                            <span class="tab">Amenities</span>
                            <span class="tab-separator">|</span>
                            <span class="tab">Cancellation Terms</span>
                            <span class="tab-separator">|</span>
                            <span class="tab bus-gallery-tab">Bus Gallery</span>
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
                    <div class="gallery-container" id="galleryImages">

                    </div>
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

            const busImages = {

                @foreach ($routes as $route)
                    {{ $route->id }}: [
                        "{{ asset('storage/' . $route->image_1) }}", // this becomes /storage/images/bus_types/...
                        "{{ asset('storage/' . $route->image_2) }}",
                        "{{ asset('storage/' . $route->image_3) }}",
                        "{{ asset('storage/' . $route->image_4) }}",
                        "{{ asset('storage/' . $route->image_5) }}",
                        "{{ asset('storage/' . $route->image_6) }}",
                        "{{ asset('storage/' . $route->image_7) }}",

                    ]
                @endforeach


            };
            console.log('Bus Images:', busImages);
            const galleryModal = document.getElementById('galleryModal');
            const imagePreviewModal = document.getElementById('imagePreviewModal');
            const previewImage = document.getElementById('previewImage');
            const galleryContainer = document.getElementById('galleryImages');
            const backToTopButton = document.querySelector('.back-to-top');

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
            const galleryTabs = document.querySelectorAll('.bus-gallery-tab');
            galleryTabs.forEach(tab => {
                tab.addEventListener('click', (e) => {
                    const busCard = e.target.closest('.bus-card');
                    if (!busCard) {
                        console.error('No bus card found');
                        return;
                    }

                    const busId = busCard.dataset.busId;
                    if (!busId) {
                        console.error('No bus ID found on this element:', busCard);
                        return;
                    }

                    currentBusId = busId;
                    console.log('Opening gallery for bus ID:', busId);

                    // Clear previous images
                    galleryContainer.innerHTML = '';

                    // Add images for this bus
                    if (busImages[busId] && busImages[busId].length > 0) {
                        busImages[busId].forEach((src, index) => {
                            if (!src) return; // Skip empty sources

                            // Create a wrapper for each image and loader
                            const wrapper = document.createElement('div');
                            wrapper.style.position = 'relative';
                            wrapper.style.width = '100%';
                            wrapper.style.height = '150px';

                            // Loader element
                            const loader = document.createElement('div');
                            loader.className = 'gallery-image-loader';
                            loader.innerHTML =
                                '<span class="loader-spinner"></span> Loading...';
                            loader.style.cssText =
                                'position:absolute;top:0;left:0;width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,0.7);z-index:2;';

                            // Image element
                            const img = document.createElement('img');
                            img.src = src;
                            img.alt = `Bus Image ${index + 1}`;
                            img.classList.add('gallery-image');
                            img.dataset.index = index;
                            img.style.opacity = '0';
                            img.addEventListener('click', () => {
                                openImagePreview(busId, index);
                            });
                            img.onload = function() {
                                loader.style.display = 'none';
                                img.style.opacity = '1';
                            };
                            img.onerror = function() {
                                loader.innerHTML = 'Failed to load image';
                            };
                            wrapper.appendChild(img);
                            wrapper.appendChild(loader);
                            galleryContainer.appendChild(wrapper);
                        });

                        galleryModal.style.display = 'flex';
                    } else {
                        console.error('No images found for bus ID:', busId);
                        alert('No gallery images available for this bus.');
                    }
                });
            });

            // Close gallery modal
            document.querySelector('.close-modal').addEventListener('click', () => {
                galleryModal.style.display = 'none';
            });

            // Close gallery modal when clicking outside
            galleryModal.addEventListener('click', (e) => {
                if (e.target === galleryModal) {
                    galleryModal.style.display = 'none';
                }
            });

            // Open image preview function
            function openImagePreview(busId, imageIndex) {
                if (!busImages[busId] || !busImages[busId][imageIndex]) {
                    console.error('Image not found:', busId, imageIndex);
                    return;
                }

                currentBusId = busId;
                currentImageIndex = imageIndex;
                previewImage.src = busImages[busId][imageIndex];
                imagePreviewModal.style.display = 'flex';
            }

            // Close image preview
            document.querySelector('.close-preview').addEventListener('click', () => {
                imagePreviewModal.style.display = 'none';
            });

            // Navigation arrows for image preview
            document.querySelector('.prev-image').addEventListener('click', () => {
                if (!busImages[currentBusId] || busImages[currentBusId].length === 0) return;

                if (currentImageIndex > 0) {
                    currentImageIndex--;
                } else {
                    currentImageIndex = busImages[currentBusId].length - 1;
                }
                previewImage.src = busImages[currentBusId][currentImageIndex];
            });

            document.querySelector('.next-image').addEventListener('click', () => {
                if (!busImages[currentBusId] || busImages[currentBusId].length === 0) return;

                if (currentImageIndex < busImages[currentBusId].length - 1) {
                    currentImageIndex++;
                } else {
                    currentImageIndex = 0;
                }
                previewImage.src = busImages[currentBusId][currentImageIndex];
            });

            // Close image preview when clicking outside
            imagePreviewModal.addEventListener('click', (e) => {
                if (e.target === imagePreviewModal) {
                    imagePreviewModal.style.display = 'none';
                }
            });

            // Add keyboard support for navigation
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

            // Tab click functionality (for other tabs)
            const tabs = document.querySelectorAll('.tab:not(.bus-gallery-tab)');
            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    alert(`${tab.textContent} tab clicked!`);
                });
            });

            // View seats button functionality
            const viewSeatsButtons = document.querySelectorAll('.view-seats-btn');
            viewSeatsButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    const busCard = e.target.closest('.bus-card');
                    const busName = busCard.querySelector('.bus-title').textContent.trim();
                    alert(`Viewing seats for ${busName}`);
                });
            });
        });
    </script>
@endsection
