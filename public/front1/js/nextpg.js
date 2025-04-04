// Function to update only the products section via AJAX
function updateProductsOnly() {
    // Show loading indicator in products area
    const contentArea = document.querySelector('.content .col');
    contentArea.innerHTML = '<div class="loading">Loading products...</div>';
    
    // Get current filters from the UI elements
    gatherFiltersFromUI();
    
    // Make AJAX request
    fetch(`/product/library/filter?${new URLSearchParams({
        category_id: currentFilters.categoryId,
        subcategory_id: currentFilters.subcategoryId || '',
        location: currentFilters.location || '',
        min_price: currentFilters.minPrice,
        max_price: currentFilters.maxPrice
    })}`)
    .then(response => {
        if (!response.ok) {
            console.error('Error response:', response.status, response.statusText);
            throw new Error('Failed to fetch products');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Update only the products section
            contentArea.innerHTML = '';
            
            if (data.products.length === 0) {
                contentArea.innerHTML = '<div class="no-products">No products found matching your filters.</div>';
            } else {
                data.products.forEach(product => {
                    // Count images
                    const imageCount = (
                        (product.image ? 1 : 0) +
                        (product.image1 ? 1 : 0) +
                        (product.image2 ? 1 : 0) +
                        (product.image3 ? 1 : 0) +
                        (product.image4 ? 1 : 0) +
                        (product.image5 ? 1 : 0) +
                        (product.image6 ? 1 : 0)
                    );
                    
                    // Create card HTML - match your existing card structure
                    const cardHtml = `
                        <div class="card">
                            <a href="#" class="card-link">
                                <div class="card">
                                    <div class="card-image">
                                        <img src="${product.image}" alt="Product" loading="lazy">
                                        <span class="image-count"><i class="fas fa-camera"></i> ${imageCount}</span>
                                    </div>
                                    <div class="card-body">
                                        <div class="category">
                                            <i class="fas fa-car"></i>${product.short_desc}
                                        </div>
                                        <h5>${product.name}</h5>
                                        <p class="price">${product.price}Rs</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    `;
                    
                    // Add card to content area
                    contentArea.innerHTML += cardHtml;
                });
            }
            
            // Update URL for bookmark/sharing without refresh
            updateURLWithoutReload();
        } else {
            console.error('Error in response data:', data);
            contentArea.innerHTML = '<div class="error">Error loading products. Please try again.</div>';
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        contentArea.innerHTML = '<div class="error">Error loading products. Please try again.</div>';
    });
}


// Gather all current filter values from the UI
function gatherFiltersFromUI() {
    // For category and subcategory, use the active elements
    const activeCategory = document.querySelector('.category-list a.active-category');
    if (activeCategory) {
        const href = activeCategory.getAttribute('href');
        const parts = href.split('/');
        currentFilters.categoryId = parts[parts.length - 1].split('?')[0];
        
        // Check if this is a subcategory link
        if (activeCategory.closest('.sub-categories')) {
            const urlParts = href.split('?');
            if (urlParts.length > 1) {
                const params = new URLSearchParams(urlParts[1]);
                currentFilters.subcategoryId = params.get('subcategory_id');
            }
        } else {
            currentFilters.subcategoryId = null; // Reset subcategory if main category selected
        }
    }
    
    // For location, use the active location
    const activeLocation = document.querySelector('.location-list a.active');
    currentFilters.location = activeLocation ? activeLocation.textContent.trim() : null;
    
    // For price range, use the input values
    const minPriceInput = document.getElementById('minPrice');
    const maxPriceInput = document.getElementById('maxPrice');
    
    currentFilters.minPrice = minPriceInput ? minPriceInput.value.replace(/,/g, '') : 0;
    currentFilters.maxPrice = maxPriceInput ? maxPriceInput.value.replace(/,/g, '') : 500000;
}

// Update URL without page reload
function updateURLWithoutReload() {
    const url = new URL(window.location.href);
    
    // Update path for category
    if (currentFilters.categoryId) {
        // Update pathname to show correct category
        const pathParts = url.pathname.split('/');
        pathParts[pathParts.length - 1] = currentFilters.categoryId;
        url.pathname = pathParts.join('/');
    }
    
    // Clear existing parameters
    url.search = '';
    
    // Add parameters based on filters
    if (currentFilters.subcategoryId) {
        url.searchParams.set('subcategory_id', currentFilters.subcategoryId);
    }
    
    if (currentFilters.location) {
        url.searchParams.set('location', currentFilters.location);
    }
    
    if (currentFilters.minPrice > 0) {
        url.searchParams.set('min_price', currentFilters.minPrice);
    }
    
    if (currentFilters.maxPrice < 1000000) {
        url.searchParams.set('max_price', currentFilters.maxPrice);
    }
    
    // Update browser history without reloading page
    window.history.pushState({path: url.href}, '', url.href);
}

// Toggle Category List
function toggleCategoryList() {
    const categoryList = document.querySelector('.category-list');
    const icon = document.querySelector('.category-title i');
    categoryList.classList.toggle('show');
    icon.classList.toggle('collapsed');
}

// Toggle the location list
function toggleLocationList() {
    const locationList = document.querySelector('.location-list');
    const icon = document.querySelector('.location-title i');
    locationList.classList.toggle('show');
    icon.classList.toggle('collapsed');
}

// Select category and update products
function selectCategory(event, element) {
    event.preventDefault();

    // Remove active class from all categories
    document.querySelectorAll('.category-list a').forEach(a => {
        a.classList.remove('active-category');
    });

    // Add active class to selected category
    element.classList.add('active-category');
    
    // If this is a main category with subcategories, expand them
    const subCategories = element.nextElementSibling;
    if (subCategories && subCategories.classList.contains('sub-categories')) {
        subCategories.classList.add('show');
        const icon = element.querySelector('i');
        if (icon) {
            icon.classList.add('collapsed');
        }
    }
    
    // Update products section
    updateProductsOnly();
}

// Select location and update products
function selectLocation(event, element) {
    event.preventDefault();
    
    // Remove active class from all locations
    document.querySelectorAll('.location-list a').forEach(a => {
        a.classList.remove('active');
    });
    
    // Add active class to selected location
    element.classList.add('active');
    
    // Update products section
    updateProductsOnly();
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
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
    if (rangeInput) {
        rangeInput.addEventListener('input', function() {
            const value = this.value;
            currentRange.textContent = formatPrice(value);
            maxPriceInput.value = formatNumber(value);
            minPriceInput.value = '0';
        });

        // Update products when slider is released
        rangeInput.addEventListener('change', function() {
            updateProductsOnly();
        });
    }

    // Update products when max price input changes
    if (maxPriceInput) {
        maxPriceInput.addEventListener('change', function() {
            const value = this.value.replace(/,/g, '');
            if (value > 0 && value <= 1000000) {
                rangeInput.value = value;
                currentRange.textContent = formatPrice(value);
                updateProductsOnly();
            }
        });
    }

    // Update products when min price input changes
    if (minPriceInput) {
        minPriceInput.addEventListener('change', function() {
            const value = this.value.replace(/,/g, '');
            if (value >= 0 && value < maxPriceInput.value.replace(/,/g, '')) {
                this.value = formatNumber(value);
                updateProductsOnly();
            }
        });
    }

    // Initialize with values from URL
    initializeFromURL();
    
    // Handle browser back/forward buttons
    window.addEventListener('popstate', function() {
        initializeFromURL();
        updateProductsOnly();
    });
});

