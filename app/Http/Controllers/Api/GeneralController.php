<?php

namespace App\Http\Controllers\Api;

use App\Console\Commands\Vendors;
use App\Http\Controllers\Controller;
use App\Mail\UserJoined;
use App\Models\ProductMedia;
use App\Models\Service;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorBill;
use App\Models\VendorServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Client;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;

class GeneralController extends Controller
{
    //

    public function index()
    {
        $sliders = DB::select('select mobile_image as i from sliders');
        $popup = DB::select('select image as i from popups where active=1 limit 1');
        $top_professionals = DB::select("select v.image as i,u.username as u,u.name as n,v.id,s.name as s,c.name as c from vendors v join services s on v.service_id=s.id join cities c on v.city_id=c.id join users u on u.id=v.user_id where u.role=2 order by v.count desc limit 8 ");
        $categories = DB::select('select id,n,i from (select id,name as n,image as i, (select sum(count) from vendors where vendors.service_id=services.id) as c from services) ss order by ss.c desc limit 9');
        $data = compact('categories', 'top_professionals', 'sliders', 'popup');
        return response()->json($data);
    }
    public function search(Request $request)
    {
        $asset = asset('');
        $loc_id = $request->loc_id ?? -1;
        $ser_id = $request->ser_id ?? -1;

        $empty = false;
        // dd($se)
        if ($loc_id == -1 && $ser_id == -1) {
            $vendors = [];
            $empty = true;
        } else {

            $vendors_query = DB::table('vendors')
                ->join('users', 'users.id', '=', 'vendors.user_id')
                ->join('cities', 'cities.id', '=', 'vendors.city_id')
                ->join('services', 'services.id', '=', 'vendors.service_id')
                ->select(DB::raw("cities.name as cn, vendors.image as i,users.name as n,users.username u,vendors.id,vendors.phone p,services.name as s,vendors.service_id as sid,vendors.address a,vendors.count c,(select count(*) from reviews where vendor_id=vendors.id) as rc,(select avg(rate) from reviews where vendor_id=vendors.id) as ra"))
                ->where('vendors.active', 1);
            if ($request->filled('ser_id')) {

                $vendors_query = $vendors_query->where('vendors.service_id', $ser_id);
            }
            if ($request->filled('loc_id')) {

                $vendors_query = $vendors_query->where('vendors.city_id', $loc_id);
            }

            if ($request->filled('orderby')) {
                switch ($request->orderby) {
                    case 1:
                        $vendors_query = $vendors_query->orderByRaw('users.name asc');
                        break;
                    case 2:
                        $vendors_query = $vendors_query->orderByRaw('vendors.count desc');
                        break;
                    case 3:
                        $vendors_query = $vendors_query->orderByRaw('(select avg(rate) from reviews where vendor_id=vendors.id) desc');
                        break;
                    default:
                        # code...
                        break;
                }
            }
            $vendors = $vendors_query->where('vendors.type', 1)->paginate(12);
        }
        // dd($vendors);

        return response()->json($vendors);
    }
    public function searchProduct(Request $request)
    {
        $asset = asset('');
        $loc_id = $request->loc_id ?? -1;
        $ser_id = $request->ser_id ?? -1;

        $empty = false;
        // dd($se)
        if ($loc_id == -1 && $ser_id == -1) {
            $products = [];
            $empty = true;
        } else {

            $product_query = DB::table('products')
                ->join('vendors', 'vendors.id', '=', 'products.vendor_id')
                ->join('users', 'users.id', '=', 'vendors.user_id')
                ->join('cities', 'cities.id', '=', 'vendors.city_id')
                ->select(DB::raw('cities.name as city,products.name,products.id,concat(products.price," / ",products.short_desc) as price,products.image'));
            if ($ser_id != -1) {

                $product_query = $product_query->where('products.service_id', $ser_id);
            }
            if ($loc_id != -1) {
                $product_query = $product_query->where('vendors.city_id', $loc_id);
            }

            $product_query = $product_query->whereRaw('? between products.start and products.end', [date('Y-m-d')])->where('products.active', 1);
            // dd($product_query->toSql());

            if ($request->filled('orderby')) {
                switch ($request->orderby) {
                    case 1:
                        $product_query = $product_query->orderByRaw('products.name asc');
                        break;
                    case 2:
                        $product_query = $product_query->orderByRaw('products.count desc');
                        break;
                    case 3:
                        $product_query = $product_query->orderByRaw('products.price desc');
                        break;
                    default:
                        break;
                }
            }
            $products = $product_query->paginate(12)->withQueryString();
        }
        // dd($vendors);

        return response()->json($products);
    }

