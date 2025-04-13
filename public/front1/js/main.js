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

// Function to initialize a single slider function initializeSlickSlider(section) {
    //     const wrapper = $(section).find('.slider-wrapper');
    //     const prevBtn = $(section).find('.slider-prev');
    //     const nextBtn = $(section).find('.slider-next');

    //     // Skip if already initialized
    //     if (wrapper.hasClass('slick-initialized')) return;

    //     // Initialize Slick Slider
    //     wrapper.slick({
    //         slidesToShow: 4,
    //         slidesToScroll: 1,
    //         infinite: false,
    //         arrows: false,
    //         dots: false,
    //         swipeToSlide: true,
    //         lazyLoad: 'ondemand',
    //         responsive: [
    //             {
    //                 breakpoint: 1200,
    //                 settings: { slidesToShow: 3 }
    //             },
    //             {
    //                 breakpoint: 992,
    //                 settings: { slidesToShow: 2 }
    //             },
    //             {
    //                 breakpoint: 768,
    //                 settings: { slidesToShow: 1.2 }
    //             }
    //         ]
    //     });

    //     // Custom Navigation
    //     prevBtn.on('click', () => {
    //         wrapper.slick('slickPrev');
    //     });

    //     nextBtn.on('click', () => {
    //         wrapper.slick('slickNext');
    //     });

    //     // Enable/Disable navigation buttons
    //     wrapper.on('afterChange', function (event, slick, currentSlide) {
    //         const totalSlides = slick.slideCount;
    //         const visibleSlides = slick.options.slidesToShow;

    //         prevBtn.prop('disabled', currentSlide === 0);
    //         nextBtn.prop('disabled', currentSlide >= totalSlides - visibleSlides);
    //     });

    //     // Trigger initial button state
    //     wrapper.trigger('afterChange', [wrapper.slick('getSlick'), 0]);
    // }

    // function initializeAllSlickSliders() {
    //     $('.section').each(function () {
    //         initializeSlickSlider(this);
    //     });
    // }

    // function setupSliderObserver() {
    //     const observer = new MutationObserver(() => {
    //         initializeAllSlickSliders();
    //     });

    //     observer.observe(document.body, {
    //         childList: true,
    //         subtree: true
    //     });
    // }

    // $(document).ready(function () {
    //     initializeAllSlickSliders();
    //     setupSliderObserver();
    // });