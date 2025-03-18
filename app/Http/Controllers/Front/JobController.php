<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\JobBid;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    public function jobSearch(){
        $user = Auth::user();
        $vendor = getVendor();
        // $jobs = Job::where('status',0)->latest()->get();
        $jobs = DB::select('select j.*,(Select count(*) from job_bids where job_id=j.id) as bids from jobs j where j.vendor_id in (select id from vendors where city_id=?) and j.service_id=? order by j.created_at desc',[$vendor->city_id,$vendor->service_id]);
        return view('vendor.jobs.job',compact('jobs','user'));
    }

    public function jobSearchdetails($id){
        $user = Auth::user();
        $job = Job::where('id',$id)->first();
        $vendor = getVendor()->id;
        $bidCount = JobBid::where('vendor_id',$vendor)->where('job_id',$id)->first();
        return view('vendor.jobs.details',compact('job','user','bidCount'));
    }

    public function addBid(Request $request){
        // dd($request->all());
        $vendor = getVendor()->id;
        $bidCount = JobBid::where('vendor_id',$vendor)->where('job_id',$request->job_id)->first();
        if($bidCount!= null){
            $bidCount->amount = $request->bidamt;
            $bidCount->save();
        }else{
            $bid = new JobBid();
            $bid->vendor_id = $vendor;
            $bid->job_id = $request->job_id;
            $bid->amount = $request->bidamt;
            $bid->save();
        }
        return redirect()->back()->with('success','Your bid addedd successfully!');
    }

    public function mybids(){
        $user = Auth::user();
        $vendor = getVendor()->id;
        $bids = DB::table('job_bids')->where('vendor_id',$vendor)->where('status',0)->get();
        $jobs = Job::whereIn('id',$bids->pluck('job_id'))->latest()->get();
        return view('vendor.page.mybids',compact('jobs','user','bids'));
    }

    public function bidAccepted(){
        $user = Auth::user();
        $vendor = getVendor()->id;
        // dd($vendor);
        $bids = DB::table('job_bids')->where('vendor_id',$vendor)->where('status',1)->get();
        $jobs = Job::whereIn('id',$bids->pluck('job_id'))->whereIn('status',[1,2])->get();

        // $jobs = DB::table('job_bids')->where('vendor_id',$vendor)->where('status',1)
        // ->join('jobs','jobs.id','job_bids.job_id')->get();

        // dd($bids,$vendor,$jobs);
        return view('vendor.page.bidaccept',compact('jobs','user','bids'));
    }

    public function finishedJobReq($id){
        $job = Job::where('id',$id)->first();
        $job->status = 2;
        $job->save();
        return redirect()->back()->with('success','Request sent successfully');
    }

    public function finishedJob(){
        $user = Auth::user();
        $vendor = getVendor()->id;
        $bids = DB::table('job_bids')->where('vendor_id',$vendor)->where('status',1)->get();
        $jobs = Job::whereIn('id',$bids->pluck('job_id'))->where('status',3)->get();
        return view('vendor.jobs.finishedjob',compact('jobs','user','bids'));
    }

    public function yesReceivedPayment($id){
        $pay = Payment::where('id',$id)->first();
        $pay->received = 1;
        $pay->save();
        return redirect()->back()->with('success','Confirm success.');
    }
}
