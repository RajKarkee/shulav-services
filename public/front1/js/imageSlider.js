document.addEventListener('DOMContentLoaded', function() {
    const imageContainer = document.querySelector('.image-slider');
    const images = document.querySelectorAll('.product-image');
    const thumbnails = document.querySelectorAll('.thumbnail');
    const prevButton = document.getElementById('prevImage');
    const nextButton = document.getElementById('nextImage');
    let currentIndex = 0;
    let touchStartX = 0;
    let touchEndX = 0;
    const totalImages = images.length;

    // Function to update active image and thumbnail with smooth transitions
    function updateActiveImage(index, direction = null) {
        // Remove active class from all images and thumbnails
        images.forEach(img => {
            img.classList.remove('active');
            img.style.zIndex = 0;
        });
        thumbnails.forEach(thumb => thumb.classList.remove('active'));

        // Set z-index for smooth transitions
        if (direction) {
            images[currentIndex].style.zIndex = 1;
            images[index].style.zIndex = 2;

            // Add animation classes based on direction
            if (direction === 'next') {
                images[index].classList.add('slide-in-right');
                images[currentIndex].classList.add('slide-out-left');
            } else {
                images[index].classList.add('slide-in-left');
                images[currentIndex].classList.add('slide-out-right');
            }

            // Remove animation classes after transition
            setTimeout(() => {
                images.forEach(img => {
                    img.classList.remove('slide-in-right', 'slide-in-left', 'slide-out-left', 'slide-out-right');
                });
            }, 500);
        }

        // Add active class to current image and thumbnail
        images[index].classList.add('active');
        thumbnails[index].classList.add('active');

        // Scroll thumbnail into view if needed
        thumbnails[index].scrollIntoView({
            behavior: 'smooth',
            block: 'nearest',
            inline: 'center'
        });

        currentIndex = index;

        // Update button states
        updateButtonStates();
    }

    // Update navigation button states
    function updateButtonStates() {
        prevButton.disabled = currentIndex === 0;
        nextButton.disabled = currentIndex === images.length - 1;

        // Visual indication of disabled state
        if (prevButton.disabled) {
            prevButton.classList.add('disabled');
        } else {
            prevButton.classList.remove('disabled');
        }

        if (nextButton.disabled) {
            nextButton.classList.add('disabled');
        } else {
            nextButton.classList.remove('disabled');
        }
    }

    // Previous button click handler
    prevButton.addEventListener('click', () => {
        if (currentIndex > 0) {
            updateActiveImage(currentIndex - 1, 'prev');
        }
    });

    // Next button click handler
    nextButton.addEventListener('click', () => {
        if (currentIndex < images.length - 1) {
            updateActiveImage(currentIndex + 1, 'next');
        }
    });

    // Thumbnail click handlers
    thumbnails.forEach((thumbnail, index) => {
        thumbnail.addEventListener('click', () => {
            if (index > currentIndex) {
                updateActiveImage(index, 'next');
            } else if (index < currentIndex) {
                updateActiveImage(index, 'prev');
            }
        });
    });

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft' && currentIndex > 0) {
            updateActiveImage(currentIndex - 1, 'prev');
        } else if (e.key === 'ArrowRight' && currentIndex < images.length - 1) {
            updateActiveImage(currentIndex + 1, 'next');
        }
    });

    // Touch event handling for swipe
    imageContainer.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    });

    imageContainer.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    });

    function handleSwipe() {
        const threshold = 50; // Minimum distance required for swipe

        if (touchEndX < touchStartX - threshold && currentIndex < totalImages - 1) {
            // Swipe left - next image
            updateActiveImage(currentIndex + 1, 'next');
        } else if (touchEndX > touchStartX + threshold && currentIndex > 0) {
            // Swipe right - previous image
            updateActiveImage(currentIndex - 1, 'prev');
        }
    }

    // Auto-play functionality
    let autoplayTimer;
    let isAutoPlaying = false;
    const autoplayDelay = 5000; // 5 seconds

    function startAutoplay() {
        if (isAutoPlaying) return;

        isAutoPlaying = true;
        autoplayTimer = setInterval(() => {
            if (currentIndex < images.length - 1) {
                updateActiveImage(currentIndex + 1, 'next');
            } else {
                updateActiveImage(0, 'next');
            }
        }, autoplayDelay);
    }

    function stopAutoplay() {
        clearInterval(autoplayTimer);
        isAutoPlaying = false;
    }

    // Pause autoplay on hover or touch
    imageContainer.addEventListener('mouseenter', stopAutoplay);
    imageContainer.addEventListener('touchstart', stopAutoplay);

    // Add CSS for slide animations
    const style = document.createElement('style');
    style.textContent = `
        .slide-in-right {
            animation: slideInRight 0.5s forwards;
        }
        .slide-out-left {
            animation: slideOutLeft 0.5s forwards;
        }
        .slide-in-left {
            animation: slideInLeft 0.5s forwards;
        }
        .slide-out-right {
            animation: slideOutRight 0.5s forwards;
        }

        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes slideOutLeft {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(-100%); opacity: 0; }
        }

        @keyframes slideInLeft {
            from { transform: translateX(-100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes slideOutRight {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    `;
    document.head.appendChild(style);

    // Initialize first image
    updateActiveImage(0);

    // Start autoplay after a delay
    setTimeout(startAutoplay, 2000);
});