    public function vendor(Request $request)
    {
        $vendor = DB::table('vendors')
            ->join('users', 'users.id', '=', 'vendors.user_id')
            ->join('cities', 'cities.id', '=', 'vendors.city_id')

            ->select(DB::raw("cities.name as city,
         vendors.image ,
         users.name ,users.username ,
         vendors.id,
         vendors.phone ,
         vendors.city_id,
         vendors.address ,
         users.email ,
         vendors.count,
         (select count(*) from reviews where vendor_id=vendors.id) as rc,
         (select avg(rate) from reviews where vendor_id=vendors.id) as ra,
         vendors.opening,
         vendors.desc
         "))
            ->where('vendors.active', 1)
            ->where('vendors.id', $request->id)
            ->first();

        $vendor->reviews = DB::table('reviews')
            ->join('users', 'users.id', '=', 'reviews.user_id')
            ->join('vendors', 'vendors.user_id', '=', 'users.id')
            ->where('reviews.vendor_id', $vendor->id)
            ->select(DB::raw('reviews.created_at ,reviews.rate ,users.name ,reviews.desc ,vendors.image ,reviews.id'))
            ->orderByDesc('reviews.id')
            ->get();

        $vendor->products=DB::table('products')->where('vendor_id',$vendor->id)->where('active',1)->whereRaw('? between products.start and products.end', [date('Y-m-d')])->get();


        return response()->json($vendor);
    }

    public function signup(Request $request)
    {
        if ($request->getMethod() == "POST") {
            $data = getSetting('website');
            // dd($data);

            $validator = Validator::make(
                $request->all(),
                [
                    'email' => 'email|required|unique:users,email',
                    'name' => 'required|max:255',
                    'password' => ['required', 'confirmed', Password::min(6)],
                ],
                [
                    'email.unique' => 'Email is already in use',
                    'name.required' => 'Name is Required',
                    'email.required' => 'Email address is required',
                ]
            );

            $type=$request->type??3;

            if ($validator->fails()) {
                $err = [];
                $errors = $validator->errors()->toArray();
                foreach ($errors as $key => $_err) {
                    foreach ($_err as $key => $__err) {
                        array_push($err, $__err);
                    }
                }
                return response()->json(['status' => false, 'msg' => $err]);
            } else {

                $user = new User();
                $vendor = new Vendor();

                try {
                    $vendor->type = $type;
                    $user->name = $request->name;
                    $i = 1;
                    $tempusername = str_replace(' ', '.', $request->name);
                    $username = $tempusername;
                    while (User::where('username', $username)->count() > 0) {
                        $username = $tempusername . $i++;
                    }
                    $user->username = strtolower($username);
                    $user->email = $request->email;
                    $user->role = $type;
                    $user->password = bcrypt($request->password);
                    $user->save();

                    $vendor->active = 0;
                    $vendor->user_id = $user->id;
                    $vendor->save();
                    return response()->json([
                        'status' => true,
                        'user'=>(object)[
                            'name'=>$user->name,
                            'email'=>$user->email,
                        ],
                        'step'=>$vendor->step,
                        'type'=>$vendor->type,
                        'token'=>$user->createToken('API-KEY')->accessToken
                    ]);

                } catch (\Throwable $th) {
                    //throw $th;
                    if ($user->id != 0 && $user->id != null) {
                        if ($vendor->id != 0 && $vendor->id != null) {
                            VendorBill::where('vendor_id', $vendor->id)->delete();
                            $vendor->delete();
                        }
                        $user->delete();
                    }
                    return response()->json([
                        'status' => false,
                        'msg' => [$th->getMessage()]
                    ]);
                }
                return response()->json(['status' => true, 'msg' => []]);
            }
        }
    }


    //auth routes
    public function user()
    {
        $user = Auth::user();
        $vendor = null;
        if ($user->role == 2) {
            $vendor = DB::table('vendors')
                ->join('users', 'users.id', '=', 'vendors.user_id')
                ->select(DB::raw("vendors.*,
                users.name,
                users.username,
                users.email,
                vendors.type,
                (select avg(rate) from reviews where vendor_id=vendors.id) as rating,
                (select count(*) from products where vendor_id = vendors.id and type=2) as services,
                (select count(*) from products where vendor_id = vendors.id and type=1) as products,
                (select count(*) from vendor_bills where vendor_id = vendors.id ) as invoices,
                (select count(*) from reviews where vendor_id = vendors.id ) as reviews
                "))
                ->where('vendors.user_id', $user->id)
                ->first();
            // $vendor->reviews = DB::table('reviews')
            //     ->join('users', 'users.id', '=', 'reviews.user_id')
            //     ->join('vendors', 'vendors.user_id', '=', 'users.id')
            //     ->where('reviews.vendor_id', $vendor->id)
            //     ->select(DB::raw('reviews.created_at ,reviews.rate ,users.name ,reviews.desc ,vendors.image ,reviews.id'))
            //     ->orderByDesc('reviews.id')
            //     ->get();

            // $vendor->otherServices = DB::table('vendor_services')
            //     ->join('services', 'services.id', '=', 'vendor_services.service_id')
            //     ->where('vendor_services.vendor_id', $vendor->id)->select('vendor_services.id', 'vendor_services.active', 'vendor_services.paid')
            //     ->where('services.id', '!=', $vendor->service_id)
            //     ->get();
            // $vendor->bills = DB::table('vendor_bills')
            //     ->where('vendor_bills.vendor_id', $vendor->id)
            //     ->get();
        } else {
            $vendor = DB::table('vendors')
                ->join('users', 'users.id', '=', 'vendors.user_id')
                ->select(DB::raw("
                    vendors.image ,
                    users.name ,
                    users.username ,
                    vendors.id,
                    vendors.step,
                    vendors.phone ,
                    vendors.city_id,
                    vendors.type,
                    vendors.address ,
                    users.email,
                    vendors.type,
                    vendors.location_id
                "))
                ->where('users.id', $user->id)
                ->first();
            $vendor->bookmarks = DB::table('book_marks')
                ->join('vendors', 'vendors.id', '=', 'book_marks.vendor_id')
                ->join('users', 'users.id', '=', 'vendors.user_id')
                ->select(DB::raw('vendors.id,users.name as vendor,users.username ,vendors.image'))
                ->where('book_marks.user_id', $user->id)
                ->get();
            $vendor->reviews = DB::table('reviews')
                ->join('vendors', 'vendors.id', '=', 'reviews.vendor_id')
                ->join('users', 'users.id', '=', 'vendors.user_id')
                ->where('reviews.user_id', $user->id)
                ->select(DB::raw('reviews.created_at ,reviews.rate ,users.name as vendor,reviews.desc ,vendors.image ,reviews.id '))
                ->orderByDesc('reviews.id')
                ->get();
        }
        return response()->json($vendor);
    }

    public function product(Request $request)
    {
        $asset=asset('');
        $product=DB::table('products')->where('id',$request->id)->first();
        $product->images=ProductMedia::where('parent_id',$product->id)->pluck('file');
        $product->vendor=DB::table('vendors')
        // join('services','services.id','=','vendors.service_id')
        // ->
        ->join('cities','cities.id','=','vendors.city_id')
        ->join('users','users.id','=','vendors.user_id')
        ->select(DB::raw("users.name,users.username,vendors.id,vendors.phone,cities.name as city,vendors.desc,users.email,vendors.address"))->where('vendors.id',$product->vendor_id)->first();
        DB::update('update products set count = count+1 where id=?',[$product->id]);
        return  response()->json($product);

    }

    public function images(Request $request){
        return response()->json(['images'=>DB::table('product_media')->where('parent_id',$request->id)->pluck('file')]);
    }

    public function setting(Request $request)
    {
        return response()->json(DB::table('settings')->whereIn('code',['contact','payment'])->get(['code','value']));
    }
}
