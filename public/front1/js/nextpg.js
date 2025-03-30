function toggleLocationList() {
    const locationList = document.querySelector('.location-list');
    const icon = document.querySelector('.location-title i');
    locationList.classList.toggle('show');
    icon.classList.toggle('collapsed');
}
function toggleCategoryList() {
    const categoryList = document.querySelector('.category-list');
    const icon = document.querySelector('.category-title i');
    categoryList.classList.toggle('show');
    icon.classList.toggle('collapsed');
}

function toggleSubCategories(event, element) {
    event.preventDefault();
    const subCategories = element.nextElementSibling;
    const icon = element.querySelector('i');

    if (subCategories && subCategories.classList.contains('sub-categories')) {
        subCategories.classList.toggle('show');
        icon.classList.toggle('collapsed');
    }
}

function selectCategory(event, element) {
    event.preventDefault();

    // Remove active class from all categories
    document.querySelectorAll('.category-list a').forEach(a => {
        a.classList.remove('active-category');
    });

    // Add active class to selected category
    element.classList.add('active-category');

    // If it's a subcategory, also activate its parent category
    const parentLink = element.closest('.sub-categories')?.previousElementSibling;
    if (parentLink) {
        parentLink.classList.add('active-category');
    }
}

function selectLocation(event, element) {
    event.preventDefault();
    // Remove active class from all locations
    document.querySelectorAll('.location-list a').forEach(a => {
        a.classList.remove('active');
    });
    // Add active class to selected location
    element.classList.add('active');
}

// Price Range Slider
const rangeInput = document.getElementById('priceRange');
const minPriceInput = document.getElementById('minPrice');
const maxPriceInput = document.getElementById('maxPrice');
const currentRange = document.getElementById('currentRange');

// Format number with commas
function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

// Format price with currency
function formatPrice(value) {
    return `₨ ${formatNumber(value)}`;
}

// Update display when slider moves
rangeInput.addEventListener('input', function () {
    const value = this.value;
    currentRange.textContent = formatPrice(value);
    maxPriceInput.value = formatNumber(value);
    minPriceInput.value = '0';
});

// Update slider when input fields change
maxPriceInput.addEventListener('change', function () {
    const value = this.value.replace(/,/g, '');
    if (value > 0 && value <= 1000000) {
        rangeInput.value = value;
        currentRange.textContent = formatPrice(value);
    }
});

minPriceInput.addEventListener('change', function () {
    const value = this.value.replace(/,/g, '');
    if (value >= 0 && value < maxPriceInput.value.replace(/,/g, '')) {
        this.value = formatNumber(value);
    }
});

// Initialize with default values
rangeInput.value = 500000;
maxPriceInput.value = '500,000';
minPriceInput.value = '0';
currentRange.textContent = formatPrice(500000);
