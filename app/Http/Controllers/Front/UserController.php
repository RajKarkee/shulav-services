<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BookMark;
use App\Models\Review;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public  function bookmark($vendor_id){
        $user=Auth::user();
            $h=BookMark::where('user_id',$user->id)->where('vendor_id',$vendor_id)->first();
            if($h==null){
                $h= BookMark::create([
                    'user_id'=>$user->id,
                    'vendor_id'=>$vendor_id,
                ]);

            }else{
                $h->delete();
            }
            return redirect()->back();
    }
    public function index()
    {
        $user=Auth::user();
        $reviews=DB::table('reviews')
        ->join('vendors','vendors.id','=','reviews.vendor_id')
        ->join('users','users.id','=','vendors.user_id')
        ->where('reviews.user_id',$user->id)
        ->select(DB::raw('reviews.created_at as c,reviews.rate as r,users.name as n,reviews.desc as d,vendors.image as i,reviews.id as vid' ))
        ->orderByDesc('reviews.id')
        ->get();

        $histories=DB::table('histories')
        ->join('vendors','vendors.id','=','histories.vendor_id')
        ->join('users','users.id','=','vendors.user_id')
        ->select(DB::raw('vendors.id,users.name,users.username,vendors.image' ))
        ->where('histories.user_id',$user->id)
        ->get();
        $bookmarks=DB::table('book_marks')
        ->join('vendors','vendors.id','=','book_marks.vendor_id')
        ->join('users','users.id','=','vendors.user_id')
        ->select(DB::raw('vendors.id,users.name,users.username,vendors.image' ))
        ->where('book_marks.user_id',$user->id)
        ->get();



        // dd($reviews);
        return view('user.index',compact('user','reviews','histories','bookmarks'));
    }
    public function editInfo(Request $request)
    {
        $user=Auth::user();

        if($request->getMethod()=="POST"){
            if($request->phone!=$user->vendor->phone){

                if(Vendor::where('phone',$request->phone)->where('id','<>',$user->vendor->id)->count()>0){
                    throw new \Exception('Phone Number Is Already Used');
                }
            }

            $user->name=$request->name;
            $user->save();

            $vendor=$user->vendor;
            $vendor->phone=$request->phone;
            $vendor->address=$request->address;
            $vendor->city_id=$request->city_id;
            $vendor->gender=$request->gender;
            $vendor->dob=$request->dob;
            $vendor->desc=$request->desc;
            $vendor->save();

        }else{

            return view('user.edit',compact('user'));
        }
    }

    public function updatePass(Request $request)
    {
        $user=Auth::user();
        if(Hash::check($request->oldpass,$user->password)){
            $user->password=bcrypt($request->pass);
            $user->save();
            return response()->json('ok');
        }else{
            throw new \Exception('Password Not Match');
        }

    }

    public function changeImage(Request $request){
        $image= $request->image->store('uploads/vendor');
        Vendor::where('user_id',Auth::user()->id)->update(['image'=>$image]);
        return response()->json(['status'=>true]);
    }

    public function changeDesc(Request $request){
        // $image= $request->image->store('uploads/vendor');
        Vendor::where('user_id',Auth::user()->id)->update(['desc'=>$request->desc]);
        return response()->json(['status'=>true]);
    }
    public function changeName(Request $request){
        $user=Auth::user();
        $user->name=$request->name;
        $user->save();
        return response()->json(['status'=>true]);
    }

    public function addReview(Request $request)
    {
        $data=$request->validate([
            'desc'=>'required',
            'rate'=>'required|between:0,6|integer',
            'vendor_id'=>'required|exists:vendors,id'
        ]);
        $data['user_id']=Auth::user()->id;
        $review=Review::create($data);
        $review_data=DB::selectOne("select (select count(*) from reviews where vendor_id={$review->vendor_id}) as review_count,(select avg(rate) from reviews where vendor_id={$review->vendor_id}) as review_avg");
        if($request->wantsJson()){
            return response()->json(['review'=>$review,'data'=>$review_data]);
        }else{
            return redirect()->back();
        }
    }
}
