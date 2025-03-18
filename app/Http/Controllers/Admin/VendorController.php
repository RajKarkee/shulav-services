<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    //
    public function index()
    {
        $vendors=DB::table('vendors')
        ->join('users','users.id','=','vendors.user_id')
        ->join('cities','cities.id','=','vendors.city_id')
        ->join('services','services.id','=','vendors.service_id')
        ->select(DB::raw('vendors.id,users.name ,users.email,vendors.phone,vendors.address,cities.name as city,services.name as service,vendors.gender,vendors.is_org,vendors.active'))
        ->get();
        return view('admin.vendor.index',compact('vendors'));
    }

    public function add(Request $request){
        if($request->getMethod()=="POST"){
            if(User::where('email',$request->email)->count()>0){
                throw new \Exception('Email already in use.');
            }
            $u=new User();
            $v=new Vendor();
            try {
                $u->name=$request->name;
                $u->email=$request->email;
                $u->role=2;
                $u->password=bcrypt($request->phone);
                $u->save();

                // $v->name=$request->name;
                $v->service_id=$request->service_id;
                $v->city_id=$request->city_id;
                // $v->email=$request->email;
                $v->phone=$request->phone;
                $v->dob=$request->dob;
                $v->desc=$request->desc;
                $v->gender=$request->gender;
                $v->address=$request->address;
                if($request->has('image')){
                    $v->image=$request->image->store('uploads/vendor');
                }
                $v->user_id=$u->id;
                $v->save();

            } catch (\Throwable $th) {
                if($u->id!=0 && $u->id!=null){
                    $u->delete();
                }
                throw $th;
            }
        }else{
            $data=DB::select("select (select GROUP_CONCAT(id,concat(':',name)) from services) as services,(select GROUP_CONCAT(id,concat(':',name)) from cities) as cities");
            return view('admin.vendor.add',compact('data'));
        }
    }

    public function detail(Vendor $vendor)
    {

        $reviews=DB::table('reviews')
        ->join('users','users.id','=','reviews.user_id')
        ->join('vendors','vendors.user_id','=','users.id')
        ->where('reviews.vendor_id',$vendor->id)
        ->select(DB::raw('reviews.created_at as c,reviews.rate as r,users.name as n,reviews.desc as d,vendors.image as i,reviews.id as vid' ))
        ->orderByDesc('reviews.id')
        ->take(5)
        ->get();
        $products = DB::table('products')->where('vendor_id',$vendor->id)->get();


        // $otherServices=VendorServices::join('services','services.id','=','vendor_services.service_id')
        // ->where('vendor_services.vendor_id',$vendor->id)->select('services.name','services.image','services.id','vendor_services.active')->get();
        return view('admin.vendor.detail',compact('vendor','reviews','products'));
    }

    public function pdetail(Product $product)
    {
        $vendor=DB::table('vendors')
        ->join('users','users.id','=','vendors.user_id')
        ->select('vendors.id','users.name')
        ->where('vendors.id',$product->vendor_id)->first();

        return view('admin.vendor.product.index',compact('product','vendor'));
    }
    public function pstatus(Product $product,$status)
    {
        $product->active=$status;
        $product->save();
        return redirect()->back();
    }
    public function status(Vendor $vendor,$status)
    {
        $vendor->active=$status;
        $vendor->save();
        return redirect()->back();
    }
}
