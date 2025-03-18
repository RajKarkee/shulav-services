document.querySelectorAll('.location-option').forEach(option => {
    option.addEventListener('click', function() {
        // Remove selected class from all options
        console.log("clicked");

        document.querySelectorAll('.location-option').forEach(opt => {
            opt.classList.remove('selected');
        });

        // Add selected class to clicked option
        this.classList.add('selected');

        // Update location text
        document.querySelector('.language-selector').innerText = this.querySelector('span').innerText;

        // Add the icon back
        const icon = document.createElement('i');
        icon.className = 'fas fa-chevron-down';
        document.querySelector('.language-selector').appendChild(icon);

        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('locationModal'));
        modal.hide();
    });
});

/**
 * Dynamic Slider Initialization
 *
 * This function initializes all sliders on the page and sets up a MutationObserver
 * to automatically initialize any new sliders that are added to the DOM later.
 *
 * To create a new slider section that works with this code:
 * 1. Use the class 'slider-section' on the container element
 * 2. Include a '.slider-wrapper' element inside the section
 * 3. Include '.slider-prev' and '.slider-next' buttons
 * 4. Add cards with the class '.slider-card'
 *
 * Example HTML structure:
 * <div class="slider-section">
 *   <div class="header">
 *     <h4>Section Title</h4>
 *     <div class="slider-controls">
 *       <button class="slider-prev" title="Previous slide"><i class="fas fa-chevron-left"></i></button>
 *       <button class="slider-next" title="Next slide"><i class="fas fa-chevron-right"></i></button>
 *     </div>
 *   </div>
 *   <div class="slider">
 *     <div class="slider-wrapper">
 *       <div class="slider-card">Card content...</div>
 *       <div class="slider-card">Card content...</div>
 *     </div>
 *   </div>
 * </div>
 */

// Function to initialize a single slider
function initializeSlider(section) {
    // Skip if already initialized
    if (section.dataset.initialized === 'true') {
        return;
    }

    const sliderWrapper = section.querySelector('.slider-wrapper');
    const prevButton = section.querySelector('.slider-prev');
    const nextButton = section.querySelector('.slider-next');

    // Use either .slider-card or .card for backwards compatibility
    const cards = section.querySelectorAll('.slider-card, .card');

    if (!sliderWrapper || !prevButton || !nextButton || cards.length === 0) {
        console.error('Missing required elements for slider in section:', section);
        return;
    }

    // Mark as initialized to prevent duplicate initialization
    section.dataset.initialized = 'true';

    // Store the slider state in the section's dataset
    section.dataset.currentPosition = '0';
    section.dataset.cardWidth = '316'; // Default card width + gap

    // Calculate visible cards and max position
    const cardWidth = parseInt(section.dataset.cardWidth);
    const visibleCards = Math.floor(sliderWrapper.parentElement.offsetWidth / cardWidth);
    const maxPosition = Math.max(0, (cards.length - visibleCards) * cardWidth);

    section.dataset.maxPosition = maxPosition.toString();

    // Initialize slider position
    sliderWrapper.style.transform = `translateX(0px)`;

    // Previous button click
    prevButton.addEventListener('click', function() {
        const currentPosition = parseInt(section.dataset.currentPosition);
        const cardWidth = parseInt(section.dataset.cardWidth);

        if (currentPosition > 0) {
            const newPosition = currentPosition - cardWidth;
            section.dataset.currentPosition = newPosition.toString();
            sliderWrapper.style.transform = `translateX(-${newPosition}px)`;
        }
    });

    // Next button click
    nextButton.addEventListener('click', function() {
        const currentPosition = parseInt(section.dataset.currentPosition);
        const cardWidth = parseInt(section.dataset.cardWidth);
        const maxPosition = parseInt(section.dataset.maxPosition);

        if (currentPosition < maxPosition) {
            const newPosition = currentPosition + cardWidth;
            section.dataset.currentPosition = newPosition.toString();
            sliderWrapper.style.transform = `translateX(-${newPosition}px)`;
        }
    });

    console.log('Slider initialized:', section);
}

// Function to initialize all sliders on the page
function initializeAllSliders() {
    // Get all slider sections (support both old .section and new .slider-section classes)
    const sliderSections = document.querySelectorAll('.section, .slider-section');

    // Initialize each slider independently
    sliderSections.forEach(section => {
        initializeSlider(section);
    });
}

// Function to recalculate slider dimensions on window resize
function recalculateSliders() {
    const sliderSections = document.querySelectorAll('.section, .slider-section');

    sliderSections.forEach(section => {
        if (section.dataset.initialized !== 'true') return;

        const sliderWrapper = section.querySelector('.slider-wrapper');
        const cards = section.querySelectorAll('.slider-card, .card');
        const cardWidth = parseInt(section.dataset.cardWidth);
        const currentPosition = parseInt(section.dataset.currentPosition);

        // Recalculate max position
        const visibleCards = Math.floor(sliderWrapper.parentElement.offsetWidth / cardWidth);
        const maxPosition = Math.max(0, (cards.length - visibleCards) * cardWidth);
        section.dataset.maxPosition = maxPosition.toString();

        // Reset position if needed
        if (currentPosition > maxPosition) {
            section.dataset.currentPosition = maxPosition.toString();
            sliderWrapper.style.transform = `translateX(-${maxPosition}px)`;
        }
    });
}

// Set up MutationObserver to detect new slider sections
function setupSliderObserver() {
    // Create a MutationObserver to watch for new slider sections
    const observer = new MutationObserver(mutations => {
        let shouldInitialize = false;

        mutations.forEach(mutation => {
            if (mutation.type === 'childList') {
                mutation.addedNodes.forEach(node => {
                    // Check if the added node is an element and has the slider-section class
                    if (node.nodeType === 1 &&
                        (node.classList.contains('slider-section') || node.classList.contains('section'))) {
                        shouldInitialize = true;
                    }

                    // Check if the added node contains slider sections
                    if (node.nodeType === 1) {
                        const nestedSections = node.querySelectorAll('.slider-section, .section');
                        if (nestedSections.length > 0) {
                            shouldInitialize = true;
                        }
                    }
                });
            }
        });

        if (shouldInitialize) {
            initializeAllSliders();
        }
    });

    // Start observing the document body for changes
    observer.observe(document.body, { childList: true, subtree: true });
}

// Initialize everything when the DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeAllSliders();
    setupSliderObserver();

    // Handle window resize
    window.addEventListener('resize', recalculateSliders);
});