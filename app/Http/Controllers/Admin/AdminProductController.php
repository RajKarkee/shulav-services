<?php

namespace App\Http\Controllers\Admin;

use App\Helper;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Models\ProductType;
use App\Models\Vendor;
use App\Models\City;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.product.index');
    }

    public function loadData(Request $request)
    {
        $query = DB::table(Product::tableName);
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->filled('city_id')) {
            $query->where('city_id', $request->city_id);
        }
        $products = $query->get(['id', 'name', 'short_desc',  'price', 'on_sale', 'image', 'category_id', 'city_id']);
        return response()->json($products);
    }
    public function create()
    {
        $serviceCategories = Helper::getCategoriesMini();
        $cities = DB::table('cities')->get(['id', 'name']);
        return view('admin.product.add', compact('serviceCategories', 'cities')); // Pass $cities to the view
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:products,name',
            'short_desc' => 'required',
            'desc' => 'required',
            'price' => 'required|numeric',
            'image' => 'required|image',
            'category_id' => 'required|exists:categories,id',
            'city_id' => 'required|exists:cities,id',
            'start' => 'nullable|date',
            'end' => 'nullable|date'
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->short_desc = $request->short_desc;
        $product->desc = $request->desc;
        $product->price = $request->price;
        $product->on_sale = $request->sale_price;
        $product->category_id = $request->category_id;
        $product->city_id = $request->city_id;
        $product->start = $request->start;
        $product->end = $request->end;
        $product->active = 1;
        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('uploads/products');
        }

        for ($i = 0; $i < 6; $i++) {
            if ($request->hasFile('image-' . $i)) {
                $product->{'image' . ($i + 1)} = $request->file('image-' . $i)->store('uploads/products');
            }
        }
        $product->save();
        return redirect()->back()->with('success', 'Product added successfully!');
    }
    public function edit(Request $request, $product_id)
    {
        $product = Product::where('id', $product_id)->first();
        if($request->getMethod() == 'GET'){
            $serviceCategories = DB::table('categories')->where('type', 2)->get(['id', 'name']);
            $cities = DB::table('cities')->get(['id', 'name']);
            return view('admin.product.edit', compact('product', 'serviceCategories', 'cities'));
        }else{
            $product->name = $request->name;
            $product->short_desc = $request->short_desc;
            $product->desc = $request->desc;
            $product->price = $request->price;
            $product->on_sale = $request->sale_price;
            $product->category_id = $request->category_id;
            $product->city_id = $request->city_id;
            $product->start = $request->start;
            $product->end = $request->end;
            $product->active = 1;
            if ($request->hasFile('image')) {
                $product->image = $request->file('image')->store('uploads/products');
            }

            for ($i = 0; $i < 6; $i++) {
                if ($request->hasFile('image-' . $i)) {
                    $product->{'image' . ($i + 1)} = $request->file('image-' . $i)->store('uploads/products');
                }
            }
            $product->save();
            return redirect()->back()->with('success', 'Product updated successfully!');
        }
    }

    // Delete product
    public function del( $product_id)
    {
        Product::where('id', $product_id)->delete();
        return redirect()->back()->with('success', 'Product deleted successfully!');
    }
}
