public function filter(Request $request)
{
    // Debug incoming request
    \Log::info('Filter request:', $request->all());

    // Fetch products based on filters
    $products = Product::query();

    if ($request->category_id) {
        $products->where('category_id', $request->category_id);
    }

    if ($request->subcategory_id) {
        $products->where('subcategory_id', $request->subcategory_id);
    }

    if ($request->location) {
        $products->where('location', $request->location);
    }

    if ($request->min_price) {
        $products->where('price', '>=', $request->min_price);
    }

    if ($request->max_price) {
        $products->where('price', '<=', $request->max_price);
    }

    $products = $products->get();

    return response()->json([
        'success' => true,
        'products' => $products,
    ]);
}
