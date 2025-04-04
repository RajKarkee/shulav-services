<?php

namespace App\Http\Controllers\front1;

use App\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\FrontPageSection;
use CreateProductsTable;

class FrontController extends Controller
{
    public function index()
    {
        $sliders = DB::table('sliders')->get(['id', 'image', 'link']);
        $serviceCategories = DB::table('categories')->whereNull('parent_id')->get(['id', 'name', 'image']);
        $sections = FrontPageSection::with(['products.productType'])
            ->orderBy('position', 'asc')
            ->get();
        return view('front1.index', compact('sliders', 'serviceCategories', 'sections'));
    }

    public function categoryIndex(Request $request, $id)
    {
        // Get the category from the database using the $id passed in the route
        $category = DB::table('categories')->where('id', $id)->first();

        if (!$category) {
            abort(404); // Category not found
        }

        // Get the category_id from the route and subcategory_id from the query string
        $categoryId = $id; // This is the category_id from the route
        $subcategoryId = $request->query('subcategory_id'); // Get subcategory_id from the query string (if available)

        // Start building the query to get products based on category or subcategory
        $query = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.name as category_name')
            ->where('products.category_id', $categoryId)
            ->where('products.active', 1)
            ->orderBy('products.created_at', 'desc');

        // If a subcategory_id is provided, filter by subcategory
        if ($subcategoryId) {
            $query->where('products.subcategory_id', $subcategoryId);
        }
        // Get the paginated list of products
        $products = $query->paginate(12);
        $cities = Helper::getCities();
        // Fetch all categories and subcategories
        $allcategories = DB::table('categories')->whereNull('parent_id')->get(['id', 'name']);
        $subcategories = DB::table('categories')->whereNotNull('parent_id')->get();

        // Return the view with products, categories, and subcategories
        return view('front1.library', compact('cities','products', 'allcategories', 'category', 'subcategories'));
    }

    public function categorySingle($name, $id)
    {
        $product = DB::table('products')
            ->leftjoin('cities', 'products.city_id', '=', 'cities.id')
            ->select('products.*', 'cities.name as city_name')

            ->where('products.id', $id)
            ->where('products.active', 1)
            ->first();

        if (!$product) {
            abort(404);
        }
        return view('front1.view', compact('product'));
    }

    public function filterProducts(Request $request)
    {
        // Build the base query
        $query = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.name as category_name')
            ->where('products.active', 1);
    
        // Initialize $category as null
        $category = null;
    
        // If subcategory_id is provided, filter by subcategory_id and fetch that category info.
        // Otherwise, if category_id is provided, filter by category_id.
        if ($request->subcategory_id) {
            $query->where('products.category_id', $request->subcategory_id);
            $category = DB::table('categories')->where('id', $request->subcategory_id)->first();
        } elseif ($request->category_id) {
            $query->where('products.category_id', $request->category_id);
            $category = DB::table('categories')->where('id', $request->category_id)->first();
        }
    
        // Apply price range filter if both min and max prices are provided
        if ($request->min_price !== null && $request->max_price !== null) {
            $query->whereBetween('products.price', [$request->min_price, $request->max_price]);
        }
    
        // Apply city filter if provided
        if ($request->city_id) {
            $query->where('products.city_id', $request->city_id);
        }
    
        // Get the filtered products
        $products = $query->get();
    
        // Build the response
        $response = [
            'products' => $products,
            'success'  => !$products->isEmpty(),
            'message'  => $products->isEmpty() ? 'No products found for the selected filters.' : ''
        ];
    
        // Include category info if a category filter was applied
        if ($category) {
            $response['category'] = $category;
        }
    
        return response()->json($response);
    }
    
}
