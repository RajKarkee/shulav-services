<?php

namespace App;

class CacheKeys
{
    const SLIDERS = 'sliders';
    const SERVICE_CATEGORIES = 'service_categories';
    const FRONT_PAGE_SECTIONS = 'front_page_sections';
    const CITIES = 'cities';
    const ALL_CATEGORIES = 'all_categories';
    const SUBCATEGORIES = 'subcategories';
    
    // Dynamic keys
    public static function category($id) {
        return "category_{$id}";
    }
    
    public static function product($id) {
        return "product_{$id}";
    }
    
    public static function categoryProducts($categoryId, $subcategoryId = null) {
        return "products_category_{$categoryId}_subcategory_{$subcategoryId}";
    }
}