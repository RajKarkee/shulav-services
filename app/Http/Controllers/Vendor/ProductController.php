<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Mail\ProductAdded;
use App\Models\Product;
use App\Models\ProductMedia;
use App\Models\VendorBill;
use App\productHolder;
use App\Purify;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index($type)
    {
        $user = Auth::user();

        $products = DB::table('products')->where([
            ['type', $type],
            ['vendor_id', $user->vendor->id],

        ])->select(DB::raw('products.*,(select id from vendor_bills where service_id=products.id and type=5) as bill_id,(select paid from vendor_bills where service_id=products.id and type=5) as paid'))->get();
        // dd($products);
        return view('vendor.product.index', compact('type', 'products', 'user'));
    }

    public function status($product, $status)
    {
        Product::where('id', $product)->update([
            'active' => $status
        ]);
        return redirect()->back();
    }
    public function del(Product $product)
    {
        $product->delete();
        return redirect()->back();
    }

    public function gallery(Request $request,Product $product)
    {
        if($request->getMethod()=="GET"){
            $images=ProductMedia::where('parent_id',$product->id)->get();
            return view('vendor.product.gallery',compact('product','images'));
        }else{
            if($request->type==1){
                $media=new ProductMedia();
                $media->parent_id=$product->id;
                $media->file=$request->image->store(getDatePath('uploads/product'));
                $media->type=1;
                $media->save();
                return view('vendor.product.gallerylist',['images'=>[$media]]);
            }elseif($request->type==2){
                ProductMedia::where('id',$request->id)->delete();
            }else{
                abort(500);
            }
        }
    }

    public function add($type, Request $request)
    {
        $user = Auth::user();
        // $date=Carbon::now()->subDay(1);
        if ($request->getMethod() == "POST") {
            $validate = $request->validate([
                'image' => 'image|required',
                'name' => 'required',
                'price' => 'required|numeric|min:1',
                'start' => 'required|date',
                'end' => 'required|date',
                'service_id' => 'required|exists:services,id',
            ]);
            $product = new Product();
            $product->type = $type;
            $product->active = 0;
            $product->name = $request->name;
            $product->start = $request->start;
            $product->end = $request->end;
            $product->service_id = $request->service_id;
            $product->price = $request->price;
            $product->desc = Purify::removeJS(($request->desc ?? ""));
            $product->short_desc = $request->short_desc ?? "";
            $product->vendor_id = $user->vendor->id;
            $product->image = $request->image->store(getDatePath('uploads/product'));
            $product->save();
            if($request->images!=null){
                foreach ($request->images as $key => $image) {
                    $media=new ProductMedia();
                    $media->parent_id=$product->id;
                    $media->file=$image->store(getDatePath('uploads/product'));
                    $media->type=1;
                    $media->save();
                }
            }

            $start = new Carbon($request->start);
            $end = new Carbon($request->end);

            $days = $start->diff($end)->days + 1;

            $pricing = DB::table('pricings')->where('days', '>=', $days)->orderBy('days')->first();
            // dd($pricing,$days,$request->start,$request->end);
            if ($pricing == null) {
                $pricing = DB::table('pricings')->orderByDesc('days')->first();
            }
            $bill = new VendorBill();
            if ($pricing->price > 0) {
                $bill->name = $user->name;
                $bill->vendor_id = $user->vendor->id;
                $bill->amount = $pricing->price;
                $bill->type = 5;
                $bill->service_id = $product->id;
                $bill->particular = "lisitng {$product->name} for {$days} days.";
                $bill->date = Carbon::now();
                $bill->save();
                Mail::to($user)->send(new ProductAdded($user,$bill));
            }


            // dd($days, $start, $end, $product, $product, $pricing,$bill);
            return redirect()->back()->with('message','product added');
        } else {
            return view('vendor.product.add', compact('type', 'user'));
        }
    }

    public function edit(Product $product, Request $request)
    {
        $user = Auth::user();
        $type = $product->type;
        if ($request->getMethod() == "POST") {
            $validate = $request->validate([
                'name' => 'required',
                'price' => 'required|numeric|min:1'
            ]);
            $product->name = $request->name;
            $product->price = $request->price;

            $product->desc = Purify::removeJS(($request->desc ?? ""));
            $product->short_desc = $request->short_desc ?? "";
            $product->vendor_id = $user->vendor->id;
            if ($request->hasFile('image')) {
                $product->image = $request->image->store(getDatePath('uploads/product'));
            }
            $product->save();
            if($request->images!=null){
                foreach ($request->images as $key => $image) {
                    $media=new ProductMedia();
                    $media->parent_id=$product->id;
                    $media->file=$image->store(getDatePath('uploads/product'));
                    $media->type=1;
                    $media->save();
                }
            }
            return redirect()->back();
        } else {
            return view('vendor.product.edit', compact('type', 'product', 'user'));
        }
    }
}
