<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\ProductType;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    public function index()
    {
        $productTypes = ProductType::all();
        return view('admin.product_types.index', compact('productTypes'));
    }

    public function create()
    {
        return view('admin.product_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:product_types,name',
        ]);

        ProductType::create(['name' => $request->name]);
        cache()->forget('front_page_sections');
        cache()->forget('service_categories');


        return redirect()->route('admin.product_types.create')->with('success', 'Product type added successfully!');
    }

    public function destroy(ProductType $productType)
    {
        $productType->delete();
        cache()->forget('front_page_sections');
        cache()->forget('service_categories');
        return redirect()->route('admin.product_types.index')->with('success', 'Product type deleted!');
    }
}
