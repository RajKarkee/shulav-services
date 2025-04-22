@extends('front1.navbar.layout')
@section('content')
    <div class="route-page">
        <div class="container">
           @foreach($routes as $route)

            <div class="bus-card" data-bus-id="1">
                <div class="bus-details">
                    <div class="bus-title">
                        Sunaulo Mahakali 2x2 Luxury Sofa Bus
                        {{-- <span class="night-badge">Night</span> --}}
                    </div>
                    <div class="bus-subtype">{{$route->bus_type_name}}</div>

                    <div class="journey-details">
                        <div class="departure">
                            <div class="time">{{$locations['from_location']}}</div>
                            <div class="location">From</div>
                        </div>

                        <div class="journey-middle">
                            <div class="journey-duration">20 Hours</div>
                            <div class="journey-line"></div>
                            <div class="bus-number">Bus No. NA 8 KHA 8347</div>
                        </div>

                        <div class="arrival">
                            <div class="time">{{$locations['to_location']}}</div>
                            <div class="location">To</div>
                        </div>
                    </div>

                    <div class="bus-features">
                        <div class="feature-icon">
                            <span>🔌</span>
                        </div>
                        <div class="feature-icon">
                            <span>🚻</span>
                        </div>
                    </div>

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
                        <div class="price">Rs.{{$route->fare}}</div>
                        <div class="seats-available">46 Seats Available</div>
                    </div>
                    <button class="view-seats-btn">View Seats</button>
                </div>
            </div>

            @endforeach

            <!-- Second Bus Card -->
            <div class="bus-card" data-bus-id="2">
                <div class="bus-details">
                    <div class="bus-title">
                        Sunaulo Mahakali 2x2 Luxury Sofa Bus
                        <span class="night-badge">Night</span>
                    </div>
                    <div class="bus-subtype">2x2 Sofa Seater</div>

                    <div class="journey-details">
                        <div class="departure">
                            <div class="time">02:00 PM</div>
                            <div class="location">Kathmandu</div>
                        </div>

                        <div class="journey-middle">
                            <div class="journey-duration">20 Hours</div>
                            <div class="journey-line"></div>
                            <div class="bus-number">Bus No. Su. Pa. Pra. 02 001 KHA 1321</div>
                        </div>

                        <div class="arrival">
                            <div class="time">10:00 AM</div>
                            <div class="location">Sukhad</div>
                        </div>
                    </div>

                    <div class="bus-features">
                        <div class="feature-icon">
                            <span>🔌</span>
                        </div>
                        <div class="feature-icon">
                            <span>🚻</span>
                        </div>
                    </div>

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
                        <div class="price">Rs.2500</div>
                        <div class="seats-available">47 Seats Available</div>
                    </div>
                    <button class="view-seats-btn">View Seats</button>
                </div>
            </div>
        </div>

        <!-- Gallery Modal -->
        <div id="galleryModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">Bus Gallery</div>
                    <button class="close-modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="gallery-container" id="galleryImages">
                        <!-- Gallery images will be loaded here -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Image Preview Modal -->
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
        // Bus image data (Simulated from a database)
        const busImages = {
            1: [
                "/api/placeholder/800/600?text=Bus+Interior+1",
                "/api/placeholder/800/600?text=Bus+Exterior+1",
                "/api/placeholder/800/600?text=Bus+Seats+1",
                "/api/placeholder/800/600?text=Bus+Toilet+1",
                "/api/placeholder/800/600?text=Bus+Driver+Area+1",
                "/api/placeholder/800/600?text=Bus+Night+View+1"
            ],
            2: [
                "/api/placeholder/800/600?text=Bus+Interior+2",
                "/api/placeholder/800/600?text=Bus+Exterior+2",
                "/api/placeholder/800/600?text=Bus+Seats+2",
                "/api/placeholder/800/600?text=Bus+Night+View+2"
            ]
        };

        // Back to top functionality
        const backToTopButton = document.querySelector('.back-to-top');
        backToTopButton.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Gallery modal functionality
        const galleryModal = document.getElementById('galleryModal');
        const imagePreviewModal = document.getElementById('imagePreviewModal');
        const previewImage = document.getElementById('previewImage');
        const galleryContainer = document.getElementById('galleryImages');

        // Variables for image navigation
        let currentBusId = null;
        let currentImageIndex = 0;

        // Open gallery modal when "Bus Gallery" is clicked
        const galleryTabs = document.querySelectorAll('.bus-gallery-tab');
        galleryTabs.forEach(tab => {
            tab.addEventListener('click', (e) => {
                const busCard = e.target.closest('.bus-card');
                const busId = busCard.dataset.busId;
                currentBusId = busId;

                // Clear previous images
                galleryContainer.innerHTML = '';

                // Add images for this bus
                if (busImages[busId]) {
                    busImages[busId].forEach((src, index) => {
                        const img = document.createElement('img');
                        img.src = src;
                        img.alt = `Bus Image ${index + 1}`;
                        img.classList.add('gallery-image');
                        img.dataset.index = index;

                        img.addEventListener('click', () => {
                            openImagePreview(busId, index);
                        });

                        galleryContainer.appendChild(img);
                    });
                }

                galleryModal.style.display = 'flex';
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

        // Open image preview
        function openImagePreview(busId, imageIndex) {
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
            if (currentImageIndex > 0) {
                currentImageIndex--;
            } else {
                currentImageIndex = busImages[currentBusId].length - 1;
            }
            previewImage.src = busImages[currentBusId][currentImageIndex];
        });

        document.querySelector('.next-image').addEventListener('click', () => {
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
    </script>
@endsection
