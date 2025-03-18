<?php

namespace App\Http\Controllers\Front;

use App\Extra\Opening;
use App\Helper;
use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorBill;
use App\Models\VendorServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{

    public function verify(Request $request){
        $user=User::where('email',$request->email)->where('token',$request->code)->first();
        if($user!=null){

        }else{

        }
    }
    public function editInfo(Request $request)
    {
        $user = Auth::user();

        if ($request->getMethod() == "POST") {
            if ($request->phone != $user->vendor->phone) {

                if (Vendor::where('phone', $request->phone)->where('id', '<>', $user->vendor->id)->count() > 0) {
                    throw new \Exception('Phone Number Is Already Used');
                }
            }

            $user->name = $request->name;
            $user->save();

            $vendor = $user->vendor;
            $oldcity = $vendor->city_id;
            $vendor->phone = $request->phone;
            $vendor->address = $request->address;
            $vendor->city_id = $request->city_id;
            $vendor->gender = $request->gender;
            $vendor->dob = $request->dob;
            $vendor->desc = $request->desc;
            $vendor->save();

            $this->updateCity();
            if ($oldcity != $vendor->city_id) {
                $this->updateCity($oldcity);
            }

        } else {

            return view('vendor.edit', compact('user'));
        }
    }

    private function updateCity($oldid = 0)
    {
        $user = Auth::user();
        $user->vendor;
        $id = $oldid == 0 ? $user->vendor->city_id : $oldid;
        $data = json_decode(include(public_path('api/city_' . $id . '.php')));
        foreach ($data->vendors as $key => $value) {
            if ($value->id == $vendor->id) {
                Artisan::call('make:city', ['id' =>  $id]);
            }
        }

        $data = json_decode(include(public_path('api/homepage.php')));
        dd($data);
        foreach ($data->top_professionals as $key => $value) {
            if ($value->id == $vendor->id) {
                Artisan::call('make:homepage');
            }
        }
    }

    public function updatePass(Request $request)
    {
        $user = Auth::user();
        if (Hash::check($request->oldpass, $user->password)) {
            $user->password = bcrypt($request->pass);
            $user->save();
            return response()->json('ok');
        } else {
            throw new \Exception('Password Not Match');
        }
    }
    public function changeImage(Request $request)
    {
        $user=Auth::user();
        $image = $request->image->store('uploads/vendor');
        Vendor::where('user_id', $user->id)->update(['image' => $image]);
        $this->updateCity();

        return response()->json(['status' => true]);
    }

    public function changeMainService(Request $request, $id)
    {
        $user=Auth::user();

        Vendor::where('user_id', $user->id)->update(['service_id' => $id]);
        $this->updateCity();

        return redirect()->back();
    }
    public function changeStatusService($id, $status)
    {
        VendorServices::where('id', $id)->update(['active' => $status]);
        return redirect()->back();
    }
    public function changeDesc(Request $request)
    {
        // $image= $request->image->store('uploads/vendor');
        Vendor::where('user_id', Auth::user()->id)->update(['desc' => $request->desc]);
        return response()->json(['status' => true]);
    }
    public function changeName(Request $request)
    {
        $user = Auth::user();
        $user->name = $request->name;
        $user->save();
        $this->updateCity();

        return response()->json(['status' => true]);
    }
    public function index()
    {
        $user = Auth::user();

        // $reviews = DB::table('reviews')
        //     ->join('users', 'users.id', '=', 'reviews.user_id')
        //     ->join('vendors', 'vendors.user_id', '=', 'users.id')
        //     ->where('reviews.vendor_id', $user->vendor->id)
        //     ->select(DB::raw('reviews.created_at as c,reviews.rate as r,users.name as n,reviews.desc as d,vendors.image as i,reviews.id as vid'))
        //     ->orderByDesc('reviews.id')
        //     ->take(5)
        //     ->get();

        $info=DB::selectOne('select
        (select count(*) from products where vendor_id = ? and type=1) as products,
        (select count(*) from vendor_bills where vendor_id = ? ) as invoices,
        (select count(*) from reviews where vendor_id = ? ) as reviews

        ',[$user->vendor->id,$user->vendor->id,$user->vendor->id]);
        // $otherServices = VendorServices::join('services', 'services.id', '=', 'vendor_services.service_id')
        //     ->where('vendor_services.vendor_id', $user->vendor->id)->select('services.name', 'services.image', 'services.id')->get();
        // dd(compact('reviews'));
        return view('vendor.dashboard.index', compact('user',  'info'));
    }

    public function step(Request $request)
    {
        $user = Auth::user();
        $step = $user->vendor->step;
        // dd($step);
        if ($request->getMethod() == "POST") {
            try {
                if ($step == 1) {

                    $image = $request->image->store('uploads/vendor');
                    Vendor::where('user_id', $user->id)->update(['image' => $image, 'step' => 2]);
                    return response()->json(['status' => true]);
                } elseif ($step == 2) {
                    Vendor::where('user_id', $user->id)->update(['desc' => $request->desc, 'step' => 3]);
                    return response()->json(['status' => true]);
                } elseif ($step == 3) {
                    $data = Opening::init($request);
                    Vendor::where('user_id', $user->id)->update(['opening' => json_encode($data), 'step' => 4]);
                    return response()->json(['status' => true]);

                    // return response()->json($data);
                }
                // $vendor=Auth::user()->vendor;
            } catch (\Throwable $th) {
                throw $th;
            }
        } else {
            if ($step > 3) {
                return redirect()->route('vendor.dashboard');
            } else {
                return view('vendor.step-' . $step);
            }
        }
    }


    public function bill(VendorBill $bill)
    {

        $user = Auth::user();
        if ($bill->vendor_id != $user->vendor->id) {
            abort(404, 'Bill not found');
        }
        return view('vendor.bill', compact('bill', 'user'));
    }
    public function bills()
    {

        $user = Auth::user();
        return view('vendor.bills', compact( 'user'));
    }
    public function reviews(Request $request)
    {
        $user = Auth::user();
        if ($request->getMethod() == "GET") {

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
                ->select(DB::raw('reviews.created_at as c,reviews.rate as r,users.name as n,reviews.desc as d,vendors.image as i,reviews.id as vid'))
                ->orderByDesc('reviews.id')
                ->get();
            return view('vendor.review', compact('reviews', 'count', 'user', 'overview'));
        }
    }
    public function subscribe(Request $request)
    {
        $user = Auth::user();

        if ($request->getMethod() == "POST") {
            $newservice = new VendorServices();
            $newservice->vendor_id = $user->vendor->id;
            $newservice->service_id    = $request->service_id;
            $newservice->save();
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
            }


            return redirect()->back()->with('messaeg', 'Subscription added Sucessfully');
        } else {
            $cats1 = VendorServices::where('vendor_services.vendor_id', $user->vendor->id)
                ->join('services', 'services.id', '=', 'vendor_services.service_id')
                ->select('services.id', 'services.name', 'services.image', 'vendor_services.*')->get();
            // $ids->push($user->vendor->service_id);
            $ids = VendorServices::where('vendor_id', $user->vendor->id)->pluck('service_id');
            $ids_str = '(' . $ids->join(',') . ')';

            if(count($ids)>0){
                $query = "select id,name,rate, (select group_concat(id,':',name,':',rate) from services where category_id=categories.id and id not in {$ids_str}) as services from categories";
            }else{
                $query = "select id,name,rate, (select group_concat(id,':',name,':',rate) from services where category_id=categories.id ) as services from categories";

            }
            $cats = DB::select($query);
            return view('vendor.subscription', compact('user', 'cats', 'cats1'));
        }
    }

    public function openingHour (Request $request)
    {
        $user=Auth::user();
        // dd($data);
        if($request->getMethod()=="POST"){
            $data = Opening::init($request);
            $user->vendor->opening=$data;
            $user->vendor->save();
            return redirect()->back();
        }else{
            $data= (array)$user->vendor->opening;
            return view('vendor.opening',compact('user','data'));
        }
    }
}
