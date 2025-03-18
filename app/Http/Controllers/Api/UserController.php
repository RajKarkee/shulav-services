<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BookMark;
use App\Models\Otp;
use App\Models\Review;
use App\Models\User;
use App\Models\Vendor;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function phoneLogin(Request $request)
    {
        $phone = $request->phone;
        $now = Carbon::now();
        $otp = Otp::where('phone', $phone)->first();
        $resend = false;
        if ($otp != null) {
            if ($now->gt($otp->validtill)) {
                $resend = true;
            }
        } else {
            $otp = new Otp();
            $otp->phone = $phone;
            $resend = true;
        }

        // return response()->json($otp->send());

        if ($resend) {
            $otp->otp = mt_rand(111111, 999999);
            $otp->validtill = $now->addMinute(5);
            return response()->json([
                'status'=> $otp->send(),
            ]);
        }else{
            return response()->json([
                'status'=> true
            ]);
        }
    }




    public function checkOtps(Request $request){
        // return response()->json($request->all());
        $checkOtp = Otp::where('phone',$request->phone)->where('otp',$request->otp)->first();
        if($checkOtp != null){
            $vendor = Vendor::where('phone',$request->phone)->first();
            if($vendor!=null){
                $userDetail = User::where('id',$vendor->user_id)->first();
                $checkOtp->delete();
                return response()->json([
                    'status' => true,
                    'new_user' => false,
                    'token'=>$userDetail->createToken('API-KEY')->accessToken
                ]);
            }else{
                $type=$request->type??3;
                $pass = time();
                $user = new User();
                $vendor = new Vendor();
                $user->name = "";
                $user->role = $type;
                $user->password = bcrypt($pass);
                $user->save();

                $vendor->type = $type;
                $vendor->user_id = $user->id;
                $vendor->phone = $request->phone;
                $vendor->save();
                $checkOtp->delete();

                return response()->json([
                    'status' => true,
                    'new_user' => true,
                    'token'=>$user->createToken('API-KEY')->accessToken
                ]);
            }
        }else{
            return response()->json([
                'status'=> false,
                 'message' => 'Otp could not found'
            ]);
        }
    }

    public function initInfo(Request $request)
    {
        $user=Auth::user();
        $vendor=$user->vendor;
        $vendor->location_id=$request->location_id;
        $vendor->city_id=$request->city_id;
        $vendor->service_id=$request->service_id;
        $vendor->step=4;
        $vendor->save();
        return response()->json(['status' => true]);
    }
    //

    public function updateInfo(Request $request){
        $user=Auth::user();
        $user->name = $request->name;
        $vendor=$user->vendor;
        $vendor->location_id=$request->location_id;
        $vendor->city_id=$request->city_id;
        $vendor->service_id=$request->service_id;
        $user->save();
        $vendor->save();
        return response()->json(['status' => true]);
    }


    public function addReview(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'desc' => 'required',
            'rate' => 'required|between:0,6|integer',
            'vendor_id' => 'required|exists:vendors,id'
        ], [
            'desc.required' => "Review is required",
            'rate.required' => "Rating is required",
            'vendor_id.required' => "Vendor is required",
        ]);
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

            $data = [
                'desc' => $request->desc,
                'rate' => $request->rate,
                'vendor_id' => $request->vendor_id,
            ];
            $data['user_id'] = Auth::user()->id;
            $review = Review::create($data);
            // $review_data = DB::selectOne("select (select count(*) from reviews where vendor_id={$review->vendor_id}) as review_count,(select avg(rate) from reviews where vendor_id={$review->vendor_id}) as review_avg");
            return response()->json(['status' => true, 'review' => $review]);
        }
    }

    public  function addBookmark(Request $request)
    {

        $user = Auth::user();
        $h = BookMark::where('user_id', $user->id)->where('vendor_id', $request->vendor_id)->first();
        if ($h == null) {
            $h = BookMark::create([
                'user_id' => $user->id,
                'vendor_id' => $request->vendor_id,
            ]);
            return response()->json(['status' => true, 'bookmark' => $h]);
        } else {
            return response()->json(['status' => false, 'msg' => ['Bookmark Already Added']]);
        }
    }
    public  function removeBookmark(Request $request)
    {

        $user = Auth::user();
        $h = BookMark::where('user_id', $user->id)->where('vendor_id', $request->vendor_id)->first();
        if ($h == null) {
            return response()->json(['status' => false, 'msg' => ['Bookmark Not Found']]);
        } else {
            $h->delete();
            return response()->json(['status' => true, 'msg' => []]);
        }
    }

    public function changeImage(Request $request){
        try {

            $image= $request->image->store('uploads/user');
            Vendor::where('user_id',Auth::user()->id)->update(['image'=>$image]);
            return response()->json(['status'=>true,'image'=>$image]);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false,'image'=>[$th->getMessage()]]);

        }
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
            ]);

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
        $vendor->phone = $request->phone;
        $vendor->address = $request->address;
        $vendor->city_id = $request->city_id;
        $vendor->gender = $request->gender;
        $vendor->dob = $request->dob;
        $vendor->desc = $request->desc;
        $vendor->save();
        return response()->json(['status' => true, 'msg' => []]);
    }

    public function createName(Request $request){
        $user = Auth::user();
        $user->name = $request->name;
        $user->save();
        return response()->json([
            'status' => true,
            'name' => $user->name
        ]);
    }


}