// Initialize filter values from URL
function initializeFromURL() {
    const url = new URL(window.location.href);
    const urlParams = new URLSearchParams(url.search);
    
    // Get category ID from URL path
    const pathParts = url.pathname.split('/');
    const categoryId = pathParts[pathParts.length - 1];
    
    if (categoryId && !isNaN(categoryId)) {
        // Find and activate the category in the UI
        const categoryLink = document.querySelector(`.category-list a[href*="/library/${categoryId}"]`);
        if (categoryLink) {
            // Remove active class from all categories
            document.querySelectorAll('.category-list a').forEach(a => {
                a.classList.remove('active-category');
            });
            
            // Add active class to this category
            categoryLink.classList.add('active-category');
            
            // Store in current filters
            currentFilters.categoryId = categoryId;
        }
    }
    
    // Get subcategory ID from URL query
    const subcategoryId = urlParams.get('subcategory_id');
    if (subcategoryId) {
        // Find and activate the subcategory in the UI
        const subcategoryLink = document.querySelector(`.sub-categories a[href*="subcategory_id=${subcategoryId}"]`);
        
        if (subcategoryLink) {
            // Remove active class from all categories
            document.querySelectorAll('.category-list a').forEach(a => {
                a.classList.remove('active-category');
            });
            
            // Add active class to this subcategory
            subcategoryLink.classList.add('active-category');
            
            // Make sure the parent category's subcategory list is visible
            const subCategoryList = subcategoryLink.closest('.sub-categories');
            if (subCategoryList) {
                subCategoryList.classList.add('show');
                
                // Change the icon of the parent category
                const parentCategory = subCategoryList.previousElementSibling;
                if (parentCategory) {
                    const icon = parentCategory.querySelector('i');
                    if (icon) {
                        icon.classList.add('collapsed');
                    }
                }
            }
            
            // Store in current filters
            currentFilters.subcategoryId = subcategoryId;
        }
    }
    
    // Get location from URL query
    const location = urlParams.get('location');
    if (location) {
        // Find and activate the location in the UI
        const locationLinks = document.querySelectorAll('.location-list a');
        locationLinks.forEach(link => {
            if (link.textContent.trim() === location) {
                // Remove active class from all locations first
                document.querySelectorAll('.location-list a').forEach(a => {
                    a.classList.remove('active');
                });
                
                // Add active class to this location
                link.classList.add('active');
                
                // Store in current filters
                currentFilters.location = location;
            }
        });
    }
    
    // Get price range from URL query
    const minPrice = urlParams.get('min_price');
    const maxPrice = urlParams.get('max_price');
    
    if (minPrice) {
        const minPriceInput = document.getElementById('minPrice');
        if (minPriceInput) {
            minPriceInput.value = formatNumber(minPrice);
            currentFilters.minPrice = minPrice;
        }
    }
    
    if (maxPrice) {
        const maxPriceInput = document.getElementById('maxPrice');
        const rangeInput = document.getElementById('priceRange');
        const currentRange = document.getElementById('currentRange');
        
        if (maxPriceInput) {
            maxPriceInput.value = formatNumber(maxPrice);
            currentFilters.maxPrice = maxPrice;
        }
        
        if (rangeInput) {
            rangeInput.value = maxPrice;
        }
        
        if (currentRange) {
            currentRange.textContent = formatPrice(maxPrice);
        }
    }
}

// Helper function to format numbers with commas
function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

// Helper function to format price with currency symbol
function formatPrice(value) {
    return `₨ ${formatNumber(value)}`;
}
