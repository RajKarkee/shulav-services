<?php

namespace App\Http\Controllers\front1;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\BusRoute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Models\FrontPageSection;
use App\Models\BusRouteLocation; // Import the BusRouteLocation model
use Illuminate\Support\Facades\Auth; // Import the Auth facade
use App\Models\Product; // Import the Product model
use App\Models\UserProduct;

class FrontController extends Controller
{
    public function index()
    {
        $sliders = Cache::rememberForever('sliders', function () {
            return DB::table('sliders')->get(['id', 'image', 'link']);
        });

        $serviceCategories = Cache::rememberForever('service_categories',  function () {
            return DB::table('categories')->whereNull('parent_id')->get(['id', 'name', 'image', 'type']);
        });

        $sections = Cache::rememberForever('front_page_sections',  function () {
            return FrontPageSection::with(['products.productType'])
                ->orderBy('position', 'asc')
                ->get();
        });
        $routes = BusRoute::with(
            ['fromLocation', 'toLocation']
        )->get();
        $locations = BusRouteLocation::all();
        $popups = DB::table('popups')->get();
        return view('front1.index', compact('sliders', 'serviceCategories', 'popups', 'sections', 'routes', 'locations'));
    }
    public function categoryIndex(Request $request, $id)
    {
        $category = Cache::rememberForever("category_{$id}",  function () use ($id) {
            return DB::table('categories')->where('id', $id)->first();
        });

        if (!$category) {
            abort(404);
        }

        $categoryId = $id;
        $subcategoryId = $request->query('subcategory_id');
        $subKey = $subcategoryId ?? 'none';

        $products = Cache::rememberForever("products_category_{$categoryId}_subcategory_{$subKey}", function () use ($categoryId, $subcategoryId) {
            $query = DB::table('products')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->select('products.*', 'categories.name as category_name')
                ->where('products.category_id', $categoryId)
                ->where('products.active', 1)
                ->orderBy('products.created_at', 'desc');

            if ($subcategoryId) {
                $query->where('products.subcategory_id', $subcategoryId);
            }

            return $query->paginate(12);
        });

        $cities = Helper::getCities();

        $allcategories = Cache::rememberForever('all_categories', function () {
            return DB::table('categories')->whereNull('parent_id')->get(['id', 'name']);
        });

        $subcategories = Cache::rememberForever('subcategories', function () {
            return DB::table('categories')->whereNotNull('parent_id')->get();
        });

        return view('front1.library', compact('cities', 'products', 'allcategories', 'category', 'subcategories'));
    }


    public function categorySingle($name, $id)
    {
        $product = Cache::rememberForever("product_{$id}",  function () use ($id) {
            return DB::table('products')
                ->leftjoin('cities', 'products.city_id', '=', 'cities.id')
                ->select('products.*', 'cities.name as city_name')
                ->where('products.id', $id)
                ->where('products.active', 1)
                ->first();
        });

        if (!$product) {
            abort(404);
        }

        return view('front1.single', compact('product'));
    }

    public function filterProducts(Request $request)
    {
        $cacheKey = 'filtered_products_' . md5(json_encode($request->all()));

        $response = Cache::rememberForever($cacheKey,  function () use ($request) {
            $query = DB::table('products')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->select('products.*', 'categories.name as category_name')
                ->where('products.active', 1);

            $category = null;

            if ($request->subcategory_id) {
                $query->where('products.category_id', $request->subcategory_id);
                $category = DB::table('categories')->where('id', $request->subcategory_id)->first();
            } elseif ($request->category_id) {
                $query->where('products.category_id', $request->category_id);
                $category = DB::table('categories')->where('id', $request->category_id)->first();
            }

            if ($request->min_price !== null && $request->max_price !== null) {
                $query->whereBetween('products.price', [$request->min_price, $request->max_price]);
            }

            if ($request->city_id && $request->city_id !== 'all') {
                $query->where('products.city_id', $request->city_id);
            }

            $products = $query->get();

            return [
                'products' => $products,
                'success'  => !$products->isEmpty(),
                'message'  => $products->isEmpty() ? 'No products found for the selected filters.' : '',
                'category' => $category,
            ];
        });

        return response()->json($response);
    }

    public function busServices()
    {
        return view('front.bus_services');
    }
    public function routeSearch(Request $request)
    {
        $from = $request->query('from');
        $to = $request->query('to');
        $routes = DB::table('bus_routes')
            ->join('bus_types', 'bus_routes.bus_type_id', '=', 'bus_types.id')

            ->where('from_location_id', $from)
            ->where('to_location_id', $to)
            ->get();
        $locations = DB::table('bus_route_locations')
            ->select('id', 'location_name')
            ->whereIn('id', [$from, $to])
            ->get()
            ->mapWithKeys(function ($location) use ($from, $to) {
                if ($location->id == $from) {
                    return ['from_location' => $location->location_name];
                } else {
                    return ['to_location' => $location->location_name];
                }
            });


        return view('front1.busServices.route', compact('routes', 'locations'));
    }

    public function seller()
    {
        $user = Auth::user();
        return view('user.index', compact('user'));
    }
    public function now()
    {
        $user = Auth::user();
        return view('front1.now', compact('user'));
    }
    public function name()
    {
        $user = Auth::user();
        return view('front1.name', compact('user'));
    }

    public function userProductsIndex(Request $request)
    {
        if (request()->isMethod('GET')) {
            $user = Auth::user();
            $products =DB::table('user_products')
            ->where('user_products.user_id', $user->id)
            ->join('products','user_products.product_id','=','products.id')
            ->join('categories','products.category_id','=','categories.id')

            ->select('products.*'
                ,'categories.name as category_name')
             ->get();


            return view('user.products.index',compact('products'));
        } else {
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
            $product->active = 0;
            if ($request->hasFile('image')) {
                $product->image = $request->file('image')->store('uploads/products');
            }

            for ($i = 0; $i < 6; $i++) {
                if ($request->hasFile('image-' . $i)) {
                    $product->{'image' . ($i + 1)} = $request->file('image-' . $i)->store('uploads/products');
                }
            }
            $product->save();
            $user = Auth::user();
            $userProduct = new UserProduct();
            $userProduct->user_id = $user->id;
            $userProduct->product_id = $product->id;
            $userProduct->save();

            $subKey = $subcategoryId ?? 'none';
            Cache::forget("products_category_{$product->category_id}_subcategory_{$subKey}");

            return redirect()->back()->with('success', 'Product added successfully!');
        }
    }

    public function userProductEdit(Request $request, $id)
    {
        if ($request->isMethod('GET')) {
            $product = DB::table('user_products')
                ->where('user_products.id', $id)
                ->join('products', 'user_products.product_id', '=', 'products.id')
                ->join('categories', 'products.category_id', '=', 'categories.id')
                ->select('products.*', 'categories.name as category_name')
                ->first();

            return view('user.products.edit', compact('product'));
        } else {
            $product = Product::find($id);
            $product->name = $request->name;
            $product->short_desc = $request->short_desc;
            $product->desc = $request->desc;
            $product->price = $request->price;
            $product->on_sale = $request->sale_price;
            $product->category_id = $request->category_id;
            $product->city_id = $request->city_id;
            $product->start = $request->start;
            $product->end = $request->end;
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

    public function userProductsDel($product_id){
        $user = Auth::user();
        $userProduct = UserProduct::where('user_id', $user->id)->where('product_id', $product_id)->first();
        if ($userProduct) {
            $userProduct->delete();
            return redirect()->back()->with('success', 'Product deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Product not found!');
        }
    }
}
