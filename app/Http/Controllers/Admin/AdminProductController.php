<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Models\ProductType;
use App\Models\Vendor;
use App\Models\City;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    // Display all products
    public function index()
    {

        return view('admin.product.index');
    }

    // Show the form to add a new product
    // Show the form to add a new product
    public function create()
    {

        return view('admin.product.add'); // Pass $cities to the view
    }

    // Store a new product

    // Show edit form
    public function edit(Product $product)
    {
        $productTypes = ProductType::all();
        $products = Product::all();
        $cities = City::all();
        $vendors = Vendor::all();
        return view('admin.product.edit', compact('product', 'productTypes', 'vendors'));
    }

    // Update product
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|unique:products,name,' . $product->id,
            'short_desc' => 'required',
            'desc' => 'required',
            'price' => 'required|numeric',
            'image' => 'image', // Image is optional in update
            'service_id' => 'required|integer',
            'start' => 'required|date',
            'end' => 'required|date',
            'count' => 'required|integer',
            'cityid' => 'required|exists:cities,id',
            'type' => 'required|exists:product_types,id'
        ]);

        // Store new image if uploaded
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);
            $imagePath = 'uploads/' . $imageName;
        } else {
            $imagePath = $product->image;
        }

        // Update product
        $product->update([
            'type' => $request->type,
            'name' => $request->name,
            'short_desc' => $request->short_desc,
            'desc' => $request->desc,
            'price' => $request->price,
            'vendor_id' => $request->vendor_id,
            'active' => $request->active,
            'image' => $imagePath,
            'service_id' => $request->service_id,
            'start' => $request->start,
            'end' => $request->end,
            'count' => $request->count,
            'cityid' => $request->cityid,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    // Delete product
    public function destroy(Product $product)
    {
        // Remove file if it exists
        $imagePath = public_path($product->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted!');
    }
    protected function uploadImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);
            return 'uploads/' . $imageName;
        }
        return null;
    }
}
