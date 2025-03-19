<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ProductAdded;
use App\Models\Product;
use App\Models\ProductMedia;
use App\Models\Service;
use App\Models\Vendor;
use App\Models\VendorBill;
use App\Models\VendorServices;
use App\Purify;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class VendorController extends Controller
{
    public function updateOpening(Request $request)
    {
        $user = Auth::user();
        $user->vendor->opening=json_encode( $request->all());
        $user->vendor->save();
    }
    public function update(Request $request)
    {
        $user = Auth::user();
        $validator = Validator::make(
            $request->all(),
            [
                'phone' => 'numeric|required',
                'name' => 'required|max:255',
                'city_id' => 'exists:cities,id|required',
            ]
        );

        if ($validator->fails()) {
            $err = [];
            $errors = $validator->errors()->toArray();
            foreach ($errors as $key => $_err) {
                foreach ($_err as $key => $__err) {
                    array_push($err, $__err);
                }
            }
            return response()->json(['status' => false, 'msg' => $err]);
        }

        if ($request->phone != $user->vendor->phone) {

            if (Vendor::where('phone', $request->phone)->where('id', '<>', $user->vendor->id)->count() > 0) {
                return response()->json(['status' => false, 'msg' => ['Phone Number Is Already Used']]);
            }
        }

        $user->name = $request->name;
        $user->save();

        $vendor = $user->vendor;
        $oldcity=$vendor->city_id;
        $vendor->phone = $request->phone;
        $vendor->address = $request->address;
        $vendor->city_id = $request->city_id;
        $vendor->gender = $request->gender;
        $vendor->dob = $request->dob;
        $vendor->desc = $request->desc;
        $vendor->save();

        return response()->json(['status' => true, 'msg' => []]);
    }

    public function changeImage(Request $request)
    {
        try {

            $image = $request->image->store('uploads/user');
            Vendor::where('user_id', Auth::user()->id)->update(['image' => $image]);
            return response()->json(['status' => true, 'image' => $image]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'image' => [$th->getMessage()]]);
        }
    }

    public function addService(Request $request)
    {
    }

    public function subscribe(Request $request)
    {
        try {
            //code...
            $user = Auth::user();
            $newservice = new VendorServices();
            $newservice->vendor_id = $user->vendor->id;
            $newservice->service_id    = $request->service_id;
            $newservice->save();
            $data = ['newservice' => $newservice, 'bill' => null];
            $data = getSetting('website');
            $now = Carbon::now();
            $service = Service::where('id', $request->service_id)->select('name', 'rate')->first();
            $arr = ["Service activation", "service activation 1  Year", 'Subscribtion For ' . $service->name, 'Subscribtion For ' . $service->name . ' 1  Year'];
            if ($data->type > 1) {

                $service = Service::where('id', $request->service_id)->select('name', 'rate')->first();
                $bill = new VendorBill();
                $bill->name = $user->name;
                $bill->vendor_id = $newservice->vendor_id;
                $bill->amount = $service->rate;
                $bill->type = $data->type;
                $bill->service_id = $newservice->service_id;
                $bill->particular = $arr[$data->type];
                $bill->date = Carbon::now();
                $bill->save();

                $newservice->active = 0;
                $newservice->paid = 0;
                $newservice->bill_id = $bill->id;
                $newservice->save();
                $data = [
                    'newservice' => $newservice,
                    'bill' => $bill
                ];
            }
            return response()->json(['status' => true, 'data' => $data]);
        } catch (\Throwable $th) {
            if ($newservice->id != null || $newservice->id != 0) {
                VendorServices::where('id', $newservice->id)->delete();
            }
            return response()->json(['status' => false, 'msg' => [$th->getMessage()]]);
        }
    }

    public function changeMainService(Request $request)
    {
        $user = Auth::user();
        Vendor::where('user_id', $user->id)->update(['service_id' => $request->service_id]);
        $this->updateCity();
        return response()->json(['status' => true]);
    }

    public function changeStatusService(Request $request)
    {
        VendorServices::where('id', $request->vendor_service_id)->update(['active' => $request->status]);
        return response()->json(['status' => true]);
    }

    private function updateCity($oldid = 0)
    {
        $user = Auth::user();
        $user->vendor;
        $id = $oldid == 0 ? $user->vendor->city_id : $oldid;
        $data = json_decode(include(public_path('api/city_' . $id . '.php')));
        foreach ($data->vendors as $key => $value) {
            if ($value->id == $user->vendor->id) {
                //Artisan::call('make:city', ['id' =>  $id]);
            }
        }

        $data = json_decode(include(public_path('api/homepage.php')));
        foreach ($data->top_professionals as $key => $value) {
            if ($value->id == $user->vendor->id) {
                //Artisan::call('make:homepage');
            }
        }
    }
    public function bills()
    {
        $user=Auth::user();
        return response()->json(['bills'=>DB::table('vendor_bills')->where('vendor_id',$user->vendor->id)->orderBy('id','desc')->get()]);
    }

    public function reviews()
    {
        $user=Auth::user();
        $count = DB::selectOne("select
            (select count(*) from reviews where vendor_id={$user->vendor->id}) as review_count,
            (select avg(rate) from reviews where vendor_id={$user->vendor->id}) as review_avg");

            $overview_query = 'select ';
            for ($i = 1; $i < 6; $i++) {
                $overview_query = $overview_query . "(select count(*) from reviews where vendor_id={$user->vendor->id} and rate={$i}) as review_count_{$i}" . ($i == 5 ? "" : ",");
            }
            $overview = DB::selectOne($overview_query);

            $reviews = DB::table('reviews')
                ->join('users', 'users.id', '=', 'reviews.user_id')
                ->join('vendors', 'vendors.user_id', '=', 'users.id')
                ->where('reviews.vendor_id', $user->vendor->id)
                ->select(DB::raw('reviews.created_at ,reviews.rate,users.name ,reviews.desc ,vendors.image ,reviews.id '))
                ->orderByDesc('reviews.id')
                ->get();
        return response()->json(compact('reviews','overview'));
    }

    public function productSingle( $id)
    {
        $product=Product::where('id',$id)->select('id','name','price','desc','short_desc','image','service_id')->first();
        return response()->json($product);
    }
    public function products($type)
    {
        return response()->json(['products'=>DB::table('products')->where('vendor_id',Auth::user()->vendor->id)->get(['id','name','image','start','end','active'])]);
    }

    public function productsAdd(Request $request)
    {
        $user=Auth::user();
        $validate = $request->validate([
            'image' => 'image|required',
            'name' => 'required',
            'price' => 'required|numeric|min:1',
            'start' => 'required|date',
            'end' => 'required|date',
            'service_id' => 'required|exists:services,id',
        ]);
        $product = new Product();
        $product->type = 1;
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
        $pricing = DB::table('pricings')->where('days', '<=', $days)->orderBy('days')->first();
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
        return response()->json($product);

    }

    public function productsEdit(Request $request)
    {
        $user=Auth::user();
        $product=Product::where('id',$request->id)->first();
        if($product==null){
            abort(404);
        }
        $validate=$request->validate([
            'name'=>'required',
            'price'=>'required|numeric|min:1'
        ]);
        $product->name=$request->name;
        $product->price=$request->price;
        $product->desc=Purify::removeJS( ($request->desc??""));
        $product->short_desc=$request->short_desc??"";
        $product->service_id=$request->service_id;
        if($request->hasFile('image')){
            $product->image=$request->image->store(getDatePath('uploads/product'));
        }
        $product->save();
        return response()->json($product);

    }
    public function productsDel(Request $request)
    {
        $user=Auth::user();
        $product=Product::where('id',$request->id)->first();
        if($product==null){
            abort(404);
        }else{
            $product->delete();
            return response()->json(['status'=>true]);
        }

    }

    public function gallery(Request $request, $id)
    {
        if($request->getMethod()=="GET"){
            $images=ProductMedia::where('parent_id',$id)->get();
            return response()->json($images);
        }else{
            if($request->type==1){
                $media=new ProductMedia();
                $media->parent_id=$id;
                $media->file=$request->image->store(getDatePath('uploads/product'));
                $media->type=1;
                $media->save();
                return response()->json($media);
            }elseif($request->type==2){
                ProductMedia::where('id',$request->id)->delete();
                return response()->json(['status'=>true]);
            }else{
                abort(500);
            }
        }
    }

}
